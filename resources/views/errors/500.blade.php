@extends('template-dasar.guest')

@section('title', '500 - Server Error')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-500 p-5">
                <div class="error-icon mb-4">
                    <i class="bi bi-exclamation-octagon" style="font-size: 5rem; color: #dc3545;"></i>
                </div>
                
                <div class="error-code mb-3" style="font-size: 6rem; font-weight: 300; color: #dc3545;">
                    500
                </div>
                
                <h2 class="error-title mb-3" style="color: var(--text-color);">
                    Server Error
                </h2>
                
                <p class="error-text mb-4" style="color: var(--light-text);">
                    Maaf, terjadi kesalahan pada server. 
                    Tim kami sedang bekerja untuk memperbaiki masalah ini.
                </p>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                    </a>
                    <button onclick="window.location.reload()" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Coba Lagi
                    </button>
                </div>
                
                <div class="mt-4">
                    <small class="text-muted">
                        Jika masalah berlanjut, silakan hubungi administrator.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection