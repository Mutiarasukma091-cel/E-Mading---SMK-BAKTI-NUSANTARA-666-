@extends('template-dasar.guest')

@section('title', $article->judul . ' - MadingDigitally')

@push('styles')
<meta name="description" content="{{ Str::limit(strip_tags($article->isi), 160) }}">
<meta name="keywords" content="{{ $article->kategori->nama_kategori }}, artikel, mading digital, sekolah">
<meta property="og:title" content="{{ $article->judul }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($article->isi), 160) }}">
<meta property="og:type" content="article">
@if($article->foto)
<meta property="og:image" content="{{ asset('uploads/articles/' . $article->foto) }}">
@endif
@endpush

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($article->judul, 50) }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8">
            <article class="mb-4">
                @if($article->foto)
                    <div class="mb-4">
                        <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="img-fluid w-100 rounded shadow" style="cursor: pointer;" alt="{{ $article->judul }}" onclick="openImageModal(this.src)">
                    </div>
                @endif
                
                <h1 class="mb-3">{{ $article->judul }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <span class="badge bg-primary me-2">{{ $article->kategori->nama_kategori }}</span>
                    <small class="text-muted">
                        Oleh <a href="{{ route('user.profile', $article->user->id) }}" class="text-decoration-none">{{ $article->user->nama }}</a> • {{ $article->created_at->format('d M Y') }}
                    </small>
                </div>
                
                <div class="article-content">
                    {!! nl2br(e($article->isi)) !!}
                </div>
            </article>
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Artikel
                </a>
            </div>
            
            <!-- Like and Comment Stats -->
            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                <form method="POST" action="{{ route('articles.like', $article->id) }}" class="me-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-heart{{ $article->isLikedByUser() ? '-fill' : '' }}"></i>
                        {{ $article->total_likes }} Like
                    </button>
                </form>
                
                <span class="text-muted me-3">
                    <i class="bi bi-eye"></i> {{ $article->views ?? 0 }} Views
                </span>
                
                <span class="text-muted">
                    <i class="bi bi-chat"></i> {{ $article->komentars->count() }} Komentar
                </span>
            </div>
            
            <!-- Comments Section -->
            <div class="comments-section">
                <h4 class="mb-4">Komentar ({{ $article->komentars->count() }})</h4>
                
                @auth
                    <form method="POST" action="{{ route('articles.comment', $article->id) }}" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="isi_komentar" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>

                @endauth
                
                <!-- Comments List -->
                <div class="comments-list">
                    @forelse($article->komentars()->with('user')->latest()->get() as $comment)
                        <div class="comment mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="{{ route('user.profile', $comment->user->id) }}" class="text-decoration-none">
                                        <strong class="text-success">{{ $comment->user->nama }}</strong>
                                    </a>
                                    <span class="badge bg-success ms-2">{{ ucfirst($comment->user->role) }}</span>
                                    <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <p class="mt-2 mb-0">{{ $comment->isi_komentar }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-chat-dots display-4 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada komentar.
                                @auth
                                    Jadilah yang pertama berkomentar!
                                @endauth
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Artikel Lainnya</h5>
                </div>
                <div class="card-body">
                    @php
                        $otherArticles = App\Models\Artikel::with(['user', 'kategori'])
                            ->where('status', 'published')
                            ->where('id', '!=', $article->id)
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @foreach($otherArticles as $other)
                        <div class="mb-3">
                            <a href="{{ route('articles.show', $other->id) }}" class="text-decoration-none">
                                <h6 class="mb-1">{{ Str::limit($other->judul, 50) }}</h6>
                                <small class="text-muted">{{ $other->created_at->format('d M Y') }}</small>
                            </a>
                        </div>
                        @if(!$loop->last)<hr>@endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $article->judul }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" style="max-height: 60vh; width: auto;">
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
        <div class="toast show" role="alert" data-bs-autohide="true" data-bs-delay="3000">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-success text-white">
                {{ session('success') }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.querySelector('.toast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>
@endif

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);
});
</script>
@endsection