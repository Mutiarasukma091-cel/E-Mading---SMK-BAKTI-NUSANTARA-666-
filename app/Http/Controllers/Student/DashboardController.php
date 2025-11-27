<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Like;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'draft' => Artikel::where('user_id', auth()->id())->where('status', 'draft')->count(),
            'published' => Artikel::where('user_id', auth()->id())->where('status', 'published')->count(),
            'total_likes' => Like::whereHas('artikel', function($q) {
                $q->where('user_id', auth()->id());
            })->count(),
        ];
        
        $recentArticles = Artikel::where('user_id', auth()->id())
            ->with(['kategori'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('halaman-siswa.dashboard', compact('stats', 'recentArticles'));
    }
}