@extends('template-dasar.guest')

@section('title', 'Semua Artikel - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Semua Artikel</h2>
        <span class="text-muted">{{ $articles->total() }} artikel ditemukan</span>
    </div>
    
    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Artikel</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('articles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Artikel</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Judul atau isi artikel...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Kategori::all() as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Urutkan</label>
                    <select class="form-select" name="sort">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Paling Dilihat</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row g-4">
        @forelse($articles as $article)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none">
                <div class="card h-100">
                    @if($article->foto)
                        <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $article->judul }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-image text-white" style="font-size: 2.5rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">{{ $article->kategori->nama_kategori }}</span>
                        <h5 class="card-title text-dark">{{ $article->judul }}</h5>
                        <p class="card-text text-muted">Oleh <a href="{{ route('user.profile', $article->user->id) }}" class="text-decoration-none text-muted">{{ $article->user->nama }}</a> • {{ $article->created_at->format('d M Y') }}</p>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">{{ Str::limit($article->isi, 80) }}</small>
                            <div>
                                <span class="badge bg-secondary me-1"><i class="bi bi-eye"></i> {{ $article->views ?? 0 }}</span>
                                <span class="badge bg-danger me-1"><i class="bi bi-heart"></i> {{ $article->total_likes }}</span>
                                <span class="badge bg-info"><i class="bi bi-chat"></i> {{ $article->komentars->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>
    
    @if($articles->hasPages())
        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection