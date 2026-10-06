<?php

use App\Http\Controllers\Auth\ApplicantAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\Backoffice\StaffController;
use App\Http\Controllers\PermitTypeController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\Applicant\ApplicationController; 
use App\Http\Controllers\Backoffice\VerificationController;
use App\Http\Controllers\Backoffice\CamatController;
use App\Http\Controllers\Backoffice\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schedule;

// ==========================================
// ROOT REDIRECT
// ==========================================
Route::get('/', function (Request $request) {
    if ($user = $request->user()) {
        return $user->role === 'pemohon' 
            ? redirect()->route('pemohon.dashboard') 
            : redirect()->route('petugas.dashboard');
    }
    
    return redirect()->route('login');
});
// ==========================================
// PORTAL User (Logged in)
// ==========================================

 // Rute Notifikasi (Pastikan berada di dalam grup middleware auth)
Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    
    // 1. Rute Notifikasi
    Route::get('/notifikasi/{id}/baca', function (\Illuminate\Http\Request $request, $id) {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect($notification->data['url']);
    })->name('notifikasi.read');

    // 2. Rute Surat Final (Bisa diakses Pemohon, Admin & Camat)
    // PERBAIKAN: Menggunakan match(['get', 'post']) agar kebal terhadap error MethodNotAllowed
    Route::match(['get', 'post'], '/surat/final/preview/{id}', [\App\Http\Controllers\DraftController::class, 'previewSelesai'])->name('surat.final.preview');
    Route::match(['get', 'post'], '/surat/final/download/{id}', [\App\Http\Controllers\DraftController::class, 'downloadSelesai'])->name('surat.final.download');
    
});
// ==========================================
// PORTAL MASYARAKAT (PEMOHON)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [ApplicantAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ApplicantAuthController::class, 'login'])->name('login.authenticate');
    Route::get('/register', [ApplicantAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [ApplicantAuthController::class, 'register'])->name('register.store');
});

// Area Dashboard & Fitur Pemohon
Route::middleware(['auth', 'role:pemohon', PreventBackHistory::class])->group(function () {
    Route::get('/dashboard', function () { return view('pemohon.dashboard'); })->name('pemohon.dashboard');
    Route::post('/logout', [ApplicantAuthController::class, 'logout'])->name('logout');
    
    // Fitur Pengajuan Izin
    Route::get('/pengajuan', [ApplicationController::class, 'index'])->name('pemohon.pengajuan.index');
    Route::get('/pengajuan/baru', [ApplicationController::class, 'create'])->name('pemohon.pengajuan.create');
    Route::post('/pengajuan', [ApplicationController::class, 'store'])->name('pemohon.pengajuan.store');
    Route::get('/pengajuan/{pengajuan}', [ApplicationController::class, 'show'])->name('pemohon.pengajuan.show');

    // TAMBAHKAN DUA BARIS INI UNTUK REVISI
    Route::get('/pengajuan/{pengajuan}/edit', [ApplicationController::class, 'edit'])->name('pemohon.pengajuan.edit');
    Route::put('/pengajuan/{pengajuan}', [ApplicationController::class, 'update'])->name('pemohon.pengajuan.update');

    // Rute Profil Pemohon (Tambahkan di sini)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('pemohon.profil');
    Route::put('/profil', [ProfileController::class, 'update'])->name('pemohon.profil.update');
    // notifikasi
});

// ==========================================
// PORTAL PETUGAS (ADMIN & CAMAT)
// ==========================================
Route::prefix('petugas')->group(function () {
    
    // Login Petugas
    Route::middleware('guest')->group(function () {
        Route::get('/login', [StaffAuthController::class, 'showLoginForm'])->name('petugas.login');
        Route::post('/login', [StaffAuthController::class, 'login'])->name('petugas.login.authenticate');
    });

    // Area Dashboard Petugas (Gabungan Admin & Camat)
    Route::middleware(['auth', 'role:admin,camat', PreventBackHistory::class])->group(function () {
        // UBAH BARIS INI:
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('petugas.dashboard');
        
        Route::post('/logout', [StaffAuthController::class, 'logout'])->name('petugas.logout');

        // Rute Preview/Cetak Surat
        Route::get('/surat/rekomendasi/buat/{id}', [DraftController::class, 'createRekomendasi'])->name('surat.create-rekomendasi');
        // GANTI Route::get menjadi Route::match(['get', 'post'])
        Route::match(['get', 'post'], '/surat/rekomendasi/preview/{id}', [DraftController::class, 'previewRekomendasi'])->name('surat.preview-rekomendasi');

        // Rute Profil Petugas (Tambahkan di sini)
        Route::get('/profil', [ProfileController::class, 'edit'])->name('petugas.profil');
        Route::put('/profil', [ProfileController::class, 'update'])->name('petugas.profil.update');
        
        // Rute Khusus Administrator (Hanya bisa diakses oleh Admin)
        Route::middleware(['role:admin'])->group(function () {
            // Kelola Akun Petugas
            Route::resource('staff', StaffController::class)->except(['show']);
            
            // Kelola Master Perizinan
            Route::resource('permit-types', PermitTypeController::class)->except(['show']);

            // Rute Verifikasi Berkas (Baru)
            Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');
            Route::get('/verifikasi/{application}', [VerificationController::class, 'show'])->name('verifikasi.show');
            Route::post('/verifikasi/{application}/status', [VerificationController::class, 'updateStatus'])->name('verifikasi.status');
        });
        
        Route::middleware(['role:camat'])->group(function () {
            Route::get('/persetujuan', [CamatController::class, 'index'])->name('camat.persetujuan.index');
            // TAMBAHKAN RUTE INI (Pastikan letaknya di atas rute {application})
            Route::get('/persetujuan/riwayat', [CamatController::class, 'history'])->name('camat.riwayat.index');
            Route::get('/persetujuan/{application}', [CamatController::class, 'show'])->name('camat.persetujuan.show');
            Route::post('/persetujuan/{application}/approve', [CamatController::class, 'approve'])->name('camat.persetujuan.approve');
        });
    });
});

// Penjadwalan Tugas (Bisa tetap di sini, walau idealnya di routes/console.php untuk Laravel 11+)
Schedule::command('permits:expire')->daily();