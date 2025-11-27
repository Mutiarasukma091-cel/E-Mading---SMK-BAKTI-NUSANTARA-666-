<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar artikel
        $query = Artikel::with(['user', 'kategori', 'likes']);
        
        // Filter berdasarkan bulan
        if ($request->month) {
            $query->whereMonth('created_at', $request->month);
        }
        
        // Filter berdasarkan tahun
        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }
        
        // Filter berdasarkan kategori
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        
        $articles = $query->get();
        
        // Hitung statistik artikel
        $stats = [
            'total_articles' => $articles->count(),
            'published' => $articles->where('status', 'published')->count(),
            'draft' => $articles->where('status', 'draft')->count(),
            'reviewed' => $articles->where('status', 'reviewed')->count(),
            'rejected' => $articles->where('status', 'rejected')->count(),
            'total_likes' => $articles->sum(function($article) { 
                return $article->likes->count(); 
            })
        ];
        
        // Ambil semua kategori
        $categories = Kategori::all();
        
        // Statistik per kategori
        $categoryStats = Kategori::withCount([
            'artikels as total_articles',
            'artikels as published_articles' => function($q) { 
                $q->where('status', 'published'); 
            },
            'artikels as draft_articles' => function($q) { 
                $q->where('status', 'draft'); 
            },
            'artikels as reviewed_articles' => function($q) { 
                $q->where('status', 'reviewed'); 
            },
            'artikels as rejected_articles' => function($q) { 
                $q->where('status', 'rejected'); 
            }
        ])->with(['artikels.likes'])->get()->map(function($category) {
            $category->total_likes = $category->artikels->sum(function($article) {
                return $article->likes->count();
            });
            return $category;
        });
        
        // 10 artikel terbaru
        $recentArticles = Artikel::with(['user', 'kategori', 'likes'])->latest()->take(10)->get();
        
        return view('halaman-admin.reports', compact('stats', 'categories', 'categoryStats', 'recentArticles'));
    }

    public function export(Request $request)
    {
        return $this->exportPdf($request);
    }

    public function exportPdf(Request $request)
    {
        $query = Artikel::with(['user', 'kategori', 'likes']);
        
        if ($request->month) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        
        $articles = $query->get();
        
        $stats = [
            'total_articles' => $articles->count(),
            'published' => $articles->where('status', 'published')->count(),
            'draft' => $articles->where('status', 'draft')->count(),
            'reviewed' => $articles->where('status', 'reviewed')->count(),
            'rejected' => $articles->where('status', 'rejected')->count(),
            'total_likes' => $articles->sum('total_likes')
        ];
        
        $categories = Kategori::all();
        $categoryStats = Kategori::withCount('artikels')->get();
        
        $pdf = Pdf::loadView('admin.reports-pdf', compact('stats', 'articles', 'categories', 'categoryStats'));
        
        return $pdf->download('laporan-artikel-' . date('Y-m-d') . '.pdf');
    }
}