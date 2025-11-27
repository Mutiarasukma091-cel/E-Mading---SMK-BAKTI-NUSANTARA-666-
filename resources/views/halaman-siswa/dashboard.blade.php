@extends('template-dasar.authenticated')

@section('title', 'Dashboard Siswa - MadingDigitally')

@section('content')

  <div class="container py-4">
    <h2 class="mb-4">Dashboard Siswa</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <!-- Stats -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <i class="bi bi-file-text display-4 text-warning"></i>
            <h4 class="mt-2">{{ $stats['draft'] }}</h4>
            <p class="text-muted">Draft</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <i class="bi bi-check-circle display-4 text-success"></i>
            <h4 class="mt-2">{{ $stats['published'] }}</h4>
            <p class="text-muted">Published</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <i class="bi bi-heart display-4 text-danger"></i>
            <h4 class="mt-2">{{ $stats['total_likes'] }}</h4>
            <p class="text-muted">Total Like</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center">
          <div class="card-body">
            <i class="bi bi-chat display-4 text-info"></i>
            <h4 class="mt-2">0</h4>
            <p class="text-muted">Komentar</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <a href="{{ route('student.articles.create') }}" class="btn btn-primary w-100 py-3">
          <i class="bi bi-plus-circle"></i><br>Tulis Artikel Baru
        </a>
      </div>
      <div class="col-md-4 mb-3">
        <a href="{{ route('student.articles.index') }}" class="btn btn-outline-primary w-100 py-3">
          <i class="bi bi-file-text"></i><br>Artikel Saya
        </a>
      </div>
      <div class="col-md-4 mb-3">
        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary w-100 py-3">
          <i class="bi bi-book"></i><br>Baca Artikel
        </a>
      </div>
    </div>
    
    <!-- Recent Articles -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Artikel Terbaru Saya</h5>
        <!-- <a href="{{ route('student.articles.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-circle"></i> Tulis Artikel -->
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Likes</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentArticles as $article)
              <tr>
                <td>{{ Str::limit($article->judul, 30) }}</td>
                <td><span class="badge bg-primary">{{ $article->kategori->nama_kategori }}</span></td>
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
                <td>{{ $article->total_likes }}</td>
                <td>{{ $article->created_at->format('d M Y') }}</td>
                <td>
                  <a href="{{ route('student.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  @if($article->status == 'published')
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">
                  <i class="bi bi-file-text display-4 d-block mb-2"></i>
                  Belum ada artikel. <a href="{{ route('student.articles.create') }}">Tulis artikel pertama Anda!</a>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        @if($recentArticles->count() > 0)
        <div class="text-center mt-3">
          <a href="{{ route('student.articles.index') }}" class="btn btn-outline-primary">Lihat Semua Artikel Saya</a>
        </div>
        @endif
      </div>
    </div>
  </div>

@endsection