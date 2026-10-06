@extends('layouts.petugas')

@section('title', 'Tinjau Dokumen')
@section('page_title', 'Pengesahan Camat')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Ringkasan Sederhana -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <div class="flex justify-between items-center border-b pb-4 mb-5">
                <h2 class="text-xl font-bold text-slate-800">Ringkasan Dokumen Siap Sah</h2>
                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold uppercase">Menunggu ACC</span>
            </div>
            
            <div class="grid grid-cols-2 gap-y-6 gap-x-4 text-sm mb-6">
                <div>
                    <p class="text-slate-500 mb-1">Nama Pemohon</p>
                    <p class="font-bold text-slate-800 text-base">{{ $application->user->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-slate-500 mb-1">NIK</p>
                    <p class="font-semibold text-slate-800">{{ $application->user->nik }}</p>
                </div>
                <div>
                    <p class="text-slate-500 mb-1">Jenis Layanan</p>
                    <p class="font-semibold text-blue-700">{{ $application->permitType->nama_izin }}</p>
                </div>
                <div>
                    <p class="text-slate-500 mb-1">Nomor Registrasi</p>
                    <p class="font-mono text-slate-800 bg-slate-100 px-2 py-1 rounded inline-block">{{ $application->nomor_pendaftaran }}</p>
                </div>
            </div>

            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 text-sm flex items-start">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Seluruh persyaratan administratif untuk pengajuan ini telah <b>diverifikasi dan dinyatakan lengkap</b> oleh staf admin kecamatan.</p>
            </div>
            <!-- Kotak Hijau Sebelumnya -->
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 text-sm flex items-start">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Seluruh persyaratan administratif untuk pengajuan ini telah <b>diverifikasi dan dinyatakan lengkap</b> oleh staf admin kecamatan.</p>
            </div>

            <!-- TAMBAHKAN KODE INI: Tombol Pratinjau Draf -->
            <div class="mt-6 border-t border-slate-200 pt-6">
                <p class="text-sm text-slate-500 mb-3">Anda dapat meninjau isi draf surat sebelum memberikan pengesahan.</p>
                <a href="{{ route('surat.preview-rekomendasi', $application->id) }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg text-sm font-bold transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat Pratinjau Draf Surat
                </a>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 text-white h-fit">
        
        @if($application->status === 'menunggu_tte')
            <h2 class="text-lg font-bold border-b border-slate-700 pb-3 mb-4">Pengesahan Pimpinan</h2>
            <p class="text-sm text-slate-400 mb-6">Dengan menekan tombol di bawah ini, Anda menyetujui pengajuan ini...</p>
            <form action="{{ route('camat.persetujuan.approve', $application->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-4 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-bold transition shadow-[0_0_15px_rgba(16,185,129,0.4)]">
                    Stempel & Terbitkan Surat
                </button>
            </form>
            
        @elseif($application->status === 'selesai')
            <h2 class="text-lg font-bold border-b border-slate-700 pb-3 mb-4 text-emerald-400">Surat Disahkan</h2>
            <p class="text-sm text-slate-400 mb-6">Dokumen ini telah Anda sahkan secara elektronik.</p>
            
            <a href="{{ route('surat.final.preview', $application->id) }}" target="_blank" class="w-full flex justify-center px-4 py-3 bg-slate-800 hover:bg-slate-700 rounded-xl text-sm font-bold mb-3 transition">
                Lihat Dokumen Final
            </a>
            <a href="{{ route('surat.final.download', $application->id) }}" class="w-full flex justify-center px-4 py-3 bg-blue-600 hover:bg-blue-500 rounded-xl text-sm font-bold transition">
                Unduh Arsip PDF
            </a>
        @endif
        
    </div>
</div>
@endsection