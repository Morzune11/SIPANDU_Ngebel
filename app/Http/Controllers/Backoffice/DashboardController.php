<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // PERHATIAN: Tulisan ": View" di akhir fungsi ini sudah dihapus
    public function index(Request $request)
    {
        $user = $request->user();

        // ==========================================
        // 1. CEGAT POLSEK & KORAMIL DI SINI (Paling Atas)
        // ==========================================
        if (in_array($user->role, ['admin_polsek', 'admin_koramil'])) {
            return redirect()->route('instansi.tembusan.index');
        }

        // ==========================================
        // 2. KODE ASLI ANDA UNTUK ADMIN & CAMAT
        // ==========================================
        // Statistik global untuk gambaran umum
        $stats = [
            'total_pengajuan' => PermitApplication::count(),
            'menunggu_admin'  => PermitApplication::whereIn('status', ['diajukan', 'diproses', 'revisi'])->count(),
            'menunggu_camat'  => PermitApplication::where('status', 'menunggu_tte')->count(),
            'selesai'         => PermitApplication::where('status', 'selesai')->count(),
        ];

        // Data dinamis khusus Admin (5 Riwayat Masuk Terbaru)
        $recentApplications = PermitApplication::with(['user', 'permitType'])
            ->latest()
            ->take(5)
            ->get();

        // Data dinamis khusus Camat (5 Antrean Prioritas TTE)
        $waitingForCamat = PermitApplication::with(['user', 'permitType'])
            ->where('status', 'menunggu_tte')
            ->orderBy('updated_at', 'asc') // Urutkan dari yang paling lama menunggu
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact('stats', 'recentApplications', 'waitingForCamat'));
    }
}