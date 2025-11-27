<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Tampilkan artikel guru
    public function index()
    {
        $articles = Artikel::where('user_id', auth()->id())->with(['kategori', 'likes'])->latest()->get();
        return view('halaman-guru.articles', compact('articles'));
    }

    // Form buat artikel baru
    public function create()
    {
        $categories = Kategori::all();
        return view('halaman-guru.articles.create', compact('categories'));
    }

    // Simpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Cek duplikat berdasarkan judul dan user dalam 1 menit terakhir
        $existingArticle = Artikel::where('user_id', auth()->id())
            ->where('judul', $request->judul)
            ->where('created_at', '>', now()->subMinute())
            ->first();
            
        if ($existingArticle) {
            return redirect()->route('teacher.articles.index')->with('success', 'Artikel sudah tersimpan sebelumnya');
        }

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'user_id' => auth()->id(),
            'kategori_id' => $request->kategori_id,
            'status' => $request->status ?? 'draft'
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $uploadPath = public_path('uploads/articles');
            
            ImageHelper::resizeAndSave($foto, $uploadPath, $filename, 1500, 98);
            $data['foto'] = $filename;
        }

        Artikel::create($data);
        return redirect()->route('teacher.articles.index')->with('success', 'Artikel berhasil disimpan');
    }

    // Form edit artikel
    public function edit($id)
    {
        $article = Artikel::where('user_id', auth()->id())->findOrFail($id);
        $categories = Kategori::all();
        return view('halaman-guru.articles.edit', compact('article', 'categories'));
    }

    // Update artikel
    public function update(Request $request, $id)
    {
        $article = Artikel::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $data = $request->only(['judul', 'isi', 'kategori_id', 'status']);

        if ($request->hasFile('foto')) {
            if ($article->foto && file_exists(public_path('uploads/articles/' . $article->foto))) {
                unlink(public_path('uploads/articles/' . $article->foto));
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $uploadPath = public_path('uploads/articles');
            
            ImageHelper::resizeAndSave($foto, $uploadPath, $filename, 1500, 98);
            $data['foto'] = $filename;
        }

        $article->update($data);
        return redirect()->route('teacher.articles.index')->with('success', 'Artikel berhasil diupdate');
    }

    // Hapus artikel
    public function destroy($id)
    {
        $article = Artikel::where('user_id', auth()->id())->findOrFail($id);
        
        $article->komentars()->delete();
        $article->likes()->delete();
        
        if ($article->foto && file_exists(public_path('uploads/articles/' . $article->foto))) {
            unlink(public_path('uploads/articles/' . $article->foto));
        }
        
        $article->delete();
        return redirect()->route('teacher.articles.index')->with('success', 'Artikel berhasil dihapus');
    }

    // Publish artikel sendiri
    public function publish($id)
    {
        $article = Artikel::where('user_id', auth()->id())->findOrFail($id);
        $article->update(['status' => 'published']);
        
        return redirect()->route('teacher.articles.index')->with('success', 'Artikel berhasil dipublikasikan');
    }
}