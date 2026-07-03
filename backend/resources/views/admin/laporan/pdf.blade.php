<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemesanan Hotel</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 9px; }
        h2 { text-align: center; margin: 0 0 5px 0; color: #1e40af; }
        .periode { text-align: center; margin: 0 0 15px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1e40af; color: white; padding: 6px 4px; text-align: left; border: 1px solid #ddd; font-weight: 600; }
        td { padding: 5px 4px; border: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9fafb; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 8px; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .total { text-align: right; font-weight: bold; font-size: 12px; margin-top: 15px; padding: 10px; background: #dcfce7; border-radius: 4px; }
        .footer { margin-top: 20px; text-align: center; font-size: 8px; color: #999; }
    </style>
</head>
<body>
    <h2>📊 LAPORAN PEMESANAN HOTEL</h2>
    <p class="periode">Periode: {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</p>
    
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>No. Pemesanan</th>
                <th>Tanggal</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th class="text-center">Check-in</th>
                <th class="text-center">Check-out</th>
                <th class="text-center">Jam Terlambat</th>
                <th class="text-right">Total</th>
                <th class="text-right">Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($data as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item->nomor_pemesanan }}</td>
                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                <td>{{ $item->nama_pemesan ?? ($item->user ? ($item->user->username ?? $item->user->nama) : '-') }}</td>
                <td>{{ $item->tipeKamar ? $item->tipeKamar->nama : '-' }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($item->check_in)) }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($item->check_out)) }}</td>
                
                <!-- ✅ KOLOM JAM TERLAMBAT -->
                <td class="text-center">
                    @if(($item->jam_terlambat ?? 0) > 0)
                        <span class="badge badge-red">{{ $item->jam_terlambat }} jam</span>
                    @else
                        <span class="badge badge-green">Tepat waktu</span>
                    @endif
                </td>
                
                <td class="text-right">Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
                
                <!-- ✅ KOLOM DENDA -->
                <td class="text-right" style="color: {{ ($item->denda_keterlambatan ?? 0) > 0 ? '#dc2626' : '#6b7280' }}; font-weight: {{ ($item->denda_keterlambatan ?? 0) > 0 ? 'bold' : 'normal' }}">
                    Rp {{ number_format($item->denda_keterlambatan ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- ✅ TOTAL SUDAH INCLUDE DENDA -->
    @php
        $grandTotal = $data->where('status', '!=', 'batal')->sum(function($item) {
            return ($item->total_harga ?? 0) + ($item->denda_keterlambatan ?? 0);
        });
    @endphp
    
    <div class="total">
        💰 Total Pendapatan (Termasuk Denda): Rp {{ number_format($grandTotal, 0, ',', '.') }}
    </div>
    
    <p class="footer">
        Dokumen ini dibuat otomatis pada {{ date('d/m/Y H:i:s') }} | Hotel Management System
    </p>
</body>
</html>