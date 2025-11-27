<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Artikel;
use App\Models\Like;
use App\Models\Komentar;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik dasar
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Artikel::count(),
            'published_articles' => Artikel::where('status', 'published')->count(),
            'pending_articles' => Artikel::where('status', 'draft')->count(),
            'reviewed_articles' => Artikel::where('status', 'reviewed')->count(),
            'rejected_articles' => Artikel::where('status', 'rejected')->count(),
            'total_categories' => Kategori::count(),
            'total_likes' => Artikel::getTotalLikesCount(),
            'total_comments' => Komentar::count()
        ];
        
        // Ambil 5 artikel terbaru
        $recentArticles = Artikel::with(['user', 'kategori'])->latest()->take(5)->get();
        
        // Ambil 5 penulis terbaik
        $topAuthors = User::withCount('artikels')->orderBy('artikels_count', 'desc')->take(5)->get();
        
        return view('halaman-admin.dashboard', compact('stats', 'recentArticles', 'topAuthors'));
    }
}