<?php

namespace App\Http\Controllers;

use Milon\Barcode\Facades\DNS1D;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    // Helper untuk tambahkan prefix 'profile/' jika belum ada
    protected function addProfilePrefix($gambar)
    {
        if (!$gambar) return null;
        // Jika belum ada 'profile/', tambahkan
        if (!str_starts_with($gambar, 'profile/')) {
            return 'profile/' . $gambar;
        }
        return $gambar;
    }


    
    public function index()
    {
        $produks = Produk::with('kategori')->get();

        foreach ($produks as $produk) {
            $produk->gambar = $this->addProfilePrefix($produk->gambar);
        }

        return response()->json([
            'success' => true,
            'data' => $produks
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string',
            'fid_kategori' => 'required|integer',
            'stok' => 'required|integer|min:0',
            'modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'deskripsi' => 'nullable|string',
            'ketersediaan' => 'required|in:tersedia,tidaktersedia',
            'estimasi' => 'required|in:langsung_ambil,7_hari_kerja'
        ]);

        $barcode = 'PROD-' . strtoupper(substr(md5(time()), 0, 8));
        $keuntungan = $request->harga_jual - $request->modal;

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public');
            $gambarPath = $filename; // Hanya simpan nama file
        }

        // ✅ Biarkan stok sesuai input user, baik untuk tersedia maupun pre-order
        $stok = $request->stok;

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'fid_kategori' => $request->fid_kategori,
            'stok' => $stok,
            'modal' => $request->modal,
            'harga_jual' => $request->harga_jual,
            'keuntungan' => $keuntungan,
            'gambar' => $gambarPath,
            'deskripsi' => $request->deskripsi,
            'ketersediaan' => $request->ketersediaan,
            'estimasi' => $request->estimasi,
            'barcode' => $barcode
        ]);

        // Tambahkan prefix saat kirim response
        $produk->gambar = $this->addProfilePrefix($produk->gambar);

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->find($id);

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        // Tambahkan prefix saat kirim response
        $produk->gambar = $this->addProfilePrefix($produk->gambar);

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_produk' => 'required|string',
            'fid_kategori' => 'required|integer',
            'stok' => 'required|integer|min:0',
            'modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'deskripsi' => 'nullable|string',
            'ketersediaan' => 'required|in:tersedia,tidaktersedia',
            'estimasi' => 'required|in:langsung_ambil,7_hari_kerja'
        ]);

        $keuntungan = $request->harga_jual - $request->modal;
        $gambarPath = $produk->gambar; // Biarkan gambar lama jika tidak diganti

        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($produk->gambar && Storage::disk('public')->exists('profile/' . $produk->gambar)) {
                Storage::disk('public')->delete('profile/' . $produk->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public');
            $gambarPath = $filename;
        }

        // ✅ Biarkan stok sesuai input user, baik untuk tersedia maupun pre-order
        $stok = $request->stok;

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'fid_kategori' => $request->fid_kategori,
            'stok' => $stok,
            'modal' => $request->modal,
            'harga_jual' => $request->harga_jual,
            'keuntungan' => $keuntungan,
            'gambar' => $gambarPath,
            'deskripsi' => $request->deskripsi,
            'ketersediaan' => $request->ketersediaan,
            'estimasi' => $request->estimasi,
            'barcode' => $request->barcode ?? $produk->barcode
        ]);

        // Tambahkan prefix saat kirim response
        $produk->gambar = $this->addProfilePrefix($produk->gambar);

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    public function kurangiStok(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:produk,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->items as $item) {
            $produk = Produk::find($item['id']);
            
            // ✅ Hanya kurangi stok jika produk tersedia (bukan pre-order)
            if ($produk && $produk->ketersediaan === 'tersedia') {
                DB::table('produk')
                    ->where('id', $item['id'])
                    ->decrement('stok', $item['quantity']);
            }
            // Produk pre-order tidak dikurangi stoknya
        }

        return response()->json(['success' => true, 'message' => 'Stok berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        // ✅ Hanya blokir hapus jika produk tersedia DAN stok masih > 0
        if ($produk->ketersediaan === 'tersedia' && $produk->stok > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk ini masih memiliki stok. Tunggu hingga stok habis.'
            ], 400);
        }
        

        // Hapus foto jika ada
        if ($produk->gambar && Storage::disk('public')->exists('profile/' . $produk->gambar)) {
            Storage::disk('public')->delete('profile/' . $produk->gambar);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus'
        ]);
    }

    public function generateBarcode($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        if (!$produk->barcode) {
            $produk->barcode = 'PROD-' . strtoupper(substr(md5(time()), 0, 8));
            $produk->save();
        }

        $barcodePNG = DNS1D::getBarcodePNG($produk->barcode, 'C39');
        return response($barcodePNG)->header('Content-Type', 'image/png');
    }
}