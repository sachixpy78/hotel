<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
// ❌ HAPUS: use Illuminate\Support\Facades\Hash;  (tidak diperlukan lagi)

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',           // ✅ Sekarang akan disimpan plain text
        'gambar',
        'alamat',
        'no_telp',
        'level',
        'status',
        'login_attempts',
        'otp',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'id' => 'integer',
        'login_attempts' => 'integer',
        'otp_expires_at' => 'datetime',
    ];

    /**
     * ✅ MUTATOR: SIMPAN PASSWORD PLAIN TEXT (TANPA HASH)
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            // ✅ Langsung simpan value, TANPA Hash::make()
            set: fn ($value) => $value,
        );
    }

    /**
     * Accessor: Mengembalikan URL gambar lengkap
     */
    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->gambar && $this->gambar !== 'logo.jpg'
                ? url('storage/' . $this->gambar)
                : url('logo.jpg'),
        );
    }

    // ... (scope dan helper methods lainnya tetap sama) ...
    
    public function scopeAktif($query) { return $query->where('status', 'on'); }
    public function scopeLevel($query, $level) { return $query->where('level', $level); }
    public function scopeStatus($query, $status) { return $query->where('status', $status); }
    
    public function isAdmin(): bool { return $this->level === 'admin'; }
    public function isResepsionis(): bool { return $this->level === 'resepsionis'; }
    public function isTamu(): bool { return $this->level === 'tamu'; }
    public function isAktif(): bool { return $this->status === 'on'; }
    public function isBlokir(): bool { return $this->status === 'blokir'; }
    
    public static function generateOTP(): string {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
    
    public function isOTPValid(string $otp): bool {
        return $this->otp === $otp && 
               $this->otp_expires_at !== null && 
               $this->otp_expires_at->isFuture();
    }
    
    public function clearOTP(): void {
        $this->update(['otp' => null, 'otp_expires_at' => null]);
    }
    
    public function bookings() {
        return $this->hasMany(Booking::class, 'user_id');
    }
}