<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use App\Models\PermitDocument;
use App\Models\PermitType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Notifications\PermitNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class ApplicationController extends Controller
{
    // Tambahkan parameter Request $request
    public function index(Request $request)
    {
        // Perbaikan baris 17
        $applications = PermitApplication::where('user_id', $request->user()->id)->latest()->get();
        return view('pemohon.pengajuan.index', compact('applications'));
    }

    // ... kode sebelumnya (index, create, store) ...

    public function show(Request $request, PermitApplication $pengajuan)
    {
        // Pastikan pemohon hanya bisa melihat data pengajuannya sendiri
        if ($pengajuan->user_id !== $request->user()->id) {
            abort(403, 'Akses Ditolak.');
        }

        // Muat relasi tabel terkait
        $pengajuan->load(['permitType', 'documents']);

        return view('pemohon.pengajuan.show', compact('pengajuan'));
        }    

    public function create(Request $request)
    {
        $user = $request->user();
        
        // Cek kelengkapan data diri (Boolean: true atau false)
        $isProfileComplete = !empty($user->alamat) && !empty($user->tempat_tanggal_lahir) && !empty($user->jenis_kelamin) && !empty($user->pekerjaan);

        // Ambil jenis perizinan
        $permitTypes = \App\Models\PermitType::where('is_active', true)->get();
        
        // Kirim variabel $isProfileComplete ke tampilan
        return view('pemohon.pengajuan.create', compact('permitTypes', 'isProfileComplete'));
    }

    public function store(Request $request)
    {
       $user = $request->user();
        
        $isProfileComplete = !empty($user->alamat) && !empty($user->tempat_tanggal_lahir) && !empty($user->jenis_kelamin) && !empty($user->pekerjaan);

        // Pencegahan ganda jika ada yang memaksa submit melalui inspect element
        if (!$isProfileComplete) {
            return back()->with('error', 'Gagal memproses. Anda wajib melengkapi data profil terlebih dahulu.');
        }

        $request->validate([
            'permit_type_id' => 'required|exists:permit_types,id',
            'dokumen.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'dokumen.*.mimes' => 'Format file harus berupa PDF, JPG, atau PNG.',
            'dokumen.*.max' => 'Ukuran file maksimal adalah 2MB.',
        ]);

        $nomorPendaftaran = 'REG-' . date('Ym') . '-' . strtoupper(Str::random(6));

        $application = PermitApplication::create([
            'nomor_pendaftaran' => $nomorPendaftaran,
            // Perbaikan baris 45
            'user_id' => $request->user()->id,
            'permit_type_id' => $request->permit_type_id,
            'status' => 'diajukan',
        ]);

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('dokumen_persyaratan', 'public');
                
                PermitDocument::create([
                    'permit_application_id' => $application->id,
                    'nama_dokumen' => $file->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            }
        }
        
        // Kirim Notifikasi ke semua Admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\PermitNotification(
            'Pengajuan Baru', 
            $user->nama_lengkap . ' mengajukan izin baru.', 
            // PASTIKAN MENGGUNAKAN VARIABEL YANG BENAR, MISALNYA $application->id
            route('verifikasi.show', $application->id) 
        ));

        return redirect()->route('pemohon.pengajuan.index')
            ->with('status', 'Pengajuan berhasil dikirim. Silakan tunggu proses verifikasi.');
    }

    // Menampilkan form revisi berkas
    public function edit(Request $request, $id)
    {
        $pengajuan = \App\Models\PermitApplication::with('documents')->findOrFail($id);

        // Pastikan hanya pemiliknya dan statusnya memang revisi
        if ($pengajuan->user_id !== $request->user()->id || $pengajuan->status !== 'revisi') {
            abort(403, 'Akses Ditolak');
        }

        return view('pemohon.pengajuan.edit', compact('pengajuan'));
    }

    // Memproses unggahan ulang
    public function update(Request $request, $id)
    {
        $pengajuan = \App\Models\PermitApplication::with('documents')->findOrFail($id);

        if ($pengajuan->user_id !== $request->user()->id || $pengajuan->status !== 'revisi') {
            abort(403);
        }

        // Cek jika ada file yang diunggah ulang
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $doc_id => $file) {
                $document = $pengajuan->documents()->find($doc_id);
                if ($document) {
                    // Hapus file fisik yang lama
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
                    
                    // Simpan file baru
                    $path = $file->store('dokumen_syarat', 'public');
                    $document->update(['file_path' => $path]);
                }
            }
        }

        // Kembalikan status menjadi diproses
        $pengajuan->update([
            'status' => 'diproses',
            'catatan_revisi' => null // Kosongkan catatan karena sudah diperbaiki
        ]);

        // Opsional: Beri notifikasi ke Admin bahwa user sudah merevisi
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\PermitNotification(
            'Revisi Berkas', 
            $pengajuan->user->nama_lengkap . ' telah merevisi berkas pengajuannya.', 
            route('verifikasi.show', $pengajuan->id)
        ));

        return redirect()->route('pemohon.pengajuan.show', $pengajuan->id)
            ->with('status', 'Berkas berhasil diperbarui dan telah dikirim ulang ke Admin.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Anda berhasil keluar dari sistem.');
    }
}