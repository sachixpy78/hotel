<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransaksiExport implements Responsable
{
    protected $data;
    protected $type;

    public function __construct($data, $type = 'tabel')
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function toResponse($request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if ($this->type === 'grafik') {
            $sheet->setCellValue('A1', 'Tanggal');
            $sheet->setCellValue('B1', 'Total Penjualan');
            
            $row = 2;
            foreach ($this->data as $item) {
                $sheet->setCellValue('A' . $row, $item->tanggal ?? '');
                $sheet->setCellValue('B' . $row, 'Rp ' . number_format($item->total ?? 0, 0, ',', '.'));
                $row++;
            }
        } else {
            $sheet->setCellValue('A1', 'Tanggal');
            $sheet->setCellValue('B1', 'Nama Produk');
            $sheet->setCellValue('C1', 'Total Harga');
            $sheet->setCellValue('D1', 'Detail');
            $sheet->setCellValue('E1', 'Keuntungan');
            
            $row = 2;
            foreach ($this->data as $item) {
                $sheet->setCellValue('A' . $row, $item->tanggal_pembelian ?? '');
                $sheet->setCellValue('B' . $row, $item->nama_produk ?? '');
                $sheet->setCellValue('C' . $row, $item->total_harga ?? 'Rp 0');
                $sheet->setCellValue('D' . $row, $item->detail ?? '');
                $sheet->setCellValue('E' . $row, $item->total_keuntungan ?? 'Rp 0');
                $row++;
            }
        }

        $filename = $this->type === 'grafik' 
            ? 'Laporan_Grafik.xlsx' 
            : 'Laporan_Tabel.xlsx';

        $writer = new Xlsx($spreadsheet);
        
        return Response::stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}