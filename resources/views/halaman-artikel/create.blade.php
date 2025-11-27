<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Tulis Artikel - MadingDigitally</title>
  
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
          <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
          </a>
        </div>
      </div>
    </div>
  </header>

  <main class="main">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">
              <h4 class="mb-0">Tulis Artikel Baru</h4>
              <small class="text-muted">Artikel akan disimpan sebagai draft dan menunggu persetujuan guru/admin</small>
            </div>
            <div class="card-body">
              <form>
                <div class="mb-3">
                  <label for="title" class="form-label">Judul Artikel</label>
                  <input type="text" class="form-control" id="title" placeholder="Masukkan judul artikel yang menarik" required>
                </div>
                
                <div class="mb-3">
                  <label for="category" class="form-label">Kategori</label>
                  <select class="form-select" id="category" required>
                    <option value="">Pilih Kategori</option>
                    <option value="teknologi">Pendidikan</option>
                    <option value="pendidikan">Prestasi</option>
                    <option value="olahraga">kegiatan</option>
                    <option value="seni">Informasi sekolah</option>
                  </select>
                </div>
                
                <div class="mb-3">
                  <label for="image" class="form-label">Foto Artikel</label>
                  <input type="file" class="form-control" id="image" accept="image/*">
                  <small class="text-muted">Upload foto untuk mempercantik artikel</small>
                </div>
                
                <div class="mb-3">
                  <label for="content" class="form-label">Isi Artikel *</label>
                  <textarea class="form-control" id="content" rows="15" placeholder="Tulis isi artikel di sini..." required></textarea>
                  <small class="text-muted">Minimal 100 kata</small>
                </div>
                
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">
                      Saya menyetujui bahwa artikel ini adalah karya asli saya dan tidak melanggar hak cipta
                    </label>
                  </div>
                </div>
                
                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-outline-secondary">
                    <i class="bi bi-save"></i> Simpan Draft
                  </button>
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> Kirim untuk Review
                  </button>
                </div>
              </form>
            </div>
          </div>
          
          <!-- Writing Tips -->
          <div class="card mt-4">
            <div class="card-header">
              <h5 class="mb-0">Tips Menulis Artikel yang Baik</h5>
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li><i class="bi bi-check-circle text-success"></i> Gunakan judul yang menarik dan informatif</li>
                <li><i class="bi bi-check-circle text-success"></i> Tulis dengan bahasa yang mudah dipahami</li>
                <li><i class="bi bi-check-circle text-success"></i> Sertakan fakta dan data yang akurat</li>
                <li><i class="bi bi-check-circle text-success"></i> Gunakan paragraf yang tidak terlalu panjang</li>
                <li><i class="bi bi-check-circle text-success"></i> Periksa ejaan dan tata bahasa sebelum mengirim</li>
              </ul>
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