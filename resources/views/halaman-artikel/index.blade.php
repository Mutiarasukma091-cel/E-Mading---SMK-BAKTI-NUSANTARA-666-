<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artikel - MadingDigitally</title>
  
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom-pastel.css') }}" rel="stylesheet">
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('assets/img/logobn.jpg') }}" alt="MadingDigitally" height="50" style="background: transparent;">
      </a>
      
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('articles.index') }}">Artikel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">Kategori</a>
          </li>
        </ul>
        
        <div class="d-flex">
          @auth
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                {{ auth()->user()->name }}
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          @else
            <a href="{{ route('login') }}" class="btn btn-outline-secondary me-2">Login</a>
            <!-- <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a> -->
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Semua Artikel</h2>
      @if(request('search') || request('kategori') || request('tanggal'))
        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-x-circle"></i> Clear Filter
        </a>
      @endif
    </div>
    
    @if(request('search') || request('kategori') || request('tanggal'))
      <div class="alert alert-info">
        <strong>Filter aktif:</strong>
        @if(request('search'))
          Pencarian: "{{ request('search') }}"
        @endif
        @if(request('kategori'))
          @php $selectedCat = App\Models\Kategori::find(request('kategori')) @endphp
          @if($selectedCat)
            | Kategori: {{ $selectedCat->nama_kategori }}
          @endif
        @endif
        @if(request('tanggal'))
          | Tanggal: {{ date('d M Y', strtotime(request('tanggal'))) }}
        @endif
      </div>
    @endif
    
    <!-- Filter -->
    <form method="GET" class="row mb-4">
      <div class="col-md-4">
        <input type="text" class="form-control" name="search" placeholder="Cari artikel..." value="{{ request('search') }}">
      </div>
      <div class="col-md-3">
        <select class="form-select" name="kategori">
          <option value="">Pilih Kategori</option>
          @foreach(App\Models\Kategori::all() as $cat)
            <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" class="form-control" name="tanggal" value="{{ request('tanggal') }}" placeholder="Pilih Tanggal">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-outline-secondary w-100">Cari</button>
      </div>
    </form>
    
    <!-- Articles -->
    <div class="row">
      @forelse($articles as $article)
      <div class="col-md-6 mb-4">
        <div class="card h-100 article-card">
          @if($article->foto)
            <img src="{{ asset('uploads/articles/' . $article->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $article->judul }}">
          @else
            <img src="{{ asset('assets/img/blog/blog-post-1.webp') }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $article->judul }}">
          @endif
          <div class="card-body d-flex flex-column">
            <div class="mb-2">
              <span class="badge bg-secondary">{{ $article->kategori->nama_kategori }}</span>
            </div>
            <h5 class="card-title">
              <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none text-dark">{{ $article->judul }}</a>
            </h5>
            <p class="card-text text-muted flex-grow-1">{{ Str::limit($article->isi, 120) }}</p>
            
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <small class="text-muted">{{ $article->user->name }} • {{ $article->tanggal->format('d M Y') }}</small>
              <div>
                <form method="POST" action="{{ route('articles.like', $article->id) }}" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" {{ !auth()->check() ? 'disabled' : '' }}>
                    <i class="bi bi-heart{{ auth()->check() && $article->isLikedBy(auth()->user()) ? '-fill' : '' }}"></i>
                    {{ $article->likes->count() }}
                  </button>
                </form>
                <span class="badge bg-info ms-1">
                  <i class="bi bi-chat"></i> {{ $article->comments->count() }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <div class="text-center py-5">
          <i class="bi bi-file-text display-1 text-muted"></i>
          <h4 class="mt-3">Belum Ada Artikel</h4>
          <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
        </div>
      </div>
      @endforelse
    </div>
    
    <!-- Pagination -->
    @if(isset($articles) && method_exists($articles, 'links'))
      {{ $articles->links() }}
    @endif
  </div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>