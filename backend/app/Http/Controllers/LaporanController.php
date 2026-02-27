<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // === GRAFIK (HARIAN) ===
    public function grafik(Request $request)
    {
        try {
            $bulan = $request->query('bulan', date('m'));
            $tahun = $request->query('tahun', date('Y'));
            $id_kasir = $request->query('id_kasir');

            $query = DB::table('transaksi')
                ->select(
                    DB::raw("DATE_FORMAT(tanggal_pembelian, '%d-%m-%Y') as tanggal"),
                    DB::raw("SUM(CAST(REPLACE(REPLACE(total_harga, 'Rp ', ''), '.', '') AS UNSIGNED)) as total")
                )
                ->whereYear('tanggal_pembelian', $tahun)
                ->whereMonth('tanggal_pembelian', $bulan);

            if ($id_kasir) {
                $query->where('fid_admin', $id_kasir);
            }

            $data = $query
                ->groupBy(DB::raw("DATE_FORMAT(tanggal_pembelian, '%d-%m-%Y')"))
                ->orderBy('tanggal_pembelian')
                ->get();

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    // === EXPORT GRAFIK (CSV) ===
    public function exportExcel(Request $request)
    {
        try {
            $bulan = $request->query('bulan', date('m'));
            $tahun = $request->query('tahun', date('Y'));
            $id_kasir = $request->query('id_kasir');

            $query = DB::table('transaksi')
                ->select(
                    DB::raw("DATE_FORMAT(tanggal_pembelian, '%d-%m-%Y') as tanggal"),
                    DB::raw("SUM(CAST(REPLACE(REPLACE(total_harga, 'Rp ', ''), '.', '') AS UNSIGNED)) as total")
                )
                ->whereYear('tanggal_pembelian', $tahun)
                ->whereMonth('tanggal_pembelian', $bulan);

            if ($id_kasir) {
                $query->where('fid_admin', $id_kasir);
            }

            $data = $query
                ->groupBy(DB::raw("DATE_FORMAT(tanggal_pembelian, '%d-%m-%Y')"))
                ->orderBy('tanggal_pembelian')
                ->get();

            $filename = "Laporan_Grafik_{$bulan}_{$tahun}" . ($id_kasir ? "_kasir_{$id_kasir}" : "") . ".csv";

            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename={$filename}");
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['Tanggal', 'Total Penjualan']);

            foreach ($data as $row) {
                fputcsv($output, [
                    $row->tanggal,
                    'Rp ' . number_format($row->total, 0, ',', '.')
                ]);
            }

            fclose($output);
            exit();

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

// === DATA TABEL (UNTUK FRONTEND) ===
public function tabel(Request $request)
{
    try {
        $bulan = $request->query('bulan', date('m'));
        $tahun = $request->query('tahun', date('Y'));
        $id_kasir = $request->query('id_kasir');

        $query = DB::table('transaksi')
            ->select(
                'transaksi.tanggal_pembelian',
                'produk.nama_produk as nama_produk',
                'transaksi.total_harga',
                'transaksi.detail',
                'transaksi.total_keuntungan',
                'admin.username as kasir_nama',       // ← nama kasir
                'produk.deskripsi as produk_deskripsi' // ← deskripsi produk
            )
            ->join('produk', 'transaksi.fid_produk', '=', 'produk.id')
            ->leftJoin('admin', 'transaksi.fid_admin', '=', 'admin.id') // ← join admin untuk nama kasir
            ->whereYear('transaksi.tanggal_pembelian', $tahun)
            ->whereMonth('transaksi.tanggal_pembelian', $bulan);

        if ($id_kasir) {
            $query->where('transaksi.fid_admin', $id_kasir);
        }

        $data = $query
            ->orderBy('transaksi.tanggal_pembelian', 'desc')
            ->get();

        return response()->json($data);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
        ], 500);
    }
}
    // === EXPORT TABEL (CSV) ===
    public function exportExcelTabel(Request $request)
    {
        try {
            $bulan = $request->query('bulan', date('m'));
            $tahun = $request->query('tahun', date('Y'));
            $id_kasir = $request->query('id_kasir');

            $query = DB::table('transaksi')
                ->select(
                    'transaksi.tanggal_pembelian',
                    'produk.nama_produk as nama_produk',
                    'transaksi.total_harga',
                    'transaksi.detail',
                    'transaksi.total_keuntungan'
                )
                ->join('produk', 'transaksi.fid_produk', '=', 'produk.id')
                ->whereYear('transaksi.tanggal_pembelian', $tahun)
                ->whereMonth('transaksi.tanggal_pembelian', $bulan);

            if ($id_kasir) {
                $query->where('transaksi.fid_admin', $id_kasir);
            }

            $data = $query
                ->orderBy('transaksi.tanggal_pembelian', 'desc')
                ->get();

            $filename = "Laporan_Tabel_{$bulan}_{$tahun}" . ($id_kasir ? "_kasir_{$id_kasir}" : "") . ".csv";

            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename={$filename}");
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['Tanggal', 'Nama Produk', 'Total Harga', 'Detail', 'Keuntungan']);

            foreach ($data as $row) {
                fputcsv($output, [
                    $row->tanggal_pembelian,
                    $row->nama_produk,
                    $row->total_harga,
                    $row->detail,
                    $row->total_keuntungan
                ]);
            }

            fclose($output);
            exit();

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}