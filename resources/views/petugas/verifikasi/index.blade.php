@extends('layouts.petugas')

@section('title', 'Verifikasi Berkas')
@section('page_title', 'Daftar Pengajuan Masuk')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-bold text-slate-800">Antrean Verifikasi Berkas</h2>
        <p class="text-sm text-slate-500">Pilih berkas masyarakat untuk diperiksa kelengkapannya dan diproses lebih lanjut.</p>
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
                    <th class="p-4 font-semibold">Pemohon</th>
                    <th class="p-4 font-semibold">Layanan & Reg</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse ($applications as $app)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 text-slate-600 whitespace-nowrap">{{ $app->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4">
                        <p class="font-bold text-slate-800">{{ $app->user->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">NIK: {{ $app->user->nik }}</p>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-slate-800">{{ $app->permitType->nama_izin }}</p>
                        <p class="text-xs text-slate-500">{{ $app->nomor_pendaftaran }}</p>
                    </td>
                    <td class="p-4">
                        @php
                            $color = match($app->status) {
                                'diajukan' => 'bg-blue-100 text-blue-800',
                                'diproses', 'menunggu_tte' => 'bg-amber-100 text-amber-800',
                                'revisi' => 'bg-orange-100 text-orange-800',
                                'selesai' => 'bg-emerald-100 text-emerald-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-slate-100 text-slate-800'
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium capitalize {{ $color }}">
                            {{ str_replace('_', ' ', $app->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('verifikasi.show', $app->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg text-sm font-medium transition">
                            Periksa
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500 italic">Belum ada pengajuan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection