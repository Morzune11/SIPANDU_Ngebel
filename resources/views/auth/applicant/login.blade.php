@extends('layouts.auth')

@section('title', 'Masuk Pemohon - Pelayanan Perizinan')

@section('content')
<div class="w-full max-w-md bg-white rounded-xl shadow-md border border-slate-200 p-6 sm:p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Selamat Datang</h2>
        <p class="text-sm text-slate-600 mt-1">Masuk untuk mengajukan dan memantau surat perizinan.</p>
    </div>

    <!-- Alert Status (misal: setelah berhasil registrasi) -->
    @if (session('status'))
        <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded">
            {{ session('status') }}
        </div>
    @endif

    <!-- Alert Gagal Login -->
    @if ($errors->has('login_error'))
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            {{ $errors->first('login_error') }}
        </div>
    @endif

    <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-4">
        @csrf

        <!-- NIK / Email Identifier -->
        <div>
            <label for="identity" class="block text-sm font-medium text-slate-700 mb-1">NIK / Alamat Email</label>
            <input type="text" id="identity" name="identity" value="{{ old('identity') }}" required autofocus
                   placeholder="Masukkan NIK atau Email terdaftar"
                   class="w-full px-3 py-2 border @error('identity') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            @error('identity')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                <a href="#" class="text-xs text-blue-600 hover:underline">Lupa sandi?</a>
            </div>
            <input type="password" id="password" name="password" required
                   placeholder="Masukkan kata sandi"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
            <label for="remember" class="ml-2 text-xs text-slate-600">Ingat Saya di Perangkat Ini</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition duration-150 shadow-sm text-sm">
            Masuk ke Portal
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-600">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Daftar Akun Baru</a>
    </div>
</div>
@endsection