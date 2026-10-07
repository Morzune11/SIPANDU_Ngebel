@extends('layouts.petugas')

@section('title', 'Profil Saya')
@section('page_title', 'Pengaturan Akun')

@section('content')
<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
    
    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm rounded-lg border border-green-200">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm rounded-lg border border-red-200">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.profil.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50 text-slate-500" readonly>
                <p class="text-xs text-slate-400 mt-1">NIK tidak dapat diubah.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email Kedinasan</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon / WA</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', auth()->user()->no_telepon) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="border-t border-slate-200 pt-6 mt-6">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Ubah Kata Sandi</h3>
            <p class="text-xs text-slate-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CONTOH 1: PASSWORD LAMA -->
<div class="mb-4">
    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Password Lama</label>
    <div class="relative">
        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 pr-10">
        @error('current_password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        
        <button type="button" onclick="togglePassword('current_password', 'eye-open-current', 'eye-closed-current')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none">
            <!-- Ikon Mata Tertutup (Default) -->
            <svg id="eye-closed-current" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            </svg>
            <!-- Ikon Mata Terbuka -->
            <svg id="eye-open-current" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
</div>

<!-- CONTOH 2: PASSWORD BARU -->
<div class="mb-4">
    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
    <div class="relative">
        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 pr-10">
        
        <button type="button" onclick="togglePassword('password', 'eye-open-new', 'eye-closed-new')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none">
            <!-- Ikon Mata Tertutup -->
            <svg id="eye-closed-new" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            </svg>
            <!-- Ikon Mata Terbuka -->
            <svg id="eye-open-new" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
</div>

            <!-- CONTOH 3: KONFIRMASI PASSWORD -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 pr-10">
                    
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-open-confirm', 'eye-closed-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none">
                        <!-- Ikon Mata Tertutup -->
                        <svg id="eye-closed-confirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                        <!-- Ikon Mata Terbuka -->
                        <svg id="eye-open-confirm" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium hover:bg-blue-700 rounded-lg transition text-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function togglePassword(inputId, eyeOpenId, eyeClosedId) {
        // Ambil elemen HTML berdasarkan ID
        const inputField = document.getElementById(inputId);
        const eyeOpen = document.getElementById(eyeOpenId);
        const eyeClosed = document.getElementById(eyeClosedId);

        // Cek tipe input saat ini
        if (inputField.type === "password") {
            // Ubah menjadi teks yang bisa dibaca
            inputField.type = "text";
            
            // Sembunyikan mata tertutup (coret), tampilkan mata terbuka
            eyeClosed.classList.add('hidden');
            eyeOpen.classList.remove('hidden');
        } else {
            // Kembalikan menjadi titik-titik rahasia (password)
            inputField.type = "password";
            
            // Tampilkan mata tertutup, sembunyikan mata terbuka
            eyeClosed.classList.remove('hidden');
            eyeOpen.classList.add('hidden');
        }
    }
</script>
@endsection