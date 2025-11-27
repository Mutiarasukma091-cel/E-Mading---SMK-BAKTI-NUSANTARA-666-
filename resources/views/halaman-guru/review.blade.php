@extends('template-dasar.authenticated')

@section('title', 'Review Artikel - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Review Artikel</h2>
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Artikel Draft untuk Review</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($article->judul, 40) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit(strip_tags($article->isi), 60) }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <strong>{{ $article->user->nama }}</strong>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($article->user->role) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $article->kategori->nama_kategori }}</span>
                            </td>
                            <td>
                                <small>{{ $article->created_at->format('d M Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#previewModal{{ $article->id }}">
                                        <i class="bi bi-eye"></i> Preview
                                    </button>
                                    <form method="POST" action="{{ route('teacher.review.approve', $article->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" 
                                                onclick="return confirm('Setujui artikel ini untuk dikirim ke admin?')">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $article->id }}">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-file-text display-4 d-block mb-3"></i>
                                <h5>Tidak ada artikel draft untuk direview</h5>
                                <p>Semua artikel sudah dipublish atau belum ada artikel yang dibuat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modals -->
@foreach($articles as $article)
<div class="modal fade" id="previewModal{{ $article->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($article->foto)
                    <div class="text-center mb-3">
                        <img src="{{ asset('uploads/articles/' . $article->foto) }}" 
                             class="img-fluid" 
                             style="max-height: 300px; object-fit: contain;" 
                             alt="{{ $article->judul }}">
                    </div>
                @endif
                
                <h4>{{ $article->judul }}</h4>
                
                <div class="mb-3">
                    <span class="badge bg-info me-2">{{ $article->kategori->nama_kategori }}</span>
                    <small class="text-muted">
                        Oleh {{ $article->user->nama }} • {{ $article->created_at->format('d M Y') }}
                    </small>
                </div>
                
                <div class="article-content">
                    {!! nl2br(e($article->isi)) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Reject Modals -->
@foreach($articles as $article)
<div class="modal fade" id="rejectModal{{ $article->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('teacher.review.reject', $article->id) }}">
                @csrf
                <div class="modal-body">
                    <p><strong>Artikel:</strong> {{ $article->judul }}</p>
                    <p><strong>Penulis:</strong> {{ $article->user->nama }}</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" name="rejection_reason" rows="3" required placeholder="Berikan alasan mengapa artikel ini ditolak dan saran perbaikan..."></textarea>
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