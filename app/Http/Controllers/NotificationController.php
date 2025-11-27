<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tampilkan semua notifikasi
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('notifications.index', compact('notifications'));
    }

    // Tandai sudah dibaca
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    // Tandai semua sudah dibaca
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    // Hapus notifikasi
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }

    // Hapus semua notifikasi
    public function destroyAll()
    {
        Notification::where('user_id', auth()->id())->delete();
        
        return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus');
    }
}