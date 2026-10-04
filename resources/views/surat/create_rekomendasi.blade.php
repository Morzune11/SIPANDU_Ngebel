@extends('layouts.petugas')

@section('title', 'Buat Draf Surat Rekomendasi')
@section('page_title', 'Penyusunan Draf Surat')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-4xl">
    
    <div class="mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-800">Draf Surat Rekomendasi Kegiatan</h2>
        <p class="text-sm text-slate-500">Lengkapi atribut surat resmi dan verifikasi data pemohon sebelum menghasilkan dokumen PDF.</p>
    </div>

    <!-- Form menggunakan target="_blank" agar PDF terbuka di tab baru -->
    <form action="{{ route('surat.preview-rekomendasi', $permohonan->id) }}" method="POST" target="_blank" class="space-y-6">
        @csrf

        <!-- Bagian Atribut Surat Resmi -->
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg space-y-4">
            <h3 class="font-semibold text-slate-700 text-sm uppercase tracking-wider mb-2">Atribut Surat Resmi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Surat</label>
                    <input type="text" name="nomor_surat" required placeholder="Misal: 300.1.4/KH/07/405.29.19/2026"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Dikeluarkan</label>
                    <input type="text" name="tanggal_dikeluarkan" required value="{{ date('d F Y') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Dasar Surat (Konsideran)</label>
                    <textarea name="dasar_surat" rows="2" required placeholder="surat dari Panitia... tertanggal... perihal..."
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                </div>
            </div>
        </div>

        <!-- Bagian Data Pemohon & Kegiatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <h3 class="md:col-span-2 font-semibold text-slate-700 text-sm uppercase tracking-wider mt-2">Identitas & Rincian Kegiatan</h3>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pelapor</label>
                <input type="text" name="nama_pelapor" value="{{ $permohonan->nama_pelapor }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NIK</label>
                <input type="text" name="nik" value="{{ $permohonan->nik }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" value="{{ $permohonan->jenis_kelamin }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tempat/Tanggal Lahir</label>
                <input type="text" name="ttl" value="{{ $permohonan->ttl }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap</label>
                <input type="text" name="alamat" value="{{ $permohonan->alamat }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ $permohonan->pekerjaan }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tujuan Kegiatan</label>
                <input type="text" name="tujuan_kegiatan" value="{{ $permohonan->tujuan_kegiatan }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kegiatan</label>
                <input type="text" name="jenis_kegiatan" value="{{ $permohonan->jenis_kegiatan }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Waktu Kegiatan</label>
                <input type="text" name="waktu_kegiatan" value="{{ $permohonan->waktu_kegiatan }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Kegiatan</label>
                <input type="text" name="tempat_kegiatan" value="{{ $permohonan->tempat_kegiatan }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50">
            </div>
        </div>

        <!-- Data Pengesah (Camat) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 pt-4 mt-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Camat</label>
                <input type="text" name="nama_camat" value="Andi Hendratmoyo ST. MM.MT" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NIP Camat</label>
                <input type="text" name="nip_camat" value="19800110 200604 1 018" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6">
            <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white hover:bg-slate-900 rounded-lg text-sm font-medium transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Preview PDF Surat
            </button>
        </div>
    </form>
</div>
@endsection