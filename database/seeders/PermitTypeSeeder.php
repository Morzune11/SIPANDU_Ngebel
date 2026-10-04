<?php

namespace Database\Seeders;

use App\Models\PermitType;
use Illuminate\Database\Seeder;

class PermitTypeSeeder extends Seeder
{
    public function run(): void
    {
        PermitType::create([
            'nama_izin' => 'Surat Keterangan Usaha (SKU)',
            'persyaratan' => "1. Fotokopi KTP\n2. Fotokopi KK\n3. Pengantar RT/RW",
            'estimasi_hari' => 3,
            'is_active' => true,
        ]);

        PermitType::create([
            'nama_izin' => 'Surat Keterangan Domisili',
            'persyaratan' => "1. Fotokopi KTP\n2. Pengantar RT/RW",
            'estimasi_hari' => 2,
            'is_active' => true,
        ]);

        PermitType::create([
            'nama_izin' => 'Surat Rekomendasi Kegiatan (Keramaian)',
            'persyaratan' => "1. Fotokopi KTP Ketua Panitia\n2. Proposal Kegiatan\n3. Izin Lokasi",
            'estimasi_hari' => 5,
            'is_active' => true,
        ]);
    }
}