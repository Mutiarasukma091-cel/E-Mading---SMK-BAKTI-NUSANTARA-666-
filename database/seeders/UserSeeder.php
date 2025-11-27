<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@madingdigitally.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'approved'
        ]);

        User::create([
            'nama' => 'guru',
            'username' => 'guru1',
            'email' => 'guru1@madingdigitally.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
            'status' => 'approved'
        ]);

        User::create([
            'nama' => 'siswa',
            'username' => 'siswa1',
            'email' => 'siswa1@madingdigitally.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
            'status' => 'approved'
        ]);
    }
}