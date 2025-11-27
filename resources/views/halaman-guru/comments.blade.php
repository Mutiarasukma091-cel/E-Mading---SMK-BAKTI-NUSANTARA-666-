@extends('template-dasar.authenticated')

@section('title', 'Komentar Artikel - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Komentar Artikel</h2>
        <a href="{{ route('teacher.articles.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>
    
    <!-- Article Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                @if($article->foto)
                <div class="col-md-3">
                    <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="img-fluid rounded">
                </div>
                @endif
                <div class="col-md-9">
                    <span class="badge bg-primary mb-2">{{ $article->kategori->nama_kategori }}</span>
                    <h4>{{ $article->judul }}</h4>
                    <p class="text-muted">{{ Str::limit($article->isi, 200) }}</p>
                    <small class="text-muted">Dipublikasikan: {{ $article->tanggal->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Comments -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Komentar ({{ $article->comments->count() }})</h5>
        </div>
        <div class="card-body">
            @forelse($article->comments as $comment)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="badge bg-{{ $comment->user->role == 'student' ? 'success' : ($comment->user->role == 'teacher' ? 'info' : 'danger') }} ms-2">
                                {{ $comment->user->role == 'student' ? 'Siswa' : ($comment->user->role == 'teacher' ? 'Guru' : 'Admin') }}
                            </span>
                            <br>
                            <small class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                    <p class="mt-2 mb-0">{{ $comment->isi }}</p>
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-chat display-4 text-muted"></i>
                    <p class="mt-2 text-muted">Belum ada komentar untuk artikel ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection