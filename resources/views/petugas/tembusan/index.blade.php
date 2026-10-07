@extends('layouts.petugas')

@section('title', 'Tembusan Surat')
@section('page_title', 'Arsip Tembusan Dokumen')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Dokumen Tembusan</h1>
    <p class="text-slate-500 text-sm mt-1">Daftar seluruh dokumen perizinan yang telah disahkan oleh Camat untuk diketahui oleh instansi terkait.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Tgl Disahkan</th>
                    <th class="p-4 font-semibold">Nama Pemohon</th>
                    <th class="p-4 font-semibold">Jenis Layanan</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse ($applications as $app)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-medium text-slate-700">{{ $app->updated_at->format('d M Y') }}</td>
                    <td class="p-4 font-bold text-slate-800">{{ $app->user->nama_lengkap }}</td>
                    <td class="p-4 text-slate-700">{{ $app->permitType->nama_izin }}</td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Karena kita sudah mensetting rute preview dan download menjadi global, 
                                 Admin Polsek/Koramil otomatis bisa menggunakannya -->
                            <a href="{{ route('surat.final.preview', $app->id) }}" target="_blank" class="px-3 py-1.5 bg-slate-800 text-white hover:bg-slate-700 rounded-lg text-xs font-bold transition">
                                Lihat Surat
                            </a>
                            <a href="{{ route('surat.final.download', $app->id) }}" class="px-3 py-1.5 bg-emerald-600 text-white hover:bg-emerald-500 rounded-lg text-xs font-bold transition">
                                Unduh PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-slate-500">Belum ada dokumen tembusan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection