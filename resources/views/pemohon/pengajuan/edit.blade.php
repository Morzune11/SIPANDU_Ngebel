@extends('layouts.pemohon')
@section('title', 'Revisi Berkas Pengajuan')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('pemohon.pengajuan.show', $pengajuan->id) }}" class="p-2 bg-white rounded-xl border border-slate-200 hover:bg-slate-50 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Revisi Berkas</h1>
            <p class="text-slate-500 text-sm mt-1">Unggah ulang dokumen yang diminta oleh petugas.</p>
        </div>
    </div>

    <div class="mb-6 p-5 bg-orange-50 border border-orange-200 rounded-xl">
        <h3 class="font-bold text-orange-800 mb-1">Catatan dari Admin:</h3>
        <p class="text-sm text-orange-700">{{ $pengajuan->catatan_revisi }}</p>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
        <form action="{{ route('pemohon.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <p class="text-sm text-slate-500 mb-4 border-b pb-2">Hanya unggah berkas yang perlu diperbaiki. Biarkan kosong jika berkas sebelumnya sudah benar.</p>

            @foreach($pengajuan->documents as $doc)
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">{{ $doc->nama_dokumen }}</label>
                    <div class="flex items-center justify-between mb-2 p-2 bg-slate-50 rounded text-xs border border-slate-100">
                        <span class="text-slate-500 truncate">Berkas saat ini: {{ basename($doc->file_path) }}</span>
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-blue-600 font-bold hover:underline">Lihat</a>
                    </div>
                    <!-- Array dokumen berdasarkan ID-nya -->
                    <input type="file" name="dokumen[{{ $doc->id }}]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:ring-blue-500">
                </div>
            @endforeach

            <div class="pt-4">
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition shadow-sm">
                    Kirim Ulang Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection