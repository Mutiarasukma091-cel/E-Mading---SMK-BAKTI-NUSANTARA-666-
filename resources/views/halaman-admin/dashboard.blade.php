@extends('template-dasar.authenticated')

@section('title', 'Dashboard Admin - MadingDigitally')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard Admin</h2>
    
    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-file-text display-4 text-primary"></i>
                    <h4 class="mt-2">{{ $stats['total_articles'] }}</h4>
                    <p class="text-muted">Total Artikel</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-check-circle display-4 text-success"></i>
                    <h4 class="mt-2">{{ $stats['published_articles'] }}</h4>
                    <p class="text-muted">Dipublikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-clock display-4 text-warning"></i>
                    <h4 class="mt-2">{{ $stats['pending_articles'] }}</h4>
                    <p class="text-muted">Menunggu Review</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-check2-circle display-4 text-info"></i>
                    <h4 class="mt-2">{{ $stats['reviewed_articles'] }}</h4>
                    <p class="text-muted">Disetujui Guru</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-x-circle display-4 text-danger"></i>
                    <h4 class="mt-2">{{ $stats['rejected_articles'] }}</h4>
                    <p class="text-muted">Ditolak</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-people display-4 text-secondary"></i>
                    <h4 class="mt-2">{{ $stats['total_users'] }}</h4>
                    <p class="text-muted">Total Users</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100 py-3">
                <i class="bi bi-people"></i><br>Kelola Users
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary w-100 py-3">
                <i class="bi bi-file-text"></i><br>Kelola Artikel
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100 py-3">
                <i class="bi bi-tags"></i><br>Kelola Kategori
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary w-100 py-3">
                <i class="bi bi-graph-up"></i><br>Laporan
            </a>
        </div>
    </div>
    
    <!-- Recent Articles -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Artikel Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentArticles as $article)
                        <tr>
                            <td>{{ Str::limit($article->judul, 30) }}</td>
                            <td>{{ $article->user->nama }}</td>
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
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada artikel</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection