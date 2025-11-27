@extends('template-dasar.guest')

@section('title', 'Beranda - MadingDigitally')

@section('content')

  <!-- Hero Section -->
  <div class="hero-section text-white py-5">
    <div class="container text-center">
      <h1 class="display-5 fw-bold floating-element">Selamat Datang di MadingDigitally</h1>
      <p class="lead mb-4">Platform mading digital sekolah untuk berbagi artikel dan ide</p>
      <div class="mt-4">
        <a href="{{ route('articles.index') }}" class="btn btn-outline-light me-2">📚 Baca Artikel</a>
        <a href="{{ route('login') }}" class="btn btn-outline-light">✍️ Mulai Menulis</a>
      </div>
    </div>
  </div>

  <!-- Stats Section -->
  <div class="stats-section py-5">
    <div class="container">
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="card border-0 h-100">
          <div class="card-body stats-card">
            <i class="bi bi-file-text display-4"></i>
            <h3 class="mt-3 mb-2">{{ $stats['total_articles'] }}</h3>
            <p class="text-muted mb-0">Total Artikel</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 h-100">
          <div class="card-body stats-card">
            <i class="bi bi-tags display-4"></i>
            <h3 class="mt-3 mb-2">{{ $stats['total_categories'] }}</h3>
            <p class="text-muted mb-0">Kategori</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 h-100">
          <div class="card-body stats-card">
            <i class="bi bi-people display-4"></i>
            <h3 class="mt-3 mb-2">{{ $stats['total_authors'] }}</h3>
            <p class="text-muted mb-0">Penulis</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Articles Section -->
  <div class="articles-section py-5">
    <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h2 class="mb-4 section-title">Artikel Terbaru</h2>
        <div class="row g-4">
          @forelse($latestArticles as $article)
      <div class="col-md-6 col-lg-4">
        <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none">
          <div class="card h-100 article-card">
            @if($article->foto)
              <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $article->judul }}">
            @else
              <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="bi bi-image text-white" style="font-size: 2.5rem;"></i>
              </div>
            @endif
            <div class="card-body">
              <span class="badge bg-secondary mb-2">{{ $article->kategori->nama_kategori }}</span>
              <h5 class="card-title text-dark">{{ $article->judul }}</h5>
              <p class="card-text text-muted">Oleh {{ $article->user->nama }} • {{ $article->created_at->format('d M Y') }}</p>
              <div class="d-flex justify-content-between">
                <small class="text-muted">{{ Str::limit($article->isi, 80) }}</small>
                <div>
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
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Popular Articles -->
        <div class="card mb-4 sidebar-card">
          <div class="card-header">
            <h5 class="mb-0">🔥 Artikel Terpopuler</h5>
          </div>
          <div class="card-body">
            @foreach($popularArticles as $popular)
            <div class="mb-3">
              <a href="{{ route('articles.show', $popular->id) }}" class="text-decoration-none">
                <h6 class="mb-1">{{ Str::limit($popular->judul, 40) }}</h6>
                <small class="text-muted">{{ $popular->total_likes }} likes • {{ $popular->created_at->format('d M Y') }}</small>
              </a>
            </div>
            @if(!$loop->last)<hr>@endif
            @endforeach
          </div>
        </div>
        
        <!-- Categories -->
        <div class="card sidebar-card">
          <div class="card-header">
            <h5 class="mb-0">📚 Kategori</h5>
          </div>
          <div class="card-body">
            @foreach($categories as $category)
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span>{{ $category->nama_kategori }}</span>
              <span class="badge bg-secondary">{{ $category->artikels_count }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    
    <div class="text-center mt-4">
      <a href="{{ route('articles.index') }}" class="btn btn-primary btn-lg">🚀 Lihat Semua Artikel</a>
    </div>
  </div>

@endsection