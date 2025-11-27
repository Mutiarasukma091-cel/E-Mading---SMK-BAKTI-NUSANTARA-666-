<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Tampilkan profil
    public function show($id = null)
    {
        // Jika ada ID, tampilkan profil user lain (publik)
        if ($id) {
            $user = User::findOrFail($id);
            
            // Ambil likes dengan artikel terkait
            $likes = $user->likes()->with('artikel')->latest()->take(10)->get();
            
            // Ambil komentar dengan artikel terkait
            $komentars = $user->komentars()->with('artikel')->latest()->take(10)->get();
            
            return view('profile.public', compact('user', 'likes', 'komentars'));
        }
        
        // Tampilkan profil user yang sedang login
        return view('profile.show');
    }

    // Tampilkan form edit profil
    public function edit()
    {
        return view('profile.edit');
    }

    // Update profil
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ]);

        $data = $request->only(['nama', 'email']);
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diupdate');
    }
}