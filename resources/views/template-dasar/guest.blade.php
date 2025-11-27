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
    <link href="{{ asset('assets/css/homepage-style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dropdown-fix.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-bottom: 2px solid #e9ecef;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logobn.jpg') }}" alt="MadingDigitally" height="40" style="background: transparent;">
            </a>
            
            <div class="d-flex align-items-center ms-auto">
                <form class="d-flex me-3" method="GET" action="{{ route('articles.search') }}">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." style="width: 200px;">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                    <a class="nav-link" href="{{ route('articles.index') }}">Artikel</a>
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                            {{ auth()->user()->nama }}
                        </button>
                        <ul class="dropdown-menu">
                            @if(auth()->user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            @elseif(auth()->user()->role == 'teacher')
                                <li><a class="dropdown-item" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            @elseif(auth()->user()->role == 'student')
                                <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                @endauth
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
    
    @if(session('success'))
      <div data-success-message="{{ session('success') }}"></div>
    @endif
    
    @if(session('error'))
      <div data-error-message="{{ session('error') }}"></div>
    @endif
</body>
</html>