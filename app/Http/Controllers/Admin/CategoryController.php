<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Tampilkan halaman kategori
    public function index()
    {
        return view('halaman-admin.categories');
    }

    // Tambah kategori baru
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        Kategori::create($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate(['nama_kategori' => 'required']);
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only('nama_kategori'));
        return redirect()->back()->with('success', 'Kategori berhasil diupdate');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Cek apakah ada artikel yang menggunakan kategori ini
        if ($kategori->artikels()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan artikel');
        }
        
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}