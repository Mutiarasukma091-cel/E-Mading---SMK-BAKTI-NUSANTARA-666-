<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Artikel - MadingDigitally</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .text-center { text-align: center; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN ARTIKEL</h1>
        <p>MadingDigitally - Platform Mading Digital Sekolah</p>
        <p>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</p>
        <p>Total Artikel: {{ $articles->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Judul Artikel</th>
                <th width="15%">Penulis</th>
                <th width="15%">Kategori</th>
                <th width="10%">Status</th>
                <th width="10%">Likes</th>
                <th width="15%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $index => $article)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $article->judul }}</td>
                <td>{{ $article->user->nama }}</td>
                <td>
                    <span class="badge badge-secondary">{{ $article->kategori->nama_kategori }}</span>
                </td>
                <td>
                    @if($article->status == 'published')
                        <span class="badge badge-success">Published</span>
                    @else
                        <span class="badge badge-warning">Draft</span>
                    @endif
                </td>
                <td class="text-center">{{ $article->likes->count() }}</td>
                <td>{{ $article->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data artikel</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p>Laporan ini dibuat secara otomatis oleh sistem MadingDigitally</p>
        <p>© {{ date('Y') }} MadingDigitally. All rights reserved.</p>
    </div>
</body>
</html>