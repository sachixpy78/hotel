<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    // TIDAK ADA __construct()
    
    public function index()
    {
        // LANGSUNG RETURN DATA, TANPA CHECK APAPUN
        $rooms = Kamar::with('tipeKamar')->get();
        return response()->json($rooms);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar',
            'id_tipe_kamar' => 'nullable|exists:tipe_kamar,id',
            'status' => 'required|in:tersedia,dibersihkan,rusak,terisi',
            'keterangan' => 'nullable'
        ]);

        $room = Kamar::create($validated);
        return response()->json($room, 201);
    }

    public function update(Request $request, $id)
    {
        $room = Kamar::findOrFail($id);
        
        $validated = $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar,'.$id,
            'id_tipe_kamar' => 'nullable|exists:tipe_kamar,id',
            'status' => 'required|in:tersedia,dibersihkan,rusak,terisi',
            'keterangan' => 'nullable'
        ]);

        $room->update($validated);
        return response()->json($room);
    }

    public function destroy($id)
{
    $room = Kamar::findOrFail($id);
    
    // Cek apakah kamar sedang terisi
    if ($room->status === 'terisi') {
        return response()->json([
            'message' => 'Kamar tidak dapat dihapus karena masih berstatus TERISI',
            'error' => 'Kamar sedang ditempati'
        ], 422);
    }
    
    $room->delete();
    return response()->json(['message' => 'Deleted']);
}

public function getAvailableRoomsByType($tipeKamarId)
{
    try {
        $rooms = Kamar::where('id_tipe_kamar', $tipeKamarId)
            ->where('status', 'tersedia')
            ->orderBy('nomor_kamar', 'asc')
            ->get(['id', 'nomor_kamar', 'status']);
        
        return response()->json([
            'success' => true,
            'data' => $rooms,
            'count' => $rooms->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data kamar',
            'error' => $e->getMessage()
        ], 500);
    }
}
    // ✅ METHOD BARU: Auto-clean kamar yang sudah >5 detik status 'dibersihkan'
    public function autoCleanRooms()
    {   
        // Cari kamar yang statusnya 'dibersihkan' dan updated_at sudah lebih dari 5 detik yang lalu
        $rooms = \App\Models\Kamar::where('status', 'dibersihkan')
            ->where('updated_at', '<=', now()->subSeconds(5))
            ->get();

        $cleanedCount = 0;

        foreach ($rooms as $room) {
            // Update status kamar menjadi tersedia
            $room->status = 'tersedia';
            $room->save();

            // Tambah stok di room type terkait
            if ($room->id_tipe_kamar) {
                $tipeKamar = \App\Models\TipeKamar::find($room->id_tipe_kamar);
                if ($tipeKamar) {
                    $tipeKamar->increment('stok');
                }
            }

            $cleanedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil membersihkan ' . $cleanedCount . ' kamar',
            'cleaned_count' => $cleanedCount
        ]);
    }
}