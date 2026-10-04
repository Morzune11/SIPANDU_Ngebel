<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Notifications\PermitNotification;

class CamatController extends Controller
{
    /**
     * Menampilkan daftar antrean pengajuan yang menunggu tanda tangan (TTE).
     */
    public function index(): View
    {
        $applications = PermitApplication::with(['user', 'permitType'])
            ->where('status', 'menunggu_tte')
            ->latest()
            ->get();
            
        return view('camat.persetujuan.index', compact('applications'));
    }

    /**
     * Menampilkan detail berkas untuk disetujui.
     */
    public function show(PermitApplication $application): View
    {
        // Pastikan hanya membuka yang statusnya menunggu_tte
        if ($application->status !== 'menunggu_tte') {
            abort(404, 'Data tidak ditemukan dalam antrean persetujuan.');
        }

        $application->load(['user', 'permitType', 'documents']);
        return view('camat.persetujuan.show', compact('application'));
    }

    /**
     * Memproses persetujuan, mengubah status, dan menyimpan surat final.
     */
   public function approve(Request $request, PermitApplication $application): RedirectResponse
    {
        // 1. (Opsional) Disini nanti adalah tempat mengeksekusi script Generate PDF (DomPDF)
        // yang secara otomatis menanamkan tulisan/QR Code "Telah Disetujui Camat"
        
        // 2. Simpan status bahwa surat sudah di-ACC (Stempel sementara)
        $application->update([
            'status' => 'selesai',
            // File surat hasil dikosongkan sementara sampai generator PDF terpasang
            // Atau Anda bisa menyimpan path teks 'disetujui' jika diperlukan
        ]);

        // 3. Notifikasi ke pemohon
        $application->user->notify(new \App\Notifications\PermitNotification(
            'Surat Disetujui!',
            'Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.',
            route('pemohon.pengajuan.show', $application->id)
        ));

        return redirect()->route('camat.persetujuan.index')
            ->with('status', 'Surat pengajuan ' . $application->user->nama_lengkap . ' berhasil di-ACC (stempel elektronik).');
    }

    // Menampilkan riwayat dokumen yang sudah di-ACC Camat
    public function history()
    {
        $applications = \App\Models\PermitApplication::with(['user', 'permitType'])
            ->where('status', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('camat.persetujuan.history', compact('applications'));
    }
}