@extends('template-dasar.guest')

@section('title', 'Pencarian Artikel - MadingDigitally')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Hasil Pencarian</h2>
    
    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('articles.search') }}">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="q" class="form-control" placeholder="Cari artikel..." value="{{ $query }}">
                    </div>
                    <div class="col-md-4">
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $kategori == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @if($query || $kategori)
        <p class="text-muted">
            Menampilkan {{ $articles->total() }} hasil untuk 
            @if($query) "{{ $query }}" @endif
            @if($kategori) dalam kategori "{{ $categories->find($kategori)->nama_kategori ?? '' }}" @endif
        </p>
    @endif
    
    <!-- Articles Grid -->
    <div class="row">
        @forelse($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($article->foto)
                    <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $article->judul }}">
                @endif
                <div class="card-body">
                    <span class="badge bg-primary mb-2">{{ $article->kategori->nama_kategori }}</span>
                    <h5 class="card-title">{{ $article->judul }}</h5>
                    <p class="card-text text-muted">{{ Str::limit(strip_tags($article->isi), 100) }}</p>
                    <small class="text-muted">
                        Oleh {{ $article->user->nama }} • {{ $article->created_at->format('d M Y') }}
                    </small>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-danger me-1"><i class="bi bi-heart"></i> {{ $article->total_likes }}</span>
                            <span class="badge bg-info"><i class="bi bi-chat"></i> {{ $article->komentars->count() }}</span>
                        </div>
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-outline-primary">Baca</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-search display-4 text-muted"></i>
            <h5 class="mt-3">Tidak ada artikel ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda atau pilih kategori lain.</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="mt-4">
            {{ $articles->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection