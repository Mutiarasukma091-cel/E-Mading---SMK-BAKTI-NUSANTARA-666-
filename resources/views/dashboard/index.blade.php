<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - MadingDigitally</title>
  
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  
  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom-pastel.css') }}" rel="stylesheet">
</head>

<body>
  <!-- Header -->
  <header id="header" class="header position-relative">
    <div class="container-fluid container-xl position-relative">
      <div class="top-row d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-end">
          <h1 class="sitename">MadingDigitally</h1><span>.</span>
        </a>
        
        <div class="d-flex align-items-center">
          <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i> Dashboard
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
              <li><a class="dropdown-item" href="{{ route('articles.create') }}">Tulis Artikel</a></li>
              <li><a class="dropdown-item" href="{{ route('articles.drafts') }}">Draft Saya</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('home') }}">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="main">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12">
          <h2 class="mb-4">Dashboard Siswa</h2>
        </div>
      </div>
      
      <!-- Stats Cards -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="bi bi-file-text display-4 text-primary"></i>
              <h5 class="card-title mt-2">Draft Artikel</h5>
              <h3 class="text-primary">3</h3>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="bi bi-check-circle display-4 text-success"></i>
              <h5 class="card-title mt-2">Artikel Published</h5>
              <h3 class="text-success">5</h3>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="bi bi-heart display-4 text-danger"></i>
              <h5 class="card-title mt-2">Total Like</h5>
              <h3 class="text-danger">24</h3>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="bi bi-chat display-4 text-info"></i>
              <h5 class="card-title mt-2">Total Komentar</h5>
              <h3 class="text-info">12</h3>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Quick Actions -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <a href="{{ route('articles.create') }}" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> Tulis Artikel Baru
                  </a>
                </div>
                <div class="col-md-4 mb-3">
                  <a href="{{ route('articles.drafts') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-file-text"></i> Lihat Draft
                  </a>
                </div>
                <div class="col-md-4 mb-3">
                  <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-book"></i> Baca Artikel
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Recent Articles -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Artikel Terbaru Saya</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Judul</th>
                      <th>Kategori</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Masa Depan Teknologi AI</td>
                      <td><span class="badge bg-primary">Teknologi</span></td>
                      <td><span class="badge bg-warning">Draft</span></td>
                      <td>2024-01-15</td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                      </td>
                    </tr>
                    <tr>
                      <td>Tips Belajar Efektif</td>
                      <td><span class="badge bg-success">Pendidikan</span></td>
                      <td><span class="badge bg-success">Published</span></td>
                      <td>2024-01-10</td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">Lihat</button>
                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>