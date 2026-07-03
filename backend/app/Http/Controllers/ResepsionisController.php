<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\TipeKamar;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ResepsionisController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $today = Carbon::today();

        $stats = [
            'check_in_hari_ini' => Pemesanan::whereDate('check_in', $today)
                ->whereIn('status', ['dibayar', 'check_in'])
                ->whereNotIn('status', ['batal', 'check_out'])
                ->count(),
            'check_out_hari_ini' => Pemesanan::whereDate('check_out', $today)
                ->whereIn('status', ['check_in'])
                ->count(),
            'menunggu_verifikasi' => Pemesanan::where('status', 'menunggu_verifikasi')->count(),
            'total_bulan_ini' => Pemesanan::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count(),
            'pendapatan_bulan_ini' => Pemesanan::whereMonth('check_out', date('m'))
                ->whereYear('check_out', date('Y'))
                ->where('status', 'check_out')
                ->sum('total_harga'),
            'kamar_tersedia' => TipeKamar::where('tersedia', true)->sum('stok'),
        ];

        $pemesananTerbaru = Pemesanan::with(['tipeKamar'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($p) {
                $userData = DB::table('admin')->where('id', $p->user_id)->first();
                return [
                    'id' => $p->id,
                    'nomor_pemesanan' => $p->nomor_pemesanan,
                    'nama_pemesan' => $p->nama_pemesan,
                    'email' => $userData?->email ?? '-',
                    'kamar' => $p->tipeKamar?->nama,
                    'check_in' => $p->check_in->format('d M Y'),
                    'status' => $p->status,
                    'total_harga' => $p->total_harga,
                    'jumlah_kamar' => $p->jumlah_kamar ?? 1,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => ['stats' => $stats, 'pemesanan_terbaru' => $pemesananTerbaru]
        ]);
    }

    public function semuaPemesanan(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $query = Pemesanan::with(['tipeKamar', 'pembayaran']);

        if (!$request->filled('status')) {
            $query->where('status', 'check_in');
        } else {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_checkin')) {
            $query->whereDate('check_in', $request->tanggal_checkin);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pemesanan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('username', 'like', "%{$search}%");
                  });
            });
        }

        $pemesanan = $query->with('user')->orderBy('created_at', 'desc')->paginate(15);

        $now = Carbon::now();
        $data = $pemesanan->getCollection()->map(function($p) use ($now) {
            $userData = null;
            if ($p->user) {
                $userData = $p->user;
            } else {
                $userData = DB::table('admin')->where('id', $p->user_id)->first();
            }
            
            // ✅ DEADLINE CHECKOUT: tanggal_checkout + jam 12:00
            $checkOutTime = Carbon::parse($p->check_out)->setHour(12)->setMinute(0);
            
            $buktiTransfer = null;
            if ($p->pembayaran && $p->pembayaran->bukti_transfer) {
                $buktiTransfer = asset('storage/' . $p->pembayaran->bukti_transfer);
            }
            
            return [
                'id' => $p->id,
                'nomor_pemesanan' => $p->nomor_pemesanan,
                'nama_pemesan' => $p->nama_pemesan ?? $userData?->username ?? $userData?->name ?? '-',
                'email' => $userData?->email ?? '-',
                'no_telp' => $userData?->no_telp ?? $userData?->phone ?? '-',
                'tipe_kamar' => $p->tipeKamar?->nama ?? '-',
                'jumlah_kamar' => (int)($p->jumlah_kamar ?? 1),
                'check_in' => Carbon::parse($p->check_in)->setHour(13)->setMinute(0)->format('d M Y H:i'),
                // ✅ DISPLAY: tanggal + 12:00
                'check_out' => Carbon::parse($p->check_out)->setHour(12)->setMinute(0)->format('d M Y H:i'),
                'jumlah_malam' => $p->jumlah_malam,
                'total_harga' => $p->total_harga,
                'status' => $p->status,
                'metode_pembayaran' => $p->metode_pembayaran,
                'bukti_transfer' => $buktiTransfer,
                'qr_code' => $p->qr_code_path ? asset('storage/' . $p->qr_code_path) : null,
                'created_at' => $p->created_at?->format('d M Y H:i'),
                'is_late_checkout' => $p->status === 'check_in' && $now->gt($checkOutTime),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'pagination' => [
                'current_page' => $pemesanan->currentPage(),
                'last_page' => $pemesanan->lastPage(),
                'total' => $pemesanan->total(),
                'per_page' => $pemesanan->perPage(),
                'from' => $pemesanan->firstItem(),
                'to' => $pemesanan->lastItem(),
            ]
        ]);
    }

    public function detailPemesanan($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $pemesanan = Pemesanan::with(['tipeKamar', 'pembayaran'])->findOrFail($id);
        $userData = DB::table('admin')->where('id', $pemesanan->user_id)->first();

        $buktiTransfer = null;
        if ($pemesanan->pembayaran && $pemesanan->pembayaran->bukti_transfer) {
            $buktiTransfer = asset('storage/' . $pemesanan->pembayaran->bukti_transfer);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pemesanan->id,
                'nomor_pemesanan' => $pemesanan->nomor_pemesanan,
                'nama_pemesan' => $pemesanan->nama_pemesan,
                'email' => $userData?->email ?? '-',
                'no_telp' => $userData?->no_telp ?? '-',
                'tipe_kamar' => [
                    'id' => $pemesanan->tipeKamar?->id,
                    'nama' => $pemesanan->tipeKamar?->nama,
                    'harga_per_malam' => $pemesanan->tipeKamar?->harga_per_malam,
                ],
                'jumlah_kamar' => (int)($pemesanan->jumlah_kamar ?? 1),
                'check_in' => $pemesanan->check_in?->format('d M Y H:i'),
                'check_out' => $pemesanan->check_out?->format('d M Y H:i'),
                'jumlah_malam' => $pemesanan->jumlah_malam,
                'harga_per_malam' => $pemesanan->harga_per_malam,
                'total_harga' => $pemesanan->total_harga,
                'status' => $pemesanan->status,
                'metode_pembayaran' => $pemesanan->metode_pembayaran,
                'catatan' => $pemesanan->catatan,
                'bukti_transfer' => $buktiTransfer,
                'qr_code' => $pemesanan->qr_code_path ? asset('storage/' . $pemesanan->qr_code_path) : null,
                'pembayaran' => $pemesanan->pembayaran ? [
                    'id' => $pemesanan->pembayaran->id,
                    'jumlah' => $pemesanan->pembayaran->jumlah,
                    'metode' => $pemesanan->pembayaran->metode,
                    'status' => $pemesanan->pembayaran->status,
                    'bukti_transfer' => $pemesanan->pembayaran->bukti_transfer ? asset('storage/' . $pemesanan->pembayaran->bukti_transfer) : null,
                ] : null,
                'created_at' => $pemesanan->created_at?->format('d M Y H:i'),
            ]
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:menunggu_pembayaran,menunggu_verifikasi,dibayar,check_in,check_out,batal'
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $oldStatus = $pemesanan->status;
        $newStatus = $validated['status'];

        $validTransitions = [
            'menunggu_pembayaran' => ['dibayar', 'menunggu_verifikasi', 'batal'],
            'menunggu_verifikasi' => ['dibayar', 'batal'],
            'dibayar' => ['check_in', 'batal'],
            'check_in' => ['check_out', 'batal'],
            'check_out' => [],
            'batal' => [],
        ];

        if (!in_array($newStatus, $validTransitions[$oldStatus] ?? [])) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat mengubah status dari '{$oldStatus}' ke '{$newStatus}'"
            ], 400);
        }

        $pemesanan->status = $newStatus;
        
        if ($newStatus === 'dibayar') {
            $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
            if ($pembayaran) {
                $pembayaran->status = 'verified';
                $pembayaran->save();
            }
        }
        $pemesanan->save();

        return response()->json([
            'success' => true,
            'message' => "Status berhasil diubah dari '{$oldStatus}' menjadi '{$newStatus}'",
            'data' => ['id' => $pemesanan->id, 'nomor_pemesanan' => $pemesanan->nomor_pemesanan, 'status' => $pemesanan->status]
        ]);
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $validated = $request->validate([
            'action' => 'required|in:terima,tolak',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status !== 'menunggu_verifikasi' || $pemesanan->metode_pembayaran !== 'transfer') {
            return response()->json(['success' => false, 'message' => 'Pemesanan ini tidak dapat diverifikasi'], 400);
        }

        if ($validated['action'] === 'terima') {
            $pemesanan->status = 'dibayar';
            $pemesanan->save();
            $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
            if ($pembayaran) {
                $pembayaran->status = 'verified';
                $pembayaran->verified_at = now();
                $pembayaran->verified_by = $user->id;
                $pembayaran->catatan = $validated['catatan'] ?? 'Pembayaran diverifikasi';
                $pembayaran->save();
            }
            $message = 'Pembayaran diterima. Status pemesanan diubah menjadi "dibayar".';
        } else {
            $pemesanan->status = 'menunggu_pembayaran';
            $pemesanan->save();
            $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
            if ($pembayaran) {
                $pembayaran->status = 'failed';
                $pembayaran->verified_at = now();
                $pembayaran->verified_by = $user->id;
                $pembayaran->catatan = $validated['catatan'] ?? 'Pembayaran ditolak';
                $pembayaran->save();
            }
            $message = 'Pembayaran ditolak. Silakan tamu upload ulang bukti transfer.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => ['id' => $pemesanan->id, 'nomor_pemesanan' => $pemesanan->nomor_pemesanan, 'status' => $pemesanan->status]
        ]);
    }

    public function checkIn($id, Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $pemesanan = Pemesanan::findOrFail($id);

        if (in_array($pemesanan->status, ['menunggu_pembayaran', 'menunggu_verifikasi'])) {
            $pemesanan->status = 'dibayar';
            $pemesanan->save();
        }

        if ($pemesanan->status !== 'dibayar') {
            return response()->json(['success' => false, 'message' => 'Pemesanan harus berstatus "dibayar" untuk check-in'], 400);
        }

        $now = Carbon::now();
        $checkInTime = Carbon::parse($pemesanan->check_in)->setHour(13)->setMinute(0);
        
        if ($now->startOfDay()->lt($checkInTime->startOfDay())) {
            return response()->json(['success' => false, 'message' => 'Check-in baru bisa dilakukan mulai ' . $checkInTime->format('d M Y H:i')], 400);
        }

        $roomNumbers = $request->input('room_numbers');
        if (!$roomNumbers || !is_array($roomNumbers) || count($roomNumbers) === 0) {
            return response()->json(['success' => false, 'message' => 'Nomor kamar harus dipilih'], 400);
        }

        $jumlahKamarBooking = (int)($pemesanan->jumlah_kamar ?? 1);
        if (count($roomNumbers) !== $jumlahKamarBooking) {
            return response()->json(['success' => false, 'message' => "Jumlah kamar yang dipilih (" . count($roomNumbers) . ") tidak sesuai dengan pemesanan ({$jumlahKamarBooking} kamar)"], 400);
        }

        if (count($roomNumbers) !== count(array_unique($roomNumbers))) {
            return response()->json(['success' => false, 'message' => 'Nomor kamar tidak boleh sama. Silakan pilih kamar yang berbeda.'], 400);
        }

        foreach ($roomNumbers as $roomNumber) {
            $kamar = Kamar::where('nomor_kamar', $roomNumber)->first();
            if (!$kamar) {
                return response()->json(['success' => false, 'message' => "Kamar {$roomNumber} tidak ditemukan"], 404);
            }
            if ($kamar->status !== 'tersedia') {
                return response()->json(['success' => false, 'message' => "Kamar {$roomNumber} tidak tersedia (status: {$kamar->status})"], 400);
            }
            $kamar->status = 'terisi';
            $kamar->save();
        }

        $pemesanan->room_number = implode(',', $roomNumbers);
        $pemesanan->status = 'check_in';
        $pemesanan->waktu_checkin_aktual = $now;
        $pemesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil untuk ' . count($roomNumbers) . ' kamar!',
            'data' => [
                'id' => $pemesanan->id,
                'nomor_pemesanan' => $pemesanan->nomor_pemesanan,
                'status' => $pemesanan->status,
                'checked_in_at' => $now->format('d M Y H:i'),
                'room_numbers' => $roomNumbers,
                'jumlah_kamar' => count($roomNumbers),
            ]
        ]);
    }

    public function cetakStruk($id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $pemesanan = Pemesanan::with(['tipeKamar', 'pembayaran'])->findOrFail($id);
        $userData = DB::table('admin')->where('id', $pemesanan->user_id)->first();

        $dataCetak = [
            'hotel_name' => 'Flojachi Hotel',
            'hotel_address' => 'Jl. Kedung Sumur No. 123, Kota',
            'hotel_phone' => '(+62) 821-0668-551',
            'nomor_pemesanan' => $pemesanan->nomor_pemesanan,
            'tanggal_cetak' => Carbon::now()->format('d M Y H:i'),
            'data_pemesan' => ['nama' => $pemesanan->nama_pemesan, 'email' => $userData?->email ?? '-', 'no_telp' => $userData?->no_telp ?? '-'],
            'detail_kamar' => ['tipe' => $pemesanan->tipeKamar?->nama, 'jumlah' => $pemesanan->jumlah_kamar ?? 1, 'harga_per_malam' => $pemesanan->harga_per_malam],
            'periode' => ['check_in' => $pemesanan->check_in?->format('d M Y, H:i'), 'check_out' => $pemesanan->check_out?->format('d M Y, H:i'), 'jumlah_malam' => $pemesanan->jumlah_malam],
            'pembayaran' => ['metode' => ucfirst($pemesanan->metode_pembayaran), 'subtotal' => $pemesanan->total_harga, 'denda' => $pemesanan->denda_keterlambatan ?? 0, 'total' => ($pemesanan->total_harga ?? 0) + ($pemesanan->denda_keterlambatan ?? 0), 'status' => $pemesanan->status],
            'qr_code' => $pemesanan->qr_code_path ? asset('storage/' . $pemesanan->qr_code_path) : null,
            'catatan' => $pemesanan->catatan,
        ];

        return response()->json(['success' => true, 'data' => $dataCetak]);
    }

    public function showProfile()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id, 'name' => $user->username, 'email' => $user->email,
                'phone' => $user->no_telp, 'birthdate' => null, 'address' => $user->alamat,
                'foto_profil' => $user->gambar ? asset('storage/' . $user->gambar) : null,
                'level' => $user->level, 'status' => $user->status,
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'phone' => 'nullable|string|max:13',
                'address' => 'nullable|string|max:500',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if (isset($validated['name'])) $user->username = $validated['name'];
            if (isset($validated['phone'])) $user->no_telp = $validated['phone'];
            if (isset($validated['address'])) $user->alamat = $validated['address'];
            if ($request->hasFile('foto_profil')) {
                $uploadPath = 'uploads/profile';
                if (!Storage::disk('public')->exists($uploadPath)) Storage::disk('public')->makeDirectory($uploadPath);
                if ($user->gambar) Storage::disk('public')->delete($user->gambar);
                $file = $request->file('foto_profil');
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs($uploadPath, $filename, 'public');
                $user->gambar = $filePath;
            }
            $user->save();
            return response()->json([
                'success' => true, 'message' => 'Profil berhasil diperbarui',
                'data' => [...$user->toArray(), 'foto_profil' => $user->gambar ? asset('storage/' . $user->gambar) : null, 'gambar' => $user->gambar ? asset('storage/' . $user->gambar) : null]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate(['old_password' => 'required', 'new_password' => 'required|min:6|confirmed']);
        if (!Hash::check($validated['old_password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah'], 422);
        }
        $user->password = Hash::make($validated['new_password']);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Berhasil logout']);
    }

    public function scanQR(Request $request)
{
    $user = Auth::user();
    if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
        return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
    }

    $validated = $request->validate(['nomor_pemesanan' => 'required|string']);
    $pemesanan = Pemesanan::with(['tipeKamar', 'pembayaran'])->where('nomor_pemesanan', $validated['nomor_pemesanan'])->first();

    if (!$pemesanan) {
        return response()->json(['success' => false, 'message' => 'Pemesanan tidak ditemukan'], 404);
    }

    $userData = DB::table('admin')->where('id', $pemesanan->user_id)->first();
    $now = Carbon::now();
    $checkInTime = Carbon::parse($pemesanan->check_in)->setHour(13);
    $checkOutTime = Carbon::parse($pemesanan->check_out)->setHour(12)->setMinute(0);

    if (in_array($pemesanan->status, ['menunggu_pembayaran', 'menunggu_verifikasi'])) {
        $pemesanan->status = 'dibayar';
        $pemesanan->save();
        $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
        if ($pembayaran) {
            $pembayaran->status = 'verified';
            $pembayaran->verified_at = now();
            $pembayaran->verified_by = $user->id;
            $pembayaran->save();
        }
    }

    $canCheckIn = $pemesanan->status === 'dibayar' && $now->gte($checkInTime);
    $canCheckOut = $pemesanan->status === 'check_in';
    
    $isLateCheckOut = $canCheckOut && $now->gt($checkOutTime);
    $jamTerlambat = 0;
    $denda = 0;
    
    if ($isLateCheckOut) {
        $jamTerlambat = $checkOutTime->diffInHours($now);
        $jamTerlambat = min($jamTerlambat, 23);
        $denda = $jamTerlambat * 50000;
    }

    $availableRooms = [];
    if ($pemesanan->tipe_kamar_id) {
        $availableRooms = \App\Models\Kamar::where('id_tipe_kamar', $pemesanan->tipe_kamar_id)
            ->where('status', 'tersedia')->orderBy('nomor_kamar', 'asc')->pluck('nomor_kamar')->toArray();
    }

    $buktiTransfer = null;
    if ($pemesanan->pembayaran && $pemesanan->pembayaran->bukti_transfer) {
        $buktiTransfer = asset('storage/' . $pemesanan->pembayaran->bukti_transfer);
    }

    // ✅ TAMPILKAN WAKTU REAL CHECK-IN (jika sudah check-in)
    $waktuCheckinDisplay = $pemesanan->waktu_checkin_aktual 
        ? Carbon::parse($pemesanan->waktu_checkin_aktual)->format('d M Y H:i')
        : $pemesanan->check_in?->setHour(13)->setMinute(0)->format('d M Y H:i');

    // ✅ TAMPILKAN WAKTU DEADLINE CHECK-OUT
    $waktuCheckoutDeadlineDisplay = $pemesanan->check_out?->setHour(12)->setMinute(0)->format('d M Y H:i');

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $pemesanan->id, 'nomor_pemesanan' => $pemesanan->nomor_pemesanan,
            'nama_pemesan' => $pemesanan->nama_pemesan, 'email' => $userData?->email ?? '-',
            'no_telp' => $userData?->no_telp ?? '-', 'tipe_kamar' => $pemesanan->tipeKamar?->nama ?? '-',
            'tipe_kamar_id' => $pemesanan->tipe_kamar_id, 'jumlah_kamar' => (int)($pemesanan->jumlah_kamar ?? 1),
            'check_in' => $waktuCheckinDisplay,
            'check_out_deadline' => $waktuCheckoutDeadlineDisplay,
            'status' => $pemesanan->status, 'total_harga' => $pemesanan->total_harga,
            'metode_pembayaran' => $pemesanan->metode_pembayaran, 'bukti_transfer' => $buktiTransfer,
            'qr_code' => $pemesanan->qr_code_path ? asset('storage/' . $pemesanan->qr_code_path) : null,
            'can_check_in' => $canCheckIn, 'can_check_out' => $canCheckOut, 'can_verify' => false,
            'is_late_checkout' => $isLateCheckOut, 'jam_terlambat' => $jamTerlambat,
            'denda' => $denda, 'denda_per_jam' => 50000, 'available_rooms' => $availableRooms,
            'waktu_checkin_aktual' => $pemesanan->waktu_checkin_aktual ? Carbon::parse($pemesanan->waktu_checkin_aktual)->format('d M Y H:i') : null,
            'waktu_checkout_aktual' => $pemesanan->waktu_checkout_aktual ? Carbon::parse($pemesanan->waktu_checkout_aktual)->format('d M Y H:i') : null,
        ]
    ]);
}

    public function checkOut($id, Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $pemesanan = Pemesanan::findOrFail($id);
        if ($pemesanan->status !== 'check_in') {
            return response()->json(['success' => false, 'message' => 'Pemesanan harus berstatus "check_in" untuk check-out'], 400);
        }

        $now = Carbon::now();
        // ✅ DEADLINE: tanggal_checkout + jam 12:00
        $checkOutTime = Carbon::parse($pemesanan->check_out)->setHour(12)->setMinute(0);
        
        // ✅ HITUNG DENDA PER JAM - SUPPORT CROSS-DAY
        $jamTerlambat = 0;
        $denda = 0;
        
        if ($now->gt($checkOutTime)) {
            // Hitung selisih jam (support cross-day: 12:00 → 08:00 next day = 20 jam)
            $jamTerlambat = $checkOutTime->diffInHours($now);
            $jamTerlambat = min($jamTerlambat, 23); // Maksimal 23 jam
            $denda = $jamTerlambat * 50000; // Rp 50.000 per jam
        }

        $pemesanan->status = 'check_out';
        $pemesanan->waktu_checkout_aktual = $now;
        $pemesanan->denda_keterlambatan = $denda;
        $pemesanan->jam_terlambat = $jamTerlambat;
        $pemesanan->verified_by = $user->id; 
        $pemesanan->save();

        if ($pemesanan->tipe_kamar_id && $pemesanan->jumlah_kamar) {
            $tipeKamar = \App\Models\TipeKamar::find($pemesanan->tipe_kamar_id);
            if ($tipeKamar) {
                $tipeKamar->stok += (int)$pemesanan->jumlah_kamar;
                $tipeKamar->save();
            }
        }

        if ($pemesanan->room_number) {
            $roomNumbers = explode(',', $pemesanan->room_number);
            foreach ($roomNumbers as $roomNumber) {
                $kamar = Kamar::where('nomor_kamar', trim($roomNumber))->first();
                if ($kamar) {
                    $kamar->status = 'dibersihkan';
                    $kamar->save();
                }
            }
        }

        $popupMessage = "Check-out berhasil!\n\n";
        if ($jamTerlambat > 0) {
            $popupMessage .= "⚠️ Terlambat: {$jamTerlambat} jam\n";
            $popupMessage .= "Denda: Rp " . number_format($denda, 0, ',', '.') . " (Rp 50.000/jam)\n\n";
        } else {
            $popupMessage .= "✅ Check-out tepat waktu\n\n";
        }
        $popupMessage .= "Data tersimpan di laporan.";

        return response()->json([
            'success' => true, 'message' => 'Check-out berhasil!',
            'data' => [
                'id' => $pemesanan->id, 'nomor_pemesanan' => $pemesanan->nomor_pemesanan,
                'status' => 'check_out', 'checked_out_at' => $now->format('d M Y H:i'),
                'denda' => $denda, 'jam_terlambat' => $jamTerlambat, 'resepsionis_id' => $user->id,
            ],
            'show_popup' => true, 'popup_message' => $popupMessage
        ]);
    }

    public function getPembayaran($pemesananId)
    {
        try {
            $pembayaran = Pembayaran::where('pemesanan_id', $pemesananId)->first();
            if (!$pembayaran) {
                return response()->json(['success' => false, 'message' => 'Data pembayaran tidak ditemukan'], 404);
            }
            $data = $pembayaran->toArray();
            if ($pembayaran->bukti_transfer) {
                $data['bukti_transfer_url'] = asset('storage/' . $pembayaran->bukti_transfer);
            }
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data pembayaran', 'error' => $e->getMessage()], 500);
        }
    }

    public function laporan(Request $request)
{
    $user = Auth::user();
    if (!$user || !in_array($user->level, ['admin', 'resepsionis'])) {
        return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
    }

    $query = Pemesanan::with(['tipeKamar']);
    if ($request->filled('tanggal_mulai')) $query->whereDate('waktu_checkout_aktual', '>=', $request->tanggal_mulai);
    if ($request->filled('tanggal_selesai')) $query->whereDate('waktu_checkout_aktual', '<=', $request->tanggal_selesai);
    if ($request->filled('resepsionis_id')) $query->where('resepsionis_id', $request->resepsionis_id);
    $query->where('status', 'check_out');

    $laporan = $query->orderBy('waktu_checkout_aktual', 'desc')->paginate(20);

    $data = $laporan->getCollection()->map(function($p) {
        $userData = DB::table('admin')->where('id', $p->user_id)->first();
        $resepsionisData = DB::table('admin')->where('id', $p->resepsionis_id)->first();
        
        // ✅ TAMPILKAN CHECK-IN DENGAN JAM 13:00
        $waktuCheckinDisplay = $p->check_in 
            ? Carbon::parse($p->check_in)->setHour(13)->setMinute(0)->format('d M Y H:i')
            : '-';
        
        // ✅ TAMPILKAN CHECK-OUT DENGAN JAM REAL (waktu actual checkout)
        $waktuCheckoutDisplay = $p->waktu_checkout_aktual 
            ? Carbon::parse($p->waktu_checkout_aktual)->format('d M Y H:i')
            : ($p->check_out ? Carbon::parse($p->check_out)->setHour(12)->setMinute(0)->format('d M Y H:i') : '-');
        
        return [
            'id' => $p->id, 
            'nomor_pemesanan' => $p->nomor_pemesanan,
            'nama_pemesan' => $p->nama_pemesan ?? ($userData?->username ?? 'Unknown'),
            'tipe_kamar' => $p->tipeKamar?->nama ?? '-',
            // ✅ CHECK-IN: JAM 13:00 (SESUAI ATURAN HOTEL)
            'check_in' => $waktuCheckinDisplay,
            // ✅ CHECK-OUT: JAM REAL (SESUAI WAKTU TAMU CHECKOUT)
            'check_out' => $waktuCheckoutDisplay,
            'checked_out_at' => $p->waktu_checkout_aktual ? Carbon::parse($p->waktu_checkout_aktual)->format('d M Y H:i') : '-',
            'jumlah_kamar' => $p->jumlah_kamar ?? 1,
            'total_harga' => (int)($p->total_harga ?? 0),
            'denda_keterlambatan' => (int)($p->denda_keterlambatan ?? 0),
            'jam_terlambat' => (int)($p->jam_terlambat ?? 0),
            'grand_total' => (int)(($p->total_harga ?? 0) + ($p->denda_keterlambatan ?? 0)),
            'resepsionis_nama' => $resepsionisData?->username ?? '-',
        ];
    });

    $totalPendapatan = Pemesanan::where('status', 'check_out')
        ->when($request->filled('tanggal_mulai'), fn($q) => $q->whereDate('waktu_checkout_aktual', '>=', $request->tanggal_mulai))
        ->when($request->filled('tanggal_selesai'), fn($q) => $q->whereDate('waktu_checkout_aktual', '<=', $request->tanggal_selesai))
        ->when($request->filled('resepsionis_id'), fn($q) => $q->where('resepsionis_id', $request->resepsionis_id))
        ->sum('total_harga');
        
    $totalDenda = Pemesanan::where('status', 'check_out')
        ->whereNotNull('denda_keterlambatan')
        ->when($request->filled('tanggal_mulai'), fn($q) => $q->whereDate('waktu_checkout_aktual', '>=', $request->tanggal_mulai))
        ->when($request->filled('tanggal_selesai'), fn($q) => $q->whereDate('waktu_checkout_aktual', '<=', $request->tanggal_selesai))
        ->when($request->filled('resepsionis_id'), fn($q) => $q->where('resepsionis_id', $request->resepsionis_id))
        ->sum('denda_keterlambatan');

    return response()->json([
        'success' => true, 'data' => $data,
        'summary' => [
            'total_transaksi' => $laporan->total(),
            'total_pendapatan' => (int)$totalPendapatan,
            'total_denda' => (int)$totalDenda,
            'grand_total' => (int)($totalPendapatan + $totalDenda),
        ],
        'pagination' => [
            'current_page' => $laporan->currentPage(), 'last_page' => $laporan->lastPage(),
            'total' => $laporan->total(), 'from' => $laporan->firstItem(), 'to' => $laporan->lastItem(),
        ]
    ]);
}
}