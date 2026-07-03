<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{
    /**
     * LAPORAN PEMESANAN - Admin
     */
    public function laporanPemesanan(Request $request)
    {
        $query = Pemesanan::with(['user', 'tipeKamar'])
            ->where('status', 'check_out');
        
        // Filter bulan & tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
        }
        
        // Filter verified_by (resepsionis)
        if ($request->filled('resepsionis_id')) {
            $query->where('verified_by', $request->resepsionis_id);
        }
        
        $laporan = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $data = $laporan->getCollection()->map(function($p) {
            $userData = DB::table('admin')->where('id', $p->user_id)->first();
            $resepsionisData = DB::table('admin')->where('id', $p->verified_by)->first();
            
            return [
                'id' => $p->id,
                'nomor_pemesanan' => $p->nomor_pemesanan,
                'tanggal' => $p->check_out ? Carbon::parse($p->check_out)->format('d M Y') : '-',
                'nama_tamu' => $p->nama_pemesan ?? ($userData?->username ?? '-'),
                'tipe_kamar' => $p->tipeKamar ? $p->tipeKamar->nama : '-',
                'check_in' => $p->check_in ? Carbon::parse($p->check_in)->format('d M Y') : '-',
                'check_out' => $p->check_out ? Carbon::parse($p->check_out)->format('d M Y') : '-',
                'total_harga' => (int)($p->total_harga ?? 0),
                'denda_keterlambatan' => (int)($p->denda_keterlambatan ?? 0),
                'jam_terlambat' => (int)($p->jam_terlambat ?? 0),
                'grand_total' => (int)(($p->total_harga ?? 0) + ($p->denda_keterlambatan ?? 0)),
                'verified_by' => $p->verified_by,
                'resepsionis_nama' => $resepsionisData?->username ?? '-',
            ];
        });
        
        // Summary
        $totalPendapatan = Pemesanan::where('status', 'check_out')
            ->when($request->filled('bulan') && $request->filled('tahun'), function($q) use ($request) {
                $q->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
            })
            ->when($request->filled('resepsionis_id'), function($q) use ($request) {
                $q->where('verified_by', $request->resepsionis_id);
            })
            ->sum('total_harga');
        
        $totalDenda = Pemesanan::where('status', 'check_out')
            ->when($request->filled('bulan') && $request->filled('tahun'), function($q) use ($request) {
                $q->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
            })
            ->when($request->filled('resepsionis_id'), function($q) use ($request) {
                $q->where('verified_by', $request->resepsionis_id);
            })
            ->sum('denda_keterlambatan');
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'summary' => [
                'total_transaksi' => $laporan->total(),
                'total_pendapatan' => (int)$totalPendapatan,
                'total_denda' => (int)$totalDenda,
                'grand_total' => (int)($totalPendapatan + $totalDenda),
            ],
            'pagination' => [
                'current_page' => $laporan->currentPage(),
                'last_page' => $laporan->lastPage(),
                'total' => $laporan->total(),
                'from' => $laporan->firstItem(),
                'to' => $laporan->lastItem(),
            ]
        ]);
    }

    /**
     * GET LIST RESEPSIONIS untuk filter
     */
    public function resepsionisList()
    {
        $resepsionis = DB::table('admin')
            ->where('level', 'resepsionis')
            ->where('status', 'on')
            ->select('id', 'username')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $resepsionis
        ]);
    }

    /**
     * EXPORT EXCEL LAPORAN
     */
    public function exportLaporanExcel(Request $request)
    {
        $query = Pemesanan::with(['user', 'tipeKamar'])
            ->where('status', 'check_out');
        
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
        }
        
        if ($request->filled('resepsionis_id')) {
            $query->where('verified_by', $request->resepsionis_id);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'LAPORAN PEMESANAN HOTEL');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $periode = '';
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $bulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $periode = 'Periode: ' . $bulan[$request->bulan] . ' ' . $request->tahun;
        }
        if ($request->filled('resepsionis_id')) {
            $resepsionis = DB::table('admin')->where('id', $request->resepsionis_id)->first();
            $periode .= $periode ? ' | ' : 'Periode: ';
            $periode .= 'Resepsionis: ' . ($resepsionis ? $resepsionis->username : '-');
        }
        $sheet->setCellValue('A2', $periode);
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Column headers
        $headers = ['No', 'No. Pemesanan', 'Tanggal', 'Nama Tamu', 'Tipe Kamar', 'Check-in', 'Check-out', 'Total', 'Denda', 'Grand Total', 'Resepsionis'];
        $sheet->fromArray($headers, null, 'A4');
        
        // Style header
        $sheet->getStyle('A4:K4')->getFont()->setBold(true);
        $sheet->getStyle('A4:K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DC2626');
        $sheet->getStyle('A4:K4')->getFont()->getColor()->setRGB('FFFFFF');
        
        // Data rows
        $row = 5;
        $totalPendapatan = 0;
        $totalDenda = 0;
        $no = 1;
        
        foreach ($data as $item) {
            $grandTotal = ($item->total_harga ?? 0) + ($item->denda_keterlambatan ?? 0);
            $resepsionis = DB::table('admin')->where('id', $item->verified_by)->value('username') ?? '-';
            
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nomor_pemesanan);
            $sheet->setCellValue('C' . $row, $item->check_out ? Carbon::parse($item->check_out)->format('d/m/Y') : '-');
            $sheet->setCellValue('D' . $row, $item->nama_pemesan ?? '-');
            $sheet->setCellValue('E' . $row, $item->tipeKamar ? $item->tipeKamar->nama : '-');
            $sheet->setCellValue('F' . $row, $item->check_in ? Carbon::parse($item->check_in)->format('d/m/Y') : '-');
            $sheet->setCellValue('G' . $row, $item->check_out ? Carbon::parse($item->check_out)->format('d/m/Y') : '-');
            $sheet->setCellValue('H' . $row, $item->total_harga ?? 0);
            $sheet->setCellValue('I' . $row, $item->denda_keterlambatan ?? 0);
            $sheet->setCellValue('J' . $row, $grandTotal);
            $sheet->setCellValue('K' . $row, $resepsionis);
            
            $totalPendapatan += $item->total_harga ?? 0;
            $totalDenda += $item->denda_keterlambatan ?? 0;
            $row++;
        }
        
        // Total row
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->mergeCells('A' . $row . ':G' . $row);
        $sheet->setCellValue('H' . $row, $totalPendapatan);
        $sheet->setCellValue('I' . $row, $totalDenda);
        $sheet->setCellValue('J' . $row, $totalPendapatan + $totalDenda);
        $sheet->getStyle('A' . $row . ':K' . $row)->getFont()->setBold(true);
        $sheet->getStyle('H' . $row . ':J' . $row)->getNumberFormat()->setFormatCode('#,##0');
        
        // Auto-size
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getStyle('H5:J' . ($row-1))->getNumberFormat()->setFormatCode('#,##0');
        
        $filename = 'Laporan_Hotel_' . ($request->tahun ?? now()->year) . '_' . ($request->bulan ?? now()->month) . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * EXPORT PDF LAPORAN
     */
    public function exportLaporanPDF(Request $request)
    {
        $query = Pemesanan::with(['user', 'tipeKamar'])
            ->where('status', 'check_out');
        
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('resepsionis_id')) {
            $query->where('verified_by', $request->resepsionis_id);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $data->sum('total_harga');
        $totalDenda = $data->sum('denda_keterlambatan');
        
        // Build HTML
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $periode = ($request->filled('bulan') && $request->filled('tahun')) ? $bulan[$request->bulan] . ' ' . $request->tahun : 'Semua Periode';
        $resepsionisNama = '';
        if ($request->filled('resepsionis_id')) {
            $resepsionis = DB::table('admin')->where('id', $request->resepsionis_id)->first();
            $resepsionisNama = $resepsionis ? $resepsionis->username : '-';
        }
        
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Laporan</title>
        <style>body{font-family:Arial,sans-serif;font-size:11px}.header{text-align:center;margin-bottom:15px}
        .header h1{margin:0;font-size:16px}table{width:100%;border-collapse:collapse}
        th{background-color:#DC2626;color:#fff;padding:6px;text-align:left;font-size:10px}
        td{padding:5px;border-bottom:1px solid #ddd;font-size:10px}.text-right{text-align:right}
        .total{font-weight:700;background-color:#f5f5f5}.footer{margin-top:20px;text-align:right}
        .footer strong{color:#DC2626;font-size:14px}</style></head><body>
        <div class="header"><h1>LAPORAN PEMESANAN HOTEL</h1><p>Periode: ' . $periode . 
        ($resepsionisNama ? ' | Resepsionis: ' . $resepsionisNama : '') . '</p></div>
        <table><thead><tr><th>No</th><th>No. Pemesanan</th><th>Tanggal</th><th>Nama Tamu</th>
        <th>Tipe Kamar</th><th>Check-in</th><th>Check-out</th><th class="text-right">Total</th>
        <th class="text-right">Denda</th><th class="text-right">Grand Total</th><th>Resepsionis</th></tr></thead><tbody>';
        
        $no = 1;
        foreach ($data as $item) {
            $grandTotal = ($item->total_harga ?? 0) + ($item->denda_keterlambatan ?? 0);
            $resepsionis = DB::table('admin')->where('id', $item->verified_by)->value('username') ?? '-';
            $html .= '<tr><td>' . $no++ . '</td><td>' . $item->nomor_pemesanan . '</td><td>' . 
                ($item->check_out ? Carbon::parse($item->check_out)->format('d/m/Y') : '-') . 
                '</td><td>' . ($item->nama_pemesan ?? '-') . '</td><td>' . 
                ($item->tipeKamar ? $item->tipeKamar->nama : '-') . '</td><td>' . 
                ($item->check_in ? Carbon::parse($item->check_in)->format('d/m/Y') : '-') . 
                '</td><td>' . ($item->check_out ? Carbon::parse($item->check_out)->format('d/m/Y') : '-') . 
                '</td><td class="text-right">' . number_format($item->total_harga ?? 0, 0, ',', '.') . 
                '</td><td class="text-right">' . number_format($item->denda_keterlambatan ?? 0, 0, ',', '.') . 
                '</td><td class="text-right">' . number_format($grandTotal, 0, ',', '.') . 
                '</td><td>' . $resepsionis . '</td></tr>';
        }
        
        $html .= '<tr class="total"><td colspan="7" class="text-right">TOTAL</td>
        <td class="text-right">' . number_format($totalPendapatan, 0, ',', '.') . 
        '</td><td class="text-right">' . number_format($totalDenda, 0, ',', '.') . 
        '</td><td class="text-right">' . number_format($totalPendapatan + $totalDenda, 0, ',', '.') . 
        '</td><td></td></tr></tbody></table>
        <div class="footer"><p><strong>Total Pendapatan: Rp ' . number_format($totalPendapatan + $totalDenda, 0, ',', '.') . '</strong></p></div>
        </body></html>';
        
        $pdf = \PDF::loadHTML($html)->setPaper('a4', 'landscape');
        $filename = 'Laporan_Hotel_' . ($request->tahun ?? now()->year) . '_' . ($request->bulan ?? now()->month) . '.pdf';
        return $pdf->download($filename);
    }
}