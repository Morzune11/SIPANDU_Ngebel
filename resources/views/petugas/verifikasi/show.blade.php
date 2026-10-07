@extends('layouts.petugas')

@section('title', 'Detail Verifikasi')
@section('page_title', 'Pemeriksaan Berkas')

@section('content')
<!-- Header Halaman Anda... -->
    
    <!-- TAMBAHKAN KODE INI UNTUK PESAN SUKSES -->
@if (session('status'))
        <div id="notifSukses" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start shadow-sm transition-all duration-500">
            <!-- Ikon Centang -->
            <svg class="w-6 h-6 mr-3 shrink-0 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            
            <!-- Teks Pesan -->
            <span class="font-semibold flex-1">{{ session('status') }}</span>
            
            <!-- Tombol Tutup (X) -->
            <button type="button" onclick="tutupNotif()" class="ml-3 shrink-0 text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100 rounded-lg p-1 transition focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Script Menghilang Otomatis -->
        <script>
            function tutupNotif() {
                const notif = document.getElementById('notifSukses');
                if (notif) {
                    notif.style.opacity = '0'; // Efek memudar
                    setTimeout(() => notif.style.display = 'none', 500); // Hilangkan elemen setelah memudar
                }
            }

            // Hilangkan otomatis setelah 5 detik (5000 milidetik)
            setTimeout(tutupNotif, 5000);
        </script>
    @endif
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kolom Ringkasan Dokumen Anda... -->    
    
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
                
                <!-- Tambahkan id="formUbahStatus" pada form -->
                <form id="formUbahStatus" action="{{ route('verifikasi.status', $application->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Keputusan / Status</label>
                        <!-- Tambahkan id="pilihStatus" dan event onchange -->
                        <select id="pilihStatus" name="status" onchange="toggleRevisi()" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold transition bg-slate-50 cursor-pointer">
                            <!-- <option value="diajukan" {{ $application->status === 'diajukan' ? 'selected' : '' }}>Diajukan (Menunggu)</option>
                            <option value="diproses" {{ $application->status === 'diproses' ? 'selected' : '' }}>Sedang Direview / Diproses</option> -->
                            <option value="revisi" {{ $application->status === 'revisi' ? 'selected' : '' }}>Kembalikan ke Pemohon (Perlu Revisi Berkas)</option>
                            <option value="menunggu_tte" {{ $application->status === 'menunggu_tte' ? 'selected' : '' }}>Berkas Lengkap & Valid (Ajukan ke Camat)</option>
                        </select>
                    </div>
                    
                    <!-- Area Catatan Revisi: Diberi id="areaRevisi" dan disembunyikan jika bukan revisi -->
                    <div id="areaRevisi" class="mb-5 {{ $application->status === 'revisi' ? 'block' : 'hidden' }}">
                        <div class="p-4 bg-orange-50 border border-orange-200 rounded-xl">
                            <label class="block text-sm font-bold text-orange-800 mb-1">
                                Pesan Revisi Untuk Pemohon <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-orange-600 mb-3">Tuliskan secara jelas dokumen apa yang salah atau kurang agar pemohon dapat memperbaikinya.</p>
                            
                            <textarea id="inputCatatan" name="catatan_revisi" rows="3" placeholder="Contoh: Scan KTP kurang jelas, mohon foto ulang..." class="w-full px-3 py-2 border border-orange-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 bg-white">{{ $application->catatan_revisi }}</textarea>
                        </div>
                    </div>

                    <!-- Tombol dengan State Loading -->
                    <button id="btnSimpanStatus" type="submit" class="w-full flex justify-center items-center py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition shadow-sm">
                        <span id="teksTombol">Simpan Perubahan Status</span>
                        <!-- Ikon Spinner (disembunyikan secara default) -->
                        <svg id="iconLoading" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Skrip JavaScript Interaktif -->
            <script>
                // Fungsi untuk menampilkan/menyembunyikan catatan revisi
                function toggleRevisi() {
                    const status = document.getElementById('pilihStatus').value;
                    const areaRevisi = document.getElementById('areaRevisi');
                    const inputCatatan = document.getElementById('inputCatatan');

                    if (status === 'revisi') {
                        // Tampilkan kotak dan wajibkan isi
                        areaRevisi.classList.remove('hidden');
                        areaRevisi.classList.add('block');
                        inputCatatan.setAttribute('required', 'true');
                    } else {
                        // Sembunyikan kotak dan hapus kewajiban isi
                        areaRevisi.classList.remove('block');
                        areaRevisi.classList.add('hidden');
                        inputCatatan.removeAttribute('required');
                        inputCatatan.value = ''; // (Opsional) Kosongkan isian jika diganti ke status lain
                    }
                }

                // Fungsi saat form di-submit (Mencegah klik ganda & efek loading)
                document.getElementById('formUbahStatus').addEventListener('submit', function() {
                    const btn = document.getElementById('btnSimpanStatus');
                    const teks = document.getElementById('teksTombol');
                    const icon = document.getElementById('iconLoading');

                    // Kunci tombol
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    // Ubah teks & tampilkan animasi berputar
                    teks.innerText = 'Menyimpan Data...';
                    icon.classList.remove('hidden');
                });
                
                // Panggil sekali saat halaman dimuat untuk memastikan kondisinya pas
                document.addEventListener('DOMContentLoaded', toggleRevisi);
            </script>
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