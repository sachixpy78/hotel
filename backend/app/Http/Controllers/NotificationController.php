<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Ambil semua notifikasi untuk Admin
    public function index()
    {
        $notifications = Notification::where('type', 'new_resepsionis')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $unreadCount = Notification::where('status', 'unread')
            ->where('type', 'new_resepsionis')
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    
    // Tandai notifikasi sebagai sudah dibaca
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->status = 'read';
        $notification->save();
        
        return response()->json(['success' => true]);
    }
    
    // Hapus notifikasi
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        
        return response()->json(['success' => true]);
    }
    
    // Hapus semua notifikasi
    public function clearAll()
    {
        Notification::where('type', 'new_resepsionis')->delete();
        
        return response()->json(['success' => true]);
    }
    
    // Buat notifikasi (dipanggil saat resepsionis register)
    public static function create($userId, $name, $email)
    {
        return Notification::create([
            'title' => 'Resepsionis Baru Mendaftar',
            'message' => "{$name} telah mendaftar sebagai resepsionis. Aktivasi akun di User Management.",
            'type' => 'new_resepsionis',
            'user_id' => $userId,
            'user_name' => $name,
            'user_email' => $email,
            'status' => 'unread'
        ]);
    }
}