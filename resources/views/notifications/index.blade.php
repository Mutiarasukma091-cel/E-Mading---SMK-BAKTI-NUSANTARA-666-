@extends('template-dasar.authenticated')

@section('title', 'Notifikasi - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Notifikasi</h2>
        <div>
            @if($notifications->where('is_read', false)->count() > 0)
                <a href="{{ route('notifications.mark-all-read') }}" class="btn btn-outline-primary btn-sm me-2">
                    Tandai Semua Sudah Dibaca
                </a>
            @endif
            @if($notifications->count() > 0)
                <button class="btn btn-outline-danger btn-sm" onclick="deleteAllNotifications()">
                    <i class="bi bi-trash"></i> Hapus Semua
                </button>
            @endif
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            @forelse($notifications as $notification)
                <div class="d-flex align-items-start p-3 border-bottom {{ !$notification->is_read ? 'bg-light' : '' }}">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">
                                    {{ $notification->title }}
                                </h6>
                                <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="ms-3">
                                @if(!$notification->is_read)
                                    <a href="{{ route('notifications.mark-read', $notification->id) }}" 
                                       class="btn btn-sm btn-outline-primary me-1">
                                        Tandai Dibaca
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('notifications.delete', $notification->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger me-1" 
                                            onclick="return confirm('Hapus notifikasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @if($notification->type == 'success')
                                    <span class="badge bg-success">Sukses</span>
                                @elseif($notification->type == 'warning')
                                    <span class="badge bg-warning">Peringatan</span>
                                @else
                                    <span class="badge bg-info">Info</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-bell display-4 text-muted"></i>
                    <h5 class="mt-3">Tidak ada notifikasi</h5>
                    <p class="text-muted">Notifikasi akan muncul di sini ketika ada update terkait artikel Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    @if($notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<form id="deleteAllForm" method="POST" action="{{ route('notifications.delete-all') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteAllNotifications() {
    if (confirm('Hapus semua notifikasi? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteAllForm').submit();
    }
}
</script>
@endsection