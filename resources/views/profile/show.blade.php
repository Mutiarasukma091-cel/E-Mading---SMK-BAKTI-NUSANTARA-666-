@extends('template-dasar.authenticated')

@section('title', 'Profil Saya - MadingDigitally')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle display-1 text-muted"></i>
                    <h4 class="mt-3">{{ auth()->user()->nama }}</h4>
                    <p class="text-muted">{{ ucfirst(auth()->user()->role) }}</p>
                    <p class="small text-muted">Bergabung {{ auth()->user()->created_at->format('d M Y') }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Nama:</strong></div>
                        <div class="col-sm-9">{{ auth()->user()->nama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Username:</strong></div>
                        <div class="col-sm-9">{{ auth()->user()->username }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Email:</strong></div>
                        <div class="col-sm-9">{{ auth()->user()->email ?? 'Belum diatur' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Role:</strong></div>
                        <div class="col-sm-9">
                            @if(auth()->user()->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif(auth()->user()->role == 'guru')
                                <span class="badge bg-success">Guru</span>
                            @else
                                <span class="badge bg-primary">Siswa</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Status:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-success">{{ ucfirst(auth()->user()->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4 class="text-primary">{{ auth()->user()->artikels->count() }}</h4>
                            <p class="text-muted">Total Artikel</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-success">{{ auth()->user()->likes->count() }}</h4>
                            <p class="text-muted">Total Like</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-info">{{ auth()->user()->komentars->count() }}</h4>
                            <p class="text-muted">Total Komentar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection