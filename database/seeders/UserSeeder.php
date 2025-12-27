<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin HRD',
            'email' => 'admin@simpeg.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun KARYAWAN
        $karyawan = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@simpeg.com',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        // Isi detail data diri si Budi
        Karyawan::create([
            'user_id' => $karyawan->id,
            'jabatan' => 'Staff IT',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Merdeka No. 10',
        ]);
    }
}