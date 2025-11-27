@extends('template-dasar.authenticated')

@section('title', 'Tulis Artikel - MadingDigitally')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tulis Artikel Baru</h2>
    
    <form action="{{ route('student.articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm" data-autosave="true">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Foto Artikel</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF (Max: 10MB)</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Isi Artikel</label>
                            <textarea class="form-control" name="isi" rows="15" required placeholder="Tulis artikel Anda di sini..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Publikasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <small><i class="bi bi-info-circle"></i> Artikel akan melalui 2 tahap review:</small><br>
                            <small>1. Review oleh Guru</small><br>
                            <small>2. Verifikasi oleh Admin</small><br>
                            <small>Setelah itu baru dipublikasi.</small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" data-loading="true">Kirim untuk Review</button>
                            <a href="{{ route('student.articles.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Tips Menulis</h6>
                    </div>
                    <div class="card-body">
                        <ul class="small">
                            <li>Gunakan judul yang menarik</li>
                            <li>Tulis dengan bahasa yang mudah dipahami</li>
                            <li>Sertakan foto yang relevan</li>
                            <li>Periksa ejaan sebelum mengirim</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection