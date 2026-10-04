@extends('layouts.petugas')

@section('title', 'Persetujuan Surat')
@section('page_title', 'Antrean Pengesahan Camat')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-bold text-slate-800">Daftar Menunggu Tanda Tangan</h2>
        <p class="text-sm text-slate-500">Berkas yang telah diverifikasi Admin dan siap untuk diterbitkan.</p>
    </div>

    @if (session('status'))
        <div class="m-4 p-4 bg-green-50 text-green-700 text-sm rounded border border-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Tgl Masuk</th>
                    <th class="p-4 font-semibold">Nama Pemohon</th>
                    <th class="p-4 font-semibold">Layanan & Registrasi</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse ($applications as $app)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 text-slate-600 whitespace-nowrap">{{ $app->updated_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 font-bold text-slate-800">{{ $app->user->nama_lengkap }}</td>
                    <td class="p-4">
                        <p class="font-medium text-slate-800">{{ $app->permitType->nama_izin }}</p>
                        <p class="text-xs text-slate-500">{{ $app->nomor_pendaftaran }}</p>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('camat.persetujuan.show', $app->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-lg text-sm font-medium transition">
                            Tinjau & Setujui
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-500 italic">Saat ini tidak ada dokumen yang menunggu pengesahan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection