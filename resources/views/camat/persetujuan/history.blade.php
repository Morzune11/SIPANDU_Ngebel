@extends('layouts.petugas')

@section('title', 'Riwayat Pengesahan')
@section('page_title', 'Arsip Dokumen Terbit')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Riwayat Pengesahan Dokumen</h1>
    <p class="text-slate-500 text-sm mt-1">Daftar seluruh dokumen perizinan yang telah Anda setujui dan terbitkan.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Tgl Disahkan</th>
                    <th class="p-4 font-semibold">Nama Pemohon</th>
                    <th class="p-4 font-semibold">Jenis Layanan</th>
                    <th class="p-4 font-semibold">No. Registrasi</th>
                    <th class="p-4 font-semibold text-center">Arsip Final</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse ($applications as $app)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-medium text-slate-700">{{ $app->updated_at->format('d M Y') }}</td>
                    <td class="p-4 font-bold text-slate-800">{{ $app->user->nama_lengkap }}</td>
                    <td class="p-4 text-slate-700">{{ $app->permitType->nama_izin }}</td>
                    <td class="p-4">
                        <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">{{ $app->nomor_pendaftaran }}</span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Preview HTML -->
                            <a href="{{ route('surat.final.preview', $app->id) }}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Dokumen">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <!-- Tombol Download PDF -->
                            <a href="{{ route('surat.final.download', $app->id) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Unduh PDF">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-500">
                        Belum ada riwayat dokumen yang diterbitkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection