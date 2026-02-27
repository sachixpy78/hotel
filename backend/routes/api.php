<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;

// =========================
// AUTHENTICATION
// =========================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Lupa Password
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::put('/reset-password', [AuthController::class, 'resetPassword']);

// =========================
// PROFIL ADMIN
// =========================
Route::get('/profile/{id}', [AuthController::class, 'getProfile']);
Route::post('/update-profile', [AuthController::class, 'updateProfile']);

// =========================
// KATEGORI CRUD
// =========================
Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::get('/kategori/{id}', [KategoriController::class, 'show']);
Route::put('/kategori/{id}', [KategoriController::class, 'update']);
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

// =========================
// PRODUK CRUD
// =========================
Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::put('/produk/{id}', [ProdukController::class, 'update']);
Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
Route::get('/produk/{id}/barcode', [ProdukController::class, 'generateBarcode']);
Route::post('/produk/kurangi-stok', [ProdukController::class, 'kurangiStok']);

// =========================
// TRANSAKSI
// =========================
Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::post('/transaksi', [TransaksiController::class, 'store']);
Route::get('/dashboard', [DashboardController::class, 'index']);

// =========================
// ADMIN CRUD (Super Admin)
// =========================
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/{id}', [AdminController::class, 'show']);
Route::put('/admin/{id}', [AdminController::class, 'update']); // ✅ Gunakan PUT untuk update
Route::delete('/admin/{id}', [AdminController::class, 'destroy']);

// Status Admin
Route::put('/admin/{id}/activate', [AdminController::class, 'activate']);
Route::put('/admin/{id}/deactivate', [AdminController::class, 'deactivate']);

// =========================
// LAPORAN (Super Admin)
// =========================
Route::prefix('laporan')->group(function () {
    Route::get('/grafik', [LaporanController::class, 'grafik']);
    Route::get('/tabel', [LaporanController::class, 'tabel']);
    Route::get('/export', [LaporanController::class, 'exportExcel']);
    Route::get('/export-tabel', [LaporanController::class, 'exportExcelTabel']);
});
