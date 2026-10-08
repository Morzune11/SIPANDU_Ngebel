@extends('layouts.petugas')

@section('title', 'Verifikasi Berkas')
@section('page_title', 'Daftar Pengajuan Masuk')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Verifikasi Berkas Masuk</h1>
        <p class="text-slate-500 text-sm mt-1">Pilih berkas masyarakat untuk diperiksa kelengkapannya dan diproses lebih lanjut.</p>
    </div>
    
    <form method="GET" action="{{ route('verifikasi.index') }}" class="flex">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama, NIK, atau No. Reg..." 
               class="px-4 py-2 border border-slate-300 rounded-l-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm w-full md:w-64">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-r-lg hover:bg-blue-700 transition">
            Cari
        </button>
        @if($search ?? false)
            <a href="{{ route('verifikasi.index') }}" class="ml-2 px-4 py-2 bg-slate-200 text-slate-700 text-sm rounded-lg hover:bg-slate-300 transition flex items-center">
                Reset
            </a>
        @endif
    </form>
</div>

@if (session('status'))
    <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm rounded-xl border border-green-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('status') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
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
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-slate-600 whitespace-nowrap">{{ $app->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4">
                        <p class="font-bold text-slate-800">{{ $app->user->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">NIK: {{ $app->user->nik }}</p>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-slate-800">{{ $app->permitType->nama_izin }}</p>
                        <p class="text-xs text-slate-500 font-mono">{{ $app->nomor_pendaftaran }}</p>
                    </td>
                    <td class="p-4">
                        @php
                            $color = match($app->status) {
                                'diajukan' => 'bg-blue-100 text-blue-800',
                                'diproses' => 'bg-amber-100 text-amber-800',
                                'menunggu_tte' => 'bg-indigo-100 text-indigo-800',
                                'revisi' => 'bg-orange-100 text-orange-800',
                                'selesai' => 'bg-emerald-100 text-emerald-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-slate-100 text-slate-800'
                            };

                            $text = match($app->status) {
                                'menunggu_tte' => 'Diajukan ke Camat',
                                default => str_replace('_', ' ', $app->status)
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold capitalize tracking-wide {{ $color }}">
                            {{ $text }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('verifikasi.show', $app->id) }}" class="inline-flex px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg font-medium text-xs transition">
                            Periksa
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span>Belum ada pengajuan masuk.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($applications->hasPages())
    <div class="p-4 border-t border-slate-200 bg-slate-50">
        {{ $applications->links() }}
    </div>
    @endif
</div>
@endsection