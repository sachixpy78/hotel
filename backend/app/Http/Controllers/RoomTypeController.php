<?php

namespace App\Http\Controllers;

use App\Models\TipeKamar;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roomTypes = TipeKamar::orderBy('nama', 'asc')->get();
            
            // Tambahkan URL lengkap untuk foto
            $roomTypes->transform(function ($item) {
                if ($item->foto) {
                    $item->foto_url = asset('storage/' . $item->foto);
                } else {
                    $item->foto_url = null;
                }
                return $item;
            });
            
            return response()->json([
                'success' => true,
                'data' => $roomTypes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tipe kamar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ CEK DUPLIKAT NAMA SEBELUM SUBMIT (TAMBAHKAN INI)
     */
    public function checkDuplicate(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:100'
            ]);

            $nama = $request->nama;
            $excludeId = $request->exclude_id;

            $query = TipeKamar::where('nama', 'LIKE', $nama);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            $exists = $query->exists();
            
            return response()->json([
                'success' => true,
                'isDuplicate' => $exists,
                'message' => $exists ? 'Nama sudah digunakan' : 'Nama tersedia'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'isDuplicate' => false,
                'message' => 'Gagal mengecek duplikat'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:100|unique:tipe_kamar,nama',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'harga_per_malam' => 'required|numeric|min:0',
                'fasilitas' => 'nullable|string',
                'tipe_tempat_tidur' => 'nullable|string|max:50',
                'tersedia' => 'boolean',
                'stok' => 'nullable|integer|min:0'
            ]);

            // Handle upload foto
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('room-types', $filename, 'public');
                $validated['foto'] = 'room-types/' . $filename;
            }

            // SET DEFAULT STOK JIKA TIDAK DIISI
            if (!isset($validated['stok'])) {
                $validated['stok'] = 0;
            }

            $roomType = TipeKamar::create($validated);
            
            // Tambahkan URL foto
            $roomType->foto_url = $roomType->foto ? asset('storage/' . $roomType->foto) : null;

            return response()->json([
                'success' => true,
                'message' => 'Tipe kamar berhasil ditambahkan',
                'data' => $roomType
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ TANGANI ERROR VALIDASI UNIQUE DENGAN LEBIH BAIK
            if (isset($e->errors()['nama'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama tipe kamar sudah ada! Gunakan nama lain.',
                    'errors' => $e->errors()
                ], 422);
            }
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tipe kamar: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $roomType = TipeKamar::findOrFail($id);
            
            // Tambahkan URL lengkap untuk foto
            if ($roomType->foto) {
                $roomType->foto_url = asset('storage/' . $roomType->foto);
            } else {
                $roomType->foto_url = null;
            }
            
            return response()->json([
                'success' => true,
                'data' => $roomType
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $roomType = TipeKamar::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:100|unique:tipe_kamar,nama,' . $id,
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'harga_per_malam' => 'required|numeric|min:0',
                'fasilitas' => 'nullable|string',
                'tipe_tempat_tidur' => 'nullable|string|max:50',
                'tersedia' => 'boolean',
                'stok' => 'nullable|integer|min:0'
            ]);

            // Handle upload foto baru
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($roomType->foto) {
                    Storage::disk('public')->delete($roomType->foto);
                }
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('room-types', $filename, 'public');
                $validated['foto'] = 'room-types/' . $filename;
            }

            $roomType->update($validated);
            $roomType->refresh();
            
            // Tambahkan URL foto
            $roomType->foto_url = $roomType->foto ? asset('storage/' . $roomType->foto) : null;

            return response()->json([
                'success' => true,
                'message' => 'Tipe kamar berhasil diupdate',
                'data' => $roomType
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ TANGANI ERROR VALIDASI UNIQUE DENGAN LEBIH BAIK
            if (isset($e->errors()['nama'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama tipe kamar sudah ada! Gunakan nama lain.',
                    'errors' => $e->errors()
                ], 422);
            }
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate tipe kamar: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $roomType = TipeKamar::findOrFail($id);

            // ✅ CEK APAKAH TIPE KAMAR SEDANG DIGUNAKAN DI KAMAR
            $kamarCount = \App\Models\Kamar::where('id_tipe_kamar', $id)->count();
            if ($kamarCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipe kamar sedang digunakan oleh ' . $kamarCount . ' kamar. Tidak dapat dihapus!'
                ], 400);
            }

            // Hapus foto jika ada
            if ($roomType->foto) {
                Storage::disk('public')->delete($roomType->foto);
            }

            $roomType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tipe kamar berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tipe kamar: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update stok kamar
     */
    public function updateStok(Request $request, $id)
    {
        try {
            $request->validate([
                'stok' => 'required|integer|min:0'
            ]);
            
            $roomType = TipeKamar::findOrFail($id);
            $roomType->stok = $request->stok;
            $roomType->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil diupdate',
                'data' => $roomType
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate stok',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status tersedia
     */
    public function toggleTersedia($id)
    {
        try {
            $roomType = TipeKamar::findOrFail($id);
            $roomType->tersedia = !$roomType->tersedia;
            $roomType->save();
            
            return response()->json([
                'success' => true,
                'message' => $roomType->tersedia ? 'Tipe kamar diaktifkan' : 'Tipe kamar dinonaktifkan',
                'data' => $roomType
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cari kamar tersedia berdasarkan tanggal
     */
    public function cariKamar(Request $request)
    {
        try {
            $request->validate([
                'check_in' => 'required|date|after_or_equal:today',
                'check_out' => 'required|date|after:check_in'
            ]);
            
            $checkIn = Carbon::parse($request->check_in);
            $checkOut = Carbon::parse($request->check_out);
            $jumlahMalam = $checkIn->diffInDays($checkOut);
            
            // Ambil semua tipe kamar yang tersedia
            $roomTypes = TipeKamar::where('tersedia', true)
                ->where('stok', '>', 0)
                ->get();
            
            foreach ($roomTypes as $roomType) {
                // LANGSUNG PAKAI STOK DARI DATABASE (tanpa hitung pemesanan)
                $roomType->stok_tersedia = $roomType->stok;
                $roomType->jumlah_malam = $jumlahMalam;
                $roomType->total_harga = $roomType->harga_per_malam * $jumlahMalam;
                
                // Tambahkan URL foto
                if ($roomType->foto) {
                    $roomType->foto_url = asset('storage/' . $roomType->foto);
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => $roomTypes
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencari kamar',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}