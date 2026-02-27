<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalHariIni = DB::table('transaksi')
            ->whereDate('created_at', $today)
            ->sum(DB::raw("CAST(REPLACE(REPLACE(total_harga, 'Rp ', ''), '.', '') AS UNSIGNED)"));

        $jumlahTransaksi = DB::table('transaksi')
            ->whereDate('created_at', $today)
            ->count();

        $rataRata = $jumlahTransaksi > 0 ? $totalHariIni / $jumlahTransaksi : 0;

        return response()->json([
            'total_pendapatan' => (int) $totalHariIni,
            'rata_rata_transaksi' => (int) $rataRata
        ]);
    }
}