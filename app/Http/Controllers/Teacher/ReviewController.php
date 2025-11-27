<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\User;
use App\Models\Notification;

class ReviewController extends Controller
{
    // Tampilkan artikel yang perlu direview
    public function index()
    {
        $articles = Artikel::where('status', 'draft')->with(['user', 'kategori'])->latest()->get();
        return view('halaman-guru.review', compact('articles'));
    }

    // Approve artikel siswa
    public function approve($id)
    {
        $article = Artikel::findOrFail($id);
        $article->update(['status' => 'reviewed']);
        
        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Artikel Disetujui Guru',
            'message' => 'Artikel "' . $article->judul . '" telah disetujui guru dan menunggu verifikasi admin.',
            'type' => 'info'
        ]);
        
        // Kirim notifikasi ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Artikel untuk Verifikasi',
                'message' => 'Artikel "' . $article->judul . '" telah disetujui guru dan menunggu verifikasi admin.',
                'type' => 'warning'
            ]);
        }
        
        return redirect()->route('teacher.review.index')->with('success', 'Artikel berhasil disetujui dan dikirim ke admin untuk verifikasi');
    }

    // Tolak artikel siswa
    public function reject($id)
    {
        $article = Artikel::findOrFail($id);
        $rejectionReason = request('rejection_reason', 'Artikel perlu diperbaiki');
        
        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $rejectionReason
        ]);
        
        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Artikel Ditolak Guru',
            'message' => 'Artikel "' . $article->judul . '" ditolak guru. Alasan: ' . $rejectionReason,
            'type' => 'error'
        ]);
        
        return redirect()->route('teacher.review.index')->with('success', 'Artikel berhasil ditolak');
    }
}