<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;
    
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'pemesanan_id',
        'jumlah',
        'metode',
        'status',
        'bukti_transfer',
        'verified_by',
        'verified_at',
        'tanggal_pembayaran'
    ];
    
    protected $casts = [
        'jumlah' => 'decimal:2',
        'verified_at' => 'datetime',
        'tanggal_pembayaran' => 'datetime'
    ];
    
    /**
     * Relasi ke Pemesanan
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
    
    /**
     * Relasi ke Admin (verifikator)
     */
    public function verifikator()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }
    
    /**
     * Scope: Pembayaran pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    /**
     * Scope: Pembayaran terverifikasi
     */
    public function scopeTerverifikasi($query)
    {
        return $query->where('status', 'terverifikasi');
    }
}