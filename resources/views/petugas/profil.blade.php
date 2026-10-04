@extends('layouts.petugas')

@section('title', 'Profil Saya')
@section('page_title', 'Pengaturan Akun')

@section('content')
<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
    
    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm rounded-lg border border-green-200">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm rounded-lg border border-red-200">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.profil.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50 text-slate-500" readonly>
                <p class="text-xs text-slate-400 mt-1">NIK tidak dapat diubah.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email Kedinasan</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon / WA</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', auth()->user()->no_telepon) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="border-t border-slate-200 pt-6 mt-6">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Ubah Kata Sandi</h3>
            <p class="text-xs text-slate-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium hover:bg-blue-700 rounded-lg transition text-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection