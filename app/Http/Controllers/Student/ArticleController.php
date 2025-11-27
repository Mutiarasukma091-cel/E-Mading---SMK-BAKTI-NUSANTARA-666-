<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Notification;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Tampilkan artikel siswa
    public function index()
    {
        $articles = Artikel::where('user_id', auth()->id())->with('kategori')->latest()->get();
        return view('halaman-siswa.articles', compact('articles'));
    }

    // Form buat artikel baru
    public function create()
    {
        $categories = Kategori::all();
        return view('halaman-siswa.articles.create', compact('categories'));
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
            return redirect()->route('student.articles.index')->with('success', 'Artikel sudah tersimpan sebelumnya');
        }

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'user_id' => auth()->id(),
            'kategori_id' => $request->kategori_id,
            'status' => 'draft' // Artikel siswa selalu draft
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $uploadPath = public_path('uploads/articles');
            
            ImageHelper::resizeAndSave($foto, $uploadPath, $filename, 1500, 98);
            $data['foto'] = $filename;
        }

        $artikel = Artikel::create($data);
        
        // Kirim notifikasi ke semua guru
        $gurus = User::where('role', 'guru')->get();
        foreach ($gurus as $guru) {
            Notification::create([
                'user_id' => $guru->id,
                'title' => 'Artikel Baru untuk Review',
                'message' => 'Artikel "' . $artikel->judul . '" dari ' . auth()->user()->nama . ' menunggu review.',
                'type' => 'info'
            ]);
        }

        return redirect()->route('student.articles.index')->with('success', 'Artikel berhasil disimpan dan dikirim untuk review');
    }

    // Form edit artikel
    public function edit($id)
    {
        $article = Artikel::where('user_id', auth()->id())->findOrFail($id);
        $categories = Kategori::all();
        return view('halaman-siswa.articles.edit', compact('article', 'categories'));
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

        $data = $request->only(['judul', 'isi', 'kategori_id']);
        
        // Siswa tidak bisa mengubah status ke published
        // Hanya bisa draft (untuk artikel yang ditolak) atau tetap status sebelumnya
        if ($article->status == 'rejected') {
            $data['status'] = 'draft'; // Reset ke draft untuk review ulang
            $data['rejection_reason'] = null; // Hapus alasan penolakan
        }
        // Jika status lain (published, reviewed), biarkan tetap

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
        return redirect()->route('student.articles.index')->with('success', 'Artikel berhasil diupdate');
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
        return redirect()->route('student.articles.index')->with('success', 'Artikel berhasil dihapus');
    }
}