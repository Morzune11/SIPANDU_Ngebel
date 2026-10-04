@extends('layouts.petugas')

@section('title', 'Tambah Layanan Izin')
@section('page_title', 'Master Perizinan Baru')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-2xl">
    
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permit-types.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Nama Layanan Izin -->
        <div>
            <label for="nama_izin" class="block text-sm font-medium text-slate-700 mb-1">Nama Surat / Izin</label>
            <input type="text" name="nama_izin" id="nama_izin" value="{{ old('nama_izin') }}" required placeholder="Contoh: Surat Keterangan Usaha (SKU)"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>

        <!-- Estimasi Waktu -->
        <div>
            <label for="estimasi_hari" class="block text-sm font-medium text-slate-700 mb-1">Estimasi Penyelesaian (Hari Kerja)</label>
            <input type="number" name="estimasi_hari" id="estimasi_hari" value="{{ old('estimasi_hari', 3) }}" required min="1"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>

        <!-- Daftar Persyaratan -->
        <div>
            <label for="persyaratan" class="block text-sm font-medium text-slate-700 mb-1">Persyaratan Dokumen</label>
            <p class="text-xs text-slate-500 mb-2">Pisahkan setiap persyaratan dengan koma (,) atau baris baru.</p>
            <textarea name="persyaratan" id="persyaratan" rows="4" required placeholder="1. Fotokopi KTP&#10;2. Pengantar RT/RW"
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('persyaratan') }}</textarea>
        </div>

        <!-- Status Aktif -->
        <div class="flex items-center mt-4">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                   class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
            <label for="is_active" class="ml-2 block text-sm font-medium text-slate-700">Layanan Aktif (Dapat dipilih oleh pemohon)</label>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('permit-types.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-sm font-medium transition">Simpan Layanan</button>
        </div>
    </form>
</div>
@endsection