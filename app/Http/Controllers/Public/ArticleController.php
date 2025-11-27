<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Tampilkan semua artikel
    public function index(Request $request)
    {
        $query = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Sort filter
        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                $query->withCount('likes')->orderBy('likes_count', 'desc');
                break;
            case 'most_viewed':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $articles = $query->paginate(12)->appends($request->query());

        return view('articles.index', compact('articles'));
    }

    // Detail artikel
    public function show($id)
    {
        $article = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published')
            ->findOrFail($id);

        // Increment views
        $article->incrementViews();

        return view('articles.show', compact('article'));
    }

    // Cari artikel
    public function search(Request $request)
    {
        $query = $request->get('q');
        $kategori = $request->get('kategori');
        
        $articles = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published')
            ->when($query, function($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('isi', 'like', '%' . $query . '%');
            })
            ->when($kategori, function($q) use ($kategori) {
                $q->where('kategori_id', $kategori);
            })
            ->latest()
            ->paginate(12);
            
        $categories = Kategori::all();
        
        return view('articles.search', compact('articles', 'categories', 'query', 'kategori'));
    }

    // Like artikel
    public function like($id)
    {
        $article = Artikel::findOrFail($id);
        
        if (auth()->check()) {
            // User login - simpan ke database
            $userId = auth()->id();
            $existingLike = Like::where('artikel_id', $id)->where('user_id', $userId)->first();
            
            if ($existingLike) {
                $existingLike->delete();
                $message = 'Like dihapus';
            } else {
                Like::create([
                    'artikel_id' => $id,
                    'user_id' => $userId
                ]);
                
                // Kirim notifikasi ke penulis jika bukan diri sendiri
                if ($article->user_id != $userId) {
                    Notification::create([
                        'user_id' => $article->user_id,
                        'title' => 'Artikel Disukai',
                        'message' => auth()->user()->nama . ' menyukai artikel "' . $article->judul . '"',
                        'type' => 'info'
                    ]);
                }
                
                $message = 'Artikel disukai';
            }
        } else {
            // Guest - gunakan session untuk tracking per browser
            $sessionKey = 'guest_liked_' . $id;
            $hasLiked = session($sessionKey, false);
            $cacheKey = 'guest_likes_' . $id;
            $guestLikes = cache()->get($cacheKey, []);
            
            if ($hasLiked) {
                // Unlike - hapus dari cache dan session
                $guestId = session('guest_id_' . $id);
                if ($guestId && in_array($guestId, $guestLikes)) {
                    $guestLikes = array_diff($guestLikes, [$guestId]);
                    cache()->put($cacheKey, $guestLikes, now()->addDays(30));
                }
                session()->forget([$sessionKey, 'guest_id_' . $id]);
                $message = 'Like dihapus';
            } else {
                // Like - tambah ke cache dan session
                $guestId = request()->ip() . '_' . time() . '_' . rand(1000, 9999);
                $guestLikes[] = $guestId;
                cache()->put($cacheKey, $guestLikes, now()->addDays(30));
                session([$sessionKey => true, 'guest_id_' . $id => $guestId]);
                $message = 'Artikel disukai';
            }
        }
        
        return back()->with('success', $message);
    }

    // Tambah komentar (hanya untuk user yang login)
    public function comment(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan komentar');
        }

        $request->validate([
            'isi_komentar' => 'required|max:500'
        ]);

        $article = Artikel::findOrFail($id);
        
        $article->komentars()->create([
            'isi_komentar' => $request->isi_komentar,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    // Hapus komentar
    public function deleteComment($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $comment = \App\Models\Komentar::where('user_id', auth()->id())->findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus');
    }
}