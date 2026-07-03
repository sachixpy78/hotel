<?php
namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QRCodeController extends Controller
{
    // Tampilkan QR Code untuk pemesanan
    public function generate($pemesananId)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($pemesananId);
            
            // Prioritaskan QR code yang sudah tersimpan
            if ($pemesanan->qr_code_path) {
                $filePath = storage_path('app/public/' . $pemesanan->qr_code_path);
                
                if (file_exists($filePath)) {
                    return response()->file($filePath);
                }
            }
            
            // Fallback: Generate ulang jika file tidak ada
            $qrData = $pemesanan->nomor_pemesanan;
            
            $qrCode = QrCode::format('png')
                ->size(300)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($qrData);
            
            return response($qrCode)->header('Content-Type', 'image/png');
            
        } catch (\Exception $e) {
            // Error QR
            $errorQr = QrCode::format('png')
                ->size(300)
                ->generate('Error: QR Code tidak tersedia');
            
            return response($errorQr)->header('Content-Type', 'image/png');
        }
    }
    
    // Download QR Code
    public function download($pemesananId)
    {
        $pemesanan = Pemesanan::findOrFail($pemesananId);
        
        if (!$pemesanan->qr_code_path) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak tersedia'
            ], 404);
        }
        
        $filePath = storage_path('app/public/' . $pemesanan->qr_code_path);
        
        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File QR Code tidak ditemukan'
            ], 404);
        }
        
        return response()->download($filePath, 'QR_' . $pemesanan->nomor_pemesanan . '.png');
    }
}