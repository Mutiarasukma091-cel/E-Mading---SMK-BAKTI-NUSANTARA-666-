<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Like;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'my_articles' => Artikel::where('user_id', auth()->id())->count(),
            'draft' => Artikel::where('user_id', auth()->id())->where('status', 'draft')->count(),
            'published' => Artikel::where('user_id', auth()->id())->where('status', 'published')->count(),
            'pending_review' => Artikel::where('status', 'draft')->count(),
            'total_likes' => Like::whereHas('artikel', function($query) {
                $query->where('user_id', auth()->id());
            })->count()
        ];

        $recentArticles = Artikel::where('user_id', auth()->id())->latest()->take(5)->get();

        return view('halaman-guru.dashboard', compact('stats', 'recentArticles'));
    }
}