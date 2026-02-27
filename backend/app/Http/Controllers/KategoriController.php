<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public'); // Simpan ke storage/app/public/profile/
            $gambarPath = $filename; // Hanya simpan nama file, bukan path lengkap
        }

        $kategori = Kategori::create([
            'kategori' => $request->kategori,
            'gambar' => $gambarPath
        ]);

        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'kategori' => 'required|string',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $gambarPath = $kategori->gambar; // Biarkan gambar lama jika tidak diganti
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($kategori->gambar && Storage::disk('public')->exists('profile/' . $kategori->gambar)) {
                Storage::disk('public')->delete('profile/' . $kategori->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public');
            $gambarPath = $filename;
        }

        $kategori->update([
            'kategori' => $request->kategori,
            'gambar' => $gambarPath
        ]);

        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        // Hapus foto jika ada
        if ($kategori->gambar && Storage::disk('public')->exists('profile/' . $kategori->gambar)) {
            Storage::disk('public')->delete('profile/' . $kategori->gambar);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori dihapus'
        ]);
    }
}