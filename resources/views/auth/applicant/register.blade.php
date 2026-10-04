@extends('layouts.auth')

@section('title', 'Pendaftaran Akun Pemohon - Pelayanan Perizinan')

@section('content')
<div class="w-full max-w-lg bg-white rounded-xl shadow-md border border-slate-200 p-6 sm:p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Akun Pemohon</h2>
        <p class="text-sm text-slate-600 mt-1">Lengkapi data diri Anda sesuai KTP untuk mengajukan perizinan.</p>
    </div>

    <!-- Session Alert Error -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            <p class="font-semibold">Mohon periksa kembali inputan Anda:</p>
            <ul class="list-disc list-inside mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- NIK -->
        <div>
            <label for="nik" class="block text-sm font-medium text-slate-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" required
                   placeholder="16 digit angka KTP"
                   class="w-full px-3 py-2 border @error('nik') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            @error('nik')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap (Sesuai KTP)</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                   placeholder="Masukkan nama lengkap"
                   class="w-full px-3 py-2 border @error('nama_lengkap') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <!-- Email & No HP/WA Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       placeholder="nama@email.com"
                       class="w-full px-3 py-2 border @error('email') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label for="no_telepon" class="block text-sm font-medium text-slate-700 mb-1">No. WhatsApp</label>
                <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
                       placeholder="08123456789"
                       class="w-full px-3 py-2 border @error('no_telepon') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi</label>
            <input type="password" id="password" name="password" required
                   placeholder="Minimal 8 karakter"
                   class="w-full px-3 py-2 border @error('password') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   placeholder="Ulangi kata sandi"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition duration-150 shadow-sm text-sm">
            Daftar Sekarang
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-600">
        Sudah memiliki akun? 
        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk di sini</a>
    </div>
</div>
@endsection