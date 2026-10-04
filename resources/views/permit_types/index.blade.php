@extends('layouts.petugas')

@section('title', 'Master Perizinan')
@section('page_title', 'Kelola Layanan Perizinan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Jenis Layanan Izin</h2>
            <p class="text-sm text-slate-500">Tentukan izin apa saja yang bisa diajukan oleh masyarakat.</p>
        </div>
        <a href="{{ route('permit-types.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition">
            + Tambah Layanan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Nama Izin</th>
                    <th class="p-4 font-semibold">Estimasi (Hari)</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse ($permitTypes as $permit)
                <tr class="hover:bg-slate-50">
                    <td class="p-4">
                        <p class="font-medium text-slate-800">{{ $permit->nama_izin }}</p>
                        <p class="text-xs text-slate-500 mt-1 truncate max-w-xs" title="{{ $permit->persyaratan }}">
                            Syarat: {{ Str::limit($permit->persyaratan, 50) }}
                        </p>
                    </td>
                    <td class="p-4 text-slate-700">{{ $permit->estimasi_hari }} Hari Kerja</td>
                    <td class="p-4">
                        @if($permit->is_active)
                            <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-xs font-medium">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-full text-xs font-medium">Nonaktif</span>
                        @endif
                    </td>
                    <td class="p-4 text-right flex justify-end gap-3">
                        <form action="{{ route('permit-types.destroy', $permit->id) }}" method="POST" onsubmit="return confirm('Hapus layanan perizinan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-slate-500 italic">Belum ada data layanan perizinan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection