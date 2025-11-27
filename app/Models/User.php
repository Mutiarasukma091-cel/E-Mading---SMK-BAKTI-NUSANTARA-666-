<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['nama', 'username', 'email', 'password', 'role', 'status'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }
}