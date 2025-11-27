<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MadingDigitally')</title>
  
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom-pastel.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/layout-improvements.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/loading-states.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/clean-beauty.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/brown-buttons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/dropdown-fix.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Header for Authenticated Users -->
  <nav class="navbar navbar-expand-lg 
    @if(auth()->user()->role == 'admin') navbar-light bg-light 
    @elseif(auth()->user()->role == 'teacher') navbar-light bg-light 
    @else navbar-light bg-light @endif">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('assets/img/logobn.jpg') }}" alt="MadingDigitally" height="40" style="background: transparent;">
      </a>
      
      <div class="dropdown">
        <button class="btn 
          @if(auth()->user()->role == 'admin') btn-outline-danger
          @elseif(auth()->user()->role == 'guru') btn-outline-success
          @elseif(auth()->user()->role == 'siswa') btn-outline-primary
          @else btn-outline-dark @endif dropdown-toggle" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle"></i> 
          @if(auth()->user()->role == 'admin') Admin
          @elseif(auth()->user()->role == 'guru') Guru
          @elseif(auth()->user()->role == 'siswa') Siswa
          @else Pengunjung @endif
        </button>
        <ul class="dropdown-menu">
          @if(auth()->user()->role == 'admin')
            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Kategori</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.articles.index') }}">Artikel</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">User</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}">Laporan</a></li>
          @elseif(auth()->user()->role == 'guru')
            <li><a class="dropdown-item" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('teacher.articles.create') }}">Tulis Artikel</a></li>
            <li><a class="dropdown-item" href="{{ route('teacher.articles.index') }}">Artikel Saya</a></li>
            <li><a class="dropdown-item" href="{{ route('teacher.review.index') }}">Review Artikel</a></li>
          @elseif(auth()->user()->role == 'siswa')
            <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('student.articles.create') }}">Tulis Artikel</a></li>
            <li><a class="dropdown-item" href="{{ route('student.articles.index') }}">Artikel Saya</a></li>
          @else
            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Dashboard Saya</a></li>
          @endif
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="{{ route('notifications.index') }}">
            Notifikasi
            @php
              $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
              <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
            @endif
          </a></li>
          <li><a class="dropdown-item" href="{{ route('articles.index') }}">Lihat Artikel</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil Saya</a></li>
          <li>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="flex-grow-1">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-light py-4 mt-auto">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p class="mb-0">&copy; 2025 MadingDigitally. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-end">
          <small class="text-muted">Platform Mading Digital Sekolah</small>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/app-enhancements.js') }}"></script>
  @stack('scripts')
  
  @if(session('success'))
    <div data-success-message="{{ session('success') }}"></div>
  @endif
  
  @if(session('error'))
    <div data-error-message="{{ session('error') }}"></div>
  @endif
</body>
</html>