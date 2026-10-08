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
   public function approve(Request $request, PermitApplication $application)
    {
        // 1. Simpan status selesai
        $application->update(['status' => 'selesai']);

        // 2. Notifikasi ke pemohon
        $application->user->notify(new \App\Notifications\PermitNotification(
            'Surat Disetujui!',
            'Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.',
            route('pemohon.pengajuan.show', $application->id)
        ));

        // ==========================================
        // 3. TAMBAHKAN: Tembusan Notifikasi ke Polsek & Koramil
        // ==========================================
        $instansiTerkait = \App\Models\User::whereIn('role', ['admin_polsek', 'admin_koramil'])->get();
        if ($instansiTerkait->count() > 0) {
            \Illuminate\Support\Facades\Notification::send($instansiTerkait, new \App\Notifications\PermitNotification(
                'Tembusan Surat Baru',
                'Terdapat surat izin baru a/n ' . $application->user->nama_lengkap . ' yang telah disahkan oleh Camat.',
                route('instansi.tembusan.index')
            ));
        }

        return redirect()->route('camat.persetujuan.index')
            ->with('status', 'Surat pengajuan berhasil di-ACC dan diteruskan ke instansi terkait.');
    }

    // Menampilkan riwayat dokumen yang sudah di-ACC Camat
    public function history(Request $request)
    {
        $search = $request->input('search');

        $applications = \App\Models\PermitApplication::with(['user', 'permitType'])
            ->where('status', 'selesai')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nomor_pendaftaran', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q2) use ($search) {
                          $q2->where('nama_lengkap', 'like', "%{$search}%")
                             ->orWhere('nik', 'like', "%{$search}%");
                      })
                      ->orWhereHas('permitType', function ($q3) use ($search) {
                          $q3->where('nama_izin', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('camat.persetujuan.history', compact('applications', 'search'));
    }
}