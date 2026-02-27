<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ========================
    // LOGIN SUPER ADMIN / KASIR
    // ========================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
            'level'    => 'required'
        ]);

        $admin = Admin::where('email', $request->email)
                      ->where('level', $request->level)
                      ->first();

        if (!$admin) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        // CEK STATUS AKUN
        if ($admin->status === 'off') {
            return response()->json(['message' => 'Akun anda telah diblokir'], 403);
        }

        // CEK PASSWORD
        if ($request->password !== $admin->password) {
            // HANYA TERAPKAN LOGIN ATTEMPT UNTUK ROLE KASIR
            if ($admin->level === 'kasir') {
                $admin->login_attempts = $admin->login_attempts + 1;

                // JIKA SUDAH 3 KALI GAGAL, BLOKIR
                if ($admin->login_attempts >= 3) {
                    $admin->status = 'blokir';
                    $admin->login_attempts = 0; // Reset attempts
                    $admin->save();

                    return response()->json(['message' => 'Akun anda telah diblokir karena 3 kali login gagal'], 403);
                }

                $admin->save();
            }

            return response()->json(['message' => 'Password salah'], 401);
        }

        // JIKA LOGIN BERHASIL, RESET ATTEMPTS (hanya untuk kasir)
        if ($admin->level === 'kasir') {
            $admin->login_attempts = 0;
            $admin->save();
        }

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'admin'   => [
                'id'       => $admin->id,
                'email'    => $admin->email,
                'username' => $admin->username,
                'level'    => $admin->level,
                'gambar'   => $admin->gambar,
            ]
        ]);
    }

     // ========================
    // REGISTER (untuk kasir)
    // ========================
    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'username' => 'required',
            'password' => 'required',
            'level'    => 'required',
            'status'   => 'required'
        ]);

        // Handle upload gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public'); // Simpan ke storage/app/public/profile/
            $gambarPath = $path;
        }

        $admin = Admin::create([
            'email'          => $request->email,
            'username'       => $request->username,
            'password'       => $request->password,
            'gambar'         => $gambarPath, // ✅ Simpan path gambar
            'level'          => $request->level,
            'status'         => $request->status,
            'login_attempts' => 0 // ✅ Default 0
        ]);

        return response()->json([
            'message' => 'Akun berhasil dibuat',
            'data'    => $admin
        ]);
    }

    // ========================
    // GET PROFILE
    // ========================
    public function getProfile($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json($admin);
    }

    // ========================
    // UPDATE PROFILE (dengan upload foto)
    // ========================
    public function updateProfile(Request $request)
    {
        $request->validate([
            'id'       => 'required',
            'email'    => 'required',
            'username' => 'required'
        ]);

        $admin = Admin::find($request->id);

        if (!$admin) {
            return response()->json(['status' => false, 'message' => 'User tidak ditemukan']);
        }

        $admin->email = $request->email;
        $admin->username = $request->username;

        if ($request->password) {
            $admin->password = $request->password;
        }

        // UPLOAD FOTO
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($admin->gambar && Storage::disk('public')->exists($admin->gambar)) {
                Storage::disk('public')->delete($admin->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public'); // Simpan ke storage/app/public/profile/
            $admin->gambar = $path; // Contoh: "profile/1731600000_foto.jpg"
        }

        $admin->save();

        return response()->json([
            'status'  => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $admin
        ]);
    }

    // ========================
    // LUPA PASSWORD → KIRIM OTP (EMAIL ATAU WHATSAPP)
    // ========================
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|exists:admin,email',
            'phone' => 'nullable|string|exists:admin,phone'
        ]);

        // Validasi: harus isi salah satu
        if (!$request->email && !$request->phone) {
            return response()->json(['message' => 'Email atau nomor WhatsApp wajib diisi.'], 400);
        }

        // Cari admin berdasarkan email atau phone
        $admin = null;
        if ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } else if ($request->phone) {
            $admin = Admin::where('phone', $request->phone)->first();
        }

        if (!$admin) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan OTP dan waktu kadaluarsa (5 menit)
        $admin->otp = $otp;
        $admin->otp_expires_at = now()->addMinutes(5);
        $admin->save();

        // Kirim OTP via Email atau WhatsApp
        if ($request->email) {
            // Kirim via Email
            $subject = 'Kode OTP Reset Password - Flojachi';
            Mail::html(
                "<h2>Kode OTP Anda: <span style='color:#d9534f;'>{$otp}</span></h2><p>Berlaku selama 5 menit. Jangan berikan ke siapa pun.</p>",
                function ($message) use ($admin, $subject) {
                    $message->to($admin->email)
                            ->subject($subject);
                }
            );
        } else if ($request->phone) {
            // Kirim via WhatsApp (UltraMsg)
            $this->sendOtpViaWhatsApp($admin->phone, $otp);
        }

        return response()->json([
            'message' => 'Kode OTP telah dikirim.',
            'email' => $admin->email,
            'phone' => $admin->phone
        ]);
    }

    // ========================
    // VERIFIKASI OTP (EMAIL ATAU WHATSAPP)
    // ========================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|exists:admin,email',
            'phone' => 'nullable|string|exists:admin,phone',
            'otp'   => 'required|string'
        ]);

        if (!$request->email && !$request->phone) {
            return response()->json(['message' => 'Email atau nomor WhatsApp wajib diisi.'], 400);
        }

        $admin = null;
        if ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } else if ($request->phone) {
            $admin = Admin::where('phone', $request->phone)->first();
        }

        if (!$admin) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        if (!$admin->otp || $admin->otp !== $request->otp || $admin->otp_expires_at < now()) {
            return response()->json([
                'message' => 'OTP tidak valid atau sudah kadaluarsa.'
            ], 400);
        }

        return response()->json(['message' => 'OTP valid']);
    }

    // ========================
    // RESET PASSWORD
    // ========================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|exists:admin,email',
            'phone' => 'nullable|string|exists:admin,phone',
            'password' => 'required|min:6'
        ]);

        if (!$request->email && !$request->phone) {
            return response()->json(['message' => 'Email atau nomor WhatsApp wajib diisi.'], 400);
        }

        $admin = null;
        if ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } else if ($request->phone) {
            $admin = Admin::where('phone', $request->phone)->first();
        }

        if (!$admin) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $admin->password = $request->password;
        $admin->otp = null;
        $admin->otp_expires_at = null;
        $admin->login_attempts = 0;
        $admin->status = 'on';
        $admin->save();

        return response()->json(['message' => 'Password berhasil diubah!']);
    }

    // ========================
    // KIRIM OTP VIA WHATSAPP (ULTRAMSG)
    // ========================
    private function sendOtpViaWhatsApp($phone, $otp)
    {
        $instanceId = env('ULTRAMSG_INSTANCE_ID');
        $token = env('ULTRAMSG_TOKEN');

        // Format nomor: +6281513442182 → 6281513442182
        $phoneNumber = ltrim($phone, '+');

        $url = "https://api.ultramsg.com/{$instanceId}/messages/chat";
        $data = [
            'token' => $token,
            'to' => $phoneNumber,
            'body' => "Kode OTP Anda untuk reset password: *{$otp}*\n\nKode ini berlaku 5 menit.",
            'priority' => 10,
            'referenceId' => 'otp_' . time()
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        \Log::info("UltraMsg OTP sent to {$phone} | HTTP: {$httpCode} | Response: {$response}");

        if ($httpCode !== 200) {
            throw new \Exception("Gagal kirim WhatsApp: " . $response);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}