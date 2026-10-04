@extends('layouts.petugas')

@section('title', 'Detail Verifikasi')
@section('page_title', 'Pemeriksaan Berkas')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Detail Pengajuan & Dokumen -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 border-b pb-3 mb-4">Informasi Pemohon & Layanan</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-slate-500">Nama Pemohon</p>
                    <p class="font-semibold text-slate-800">{{ $application->user->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-slate-500">NIK</p>
                    <p class="font-semibold text-slate-800">{{ $application->user->nik }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Layanan yang Diajukan</p>
                    <p class="font-semibold text-slate-800">{{ $application->permitType->nama_izin }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Nomor Registrasi</p>
                    <p class="font-semibold text-slate-800">{{ $application->nomor_pendaftaran }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-800 border-b pb-3 mb-4">Dokumen Persyaratan</h2>
            <ul class="space-y-3">
                @foreach($application->documents as $doc)
                    <li class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="text-sm font-medium text-slate-700">{{ $doc->nama_dokumen }}</span>
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-100 px-3 py-1.5 rounded">
                            Buka Dokumen
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Kolom Kanan: Aksi Status & Draf -->
    <div class="space-y-6">
        <!-- PANEL FORM STATUS ADMIN -->
        @if($application->status !== 'selesai')
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Ubah Status Pengajuan</h3>
                <form action="{{ route('verifikasi.status', $application->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <!-- Dropdown Status -->
                        <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-blue-500 text-sm font-medium">
                            <!-- <option value="diajukan" {{ $application->status === 'diajukan' ? 'selected' : '' }}>Diajukan (Menunggu)</option>
                            <option value="diproses" {{ $application->status === 'diproses' ? 'selected' : '' }}>Sedang Direview</option> -->
                            <option value="revisi" {{ $application->status === 'revisi' ? 'selected' : '' }}>Perlu Revisi Berkas</option>
                            <option value="menunggu_tte" {{ $application->status === 'menunggu_tte' ? 'selected' : '' }}>Syarat Lengkap (Ajukan ke Camat)</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Revisi (Opsional)</label>
                        <textarea name="catatan_revisi" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">{{ $application->catatan_revisi }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition shadow-sm">
                        Simpan Perubahan Status
                    </button>
                </form>
            </div>
        @else
            <!-- JIKA SUDAH SELESAI, KUNCI FORM -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 mb-6 flex items-start shadow-sm">
                <svg class="w-6 h-6 text-emerald-600 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="font-bold text-emerald-900 mb-1">Telah Disahkan Pimpinan</h3>
                    <p class="text-sm text-emerald-800">Dokumen ini telah disetujui dan ditandatangani secara elektronik. Status tidak dapat diubah lagi.</p>
                </div>
            </div>
        @endif

        <!-- PANEL AKSI ADMIN -->
        @if($application->status === 'selesai')
            <!-- JIKA SUDAH DI-ACC CAMAT: Tampilkan Tombol PDF -->
            <div class="bg-emerald-900 rounded-xl shadow-sm p-6 text-white mt-6 border border-emerald-700">
                <h2 class="text-lg font-bold mb-2 text-emerald-400">Surat Telah Diterbitkan</h2>
                <p class="text-sm text-emerald-100/70 mb-5">Camat telah mengesahkan pengajuan ini. Dokumen tidak dapat diubah lagi. Anda dapat mengunduh arsip finalnya di sini.</p>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('surat.final.preview', $application->id) }}" target="_blank" class="w-full flex items-center justify-center px-4 py-3 bg-slate-800 hover:bg-slate-700 rounded-xl text-sm font-bold transition">
                        Lihat Dokumen Final
                    </a>
                    <a href="{{ route('surat.final.download', $application->id) }}" class="w-full flex items-center justify-center px-4 py-3 bg-emerald-600 hover:bg-emerald-500 rounded-xl text-sm font-bold transition shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Arsip PDF
                    </a>
                </div>
            </div>

        @else
            <!-- JIKA BELUM SELESAI: Tampilkan Form Status & Tombol Pratinjau Draf -->
            <div class="bg-slate-800 rounded-xl shadow-sm p-6 text-white mt-6">
                <h2 class="text-lg font-bold mb-2">Pratinjau Surat</h2>
                <p class="text-sm text-slate-300 mb-4">Lihat draf surat sebelum diteruskan ke Camat. Dokumen PDF asli baru dapat diunduh setelah disahkan (ACC).</p>
                <form action="{{ route('surat.preview-rekomendasi', $application->id) }}" method="POST" target="_blank">
                    @csrf
                    <button type="submit" class="w-full block text-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition shadow-sm">
                        Lihat Pratinjau (Preview) Surat
                    </button>
                </form>
            </div>
            
            <!-- (Di atas blok pratinjau ini pastinya sudah ada Form Ubah Status milik Admin yang lama, biarkan saja) -->
        @endif  
    </div>
</div>
@endsection