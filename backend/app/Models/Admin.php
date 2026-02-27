<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'email',
        'username',
        'password',
        'gambar',
        'level',
        'status',
        'login_attempts' ,
         'otp',    
         'phone',          // ✅ tambahkan ini
    'otp_expires_at'   
    ];

    public $timestamps = true;
}
