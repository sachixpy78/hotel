<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'nomor_pemesanan',
        'user_id',
        'tipe_kamar_id',
        'nama_pemesan',
        'jumlah_kamar',
        'check_in',
        'check_out',
        'jumlah_malam',
        'harga_per_malam',
        'total_harga',
        'status',
        'metode_pembayaran',
        'catatan',
        'qr_code_path',
        'room_number',
        'waktu_checkin_aktual',
        'waktu_checkout_aktual',
        'denda_keterlambatan',
        'jam_terlambat',
        'verified_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'waktu_checkin_aktual' => 'datetime',
        'waktu_checkout_aktual' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke user (tamu)
    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id', 'id');
    }

    // Relasi ke tipe kamar
    public function tipeKamar()
    {
        return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id', 'id');
    }

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pemesanan_id', 'id');
    }

    // Relasi ke resepsionis yang melakukan verifikasi checkout
    public function resepsionis()
    {
        return $this->belongsTo(Admin::class, 'verified_by', 'id');
    }

    // Alias untuk verifikator
    public function verifikator()
    {
        return $this->belongsTo(Admin::class, 'verified_by', 'id');
    }
}