<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\ResepsionisController; // ✅ TAMBAHKAN INI
use App\Http\Controllers\QRCodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =========================
// AUTH
// =========================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/logout', [AuthController::class, 'logout']);

// LUPA PASSWORD
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::put('/reset-password', [AuthController::class, 'resetPassword']);

// =========================
// ADMIN MANAJEMEN (TIDAK DIUBAH)
// =========================
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/{id}', [AdminController::class, 'show']);
Route::post('/admin/{id}', [AdminController::class, 'update']);
Route::delete('/admin/{id}', [AdminController::class, 'destroy']);
Route::put('/admin/{id}/activate', [AdminController::class, 'activate']);
Route::put('/admin/{id}/deactivate', [AdminController::class, 'deactivate']);
Route::put('/admin/{id}', [AdminController::class, 'update']); 
// Laporan Pemesanan
    Route::get('/admin/laporan/pemesanan', [AdminController::class, 'laporanPemesanan']);
    Route::get('/admin/laporan/export-excel', [AdminController::class, 'exportLaporanExcel']);
    Route::get('/admin/laporan/export-pdf', [AdminController::class, 'exportLaporanPDF']);
    
    

// =========================
// KAMAR (Room Management - Admin) (TIDAK DIUBAH)
// =========================
Route::get('/kamar', [RoomController::class, 'index']);
Route::post('/kamar', [RoomController::class, 'store']);
Route::put('/kamar/{id}', [RoomController::class, 'update']);
Route::delete('/kamar/{id}', [RoomController::class, 'destroy']);
Route::get('/kamar/available/{tipeKamarId}', [RoomController::class, 'getAvailableRoomsByType']);
Route::post('/kamar/auto-clean', [RoomController::class, 'autoCleanRooms']);

// =========================
// ROOM TYPE (Tipe Kamar) (TIDAK DIUBAH)
// =========================
Route::get('/room-types', [RoomTypeController::class, 'index']);
Route::post('/room-types', [RoomTypeController::class, 'store']);
Route::put('/room-types/{id}', [RoomTypeController::class, 'update']);
Route::delete('/room-types/{id}', [RoomTypeController::class, 'destroy']);
Route::patch('/room-types/{id}/stok', [RoomTypeController::class, 'updateStok']);
Route::patch('/room-types/{id}/toggle', [RoomTypeController::class, 'toggleTersedia']);

Route::post('/cari-kamar', [RoomTypeController::class, 'cariKamar']);
Route::get('/room-types/{id}', [RoomTypeController::class, 'show']);

// =========================
// TAMU - PUBLIC (Tanpa Login) (TIDAK DIUBAH)
// =========================
Route::get('/kamar-tersedia', [TamuController::class, 'semuaKamar']);
Route::get('/kamar/{id}', [TamuController::class, 'detailKamar']);
Route::post('/cek-pesanan', [TamuController::class, 'cekPesanan']);

// =========================
// TAMU - AUTH (Harus Login) (TIDAK DIUBAH)
// =========================
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('/tamu/dashboard', [TamuController::class, 'dashboard']);
    
    // Pemesanan
    Route::post('/tamu/pesan', [TamuController::class, 'buatPemesanan']);
    Route::get('/tamu/pemesanan', [TamuController::class, 'pemesananSaya']);
    Route::get('/tamu/pemesanan/{id}', [TamuController::class, 'detailPemesanan']);
    Route::post('/tamu/upload-bukti/{id}', [TamuController::class, 'uploadBukti']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tamu/dashboard', [TamuController::class, 'dashboard']);
    Route::get('/tamu/profile', [TamuController::class, 'showProfile']);
    Route::put('/tamu/profile', [TamuController::class, 'updateProfile']);
    Route::post('/tamu/update-password', [TamuController::class, 'updatePassword']);
    Route::post('/logout', [TamuController::class, 'logout']);
});

// =========================
// ✅ RESEPSIONIS - TAMBAHAN BARU (FIX)
// =========================
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('/resepsionis/dashboard', [ResepsionisController::class, 'dashboard']);
    
    // Scan QR Code / Cari Pemesanan
    Route::post('/resepsionis/scan-qr', [ResepsionisController::class, 'scanQR']);
    
    // Data Pemesanan
    Route::get('/resepsionis/pemesanan', [ResepsionisController::class, 'semuaPemesanan']);
    Route::get('/resepsionis/pemesanan/{id}', [ResepsionisController::class, 'detailPemesanan']);
    
    // Aksi: Check-in, Check-out, Verifikasi
    Route::post('/resepsionis/pemesanan/{id}/check-in', [ResepsionisController::class, 'checkIn']);
    Route::post('/resepsionis/pemesanan/{id}/check-out', [ResepsionisController::class, 'checkOut']);
    Route::post('/resepsionis/pemesanan/{id}/verifikasi', [ResepsionisController::class, 'verifikasiPembayaran']);
    
    // Update status manual (opsional)
    Route::put('/resepsionis/pemesanan/{id}/status', [ResepsionisController::class, 'updateStatus']);
    
    // Cetak struk
    Route::get('/resepsionis/pemesanan/{id}/struk', [ResepsionisController::class, 'cetakStruk']);
    
    // Laporan
    Route::get('/resepsionis/laporan', [ResepsionisController::class, 'laporan']);
    
    // Profile Resepsionis
    Route::get('/resepsionis/profile', [ResepsionisController::class, 'showProfile']);
    Route::put('/resepsionis/profile', [ResepsionisController::class, 'updateProfile']);
    Route::post('/resepsionis/update-password', [ResepsionisController::class, 'updatePassword']);
    
    // Logout
    Route::post('/resepsionis/logout', [ResepsionisController::class, 'logout']);
});

// =========================
// ❌ HAPUS/HINDARI INI (Route lama yang salah - pointing ke TamuController)
// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('/resepsionis/dashboard', [TamuController::class, 'dashboardStats']);
//     Route::get('/resepsionis/pemesanan', [TamuController::class, 'allBookings']);
//     Route::put('/resepsionis/pemesanan/{id}/status', [TamuController::class, 'updateStatus']);
// });

// =========================
// NOTIFIKASI (TIDAK DIUBAH)
// =========================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/notifications', [NotificationController::class, 'index']);
    Route::put('/admin/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('/admin/notifications/{id}', [NotificationController::class, 'destroy']);
    Route::delete('/admin/notifications/clear-all', [NotificationController::class, 'clearAll']);
});


// =========================
// QR CODE (TIDAK DIUBAH)
// =========================

Route::post('/pemesanan/{id}/generate-qr', [QRCodeController::class, 'generate']);
Route::get('/pemesanan/{id}/download-qr', [QRCodeController::class, 'download']);
Route::post('/pemesanan/verify-qr', [QRCodeController::class, 'verify']);
Route::get('/pemesanan/{id}/qr-base64', [QRCodeController::class, 'generateBase64']);

// =========================
// STORAGE (Akses Gambar) (TIDAK DIUBAH)
// =========================
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (file_exists($fullPath)) {
        return response()->file($fullPath);
    }
    abort(404);
})->where('path', '.*');