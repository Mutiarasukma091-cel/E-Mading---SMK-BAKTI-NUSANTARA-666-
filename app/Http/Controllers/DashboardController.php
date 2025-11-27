<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Like;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Artikel::count(),
            'total_categories' => Kategori::count(),
            'pending_articles' => Artikel::where('status', 'draft')->count(),
            'published_articles' => Artikel::where('status', 'published')->count(),
        ];

        $recentArticles = Artikel::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('halaman-admin.dashboard', compact('stats', 'recentArticles'));
    }

    public function guru()
    {
        $stats = [
            'my_articles' => Artikel::where('user_id', auth()->id())->count(),
            'published' => Artikel::where('user_id', auth()->id())->where('status', 'published')->count(),
            'draft' => Artikel::where('user_id', auth()->id())->where('status', 'draft')->count(),
            'total_likes' => Like::whereHas('artikel', function($q) {
                $q->where('user_id', auth()->id());
            })->count(),
        ];

        $recentArticles = Artikel::with(['kategori'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('halaman-guru.dashboard', compact('stats', 'recentArticles'));
    }

    public function siswa()
    {
        $stats = [
            'my_articles' => Artikel::where('user_id', auth()->id())->count(),
            'published' => Artikel::where('user_id', auth()->id())->where('status', 'published')->count(),
            'draft' => Artikel::where('user_id', auth()->id())->where('status', 'draft')->count(),
            'total_likes' => Like::whereHas('artikel', function($q) {
                $q->where('user_id', auth()->id());
            })->count(),
        ];

        $recentArticles = Artikel::with(['kategori'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('halaman-siswa.dashboard', compact('stats', 'recentArticles'));
    }




}