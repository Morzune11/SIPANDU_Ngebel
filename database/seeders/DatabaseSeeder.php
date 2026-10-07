<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PermitType;
use App\Models\PermitApplication;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. BUAT AKUN PETUGAS & INSTANSI
        // ==========================================
        User::create([
            'nik' => '3502010000000001',
            'nama_lengkap' => 'Administrator Kecamatan',
            'email' => 'admin@ngebel.go.id',
            'no_telepon' => '081111111111',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nik' => '3502010000000002',
            'nama_lengkap' => 'Camat Ngebel',
            'email' => 'camat@ngebel.go.id',
            'no_telepon' => '082222222222',
            'role' => 'camat',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nik' => '3502010000000003',
            'nama_lengkap' => 'Admin Polsek Ngebel',
            'email' => 'polsek@ngebel.go.id',
            'no_telepon' => '083333333333',
            'role' => 'admin_polsek',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nik' => '3502010000000004',
            'nama_lengkap' => 'Admin Koramil Ngebel',
            'email' => 'koramil@ngebel.go.id',
            'no_telepon' => '084444444444',
            'role' => 'admin_koramil',
            'password' => Hash::make('password'),
        ]);

        // ==========================================
        // 2. BUAT AKUN PEMOHON (MASYARAKAT)
        // ==========================================
        $pemohon1 = User::create([
            'nik' => '3502010000000005',
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'no_telepon' => '085555555555',
            'role' => 'pemohon',
            'tempat_tanggal_lahir' => 'Ponorogo, 17 Agustus 1990',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'Wiraswasta',
            'alamat' => 'Jl. Telaga Ngebel No. 10, RT 01 RW 02, Kec. Ngebel',
            'password' => Hash::make('password'),
        ]);

        $pemohon2 = User::create([
            'nik' => '3502010000000006',
            'nama_lengkap' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'no_telepon' => '086666666666',
            'role' => 'pemohon',
            'tempat_tanggal_lahir' => 'Madiun, 01 Januari 1995',
            'jenis_kelamin' => 'Perempuan',
            'pekerjaan' => 'Pegawai Swasta',
            'alamat' => 'Ds. Sahang, RT 03 RW 01, Kec. Ngebel',
            'password' => Hash::make('password'),
        ]);

        // ==========================================
        // 3. BUAT JENIS LAYANAN PERIZINAN (MASTER DATA)
        // ==========================================
        $izinDomisili = PermitType::create([
            'nama_izin' => 'Surat Keterangan Domisili',
            'persyaratan' => json_encode(['Fotokopi KTP', 'Fotokopi KK', 'Surat Pengantar RT/RW']),
        ]);

        $izinUsaha = PermitType::create([
            'nama_izin' => 'Surat Keterangan Usaha (SKU)',
            'persyaratan' => json_encode(['Fotokopi KTP', 'Fotokopi KK', 'Foto Tempat Usaha']),
        ]);

        // ==========================================
        // 4. BUAT DATA PENGAJUAN SURAT (DUMMY TRANSAKSI)
        // ==========================================
        
        // Surat 1: Baru Masuk (Diajukan)
        PermitApplication::create([
            'user_id' => $pemohon1->id,
            'permit_type_id' => $izinDomisili->id,
            'nomor_pendaftaran' => 'REG-' . date('Ym') . '-A001',
            'status' => 'diajukan',
        ]);

        // Surat 2: Sedang Diproses Admin
        PermitApplication::create([
            'user_id' => $pemohon2->id,
            'permit_type_id' => $izinUsaha->id,
            'nomor_pendaftaran' => 'REG-' . date('Ym') . '-B002',
            'status' => 'diproses',
        ]);

        // Surat 3: Perlu Revisi (Dikembalikan ke Pemohon)
        PermitApplication::create([
            'user_id' => $pemohon1->id,
            'permit_type_id' => $izinUsaha->id,
            'nomor_pendaftaran' => 'REG-' . date('Ym') . '-C003',
            'status' => 'revisi',
            'catatan_revisi' => 'Persyaratan kurang lengkap, mohon cek kembali KTP.',
        ]);

        // Surat 4: Valid & Menunggu TTE Camat (Diajukan ke Camat)
        PermitApplication::create([
            'user_id' => $pemohon2->id,
            'permit_type_id' => $izinDomisili->id,
            'nomor_pendaftaran' => 'REG-' . date('Ym') . '-D004',
            'status' => 'menunggu_tte',
        ]);

        // Surat 5: SUDAH SELESAI (Di-ACC Camat)
        PermitApplication::create([
            'user_id' => $pemohon1->id,
            'permit_type_id' => $izinDomisili->id,
            'nomor_pendaftaran' => 'REG-' . date('Ym') . '-E005',
            'status' => 'selesai',
            'updated_at' => now(), 
        ]);
    }
}