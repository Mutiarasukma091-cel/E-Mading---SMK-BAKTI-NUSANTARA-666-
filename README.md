# 📚 MadingDigitally

Sistem Mading Digital untuk Sekolah berbasis Laravel

## 🌟 Fitur Utama

- **Multi-Role System**: Admin, Guru, dan Siswa dengan hak akses berbeda
- **Sistem Moderasi**: Artikel siswa perlu persetujuan guru sebelum publish
- **Manajemen Artikel**: CRUD artikel dengan kategori dan upload gambar
- **Sistem Notifikasi**: Real-time notifications untuk semua aktivitas
- **Dashboard Analytics**: Statistik lengkap untuk admin
- **Export Laporan**: Export data ke PDF dan Excel
- **Responsive Design**: Tampilan mobile-friendly

## 🚀 Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, JavaScript
- **Authentication**: Laravel Auth
- **File Storage**: Local Storage
- **PDF Export**: DomPDF
- **Excel Export**: Maatwebsite Excel

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM (untuk asset compilation)

## 🛠️ Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Mutiarasukma091-cel/madingdigitally.git
cd madingdigitally
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Edit .env file dengan konfigurasi database Anda
# Lalu jalankan migration
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed
```

### 5. Storage Setup
```bash
# Create storage link
php artisan storage:link
```

### 6. Compile Assets
```bash
# Compile assets
npm run dev
# atau untuk production
npm run build
```

### 7. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👥 Default Accounts

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Guru | guru | guru123 |
| Siswa | siswa | siswa123 |

## 📖 Dokumentasi

Dokumentasi lengkap tersedia di file `PANDUAN_PENGGUNAAN.md`

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Project ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail.

## 👨‍💻 Developer

Dikembangkan oleh **Mutiara Sukma**
- GitHub: [@Mutiarasukma091-cel](https://github.com/Mutiarasukma091-cel)

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

---

⭐ **Jangan lupa berikan star jika project ini membantu!**