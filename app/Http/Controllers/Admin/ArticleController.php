<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\User;
use App\Models\Notification;

class ArticleController extends Controller
{
    // Tampilkan semua artikel
    public function index()
    {
        $articles = Artikel::with(['user', 'kategori', 'likes'])
            ->whereIn('status', ['draft', 'reviewed', 'published', 'rejected'])
            ->latest()->get();
        return view('halaman-admin.articles', compact('articles'));
    }

    // Review artikel (untuk guru)
    public function approve($id)
    {
        $article = Artikel::findOrFail($id);
        $article->update(['status' => 'reviewed']);
        
        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Artikel Direview Guru',
            'message' => 'Artikel "' . $article->judul . '" telah direview guru dan menunggu verifikasi admin.',
            'type' => 'info'
        ]);
        
        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Artikel untuk Verifikasi',
                'message' => 'Artikel "' . $article->judul . '" telah direview guru dan menunggu verifikasi admin.',
                'type' => 'warning'
            ]);
        }
        
        return redirect()->back()->with('success', 'Artikel berhasil direview dan dikirim ke admin');
    }

    // Publish artikel (untuk admin)
    public function publish($id)
    {
        $article = Artikel::findOrFail($id);
        $article->update(['status' => 'published']);
        
        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Artikel Dipublikasi',
            'message' => 'Artikel "' . $article->judul . '" telah diverifikasi admin dan dipublikasikan.',
            'type' => 'success'
        ]);
        
        return redirect()->back()->with('success', 'Artikel berhasil dipublikasikan');
    }

    // Unpublish artikel
    public function unpublish($id)
    {
        Artikel::findOrFail($id)->update(['status' => 'draft']);
        return redirect()->back()->with('success', 'Artikel berhasil di-unpublish');
    }

    // Tolak artikel
    public function reject($id)
    {
        $article = Artikel::findOrFail($id);
        $rejectionReason = request('rejection_reason', 'Artikel tidak memenuhi standar publikasi');
        
        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $rejectionReason
        ]);
        
        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Artikel Ditolak',
            'message' => 'Artikel "' . $article->judul . '" ditolak. Alasan: ' . $rejectionReason,
            'type' => 'error'
        ]);
        
        return redirect()->back()->with('success', 'Artikel berhasil ditolak');
    }

    // Hapus artikel
    public function destroy($id)
    {
        $article = Artikel::findOrFail($id);
        
        // Hapus komentar dan likes terkait
        $article->komentars()->delete();
        $article->likes()->delete();
        
        // Hapus foto jika ada
        if ($article->foto && file_exists(public_path('uploads/articles/' . $article->foto))) {
            unlink(public_path('uploads/articles/' . $article->foto));
        }
        
        $article->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus');
    }
}