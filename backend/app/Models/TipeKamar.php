<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model
{
    protected $table = 'tipe_kamar';
    
    protected $fillable = [
        'nama', 
        'foto', 
        'harga_per_malam', 
        'fasilitas',
        'tipe_tempat_tidur',
        'tersedia',
        'stok'  // ✅ TAMBAHKAN FIELD STOK
    ];
    
    protected $casts = [
        'harga_per_malam' => 'decimal:2',
        'tersedia' => 'boolean',
        'stok' => 'integer',  // ✅ CAST STOK SEBAGAI INTEGER
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // ✅ RELASI KE PEMESANAN
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'tipe_kamar_id');
    }
    
    // ✅ ACCESSOR UNTUK URL FOTO
    public function getFotoUrlAttribute()
    {
        if ($this->foto && file_exists(storage_path('app/public/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        return '/default-room.jpg';
    }
}