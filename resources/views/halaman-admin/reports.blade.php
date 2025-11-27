@extends('template-dasar.authenticated')

@section('title', 'Laporan - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Laporan</h2>
        <div>
            <button onclick="window.print()" class="btn btn-outline-primary me-2">
                <i class="bi bi-printer"></i> Print
            </button>
            <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn btn-danger">
                <i class="bi bi-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    
    <!-- Filter Form -->
    <form method="GET" class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <option value="1" {{ request('bulan') == '1' ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('bulan') == '2' ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('bulan') == '3' ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ request('bulan') == '4' ? 'selected' : '' }}>April</option>
                        <option value="5" {{ request('bulan') == '5' ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('bulan') == '6' ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('bulan') == '7' ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ request('bulan') == '8' ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ request('bulan') == '9' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach(App\Models\Kategori::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary w-100">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Stats Cards -->
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
                    <h4 class="mt-2">{{ $stats['published'] }}</h4>
                    <p class="text-muted">Dipublikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-clock display-4 text-warning"></i>
                    <h4 class="mt-2">{{ $stats['draft'] }}</h4>
                    <p class="text-muted">Menunggu Review</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-check2-circle display-4 text-info"></i>
                    <h4 class="mt-2">{{ $stats['reviewed'] }}</h4>
                    <p class="text-muted">Disetujui Guru</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-x-circle display-4 text-danger"></i>
                    <h4 class="mt-2">{{ $stats['rejected'] }}</h4>
                    <p class="text-muted">Ditolak</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-heart display-4 text-danger"></i>
                    <h4 class="mt-2">{{ $stats['total_likes'] }}</h4>
                    <p class="text-muted">Total Likes</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Category Stats -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Statistik per Kategori</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Total</th>
                            <th>Dipublikasi</th>
                            <th>Menunggu</th>
                            <th>Disetujui</th>
                            <th>Ditolak</th>
                            <th>Likes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryStats as $category)
                        <tr>
                            <td>{{ $category->nama_kategori }}</td>
                            <td>{{ $category->total_articles }}</td>
                            <td>{{ $category->published_articles }}</td>
                            <td>{{ $category->draft_articles }}</td>
                            <td>{{ $category->reviewed_articles }}</td>
                            <td>{{ $category->rejected_articles }}</td>
                            <td>{{ $category->total_likes ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                            <th>Likes</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentArticles as $article)
                        <tr>
                            <td>{{ Str::limit($article->judul, 40) }}</td>
                            <td>{{ $article->user->nama }}</td>
                            <td><span class="badge bg-secondary">{{ $article->kategori->nama_kategori }}</span></td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection