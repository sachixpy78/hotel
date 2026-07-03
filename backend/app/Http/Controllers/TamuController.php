<?php

namespace App\Http\Controllers;

use App\Models\TipeKamar;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TamuController extends Controller
{
    // ======================
    // DASHBOARD TAMU
    // ======================
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalPemesanan = Pemesanan::where('user_id', $user->id)->count();
        $pemesananAktif = Pemesanan::where('user_id', $user->id)
            ->whereIn('status', ['menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar', 'check_in'])
            ->count();
        $totalPengeluaran = Pemesanan::where('user_id', $user->id)
            ->where('status', 'check_out')
            ->sum('total_harga');
        
        $pemesananTerbaru = Pemesanan::where('user_id', $user->id)
            ->with('tipeKamar')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_pemesanan' => $totalPemesanan,
                'pemesanan_aktif' => $pemesananAktif,
                'total_pengeluaran' => $totalPengeluaran,
                'pemesanan_terbaru' => $pemesananTerbaru
            ]
        ]);
    }
    
    // ======================
    // KAMAR - PUBLIC
    // ======================
    public function semuaKamar()
    {
        $kamar = TipeKamar::where('tersedia', true)->get();
        return response()->json(['success' => true, 'data' => $kamar]);
    }
    
    public function detailKamar($id)
    {
        $kamar = TipeKamar::findOrFail($id);
        return response()->json(['success' => true, 'data' => $kamar]);
    }
    
    public function cariKamar(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in'
        ]);
        
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $jumlahMalam = $checkIn->diffInDays($checkOut);
        
        $kamar = TipeKamar::where('tersedia', true)
            ->where('stok', '>', 0)
            ->get();
        
        foreach ($kamar as $k) {
            $bookedRooms = Pemesanan::where('tipe_kamar_id', $k->id)
                ->where(function($q) use ($checkIn, $checkOut) {
                    $q->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function($q2) use ($checkIn, $checkOut) {
                          $q2->where('check_in', '<=', $checkIn)
                             ->where('check_out', '>=', $checkOut);
                      });
                })
                ->whereNotIn('status', ['batal', 'check_out'])
                ->sum('jumlah_kamar');
            
            $k->stok_tersedia = max(0, $k->stok - $bookedRooms);
            $k->jumlah_malam = $jumlahMalam;
            $k->total_harga = $k->harga_per_malam * $jumlahMalam;
        }
        
        return response()->json([
            'success' => true,
            'data' => $kamar->filter(function($k) {
                return $k->stok_tersedia > 0;
            })->values()
        ]);
    }
    
    // ======================
    // PEMESANAN - AUTH
    // ======================
   public function buatPemesanan(Request $request)
{
    $validated = $request->validate([
        'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
        'jumlah_kamar' => 'required|integer|min:1',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'nama_pemesan' => 'required|string|max:255',
        'metode_pembayaran' => 'required|in:tunai,transfer',
        'catatan' => 'nullable|string|max:500'
    ], [
        'check_in.after_or_equal' => 'Tanggal check-in tidak boleh di masa lalu',
        'check_out.after' => 'Tanggal check-out harus setelah check-in',
        'nama_pemesan.required' => 'Nama pemesan wajib diisi'
    ]);
    
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu'
        ], 401);
    }
    
    $tipeKamar = TipeKamar::findOrFail($validated['tipe_kamar_id']);
    
    $checkIn = Carbon::createFromFormat('Y-m-d', $validated['check_in'])->startOfDay();
    $checkOut = Carbon::createFromFormat('Y-m-d', $validated['check_out'])->startOfDay();
    $jumlahMalam = $checkIn->diffInDays($checkOut);
    $totalHarga = $tipeKamar->harga_per_malam * $jumlahMalam * $validated['jumlah_kamar'];
    
    // Cek ketersediaan
    $bookedRooms = Pemesanan::where('tipe_kamar_id', $tipeKamar->id)
        ->whereNotIn('status', ['batal', 'check_out'])
        ->where(function($q) use ($checkIn, $checkOut) {
            $q->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        })
        ->sum('jumlah_kamar');
    
    $stokTersedia = $tipeKamar->stok - $bookedRooms;
    
    if ($validated['jumlah_kamar'] > $stokTersedia) {
        return response()->json([
            'success' => false,
            'message' => "Stok tidak mencukupi. Tersedia {$stokTersedia} kamar"
        ], 400);
    }
    
    // Validasi: >500rb wajib transfer
    if ($totalHarga > 500000 && $validated['metode_pembayaran'] === 'tunai') {
        return response()->json([
            'success' => false,
            'message' => 'Total di atas Rp 500.000 wajib transfer bank'
        ], 400);
    }
    
    // Tentukan status awal
    $status = 'menunggu_pembayaran';
    
    // Generate nomor pemesanan dulu
    $nomorPemesanan = $this->generateNomorPemesanan();
    
    // Buat pemesanan
    $pemesanan = Pemesanan::create([
        'nomor_pemesanan' => $nomorPemesanan,
        'user_id' => $user->id,
        'nama_pemesan' => $validated['nama_pemesan'],
        'tipe_kamar_id' => $validated['tipe_kamar_id'],
        'jumlah_kamar' => $validated['jumlah_kamar'],
        'check_in' => $checkIn,
        'check_out' => $checkOut,
        'jumlah_malam' => $jumlahMalam,
        'harga_per_malam' => $tipeKamar->harga_per_malam,
        'total_harga' => $totalHarga,
        'status' => $status,
        'metode_pembayaran' => $validated['metode_pembayaran'],
        'catatan' => $validated['catatan'] ?? null
    ]);
    
    // ==============================
    // GENERATE QR CODE OTOMATIS ✅
    // ==============================
    $qrCodePath = $this->generateQRCode($pemesanan, $nomorPemesanan);
    if ($qrCodePath) {
        $pemesanan->qr_code_path = $qrCodePath;
        $pemesanan->save();
    }
    
    // ==============================
    // UPDATE STOK KAMAR ✅
    // ==============================
    $tipeKamar->stok = $tipeKamar->stok - $validated['jumlah_kamar'];
    $tipeKamar->save();
    
    // Buat record pembayaran jika transfer
    if ($validated['metode_pembayaran'] === 'transfer') {
        Pembayaran::create([
            'pemesanan_id' => $pemesanan->id,
            'jumlah' => $totalHarga,
            'metode' => 'transfer',
            'status' => 'pending'
        ]);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Pemesanan berhasil dibuat!',
        'data' => $pemesanan->load(['tipeKamar', 'user'])
    ], 201);
}
    
