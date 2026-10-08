<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
// use App\Models\Permohonan; // Asumsi menggunakan model Permohonan

class DraftController extends Controller
{
    /**
     * Menyimpan input nomor surat dari Admin dan menampilkan Preview PDF
     */
/**
     * Memproses data dari formulir dan menampilkan Preview PDF
     */


public function previewRekomendasi($id)
    {
        // 1. Ambil data pengajuan dan data profil pemohon dari database
        $application = \App\Models\PermitApplication::with(['user', 'permitType'])->findOrFail($id);
        $pemohon = $application->user;

        // 2. Siapkan data otomatis untuk di-render ke PDF/HTML
        $data = [
            'nomor_surat' => '400/' . $application->id . '/405.30/' . date('Y'), // Nomor surat otomatis
            'dasar_surat' => 'Peraturan perundang-undangan yang berlaku terkait perizinan masyarakat.',
            'nama_pelapor' => $pemohon->nama_lengkap,
            'nik' => $pemohon->nik,
            'jenis_kelamin' => $pemohon->jenis_kelamin ?? 'Belum diisi',
            'ttl' => $pemohon->tempat_tanggal_lahir ?? 'Belum diisi',
            'alamat' => $pemohon->alamat ?? 'Belum diisi',
            'pekerjaan' => $pemohon->pekerjaan ?? 'Belum diisi',
            'tujuan_kegiatan' => 'Pengajuan ' . $application->permitType->nama_izin,
            'jenis_kegiatan' => $application->permitType->nama_izin,
            'tempat_kegiatan' => 'Kecamatan Ngebel',
            'waktu_kegiatan' => $application->created_at->format('d F Y'),
            
            // Kolom pengesahan
            'tanggal_dikeluarkan' => date('d F Y'),
            'nama_camat' => 'Nama Camat Anda, M.Si', // Bisa disesuaikan
            'nip_camat' => '19800101 200501 1 001',
        ];

        // Panggil getSuratData agar semua data konsisten, termasuk nama Camat
        $data = $this->getSuratData($id);

        // 3. Tampilkan halaman preview
        return view('pdf.surat_rekomendasi', $data);
    }

    public function createRekomendasi($id)
    {
        // Catatan: Pada implementasi nyata, ambil data ini dari database
        // $permohonan = Permohonan::findOrFail($id);
        
        // Data simulasi (dummy) berdasarkan input pemohon untuk keperluan testing
        $permohonan = (object) [
            'id' => $id,
            'nama_pelapor'   => 'MUJIONO',
            'nik'            => '3502190605780001',
            'jenis_kelamin'  => 'Laki laki',
            'ttl'            => 'Ponorogo, 06-05-1978',
            'alamat'         => 'RT.022 RW.002 Dukuh Keleng Desa Ngebel',
            'pekerjaan'      => 'Wiraswasta / petani',
            'tujuan_kegiatan'=> 'Edukasi Peternak Kambing Seni',
            'jenis_kegiatan' => 'Latihan Bersama Kontes Kambing Seni',
            'tempat_kegiatan'=> 'Lapangan Kantor BPP Kecamatan Ngebel',
            'waktu_kegiatan' => 'Hari Minggu 26 April 2026',
        ];

        return view('surat.create_rekomendasi', compact('permohonan'));
    }

    // Untuk menyiapkan Data (digunakan oleh preview dan download)
    private function getSuratData($id) {
        $application = \App\Models\PermitApplication::with(['user', 'permitType'])->findOrFail($id);
        
        // 2. Ambil data Camat yang menjabat saat ini dari tabel users
        $camat = \App\Models\User::where('role', 'camat')->first();
        
        // Jika akun camat ditemukan, ambil namanya. Jika belum ada, beri teks cadangan.
        $namaCamat = $camat ? $camat->nama_lengkap : 'NAMA CAMAT BELUM DIATUR';
        $nikCamat = $camat ? $camat->nik : '-';

        // PERBAIKAN PROTEKSI: Hanya blokir pemohon jika surat belum selesai. Admin & Camat tetap bisa preview.
        if (auth()->user()->role === 'pemohon' && $application->status !== 'selesai') {
            abort(403, 'Surat belum diterbitkan.');
        }

        
        $pemohon = $application->user;
        return [
            'nomor_surat' => '400/' . $application->id . '/405.30/' . $application->updated_at->format('Y'),
            'dasar_surat' => 'Peraturan perundang-undangan yang berlaku terkait perizinan masyarakat.',
            'nama_pelapor' => $pemohon->nama_lengkap,
            'nik' => $pemohon->nik,
            'jenis_kelamin' => $pemohon->jenis_kelamin ?? '-',
            'ttl' => $pemohon->tempat_tanggal_lahir ?? '-',
            'alamat' => $pemohon->alamat ?? '-',
            'pekerjaan' => $pemohon->pekerjaan ?? '-',
            'tujuan_kegiatan' => 'Pengajuan ' . $application->permitType->nama_izin,
            'jenis_kegiatan' => $application->permitType->nama_izin,
            'tempat_kegiatan' => 'Kecamatan Ngebel',
            'waktu_kegiatan' => $application->created_at->format('d F Y'),
            'tanggal_dikeluarkan' => $application->updated_at->format('d F Y'),
            // PERBAIKAN: Gunakan variabel yang diambil dari database!
            'nama_camat' => $namaCamat, 
            'nip_camat' => $nikCamat,
            'is_acc' => true, // Penanda bahwa surat sudah memiliki stempel Camat
        ];
    }

// Tampilkan Pratinjau PDF Langsung di Browser (Tab Baru)
    public function previewSelesai($id)
    {
        // 1. Ambil data surat
        $data = $this->getSuratData($id);
        
        // 2. Atur ukuran kertas menjadi F4 (Folio) agar seragam dengan yang didownload
        $customPaper = array(0, 0, 609.4488, 935.433); 
        
        // 3. Render ke PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat_rekomendasi', $data)
            ->setPaper($customPaper, 'portrait');
            
        // 4. Gunakan stream() BUKAN download()
        // stream() akan membuka PDF di dalam browser (tidak otomatis terunduh)
        return $pdf->stream('Preview_Surat_Izin.pdf');
    }   

    // Download sebagai File PDF
    public function downloadSelesai($id)
    {
        $application = \App\Models\PermitApplication::findOrFail($id);
        $data = $this->getSuratData($id);
        $customPaper = array(0, 0, 609.4488, 935.433); 
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat_rekomendasi', $data)
            ->setPaper($customPaper, 'portrait');
            
        // Eksekusi download
        return $pdf->download('Surat_Izin_' . $application->user->nama_lengkap . '.pdf');
    }

}