@extends('layouts.pemohon')

@section('title', 'Buat Pengajuan Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('pemohon.pengajuan.index') }}" class="p-2 bg-white rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Formulir Pengajuan Surat</h1>
            <p class="text-slate-500 text-sm mt-1">Silakan lengkapi formulir perizinan di bawah ini.</p>
        </div>
    </div>

    <!-- Pengecekan Kelengkapan Data -->
    @if(!$isProfileComplete)
        
        <!-- JIKA DATA BELUM LENGKAP: Tampilkan Peringatan -->
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-start gap-6 shadow-sm">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-800 mb-2">Tindakan Tertahan: Data Diri Belum Lengkap!</h3>
                <p class="text-red-700 text-sm leading-relaxed mb-5">
                    Untuk dapat mencetak dokumen pengajuan Anda secara otomatis, sistem membutuhkan kelengkapan data diri Anda yang mencakup <b>Tempat/Tanggal Lahir, Jenis Kelamin, Pekerjaan, dan Alamat Lengkap</b>.
                </p>
                <a href="{{ route('pemohon.profil') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition shadow-sm text-sm">
                    Lengkapi Profil Saya Sekarang
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

    @else
        
        <!-- JIKA DATA LENGKAP: Tampilkan Form Pengajuan yang sebenarnya -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('pemohon.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf         
                <!-- Pilih Jenis Izin -->
                <div>
                    <!-- Pilih Jenis Izin -->
                <div class="mb-5">
                    <label for="permit_type_id" class="block text-sm font-medium text-slate-700 mb-1">Pilih Jenis Layanan Perizinan</label>
                <select name="permit_type_id" id="permit_type_id" required 
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="" disabled selected>-- Pilih Jenis Surat/Izin --</option>
            
                @forelse($permitTypes as $type)
                    <option value="{{ $type->id }}" {{ old('permit_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->nama_izin }} (Estimasi: {{ $type->estimasi_hari }} Hari Kerja)
                    </option>
                @empty
                    <option value="" disabled>Layanan belum tersedia. Hubungi Admin.</option>
                @endforelse
                </select>
                </div>
                    </div>

                <!-- Upload Dokumen Multiple -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Unggah Dokumen Persyaratan</label>
                    <p class="text-xs text-slate-500 mb-3">Anda dapat memilih beberapa file sekaligus (KTP, Pengantar RT/RW, dll). Format PDF/JPG/PNG max 2MB per file.</p>
                    
                    <input type="file" name="dokumen[]" multiple required
                        class="w-full px-3 py-2 border border-slate-300 bg-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">
                    Kirim Pengajuan
                    </button>
                <!-- ... -->
            </form>
        </div>

    @endif

</div>
@endsection

        