// Tambahkan method ini di TamuController.php

public function semuaKamarTersedia()
{
    $kamar = TipeKamar::where('tersedia', true)
        ->where('stok', '>', 0)
        ->get();
    
    return response()->json([
        'success' => true,
        'data' => $kamar
    ]);
}

    // ======================
    // HELPER: Generate QR Code ✅
    // ======================
    private function generateQRCode($pemesanan, $nomorPemesanan)
    {
        try {
            // Data QR Code = Nomor Pemesanan (untuk scanner barcode)
            $qrData = $nomorPemesanan;
            
            // Generate QR Code menggunakan library
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(300)
                ->margin(2)
                ->errorCorrection('H') // High error correction untuk scanner
                ->generate($qrData);
            
            // Generate nama file unik
            $filename = 'qr_' . $pemesanan->id . '_' . time() . '.png';
            $path = 'qr-codes/' . $filename;
            
            // Pastikan folder qr-codes ada di storage/public
            if (!Storage::disk('public')->exists('qr-codes')) {
                Storage::disk('public')->makeDirectory('qr-codes');
            }
            
            // Simpan file QR Code ke storage
            Storage::disk('public')->put($path, $qrCode);
            
            return $path;
            
        } catch (\Exception $e) {
            // Log error tapi jangan gagalin pemesanan
            \Log::error('QR Code generation error: ' . $e->getMessage());
            return null;
        }
    }
    
    // ======================
    // DAFTAR PESANAN SAYA
    // ======================
    public function pemesananSaya()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $pemesanan = Pemesanan::where('user_id', $user->id)
            ->with(['tipeKamar', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $pemesanan
        ]);
    }
    
    // ======================
    // DETAIL PESANAN
    // ======================
    public function detailPemesanan($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $pemesanan = Pemesanan::where('user_id', $user->id)
            ->with(['tipeKamar', 'pembayaran'])
            ->findOrFail($id);
        
        // Ambil data user dari tabel admin berdasarkan user_id
        $userData = DB::table('admin')->where('id', $pemesanan->user_id)->first();
        
        // Tambahkan data user ke response
        $pemesanan->user = $userData;
        
        return response()->json([
            'success' => true,
            'data' => $pemesanan
        ]);
    }
    
    // ======================
    // UPLOAD BUKTI TRANSFER - FIXED ✅
    // ======================
    public function uploadBukti(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu'
                ], 401);
            }
            
            // Validasi file
            $request->validate([
                'bukti_transfer' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
            ], [
                'bukti_transfer.required' => 'File bukti transfer wajib diupload',
                'bukti_transfer.file' => 'Harap upload file yang valid',
                'bukti_transfer.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, pdf',
                'bukti_transfer.max' => 'Ukuran file maksimal 2MB'
            ]);
            
            // Cari pemesanan milik user
            $pemesanan = Pemesanan::where('user_id', $user->id)->findOrFail($id);
            
            // Validasi metode pembayaran
            if ($pemesanan->metode_pembayaran !== 'transfer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pemesanan ini tidak menggunakan metode transfer'
                ], 400);
            }
            
            // Validasi status
            if ($pemesanan->status !== 'menunggu_pembayaran') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pemesanan tidak dapat diupload bukti transfer'
                ], 400);
            }
            
            // Proses upload file
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                
                // Generate nama file unik
                $extension = $file->getClientOriginalExtension();
                $filename = 'bukti_' . time() . '_' . $pemesanan->nomor_pemesanan . '.' . $extension;
                
                // Pastikan folder exists
                $path = 'bukti-transfer';
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                
                // Simpan file
                $storedPath = $file->storeAs($path, $filename, 'public');
                
                if (!$storedPath) {
                    throw new \Exception('Gagal menyimpan file');
                }
                
                // Update pemesanan
                $pemesanan->bukti_transfer = $storedPath;
                $pemesanan->status = 'menunggu_verifikasi';
                $pemesanan->save();
                
                // Update atau create pembayaran
                // ⚠️ PENTING: Status di tabel 'pembayaran' pakai: pending, verified, failed
                $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
                if ($pembayaran) {
                    $pembayaran->status = 'pending';  // ← UBAH: tetap 'pending' (belum diverifikasi admin)
                    $pembayaran->bukti_transfer = $storedPath;
                    $pembayaran->save();
                } else {
                    Pembayaran::create([
                        'pemesanan_id' => $pemesanan->id,
                        'jumlah' => $pemesanan->total_harga,
                        'metode' => 'transfer',
                        'status' => 'pending',  // ← UBAH: 'pending' (bukan 'menunggu_verifikasi')
                        'bukti_transfer' => $storedPath
                    ]);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Bukti transfer berhasil diupload',
                'data' => $pemesanan->load(['tipeKamar', 'user', 'pembayaran'])
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Upload bukti error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload bukti transfer: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // ======================
    // CEK PESANAN (PUBLIC)
    // ======================
    public function cekPesanan(Request $request)
    {
        $validated = $request->validate([
            'nomor_pemesanan' => 'required|string',
            'email' => 'required|email'
        ]);
        
        // Cari pemesanan berdasarkan nomor
        $pemesanan = Pemesanan::where('nomor_pemesanan', $validated['nomor_pemesanan'])
            ->with(['tipeKamar', 'pembayaran'])
            ->first();
        
        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        }
        
        // Ambil data user dari tabel admin berdasarkan user_id
        $userData = DB::table('admin')->where('id', $pemesanan->user_id)->first();
        
        // Cek apakah email cocok
        if (!$userData || $userData->email !== $validated['email']) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak sesuai dengan pemesanan'
            ], 403);
        }
        
        // Tambahkan data user ke response
        $pemesanan->user = $userData;
        
        return response()->json([
            'success' => true,
            'data' => $pemesanan
        ]);
    }
    
    // ======================
    // RESEPSIONIS: Dashboard Stats
    // ======================
    public function dashboardStats()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $today = Carbon::today();
        
        $stats = [
            'check_in_hari_ini' => Pemesanan::whereDate('check_in', $today)
                ->whereNotIn('status', ['batal'])
                ->count(),
            'check_out_hari_ini' => Pemesanan::whereDate('check_out', $today)
                ->whereNotIn('status', ['batal'])
                ->count(),
            'total_pemesanan' => Pemesanan::count(),
            'kamar_tersedia' => TipeKamar::where('tersedia', true)->sum('stok')
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
    
    // ======================
    // RESEPSIONIS: Semua Pemesanan
    // ======================
    public function allBookings(Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $query = Pemesanan::with(['tipeKamar', 'user', 'pembayaran']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_pemesanan', 'like', "%{$request->search}%")
                  ->orWhere('nama_pemesan', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('email', 'like', "%{$request->search}%");
                  });
            });
        }
        
        $pemesanan = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $pemesanan
        ]);
    }
    
    // ======================
    // RESEPSIONIS: Update Status
    // ======================
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'status' => 'required|in:menunggu_pembayaran,menunggu_verifikasi,dibayar,check_in,check_out,batal'
        ]);
        
        $pemesanan = Pemesanan::findOrFail($id);
        $oldStatus = $pemesanan->status;
        $pemesanan->status = $validated['status'];
        
        // ⚠️ PENTING: Jika status pemesanan jadi 'dibayar', update juga tabel pembayaran
        if ($validated['status'] === 'dibayar') {
            $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
            if ($pembayaran) {
                $pembayaran->status = 'verified';  // ← Update pembayaran jadi 'verified'
                $pembayaran->save();
            }
        }
        
        $pemesanan->save();
        
        return response()->json([
            'success' => true,
            'message' => "Status diubah dari '{$oldStatus}' menjadi '{$validated['status']}'",
            'data' => $pemesanan->load(['tipeKamar', 'user'])
        ]);
    }
    
    // ======================
    // HELPER: Generate Nomor Pemesanan
    // ======================
    private function generateNomorPemesanan()
    {
        $prefix = 'INV';
        $date = date('Ymd');
        $last = Pemesanan::whereDate('created_at', today())->count();
        $number = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        return $prefix . $date . $number;
    }
}