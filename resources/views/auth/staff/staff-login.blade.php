@extends('layouts.auth')

@section('title', 'Login Petugas - Backoffice Kecamatan')

@section('content')
<div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
    
    <!-- Header Khusus Petugas -->
    <div class="bg-slate-800 p-6 text-center border-b-4 border-red-500">
        <h2 class="text-2xl font-bold text-white">Portal Backoffice</h2>
        <p class="text-sm text-slate-300 mt-1">Sistem Informasi Perizinan Kecamatan</p>
    </div>

    <div class="p-6 sm:p-8">
        <div class="mb-6 text-center">
            <span class="inline-block bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">
                Area Terbatas
            </span>
            <p class="text-sm text-slate-600">Silakan login menggunakan email kedinasan Anda.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('petugas.login.authenticate') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Petugas -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Kedinasan</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="admin@kecamatan.go.id"
                       class="w-full px-3 py-2 border @error('email') border-red-500 @else border-slate-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 text-sm bg-slate-50">
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                </div>
                <input type="password" id="password" name="password" required
                       placeholder="Masukkan kata sandi"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 text-sm bg-slate-50">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-slate-800 border-slate-300 rounded focus:ring-slate-800">
                <label for="remember" class="ml-2 text-xs text-slate-600">Ingat Saya</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2.5 rounded-lg transition duration-150 shadow-sm text-sm mt-4">
                Masuk ke Backoffice
            </button>
        </form>

        <div class="mt-6 text-center border-t border-slate-100 pt-4">
            <p class="text-xs text-slate-500">
                Bukan petugas? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Kembali ke Portal Masyarakat</a>
            </p>
        </div>
    </div>
</div>
@endsection