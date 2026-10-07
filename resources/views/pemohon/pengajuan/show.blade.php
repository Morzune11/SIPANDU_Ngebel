@extends('layouts.pemohon')

@section('title', 'Detail Pengajuan - ' . $pengajuan->nomor_pendaftaran)

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('pemohon.pengajuan.index') }}" class="p-2 bg-white rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Pengajuan Izin</h1>
            <p class="text-slate-500 text-sm mt-1">Status dan informasi dokumen Anda saat ini.</p>
        </div>
    </div>

    @if($pengajuan->status === 'revisi' && $pengajuan->catatan_revisi)
        <div class="mb-6 p-5 bg-orange-50 border border-orange-200 rounded-xl flex items-start">
            <svg class="w-6 h-6 text-orange-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h3 class="font-bold text-orange-800 mb-1">Perlu Revisi Dokumen:</h3>
                <p class="text-sm text-orange-700 mb-3">{{ $pengajuan->catatan_revisi }}</p>
                <a href="{{ route('pemohon.pengajuan.edit', $pengajuan->id) }}" class="inline-block px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-xs font-bold transition">
                        Perbaiki Berkas Sekarang &rarr;
                </a>
            </div>
        </div>
        
    @endif

    <!-- Kartu Informasi -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Nomor Registrasi</p>
                <p class="text-lg font-bold text-slate-800">{{ $pengajuan->nomor_pendaftaran }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Status Saat Ini</p>
                    @php
                        $color = match($pengajuan->status) {
                            'diajukan' => 'bg-blue-100 text-blue-800',
                            'diproses' => 'bg-amber-100 text-amber-800',
                            'menunggu_tte' => 'bg-indigo-100 text-indigo-800', // Warna khusus (Indigo)
                            'revisi' => 'bg-orange-100 text-orange-800',
                            'selesai' => 'bg-emerald-100 text-emerald-800',
                            'ditolak' => 'bg-red-100 text-red-800',
                            default => 'bg-slate-100 text-slate-800'
                        };

                        $text = match($pengajuan->status) {
                            'menunggu_tte' => 'Diajukan ke Camat', // Custom teks di sini
                            default => str_replace('_', ' ', $pengajuan->status)
                        };
                    @endphp
                    <span class="inline-block px-3 py-1 mt-1 {{ $color }} rounded-full text-xs font-bold uppercase tracking-wider">
                        {{ $text }}
                    </span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Jenis Layanan</p>
                <p class="font-semibold text-slate-800">{{ $pengajuan->permitType->nama_izin }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Tanggal Diajukan</p>
                <p class="font-semibold text-slate-800">{{ $pengajuan->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Berkas Yang Diunggah -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <svg class="w-5 h-5 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
            Dokumen Persyaratan yang Diunggah
        </h2>
        <ul class="space-y-3">
            @foreach($pengajuan->documents as $doc)
                <li class="flex items-center justify-between p-3.5 bg-slate-50 rounded-xl border border-slate-100 hover:border-slate-300 transition">
                    <span class="text-sm font-medium text-slate-700">{{ $doc->nama_dokumen }}</span>
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-100 hover:bg-blue-200 px-3 py-1.5 rounded-lg transition">
                        Buka
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Unduh Surat Jika Selesai -->
    @if($pengajuan->status === 'selesai')
        <div class="mt-6 p-8 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl border border-emerald-400 text-center shadow-md">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Surat Izin Telah Diterbitkan!</h3>
            <p class="text-emerald-50 text-sm mb-6 max-w-lg mx-auto">Pengajuan Anda telah disetujui dan ditandatangani oleh Camat.</p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <!-- Tombol Lihat -->
                <form action="{{ route('surat.final.preview', $pengajuan->id) }}" method="POST" target="_blank" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center bg-emerald-700/50 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl border border-emerald-400 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Surat
                    </button>
                </form>
                <!-- Tombol Unduh PDF -->
                <a href="{{ route('surat.final.download', $pengajuan->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-emerald-700 hover:bg-slate-50 font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh File PDF
                </a>
            </div>
        </div>
    @endif

</div>
@endsection