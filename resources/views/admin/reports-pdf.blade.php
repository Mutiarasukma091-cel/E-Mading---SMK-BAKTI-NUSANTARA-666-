<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Artikel - MadingDigitally</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-info { background-color: #d1ecf1; color: #0c5460; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN ARTIKEL</h1>
        <h2>MadingDigitally</h2>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <!-- Statistik Umum -->
    <h3>Statistik Umum</h3>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <strong>{{ $stats['total_articles'] }}</strong><br>
                Total Artikel
            </div>
            <div class="stats-cell">
                <strong>{{ $stats['published'] }}</strong><br>
                Dipublikasi
            </div>
            <div class="stats-cell">
                <strong>{{ $stats['draft'] }}</strong><br>
                Menunggu Review
            </div>
            <div class="stats-cell">
                <strong>{{ $stats['reviewed'] }}</strong><br>
                Disetujui Guru
            </div>
        </div>
        <div class="stats-row">
            <div class="stats-cell">
                <strong>{{ $stats['rejected'] }}</strong><br>
                Ditolak
            </div>
            <div class="stats-cell">
                <strong>{{ $stats['total_likes'] }}</strong><br>
                Total Likes
            </div>
            <div class="stats-cell"></div>
            <div class="stats-cell"></div>
        </div>
    </div>

    <!-- Statistik per Kategori -->
    <h3>Statistik per Kategori</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Total Artikel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryStats as $category)
            <tr>
                <td>{{ $category->nama_kategori }}</td>
                <td>{{ $category->artikels_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Daftar Artikel -->
    <h3>Daftar Artikel</h3>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Likes</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $index => $article)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ Str::limit($article->judul, 40) }}</td>
                <td>{{ $article->user->nama }}</td>
                <td>{{ $article->kategori->nama_kategori }}</td>
                <td>
                    @if($article->status == 'draft')
                        <span class="badge badge-warning">Menunggu Review</span>
                    @elseif($article->status == 'reviewed')
                        <span class="badge badge-info">Disetujui Guru</span>
                    @elseif($article->status == 'published')
                        <span class="badge badge-success">Dipublikasi</span>
                    @elseif($article->status == 'rejected')
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </td>
                <td>{{ $article->total_likes }}</td>
                <td>{{ $article->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem MadingDigitally</p>
        <p>© {{ date('Y') }} MadingDigitally. All rights reserved.</p>
    </div>
</body>
</html>