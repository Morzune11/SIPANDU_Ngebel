@extends('layouts.pemohon')

@section('title', 'Kelola Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Akun</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui informasi kontak dan keamanan akun Anda di bawah ini.</p>
    </div>

    @if (session('status'))
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm rounded-xl border border-green-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-200">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
        <form action="{{ route('pemohon.profil.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Data Pribadi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">NIK KTP</label>
                    <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm bg-slate-50 text-slate-500 cursor-not-allowed focus:outline-none" readonly>
                    <p class="text-xs text-slate-400 mt-1">NIK tidak dapat diubah sendiri.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Aktif</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', auth()->user()->no_telepon) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Data Pelengkap (Wajib untuk Pengajuan Surat) -->
            <div class="p-5 bg-blue-50/50 border border-blue-100 rounded-xl mt-6">
                <div class="flex items-center mb-4">
                    <h3 class="text-sm font-bold text-slate-800">Data Pelengkap Biodata</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Tambahkan logika PHP ini tepat di atas input Tempat Lahir -->
                @php
                    $ttl = auth()->user()->tempat_tanggal_lahir;
                    $tempatLahir = '';
                    $tanggalLahir = '';
                    if ($ttl && str_contains($ttl, ', ')) {
                        $parts = explode(', ', $ttl);
                        $tempatLahir = $parts[0];
                        // Konversi dari format DD-MM-YYYY (database) ke YYYY-MM-DD (format wajib input date HTML)
                        $tanggalLahir = date('Y-m-d', strtotime($parts[1]));
                    }
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $tempatLahir) }}" placeholder="Contoh: Ponorogo" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir</label>
                        <!-- Sekarang valuenya akan terisi otomatis jika sudah pernah disimpan -->
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $tanggalLahir) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="" disabled {{ !auth()->user()->jenis_kelamin ? 'selected' : '' }}>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan Saat Ini</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan', auth()->user()->pekerjaan) }}" placeholder="Contoh: Wiraswasta / Petani" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" placeholder="Contoh: RT.022 RW.002 Dukuh Keleng Desa Ngebel" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Ubah Kata Sandi -->
            <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl mt-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-slate-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <h3 class="text-sm font-bold text-slate-800">Ubah Kata Sandi (Opsional)</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Kata Sandi Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Ulangi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition shadow-sm">
                    Simpan Perubahan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection