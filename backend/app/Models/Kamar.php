<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    
    protected $fillable = ['nomor_kamar', 'id_tipe_kamar', 'status', 'keterangan'];

    // Relasi: Kamar punya satu Tipe Kamar
    public function tipeKamar()
    {
        return $this->belongsTo(TipeKamar::class, 'id_tipe_kamar');
    }
}