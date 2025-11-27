@extends('template-dasar.guest')

@section('title', $article->judul . ' - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Article -->
            <article class="card">
                @if($article->foto)
                    <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="card-img-top">
                @endif
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $article->kategori->nama_kategori }}</span>
                        <small class="text-muted ms-2">{{ $article->tanggal->format('d M Y') }}</small>
                    </div>
                    
                    <h1 class="card-title">{{ $article->judul }}</h1>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <strong>{{ $article->user->name }}</strong>
                            <small class="text-muted d-block">Penulis</small>
                        </div>
                        <div class="ms-auto">
                            @auth
                                <form method="POST" action="{{ route('articles.like', $article->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-heart{{ $article->isLikedBy(auth()->user()) ? '-fill' : '' }}"></i>
                                        {{ $article->likes->count() }}
                                    </button>
                                </form>
                            @else
                                <span class="btn btn-outline-danger btn-sm disabled">
                                    <i class="bi bi-heart"></i> {{ $article->likes->count() }}
                                </span>
                            @endauth
                        </div>
                    </div>
                    
                    <div class="article-content">
                        {!! nl2br(e($article->isi)) !!}
                    </div>
                </div>
            </article>
            
            <!-- Comments Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Komentar ({{ $article->comments->count() }})</h5>
                </div>
                <div class="card-body">
                    @auth
                        <!-- Comment Form -->
                        <form method="POST" action="{{ route('articles.comment', $article->id) }}" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" name="isi" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <a href="{{ route('login') }}">Login</a> untuk memberikan komentar.
                        </div>
                    @endauth
                    
                    <!-- Comments List -->
                    @forelse($article->comments()->with('user')->latest()->get() as $comment)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <p class="mt-2 mb-0">{{ $comment->isi }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Related Articles -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Artikel Terkait</h6>
                </div>
                <div class="card-body">
                    @foreach(App\Models\Artikel::where('kategori_id', $article->kategori_id)->where('id', '!=', $article->id)->where('status', 'published')->take(3)->get() as $related)
                        <div class="d-flex mb-3">
                            @if($related->foto)
                                <img src="{{ asset('uploads/articles/' . $related->foto) }}" width="60" height="60" class="rounded me-3">
                            @endif
                            <div>
                                <a href="{{ route('articles.show', $related->id) }}" class="text-decoration-none">
                                    <h6 class="mb-1">{{ Str::limit($related->judul, 50) }}</h6>
                                </a>
                                <small class="text-muted">{{ $related->tanggal->format('d M Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection