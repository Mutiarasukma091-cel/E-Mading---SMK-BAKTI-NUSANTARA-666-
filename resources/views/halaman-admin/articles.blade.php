@extends('template-dasar.authenticated')

@section('title', 'Kelola Artikel - MadingDigitally')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Kelola Artikel</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Likes</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ Str::limit($article->judul, 30) }}</td>
                            <td>{{ $article->user->nama }}</td>
                            <td><span class="badge bg-secondary">{{ $article->kategori->nama_kategori }}</span></td>
                            <td>
                                @if($article->status == 'draft')
                                    <span class="badge bg-warning">Menunggu Review</span>
                                @elseif($article->status == 'reviewed')
                                    <span class="badge bg-info">Disetujui Guru</span>
                                @elseif($article->status == 'published')
                                    <span class="badge bg-success">Dipublikasi</span>
                                @elseif($article->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $article->likes->count() }}</td>
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td>
                                @if($article->status == 'draft')
                                    <span class="text-muted small">Menunggu review guru</span>
                                @elseif($article->status == 'reviewed')
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('admin.articles.publish', $article->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">Publish</button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $article->id }}">Tolak</button>
                                    </div>
                                @elseif($article->status == 'rejected')
                                    <span class="text-muted small">Artikel ditolak</span>
                                    @if($article->rejection_reason)
                                        <br><small class="text-danger">{{ Str::limit($article->rejection_reason, 50) }}</small>
                                    @endif
                                @else
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('admin.articles.unpublish', $article->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning">Unpublish</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus artikel ini?')">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modals -->
@foreach($articles as $article)
@if($article->status == 'reviewed')
<div class="modal fade" id="rejectModal{{ $article->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.articles.reject', $article->id) }}">
                @csrf
                <div class="modal-body">
                    <p><strong>Artikel:</strong> {{ $article->judul }}</p>
                    <p><strong>Penulis:</strong> {{ $article->user->nama }}</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" name="rejection_reason" rows="3" required placeholder="Berikan alasan mengapa artikel ini ditolak..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Artikel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

@push('scripts')
<script>
// Ensure modals work properly
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all modals
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        new bootstrap.Modal(modal);
    });
    
    // Handle reject button clicks
    var rejectButtons = document.querySelectorAll('[data-bs-target^="#rejectModal"]');
    rejectButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var targetModal = document.querySelector(button.getAttribute('data-bs-target'));
            if (targetModal) {
                var modal = new bootstrap.Modal(targetModal);
                modal.show();
            }
        });
    });
});
</script>
@endpush

@endsection