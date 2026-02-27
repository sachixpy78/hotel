<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal_pembelian','total_harga','fid_admin',
        'fid_produk','detail','total_keuntungan','tunai',      // ✅ Harus ada!
        'kembalian', 
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'fid_admin');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'fid_produk');
    }
}
