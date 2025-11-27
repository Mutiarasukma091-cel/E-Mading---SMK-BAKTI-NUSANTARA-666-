<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $guru = User::where('role', 'guru')->first();
        $siswa = User::where('role', 'siswa')->first();
        
        $kategori1 = Kategori::first();
        $kategori2 = Kategori::skip(1)->first();

        // Artikel dari admin (published)
        Artikel::create([
            'judul' => 'Selamat Datang di MadingDigitally',
            'isi' => 'Selamat datang di platform mading digital sekolah. Platform ini memungkinkan siswa dan guru untuk berbagi artikel, berita, dan informasi penting sekolah.',
            'foto' => 'default.jpg',
            'user_id' => $admin->id,
            'kategori_id' => $kategori1->id,
            'status' => 'published',
            'views' => 25
        ]);

        // Artikel dari guru (published)
        Artikel::create([
            'judul' => 'Tips Belajar Efektif di Era Digital',
            'isi' => 'Di era digital ini, siswa perlu menguasai teknik belajar yang efektif. Berikut beberapa tips yang dapat membantu meningkatkan prestasi belajar.',
            'foto' => 'default.jpg',
            'user_id' => $guru->id,
            'kategori_id' => $kategori2->id,
            'status' => 'published',
            'views' => 18
        ]);

        // Artikel dari siswa (published)
        Artikel::create([
            'judul' => 'Pengalaman Mengikuti Olimpiade Sains',
            'isi' => 'Berbagi pengalaman mengikuti olimpiade sains tingkat nasional. Persiapan, tantangan, dan pembelajaran yang didapat.',
            'foto' => 'default.jpg',
            'user_id' => $siswa->id,
            'kategori_id' => $kategori1->id,
            'status' => 'published',
            'views' => 12
        ]);

        // Artikel menunggu review
        Artikel::create([
            'judul' => 'Kegiatan Ekstrakurikuler Robotika',
            'isi' => 'Laporan kegiatan ekstrakurikuler robotika semester ini. Berbagai project menarik yang telah dikerjakan siswa.',
            'foto' => 'default.jpg',
            'user_id' => $siswa->id,
            'kategori_id' => $kategori2->id,
            'status' => 'draft',
            'views' => 0
        ]);

        // Artikel sudah direview guru
        Artikel::create([
            'judul' => 'Prestasi Sekolah di Bidang Olahraga',
            'isi' => 'Sekolah meraih berbagai prestasi di bidang olahraga pada kompetisi antar sekolah tahun ini.',
            'foto' => 'default.jpg',
            'user_id' => $siswa->id,
            'kategori_id' => $kategori1->id,
            'status' => 'reviewed',
            'views' => 0
        ]);
    }
}