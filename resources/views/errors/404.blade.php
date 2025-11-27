@extends('template-dasar.guest')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-404 p-5">
                <div class="error-icon mb-4">
                    <i class="bi bi-exclamation-triangle" style="font-size: 5rem; color: var(--primary-color);"></i>
                </div>
                
                <div class="error-code mb-3" style="font-size: 6rem; font-weight: 300; color: var(--primary-color);">
                    404
                </div>
                
                <h2 class="error-title mb-3" style="color: var(--text-color);">
                    Halaman Tidak Ditemukan
                </h2>
                
                <p class="error-text mb-4" style="color: var(--light-text);">
                    Maaf, halaman yang Anda cari tidak dapat ditemukan. 
                    Mungkin halaman telah dipindahkan atau URL yang Anda masukkan salah.
                </p>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-book me-2"></i>Lihat Artikel
                    </a>
                </div>
                
                <div class="mt-4">
                    <small class="text-muted">
                        Atau gunakan menu navigasi di atas untuk menemukan halaman yang Anda cari.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection