<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login - MadingDigitally</title>
  
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  
  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom-pastel.css') }}" rel="stylesheet">
</head>

<body>
  <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">
      <div class="col-md-6 col-lg-4 mx-auto">
        <div class="card shadow-lg border-0" style="border-radius: 20px;">
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <h1 class="h3 mb-3 fw-normal text-primary">MadingDigitally</h1>
              <p class="text-muted">Masuk ke akun Anda</p>
            </div>
            
            <form>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
              </div>
              
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" required>
              </div>
              
              <div class="mb-3">
                <label for="role" class="form-label">Login sebagai</label>
                <select class="form-select" id="role" required>
                  <option value="">Pilih Role</option>
                  <option value="student">Siswa</option>
                  <option value="teacher">Guru</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              
              <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit">Masuk</button>
              </div>
              
              <div class="text-center mt-3">
                <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar</a></p>
                <a href="{{ route('home') }}" class="text-muted">← Kembali ke Beranda</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>