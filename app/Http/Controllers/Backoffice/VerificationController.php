<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Notifications\PermitNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class VerificationController extends Controller
{
    /**
     * Menampilkan daftar semua pengajuan izin beserta fitur pencarian dan paginasi.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        // Mengambil data dengan relasi, filter pencarian, dan paginasi (10 data per halaman)
        $applications = PermitApplication::with(['user', 'permitType'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nomor_pendaftaran', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q2) use ($search) {
                          $q2->where('nama_lengkap', 'like', "%{$search}%")
                             ->orWhere('nik', 'like', "%{$search}%");
                      })
                      ->orWhereHas('permitType', function ($q3) use ($search) {
                          $q3->where('nama_izin', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(5) // Mengubah get() menjadi paginate(5)
            ->withQueryString(); // Mempertahankan query pencarian di URL saat pindah halaman

        return view('petugas.verifikasi.index', compact('applications', 'search'));
    }

    /**
     * Menampilkan detail satu pengajuan untuk diverifikasi.
     */
    public function show(PermitApplication $application): View
    {
        $application->load(['user', 'permitType', 'documents']);
        return view('petugas.verifikasi.show', compact('application'));
    }

    /**
     * Memperbarui status pengajuan dan menyimpan catatan revisi jika ada.
     */
    public function updateStatus(Request $request, PermitApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,diproses,revisi,menunggu_tte,selesai,ditolak',
            'catatan_revisi' => 'nullable|string|required_if:status,revisi',
        ]);

        $application->update([
            'status' => $validated['status'],
            // Hapus catatan jika statusnya bukan revisi
            'catatan_revisi' => $validated['status'] === 'revisi' ? $validated['catatan_revisi'] : null,
        ]);

        $application->user->notify(new PermitNotification(
            'Status Berubah',
            'Pengajuan izin Anda kini berstatus: ' . strtoupper($validated['status']),
            route('pemohon.pengajuan.show', $application->id)
        ));

        // Jika statusnya menunggu TTE, beri notif juga ke Camat
        if ($validated['status'] === 'menunggu_tte') {
            $camat = User::where('role', 'camat')->get();
            Notification::send($camat, new PermitNotification(
                'Menunggu Pengesahan',
                'Ada dokumen atas nama ' . $application->user->nama_lengkap . ' menunggu TTE.',
                route('camat.persetujuan.show', $application->id)
            ));
        }

        // 5. Kembali ke halaman admin dengan pesan sukses (flash message hijau)
        return back()->with('status', 'Status pengajuan berhasil diperbarui menjadi: ' . 
            ($request->status === 'menunggu_tte' ? 'Diajukan ke Camat' : $request->status)
        );
    }
}