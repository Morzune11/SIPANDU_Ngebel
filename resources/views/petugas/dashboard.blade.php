@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('page_title', auth()->user()->role === 'camat' ? 'Dashboard Pimpinan' : 'Statistik Pelayanan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800">Selamat Datang, {{ auth()->user()->nama_lengkap }}!</h2>
    <p class="text-sm text-slate-500">
        {{ auth()->user()->role === 'camat' ? 'Berikut adalah ringkasan dokumen yang menunggu pengesahan Anda.' : 'Berikut adalah ringkasan statistik pelayanan perizinan kecamatan saat ini.' }}
    </p>
</div>

<!-- Kartu Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center">
        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Pengajuan</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_pengajuan'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center">
        <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Verifikasi Admin</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['menunggu_admin'] }}</p>
        </div>
    </div>

    <!-- Highlight Khusus untuk Camat -->
    <div class="bg-white rounded-xl shadow-sm border {{ auth()->user()->role === 'camat' && $stats['menunggu_camat'] > 0 ? 'border-amber-400 ring-2 ring-amber-100' : 'border-slate-200' }} p-6 flex items-center relative overflow-hidden">
        @if(auth()->user()->role === 'camat' && $stats['menunggu_camat'] > 0)
            <div class="absolute top-0 right-0 w-2 h-full bg-amber-400"></div>
        @endif
        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Antrean TTE</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['menunggu_camat'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center">
        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Selesai / Terbit</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['selesai'] }}</p>
        </div>
    </div>
</div>

<!-- Tabel Dinamis Berdasarkan Role -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    @if(auth()->user()->role === 'camat')
        <!-- TAMPILAN KHUSUS CAMAT -->
        <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-amber-50/50">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Antrean Tanda Tangan (TTE)</h2>
                <p class="text-xs text-slate-500 mt-1">Dokumen prioritas yang membutuhkan pengesahan Anda.</p>
            </div>
            <a href="{{ route('camat.persetujuan.index') }}" class="text-sm font-bold text-amber-600 hover:text-amber-800 hover:underline">Lihat Semua &rarr;</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                        <th class="p-4 font-semibold">Dikirim Oleh Admin</th>
                        <th class="p-4 font-semibold">Nama Pemohon</th>
                        <th class="p-4 font-semibold">Layanan</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse ($waitingForCamat as $app)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 text-slate-600">{{ $app->updated_at->diffForHumans() }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $app->user->nama_lengkap }}</td>
                        <td class="p-4 text-slate-700">{{ $app->permitType->nama_izin }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('camat.persetujuan.show', $app->id) }}" class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-lg font-medium transition text-xs">
                                Tinjau Dokumen
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Saat ini tidak ada antrean dokumen yang perlu disahkan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    @else
        <!-- TAMPILAN KHUSUS ADMIN -->
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-slate-800">5 Pengajuan Masuk Terbaru</h2>
                <p class="text-xs text-slate-500 mt-1">Pantau dokumen baru yang dikirimkan oleh masyarakat.</p>
            </div>
            <a href="{{ route('verifikasi.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">Kelola Berkas &rarr;</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                        <th class="p-4 font-semibold">Tgl Masuk</th>
                        <th class="p-4 font-semibold">Pemohon</th>
                        <th class="p-4 font-semibold">Layanan</th>
                        <th class="p-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse ($recentApplications as $app)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 text-slate-600">{{ $app->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 font-medium text-slate-800">{{ $app->user->nama_lengkap }}</td>
                        <td class="p-4 text-slate-700">{{ $app->permitType->nama_izin }}</td>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500 italic">Belum ada data pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection