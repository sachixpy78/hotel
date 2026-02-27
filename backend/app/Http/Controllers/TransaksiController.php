<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('admin', 'produk');

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pembelian', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pembelian', '<=', $request->end_date);
        }

        $transaksi = $query->get();

        return response()->json([
            'success' => true,
            'data' => $transaksi,
            'meta' => [
                'total' => $transaksi->count(),
                'per_page' => 10,
                'current_page' => 1,
                'last_page' => 1
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'total_harga' => 'required|numeric',
            'fid_admin' => 'required|exists:admin,id',
            'fid_produk' => 'nullable|exists:produk,id',
            'detail' => 'required|string',
              'tunai' => 'required|numeric',     // ✅ Validasi
        'kembalian' => 'required|numeric',
            // total_keuntungan TIDAK WAJIB → DIHITUNG OTOMATIS
        ]);

        // Hitung total_keuntungan dari detail
        $detail = json_decode($request->detail, true);
        $totalKeuntungan = 0;

        if (is_array($detail)) {
            foreach ($detail as $item) {
                $modal = $item['modal'] ?? 0;
                $hargaJual = $item['harga_jual'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
                $totalKeuntungan += ($hargaJual - $modal) * $quantity;
            }
        }

      $transaksi = Transaksi::create([
    'tanggal_pembelian' => $request->tanggal_pembelian,
    'total_harga' => $request->total_harga,
    'fid_admin' => $request->fid_admin,
    'fid_produk' => $request->fid_produk,
    'detail' => $request->detail,
    'total_keuntungan' => max(0, $totalKeuntungan),
    // ✅ Tambahkan ini
    'tunai' => $request->tunai,
    'kembalian' => $request->kembalian
]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil disimpan',
            'data' => $transaksi
        ]);
    }

    public function dashboard()
    {
        $totalPendapatan = DB::table('transaksi')->sum('total_harga');
        $rataTransaksi = DB::table('transaksi')->avg('total_harga');
        $hariIni = date('Y-m-d');
        $pendapatanHariIni = DB::table('transaksi')
            ->whereDate('tanggal_pembelian', $hariIni)
            ->sum('total_harga');

        return response()->json([
            'total_pendapatan' => $totalPendapatan ?? 0,
            'rata_transaksi' => $rataTransaksi ?? 0,
            'pendapatan_hari_ini' => $pendapatanHariIni ?? 0,
        ]);
    }
}