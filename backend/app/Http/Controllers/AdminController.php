<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;  

class AdminController extends Controller
{
    /**
     * GET ALL USERS (Admin, Resepsionis, Tamu)
     * Admin dapat mengelola data user sesuai PDF
     */
    public function index(Request $request)
    {
        $query = Admin::query();
        
        // Filter by level (optional)
        if ($request->has('level')) {
            $query->where('level', $request->level);
        }
        
        // Filter by status (optional)
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by username/email/no_telp
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('no_telp', 'LIKE', "%{$search}%");
            });
        }
        
        $admins = $query->orderBy('created_at', 'desc')->get();
        
        // Transform: add gambar_url, hide sensitive fields
        $admins->transform(function($admin) {
            unset($admin->password, $admin->otp); // Hide sensitive
            return $admin;
        });
        
        return response()->json($admins);
    }

    /**
     * GET USER BY ID
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        
        if (!$admin) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        // Hide sensitive fields
        unset($admin->password, $admin->otp);
        
        return response()->json($admin);
    }

    /**
     * CREATE NEW USER (Admin only - Sesuai PDF)
     * Admin dapat menambah data user
     */
    public function store(Request $request)
    {
        // Validate sesuai database schema
        $request->validate([
            'username'  => 'required|string|max:255|unique:admin,username',
            'email'     => 'required|email|max:255|unique:admin,email',
            'password'  => 'required|string|min:5',
            'no_telp'   => 'nullable|string|max:20',
            'alamat'    => 'required|string',
            'level'     => 'required|in:admin,resepsionis,tamu',
            'status'    => 'required|in:on,off,blokir',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $gambarNama = 'logo.jpg'; // default
        
        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $gambarNama = $request->file('gambar')->store('profiles', 'public');
        }

        $admin = Admin::create([
            'username'       => $request->username,
            'email'          => $request->email,
            'password'       => $request->password,  // ✅ Mutator Model auto-hash
            'no_telp'        => $request->no_telp,
            'alamat'         => $request->alamat,
            'gambar'         => $gambarNama,
            'level'          => $request->level,
            'status'         => $request->status,
            'login_attempts' => 0,
        ]);

        // Hide sensitive fields from response
        unset($admin->password, $admin->otp);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $admin
        ], 201);
    }

    /**
     * UPDATE USER (Admin only - Sesuai PDF)
     * Admin dapat mengupdate data user termasuk profil diri
     */
    public function update(Request $request, $id)
    {
        $target = Admin::find($id);
        
        if (!$target) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // Validate sesuai database schema
        $request->validate([
            'username'  => 'required|string|max:255|unique:admin,username,' . $id,
            'email'     => 'required|email|max:255|unique:admin,email,' . $id,
            'password'  => 'nullable|string|min:5',
            'no_telp'   => 'nullable|string|max:20',
            'alamat'    => 'required|string',
            'level'     => 'required|in:admin,resepsionis,tamu',
            'status'    => 'required|in:on,off,blokir',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // ✅ PERMISSION: Cek apakah user yang login adalah admin
        // Ambil user dari token Sanctum (lebih reliable daripada header custom)
        $currentUser = $request->user();
        
        // Hanya admin yang boleh edit user lain
        if ($currentUser && $currentUser->level !== 'admin') {
            // User non-admin hanya boleh edit profil sendiri
            if ($currentUser->id != $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengedit user ini.'
                ], 403);
            }
        }

        // Prepare data update (sesuai field database)
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ];

        // ✅ HASH PASSWORD jika diubah (Model mutator akan handle)
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        // ✅ UPLOAD FOTO jika ada
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada (bukan default)
            if ($target->gambar && $target->gambar !== 'logo.jpg' && Storage::disk('public')->exists($target->gambar)) {
                Storage::disk('public')->delete($target->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('profiles', 'public');
        }

        // ✅ UPDATE LEVEL & STATUS (hanya admin yang bisa ubah)
        if ($currentUser && $currentUser->level === 'admin') {
            if ($request->filled('level')) {
                $data['level'] = $request->level;
            }
            if ($request->filled('status')) {
                $data['status'] = $request->status;
            }
        }

        // Preserve login_attempts
        $data['login_attempts'] = $target->login_attempts;

        $target->update($data);
        
        // Hide sensitive fields from response
        unset($target->password, $target->otp);

        return response()->json([
            'success' => true, 
            'message' => 'Profil berhasil diperbarui',
            'data' => $target
        ]);
    }

    /**
     * DELETE USER (Admin only - Sesuai PDF)
     * Admin dapat menghapus data user (kecuali admin level 'admin')
     */
    public function destroy($id)
    {
        $target = Admin::find($id);
        
        if (!$target) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        // ✅ Tidak bisa hapus akun level 'admin'
        if ($target->level === 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'Tidak dapat menghapus akun administrator'
            ], 403);
        }

        // Hapus foto jika ada (bukan default)
        if ($target->gambar && $target->gambar !== 'logo.jpg' && Storage::disk('public')->exists($target->gambar)) {
            Storage::disk('public')->delete($target->gambar);
        }

        $target->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'User berhasil dihapus'
        ]);
    }

    /**
     * ACTIVATE USER (Approve account)
     * Admin dapat mengaktifkan akun tamu/resepsionis
     */
    public function activate($id)
    {
        $target = Admin::find($id);
        
        if (!$target) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        // ✅ Tidak bisa aktifkan akun level 'admin'
        if ($target->level === 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'Akun administrator tidak dapat diubah via endpoint ini'
            ], 400);
        }

        $target->update([
            'status' => 'on',
            'login_attempts' => 0  // Reset attempts
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Akun berhasil diaktifkan'
        ]);
    }

    /**
     * DEACTIVATE USER (Temporary disable)
     * Admin dapat menonaktifkan akun tamu/resepsionis
     */
    public function deactivate($id)
    {
        $target = Admin::find($id);
        
        if (!$target) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        // ✅ Tidak bisa nonaktifkan akun level 'admin'
        if ($target->level === 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'Akun administrator tidak dapat dinonaktifkan via endpoint ini'
            ], 400);
        }

        $target->update(['status' => 'off']);
        
        return response()->json([
            'success' => true, 
            'message' => 'Akun berhasil dinonaktifkan'
        ]);
    }

    /**
     * BLOCK USER
     * Admin dapat memblokir akun tamu/resepsionis
     */
    public function block($id)
    {
        $target = Admin::find($id);
        
        if (!$target) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        if ($target->level === 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'Akun administrator tidak dapat diblokir via endpoint ini'
            ], 400);
        }

        $target->update(['status' => 'blokir']);
        
        return response()->json([
            'success' => true, 
            'message' => 'Akun berhasil diblokir'
        ]);
    }

    /**
     * UNBLOCK USER
     * Admin dapat membuka blokir akun
     */
    public function unblock($id)
    {
        $target = Admin::find($id);
        
        if (!$target) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        if ($target->level === 'admin') {
            return response()->json([
                'success' => false, 
                'message' => 'Akun administrator tidak dapat diubah via endpoint ini'
            ], 400);
        }

        $target->update([
            'status' => 'off',
            'login_attempts' => 0
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Blokir akun berhasil diangkat'
        ]);
    }

    public function laporanPemesanan(Request $request)
{
    $query = Pemesanan::with([
        'user',
        'tipeKamar',
        'resepsionis'
    ])
    ->whereYear('created_at', $request->tahun ?? now()->year())
    ->whereMonth('created_at', $request->bulan ?? now()->month())
    ->where('status', 'check_out');
    
    if ($request->id_resepsionis) {
        $query->where('verified_by', $request->id_resepsionis);
    }
    
    $data = $query->orderBy('created_at', 'desc')
        ->paginate($request->per_page ?? 20);
    
    // Transform data
    $data->getCollection()->transform(function($pemesanan) {
        // ✅ CHECK-IN: Tampilkan jam 13:00 (sesuai aturan hotel)
        $checkinDisplay = '-';
        if ($pemesanan->check_in) {
            $checkinDisplay = Carbon::parse($pemesanan->check_in)->setHour(13)->setMinute(0)->format('d M Y H:i');
        }
        
        // ✅ CHECK-OUT: Tampilkan waktu REAL (waktu actual checkout)
        $checkoutDisplay = '-';
        if ($pemesanan->waktu_checkout_aktual) {
            $checkoutDisplay = Carbon::parse($pemesanan->waktu_checkout_aktual)->format('d M Y H:i');
        } elseif ($pemesanan->check_out) {
            // Fallback ke jadwal check-out jam 12:00
            $checkoutDisplay = Carbon::parse($pemesanan->check_out)->setHour(12)->setMinute(0)->format('d M Y H:i');
        }
        
        return [
            'id' => $pemesanan->id,
            'nomor_pemesanan' => $pemesanan->nomor_pemesanan,
            'created_at' => $pemesanan->created_at,
            // ✅ FIELD LAMA tetap ada (untuk kompatibilitas)
            'check_in' => $pemesanan->check_in ? Carbon::parse($pemesanan->check_in)->format('d M Y') : '-',
            'check_out' => $pemesanan->check_out ? Carbon::parse($pemesanan->check_out)->format('d M Y') : '-',
            // ✅ FIELD BARU dengan JAM
            'check_in_with_time' => $checkinDisplay,
            'check_out_with_time' => $checkoutDisplay,
            'total_harga' => $pemesanan->total_harga,
            'denda_keterlambatan' => $pemesanan->denda_keterlambatan ?? 0,
            'jam_terlambat' => $pemesanan->jam_terlambat ?? 0,
            'status' => $pemesanan->status,
            'verified_by' => $pemesanan->verified_by,
            'nama_tamu' => $pemesanan->nama_pemesan ?? ($pemesanan->user ? ($pemesanan->user->username ?? $pemesanan->user->nama ?? '-') : '-'),
            'user' => $pemesanan->user,
            'tipe_kamar' => $pemesanan->tipeKamar,
            'nama_kamar' => $pemesanan->tipeKamar ? $pemesanan->tipeKamar->nama : '-',
            'resepsionis_nama' => $pemesanan->resepsionis ? ($pemesanan->resepsionis->username ?? $pemesanan->resepsionis->nama ?? '-') : '-',
            'verified_by_name' => $pemesanan->resepsionis ? ($pemesanan->resepsionis->username ?? $pemesanan->resepsionis->nama ?? '-') : '-',
        ];
    });
    
    return response()->json($data);
}
    /**
     * EXPORT EXCEL - Benar-benar DOWNLOAD file
     */
    public function exportLaporanExcel(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        
        $query = Pemesanan::with(['user', 'tipeKamar', 'resepsionis'])
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan);
        
        if ($request->id_resepsionis) {
            $query->where('verified_by', $request->id_resepsionis);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        // Create Excel file menggunakan PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set judul sheet
        $sheet->setTitle('Laporan Hotel');
        
        // Header
        $sheet->setCellValue('A1', 'LAPORAN PEMESANAN HOTEL');
        $sheet->setCellValue('A2', 'Periode: ' . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)));
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Column headers
        $headers = ['No', 'No. Pemesanan', 'Tanggal', 'Nama Tamu', 'Email', 'Tipe Kamar', 'Check-in', 'Check-out', 'Malam', 'Jam Terlambat', 'Total Harga', 'Denda', 'Resepsionis'];
        $sheet->fromArray($headers, null, 'A4');
        
        // Style header
        $sheet->getStyle('A4:L4')->getFont()->setBold(true);
        $sheet->getStyle('A4:L4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('1e40af');
        $sheet->getStyle('A4:L4')->getFont()->getColor()->setRGB('FFFFFF');
        
        // Data rows
        $row = 5;
        $totalPendapatan = 0;
        $no = 1;
        
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nomor_pemesanan);
            $sheet->setCellValue('C' . $row, date('d/m/Y', strtotime($item->created_at)));
            $sheet->setCellValue('D' . $row, $item->nama_pemesan ?? ($item->user ? ($item->user->username ?? $item->user->nama) : '-'));
            $sheet->setCellValue('E' . $row, $item->user ? $item->user->email : '-');
            $sheet->setCellValue('F' . $row, $item->tipeKamar ? $item->tipeKamar->nama : '-');
            $sheet->setCellValue('G' . $row, date('d/m/Y', strtotime($item->check_in)));
            $sheet->setCellValue('H' . $row, date('d/m/Y', strtotime($item->check_out)));
            $sheet->setCellValue('I' . $row, $item->jumlah_malam);
            $sheet->setCellValue('J' . $row, ($item->jam_terlambat ?? 0) . ' jam');  // Jam Terlambat
            $sheet->setCellValue('K' . $row, $item->denda_keterlambatan ?? 0);     
            $sheet->setCellValue('L' . $row, $item->total_harga);
            $sheet->setCellValue('M' . $row, $item->resepsionis ? ($item->resepsionis->username ?? $item->resepsionis->nama) : '-');
            
            if ($item->status !== 'batal') {
    $totalPendapatan += $item->total_harga + ($item->denda_keterlambatan ?? 0);  // ✅ Include denda
}
            $row++;
        }
        
        // Total row
        $sheet->setCellValue('A' . $row, 'TOTAL PENDAPATAN');
        $sheet->mergeCells('A' . $row . ':I' . $row);
        $sheet->setCellValue('J' . $row, 'Rp ' . number_format($totalPendapatan, 0, ',', '.'));
        $sheet->getStyle('A' . $row . ':J' . $row)->getFont()->setBold(true);
        
        // Auto-size columns
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Download file
        $filename = 'Laporan_Hotel_' . $bulan . '_' . $tahun . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * EXPORT PDF - Benar-benar DOWNLOAD file PDF
     */
    public function exportLaporanPDF(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        
        $query = Pemesanan::with(['user', 'tipeKamar', 'resepsionis'])
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan);
        
        if ($request->id_resepsionis) {
            $query->where('verified_by', $request->id_resepsionis);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $data->where('status', '!=', 'batal')->sum('total_harga');
        
        // Load view PDF
        $pdf = \PDF::loadView('admin.laporan.pdf', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total' => $totalPendapatan
        ])->setPaper('a4', 'landscape');
        
        // Download file
        $filename = 'Laporan_Hotel_' . $bulan . '_' . $tahun . '.pdf';
        return $pdf->download($filename);
    }
}