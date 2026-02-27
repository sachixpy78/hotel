<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama_produk','stok','modal','harga_jual','keuntungan',
        'fid_kategori','gambar','deskripsi','ketersediaan','estimasi','barcode'
        
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'fid_kategori');
    }
}
