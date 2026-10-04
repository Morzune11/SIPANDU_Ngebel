<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin (Petugas / Superadmin)
        User::create([
            'nik'          => '1111111111111111',
            'nama_lengkap' => 'Administrator Kecamatan',
            'email'        => 'admin@kecamatan.go.id',
            'no_telepon'   => '081111111111',
            'password'     => Hash::make('password123'),
            'role'         => 'admin', // Sesuai dengan role di database
        ]);

        // 2. Akun Camat
        User::create([
            'nik'          => '2222222222222222',
            'nama_lengkap' => 'Bapak Kepala Kecamatan',
            'email'        => 'camat@kecamatan.go.id',
            'no_telepon'   => '082222222222',
            'password'     => Hash::make('password123'),
            'role'         => 'camat',
        ]);

        // 3. Akun Contoh Pemohon (Masyarakat)
        User::create([
            'nik'          => '3333333333333333',
            'nama_lengkap' => 'Budi Santoso',
            'email'        => 'budi.pemohon@gmail.com',
            'no_telepon'   => '083333333333',
            'password'     => Hash::make('password123'),
            'role'         => 'pemohon',
        ]);
    }
}