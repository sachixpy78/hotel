<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // ==========================
    // LOGIN
    // ==========================    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'level' => 'required|in:admin,resepsionis,tamu'
        ]);

        $admin = Admin::where('email', $request->email)
            ->where('level', $request->level)
            ->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau level tidak ditemukan.'
            ], 401);
        }

        if ($admin->status === 'blokir') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah diblokir. Hubungi administrator.'
            ], 403);
        }

        if ($admin->status === 'off') {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum aktif. Hubungi admin untuk verifikasi.'
            ], 403);
        }

        // ✅ CEK PASSWORD PLAIN TEXT (tanpa Hash::check)
        if ($request->password !== $admin->password) {
            if ($admin->level === 'resepsionis') {
                $admin->login_attempts = ($admin->login_attempts ?? 0) + 1;
                
                if ($admin->login_attempts >= 3) {
                    $admin->status = 'blokir';
                    $admin->login_attempts = 0;
                    $admin->save();
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Akun diblokir karena 3 kali login gagal.'
                    ], 403);
                }
                $admin->save();
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Password salah.'
            ], 401);
        }

        if ($admin->level === 'resepsionis' && $admin->login_attempts > 0) {
            $admin->login_attempts = 0;
            $admin->save();
        }

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'token' => $token,
            'admin' => [
                'id' => $admin->id,
                'username' => $admin->username,
                'email' => $admin->email,
                'level' => $admin->level,
                'status' => $admin->status,
                'gambar' => $admin->gambar,
                'gambar_url' => $admin->gambar_url,
                'no_telp' => $admin->no_telp,
                'alamat' => $admin->alamat,
            ]
        ]);
    }

    // ========================
    // REGISTER (Tamu & Resepsionis)
    // ========================
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username',
            'email' => 'required|email|max:255|unique:admin,email',
            'password' => 'required|string|min:5|confirmed',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'level' => 'required|in:tamu,resepsionis',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        try {
            $gambarNama = 'logo.jpg';

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('profiles', 'public');
                $gambarNama = $path;
            }

            $status = $request->level === 'tamu' ? 'on' : 'off';

            $admin = Admin::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'gambar' => $gambarNama,
                'level' => $request->level,
                'status' => $status,
                'login_attempts' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => $status === 'on' 
                    ? 'Registrasi berhasil! Silakan login.' 
                    : 'Registrasi berhasil! Akun menunggu verifikasi admin.',
                'data' => [
                    'id' => $admin->id,
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'level' => $admin->level,
                    'status' => $admin->status
                ]
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username atau email sudah terdaftar.'
                ], 409);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Register gagal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftar. Coba lagi nanti.'
            ], 500);
        }
    }

    // ========================
    // VERIFIKASI OLEH ADMIN
    // ========================
    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:admin,id'
        ]);

        $admin = Admin::findOrFail($request->id);

        if ($admin->level === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Akun administrator tidak dapat diverifikasi via endpoint ini.'
            ], 400);
        }

        if ($admin->status === 'on') {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini sudah aktif.'
            ], 400);
        }

        $admin->status = 'on';
        $admin->login_attempts = 0;
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil diverifikasi dan diaktifkan.'
        ]);
    }

    // ========================
    // LOGOUT
    // ========================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.'
        ]);
    }
    
    // ========================
    // 1. FORGOT PASSWORD → Kirim OTP
    // ========================
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|exists:admin,email',
            'no_telp' => 'nullable|string',
            'metode' => 'required|in:email,whatsapp'
        ]);

        if (!$request->email && !$request->no_telp) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau nomor WhatsApp wajib diisi.'
            ], 400);
        }

        $admin = null;
        if ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } else if ($request->no_telp) {
            $phone = preg_replace('/^[\+0]+/', '', $request->no_telp);
            if (strpos($phone, '62') === 0) {
                $phone = '0' . substr($phone, 2);
            }
            $admin = Admin::where('no_telp', $phone)
                         ->orWhere('no_telp', $request->no_telp)
                         ->orWhere('no_telp', '62' . ltrim($request->no_telp, '0'))
                         ->first();
        }

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $admin->otp = $otp;
        $admin->otp_expires_at = now()->addMinutes(10);
        $admin->save();

        // ✅ FIX: Gunakan && agar metode pengiriman sesuai request user
        if ($request->metode === 'email' && $admin->email) {
            // ✅ Kirim ke email yang ada di database
            $this->sendOtpViaEmail($admin, $otp);
            $pesan = 'Kode OTP telah dikirim ke email Anda.';
        } else if ($request->metode === 'whatsapp' && $admin->no_telp) {
            // ✅ Kirim ke nomor yang diformat dari request (prioritas) atau dari DB
            $phoneToSend = $request->no_telp ?? $admin->no_telp;
            $this->sendOtpViaWhatsApp($phoneToSend, $otp, $admin->username);
            $pesan = 'Kode OTP telah dikirim ke WhatsApp Anda.';
        } else {
            // Jika metode tidak sesuai dengan data admin
            return response()->json([
                'success' => false,
                'message' => 'Metode pengiriman tidak tersedia untuk akun ini.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $pesan,
            'email' => $admin->email,
            'no_telp' => $admin->no_telp
        ]);
    }

    // ========================
    // KIRIM OTP VIA EMAIL
    // ========================
    private function sendOtpViaEmail($admin, $otp)
    {
        $subject = 'Kode OTP Reset Password - ' . config('app.name');
        
        Mail::html(
            "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f5f5f5;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                    <h2 style='color: #333; margin-bottom: 20px;'>Kode OTP Reset Password</h2>
                    <p style='color: #666; margin-bottom: 15px;'>Halo <strong>{$admin->username}</strong>,</p>
                    <p style='color: #666; margin-bottom: 20px;'>Kode OTP Anda untuk reset password adalah:</p>
                    <div style='background-color: #d9534f; color: white; padding: 20px; text-align: center; font-size: 32px; font-weight: bold; border-radius: 5px; margin: 20px 0; letter-spacing: 5px;'>
                        {$otp}
                    </div>
                    <p style='color: #666; margin-bottom: 10px;'>Kode ini berlaku selama <strong>10 menit</strong>.</p>
                    <p style='color: #999; font-size: 12px; margin-top: 30px;'>Jangan berikan kode ini kepada siapapun. Jika Anda tidak meminta reset password, abaikan email ini.</p>
                </div>
            </div>
            ",
            function ($message) use ($admin, $subject) {
                $message->to($admin->email)->subject($subject);
            }
        );
    }

    // ========================
    // ✅ KIRIM OTP VIA WHATSAPP (FONNTE)
    // ========================
    private function sendOtpViaWhatsApp($phone, $otp, $username)
    {
        $token = env('FONNTE_TOKEN');

        if (!$token) {
            \Log::error('Fonnte token tidak dikonfigurasi di .env');
            throw new \Exception('Fonnte token tidak dikonfigurasi di .env');
        }

        // ✅ FORMAT NOMOR: Pastikan format 628xxx (tanpa +, tanpa 0 depan)
        $phoneNumber = preg_replace('/[^0-9]/', '', $phone); // Hapus semua non-digit
        
        if (strpos($phoneNumber, '0') === 0) {
            $phoneNumber = '62' . substr($phoneNumber, 1); // 0812 → 62812
        }
        if (strpos($phoneNumber, '62') !== 0) {
            $phoneNumber = '62' . $phoneNumber; // 812 → 62812
        }

        \Log::info('Fonnte: Sending OTP', [
            'to' => $phoneNumber,
            'otp' => $otp,
            'username' => $username
        ]);

        $url = 'https://api.fonnte.com/send';
        
        $message = "🔐 *Kode OTP Reset Password*\n\n" .
                   "Halo *{$username}*!\n\n" .
                   "Kode OTP Anda: *{$otp}*\n\n" .
                   "Kode ini berlaku 10 menit.\n" .
                   "Jangan berikan kode ini ke siapapun.";

        $response = Http::withHeaders([
            'Authorization' => $token
        ])->post($url, [
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '62'
        ]);

        $result = $response->json();

        \Log::info('Fonnte: Response', [
            'status' => $response->status(),
            'response' => $result
        ]);

        // ✅ Cek response Fonnte
        if (!$response->successful() || !isset($result['status']) || !$result['status']) {
            \Log::error('Fonnte: Failed to send', [
                'response' => $result,
                'http_status' => $response->status()
            ]);
            throw new \Exception("Gagal kirim WhatsApp: " . ($result['reason'] ?? $response->body() ?? 'Unknown error'));
        }

        return $result;
    }

    // ========================
    // 2. VERIFY OTP → Verifikasi kode OTP
    // ========================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string',
            'otp' => 'required|string|size:6'
        ]);

        if (!$request->email && !$request->no_telp) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau nomor WhatsApp wajib diisi.'
            ], 400);
        }

        $admin = null;
        if ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } else if ($request->no_telp) {
            $phone = preg_replace('/^[\+0]+/', '', $request->no_telp);
            if (strpos($phone, '62') === 0) {
                $phone = '0' . substr($phone, 2);
            }
            $admin = Admin::where('no_telp', $phone)
                         ->orWhere('no_telp', $request->no_telp)
                         ->orWhere('no_telp', '62' . ltrim($request->no_telp, '0'))
                         ->first();
        }

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        if (!$admin->otp || $admin->otp !== $request->otp || $admin->otp_expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak valid atau sudah kadaluarsa.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP valid. Silakan buat password baru.',
            'email' => $admin->email,
            'no_telp' => $admin->no_telp
        ]);
    }

    // ========================
    // 3. RESET PASSWORD → Update password plain text
    // ========================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string',
            'password' => 'required|string|min:5|confirmed'
        ]);

        if (!$request->email && !$request->no_telp) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau nomor WhatsApp wajib diisi.'
            ], 400);
        }

        $admin = null;
        if ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } else if ($request->no_telp) {
            $phone = preg_replace('/^[\+0]+/', '', $request->no_telp);
            if (strpos($phone, '62') === 0) {
                $phone = '0' . substr($phone, 2);
            }
            $admin = Admin::where('no_telp', $phone)
                         ->orWhere('no_telp', $request->no_telp)
                         ->orWhere('no_telp', '62' . ltrim($request->no_telp, '0'))
                         ->first();
        }

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        // ✅ Update password plain text (mutator di Model sudah dihapus)
        $admin->password = $request->password;
        $admin->otp = null;
        $admin->otp_expires_at = null;
        $admin->login_attempts = 0;
        $admin->status = 'on';
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah! Silakan login dengan password baru.'
        ]);
    }
}