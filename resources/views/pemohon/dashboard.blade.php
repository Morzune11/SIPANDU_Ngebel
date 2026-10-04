@extends('layouts.pemohon')

@section('title', 'Dashboard Masyarakat')

@section('content')
    <!-- Header / Judul Halaman -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Selamat Datang, {{ auth()->user()->nama_lengkap }}!</h1>
        <p class="text-slate-500 mt-2">Ini adalah portal layanan mandiri Anda. Silakan pilih menu di bawah ini untuk memulai pengajuan dokumen ke kecamatan.</p>
    </div>

    <!-- Grid Menu Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Menu 1: Buat Pengajuan Baru -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 flex flex-col items-center text-center hover:shadow-md transition">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-3">Buat Pengajuan Baru</h2>
            <p class="text-slate-500 text-sm mb-8 px-4">Pilih jenis layanan surat perizinan atau rekomendasi, lengkapi form, dan unggah berkas persyaratan yang diminta.</p>
            <a href="{{ route('pemohon.pengajuan.create') }}" class="mt-auto px-6 py-3 bg-blue-600 text-white hover:bg-blue-700 rounded-xl text-sm font-medium transition w-full">
                Mulai Pengajuan
            </a>
        </div>

        <!-- Menu 2: Pantau Riwayat -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 flex flex-col items-center text-center hover:shadow-md transition">
            <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-3">Status & Riwayat Pengajuan</h2>
            <p class="text-slate-500 text-sm mb-8 px-4">Lihat progres pengajuan Anda saat ini (Menunggu Verifikasi, Revisi, atau Selesai) dan unduh surat hasil pengerjaan.</p>
            <a href="{{ route('pemohon.pengajuan.index') }}" class="mt-auto px-6 py-3 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl text-sm font-medium transition w-full">
                Lihat Riwayat
            </a>
        </div>

    </div>
@endsection