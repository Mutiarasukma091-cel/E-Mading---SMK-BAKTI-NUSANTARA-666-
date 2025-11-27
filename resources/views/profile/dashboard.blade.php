@extends('template-dasar.authenticated')

@section('title', 'Dashboard Profil - MadingDigitally')

@section('content')
<div class="container py-4">
    <!-- Header Profil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="mb-1">{{ $user->nama }}</h3>
                    <p class="text-muted mb-2">
                        @if($user->role == 'public')
                            Pengunjung Publik
                        @else
                            {{ ucfirst($user->role) }}
                        @endif
                    </p>
                    <div class="row text-center">
                        <div class="col-4">
                            <h5 class="mb-0">{{ $user->artikels()->count() }}</h5>
                            <small class="text-muted">Artikel</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">{{ $user->likes()->count() }}</h5>
                            <small class="text-muted">Like</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">{{ $user->komentars()->count() }}</h5>
                            <small class="text-muted">Komentar</small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="likes-tab" data-bs-toggle="tab" data-bs-target="#likes" type="button" role="tab">
                        <i class="bi bi-heart"></i> Like Saya ({{ $likes->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab">
                        <i class="bi bi-chat"></i> Komentar Saya ({{ $komentars->count() }})
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="profileTabsContent">
        <!-- Likes Tab -->
        <div class="tab-pane fade show active" id="likes" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    @if($likes->count() > 0)
                        @foreach($likes as $like)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-heart-fill text-danger fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
                                        <a href="{{ route('articles.show', $like->artikel->id) }}" class="text-decoration-none">
                                            {{ $like->artikel->judul }}
                                        </a>
                                    </h6>
                                    <p class="text-muted mb-1">{{ Str::limit($like->artikel->isi, 100) }}</p>
                                    <small class="text-muted">{{ $like->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                        @if($likes->count() >= 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Menampilkan 10 like terbaru</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-heart display-4 text-muted mb-3"></i>
                            <p class="text-muted">Anda belum memberikan like pada artikel apapun</p>
                            <a href="{{ route('articles.index') }}" class="btn btn-primary">Jelajahi Artikel</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Comments Tab -->
        <div class="tab-pane fade" id="comments" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    @if($komentars->count() > 0)
                        @foreach($komentars as $komentar)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-chat-fill text-primary fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
                                        <a href="{{ route('articles.show', $komentar->artikel->id) }}" class="text-decoration-none">
                                            {{ $komentar->artikel->judul }}
                                        </a>
                                    </h6>
                                    <p class="mb-1">{{ $komentar->isi_komentar }}</p>
                                    <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                        @if($komentars->count() >= 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Menampilkan 10 komentar terbaru</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-chat display-4 text-muted mb-3"></i>
                            <p class="text-muted">Anda belum memberikan komentar pada artikel apapun</p>
                            <a href="{{ route('articles.index') }}" class="btn btn-primary">Jelajahi Artikel</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection