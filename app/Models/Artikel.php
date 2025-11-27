<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = ['judul', 'isi', 'foto', 'status', 'user_id', 'kategori_id', 'views', 'rejection_reason'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    // Hitung total likes (database + cache untuk guest)
    public function getTotalLikesAttribute()
    {
        $dbLikes = $this->likes()->count();
        
        // Tambah likes dari cache (untuk guest)
        $guestLikes = cache()->get('guest_likes_' . $this->id, []);
        
        return $dbLikes + count($guestLikes);
    }

    // Cek apakah user sudah like
    public function isLikedByUser()
    {
        if (auth()->check()) {
            return $this->likes()->where('user_id', auth()->id())->exists();
        } else {
            // Cek session untuk guest
            return session('guest_liked_' . $this->id, false);
        }
    }

    // Method static untuk menghitung total likes semua artikel
    public static function getTotalLikesCount()
    {
        $dbLikes = \App\Models\Like::count();
        
        // Tambah likes dari cache (untuk guest)
        $totalGuestLikes = 0;
        $articles = self::all();
        foreach ($articles as $article) {
            $guestLikes = cache()->get('guest_likes_' . $article->id, []);
            $totalGuestLikes += count($guestLikes);
        }
        
        return $dbLikes + $totalGuestLikes;
    }

    // Method untuk increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
}