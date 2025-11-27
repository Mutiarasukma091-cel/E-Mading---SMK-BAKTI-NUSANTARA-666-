<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // 6 artikel terbaru
        $latestArticles = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();
            
        // 4 artikel terpopuler (berdasarkan total likes termasuk session)
        $popularArticles = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published')
            ->get()
            ->sortByDesc('total_likes')
            ->take(4);
            
        // Kategori dengan jumlah artikel
        $categories = Kategori::withCount('artikels')->get();
        
        // Statistik umum
        $stats = [
            'total_articles' => Artikel::where('status', 'published')->count(),
            'total_categories' => Kategori::count(),
            'total_authors' => User::whereHas('artikels', function($query) {
                $query->where('status', 'published');
            })->count()
        ];

        return view('index', compact('latestArticles', 'popularArticles', 'categories', 'stats'));
    }
}