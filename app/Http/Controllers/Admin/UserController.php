<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * UserController - Mengelola CRUD user untuk admin
 * 
 * @author MadingDigitally Team
 * @version 1.0
 */
class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user dengan jumlah artikel
     */
    public function index()
    {
        try {
            $users = User::withCount('artikels')
                        ->orderBy('created_at', 'desc')
                        ->get();
            
            return view('halaman-admin.users', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data user');
        }
    }
    
    /**
     * Tampilkan form edit user
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('halaman-admin.users-edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'User tidak ditemukan');
        }
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['admin', 'guru', 'siswa'])]
        ]);
        
        try {
            User::create([
                'nama' => $validated['nama'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => 'approved'
            ]);
            
            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan user');
        }
    }
    
    /**
     * Update data user
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
                'role' => ['required', Rule::in(['admin', 'guru', 'siswa'])],
                'password' => 'nullable|string|min:6'
            ]);
            
            $data = collect($validated)->except('password')->toArray();
            
            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }
            
            $user->update($data);
            
            return redirect()->back()->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate user');
        }
    }
    
    /**
     * Hapus user
     */
    public function destroy($id)
    {
        try {
            // Cegah admin menghapus akun sendiri
            if ($id == auth()->id()) {
                return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri');
            }
            
            $user = User::findOrFail($id);
            $user->delete();
            
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user');
        }
    }

    /**
     * Setujui registrasi user
     */
    public function approve($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->status === 'approved') {
                return redirect()->back()->with('info', 'User sudah disetujui sebelumnya');
            }
            
            $user->update(['status' => 'approved']);
            
            // Kirim notifikasi ke user
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Akun Disetujui',
                'message' => 'Selamat! Akun Anda telah disetujui admin. Anda sekarang dapat login.',
                'type' => 'success'
            ]);
            
            return redirect()->back()->with('success', 'User berhasil disetujui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyetujui user');
        }
    }

    /**
     * Tolak registrasi user
     */
    public function reject($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->status === 'rejected') {
                return redirect()->back()->with('info', 'User sudah ditolak sebelumnya');
            }
            
            $user->update(['status' => 'rejected']);
            
            // Kirim notifikasi ke user
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Akun Ditolak',
                'message' => 'Maaf, pendaftaran akun Anda ditolak oleh admin.',
                'type' => 'error'
            ]);
            
            return redirect()->back()->with('success', 'User berhasil ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak user');
        }
    }
}