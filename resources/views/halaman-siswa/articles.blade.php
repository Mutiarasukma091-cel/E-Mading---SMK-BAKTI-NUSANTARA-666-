@extends('template-dasar.authenticated')

@section('title', 'Artikel Saya - MadingDigitally')

@section('content')
<div class="container py-4" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Artikel Saya</h2>
        <a href="{{ route('student.articles.create') }}" class="btn btn-outline-secondary">
            <i class="bi bi-plus-circle"></i> Tulis Artikel Baru
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        @forelse($articles as $article)
        <div class="col-md-6 mb-4">
            <div class="card">
                @if($article->foto)
                    <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="card-img-top" style="height: 140px; object-fit: cover;" alt="{{ $article->judul }}">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 140px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                        <i class="bi bi-image text-white" style="font-size: 2.5rem;"></i>
                    </div>
                @endif
                <div class="card-body py-3 px-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary">{{ $article->kategori->nama_kategori }}</span>
                        @if($article->status == 'draft')
                            <span class="badge bg-warning">Menunggu Review</span>
                        @elseif($article->status == 'reviewed')
                            <span class="badge bg-info">Disetujui Guru</span>
                        @elseif($article->status == 'published')
                            <span class="badge bg-success">Dipublikasi</span>
                        @elseif($article->status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                    
                    <h5 class="card-title">{{ $article->judul }}</h5>
                    <p class="card-text">{{ Str::limit($article->isi, 100) }}</p>
                    
                    @if($article->status == 'rejected' && $article->rejection_reason)
                        <div class="alert alert-danger alert-sm">
                            <strong>Alasan Ditolak:</strong> {{ $article->rejection_reason }}
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                        <div>
                            <span class="badge bg-danger me-1">
                                <i class="bi bi-heart"></i> {{ $article->total_likes }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('student.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                        <form method="POST" action="{{ route('student.articles.destroy', $article->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus artikel ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-file-text display-1 text-muted"></i>
                <h4 class="mt-3">Belum Ada Artikel</h4>
                <p class="text-muted">Mulai menulis artikel pertama Anda!</p>
                <a href="{{ route('student.articles.create') }}" class="btn btn-outline-secondary">Tulis Artikel</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection