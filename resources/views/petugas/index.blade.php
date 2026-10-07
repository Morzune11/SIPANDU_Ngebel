@extends('layouts.petugas')

@section('title', 'Daftar Petugas')
@section('page_title', 'Kelola Data Petugas')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Admin & Camat</h2>
            <p class="text-sm text-slate-500">Kelola akses internal aplikasi pelayanan perizinan.</p>
        </div>
        <a href="{{ route('staff.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition">
            + Tambah Petugas
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Nama Lengkap</th>
                    <th class="p-4 font-semibold">Kontak</th>
                    <th class="p-4 font-semibold">Peran</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @foreach ($staffs as $staff)
                <tr class="hover:bg-slate-50">
                    <td class="p-4">
                        <p class="font-medium text-slate-800">{{ $staff->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">NIK: {{ $staff->nik }}</p>
                    </td>
                    <td class="p-4">
                        <p class="text-slate-700">{{ $staff->email }}</p>
                        <p class="text-xs text-slate-500">{{ $staff->no_telepon }}</p>
                    </td>
                    <td class="p-4">
                        @php
                            $roleColor = match($staff->role) {
                                'admin' => 'bg-blue-100 text-blue-800',
                                'camat' => 'bg-purple-100 text-purple-800',
                                'admin_polsek' => 'bg-amber-100 text-amber-900',
                                'admin_koramil' => 'bg-emerald-100 text-emerald-900',
                                default => 'bg-slate-100 text-slate-800'
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $roleColor }}">
                            {{ str_replace('_', ' ', $staff->role) }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        @if (auth()->id() !== $staff->id)
                            <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Hapus</button>
                            </form>
                        @else
                            <span class="text-slate-400 text-xs italic">Akun Anda</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection