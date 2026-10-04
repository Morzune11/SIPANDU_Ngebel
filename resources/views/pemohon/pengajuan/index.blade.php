@extends('layouts.pemohon')

@section('title', 'Riwayat Pengajuan Izin')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Pengajuan</h1>
        <p class="text-slate-500 text-sm mt-1">Pantau status dokumen dan perizinan Anda di sini.</p>
    </div>
    
    <!-- Tombol Buat Baru diletakkan di header agar mudah dijangkau -->
    <a href="{{ route('pemohon.pengajuan.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Pengajuan Baru
    </a>
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
                    <th class="p-4 font-semibold">Nomor Registrasi</th>
                    <th class="p-4 font-semibold">Jenis Layanan</th>
                    <th class="p-4 font-semibold">Tanggal Diajukan</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse ($applications as $app)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-bold text-slate-800">{{ $app->nomor_pendaftaran }}</td>
                    <td class="p-4 text-slate-700">{{ $app->permitType->nama_izin }}</td>
                    <td class="p-4 text-slate-600">{{ $app->created_at->format('d M Y, H:i') }}</td>
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
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold capitalize tracking-wide {{ $color }}">
                            {{ str_replace('_', ' ', $app->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('pemohon.pengajuan.show', $app->id) }}" class="inline-flex px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg font-medium text-xs transition">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span>Belum ada riwayat pengajuan izin.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection