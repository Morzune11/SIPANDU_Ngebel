@extends('layouts.petugas')

@section('title', 'Tambah Petugas Baru')
@section('page_title', 'Registrasi Petugas Internal')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-3xl">
    
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('staff.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-medium text-slate-700 mb-1">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required maxlength="16"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Email Kedinasan -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Kedinasan</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

           <!-- No Telepon -->
            <div>
                <label for="no_telepon" class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon / WA</label>
                <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" required
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <!-- Hak Akses (Role) -->
            <div class="md:col-span-2">
                <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Peran Akses</label>
                <select name="role" id="role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">-- Pilih Peran --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Petugas Pelayanan)</option>
                    <option value="camat" {{ old('role') == 'camat' ? 'selected' : '' }}>Camat (Pengesahan TTE)</option>
                    <option value="admin_polsek" {{ (old('role', $staff->role ?? '') == 'admin_polsek') ? 'selected' : '' }}>
                        Admin Polsek (Tembusan Arsip)
                    </option>
                    <option value="admin_koramil" {{ (old('role', $staff->role ?? '') == 'admin_koramil') ? 'selected' : '' }}>
                        Admin Koramil (Tembusan Arsip)
                    </option>
                </select>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Awal</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('staff.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-sm font-medium transition">Simpan Akun</button>
        </div>
    </form>
</div>
@endsection