<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return Admin::all();
    }

    public function show($id)
    {
        return Admin::find($id);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        $admin->fill($request->except('gambar'));

        // UPLOAD FOTO
        if ($request->hasFile('gambar')) {
            if ($admin->gambar && Storage::disk('public')->exists($admin->gambar)) {
                Storage::disk('public')->delete($admin->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile', $filename, 'public');
            $admin->gambar = $path;
        }

        $admin->save();

        return response()->json(['message' => 'Admin updated', 'data' => $admin]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        // Hapus foto jika ada
        if ($admin->gambar && Storage::disk('public')->exists($admin->gambar)) {
            Storage::disk('public')->delete($admin->gambar);
        }

        $admin->delete();

        return response()->json(['message' => 'Admin deleted']);
    }

    public function activate($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        $admin->status = 'on';
        $admin->save();

        return response()->json(['message' => 'Akun diaktifkan']);
    }

    public function deactivate($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        $admin->status = 'off';
        $admin->save();

        return response()->json(['message' => 'Akun dinonaktifkan']);
    }
}