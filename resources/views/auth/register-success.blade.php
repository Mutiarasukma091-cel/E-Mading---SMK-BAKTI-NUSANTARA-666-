@extends('template-dasar.guest')

@section('title', 'Registrasi Berhasil - MadingDigitally')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="fw-bold text-success mb-3">Registrasi Berhasil!</h3>
                    
                    <p class="text-muted mb-4">
                        Terima kasih telah mendaftar di MadingDigitally. 
                        Akun Anda sedang menunggu persetujuan dari admin.
                    </p>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Langkah Selanjutnya:</strong><br>
                        Admin akan meninjau pendaftaran Anda dan memberikan persetujuan. 
                        Anda akan menerima notifikasi setelah akun disetujui.
                    </div>
                    
                    <a href="{{ route('login') }}" class="btn btn-primary">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection