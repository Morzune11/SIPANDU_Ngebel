<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Petugas')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex h-screen overflow-hidden text-slate-800 font-sans">

    <!-- Sidebar Kiri -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col hidden md:flex shrink-0">
        <!-- Logo / Judul Aplikasi -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-950">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <span class="text-lg font-bold tracking-wide">Kec. Ngebel</span>
        </div>

        <!-- Area Menu Navigasi -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            
            <a href="{{ route('petugas.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition text-sm font-medium {{ request()->routeIs('petugas.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>

            <!-- Menu Khusus Admin -->
            @if(auth()->check() && auth()->user()->role === 'admin')
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2">Tugas Admin</p>
                
                <a href="{{ route('staff.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition text-sm font-medium {{ request()->routeIs('staff.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Kelola Petugas
                </a>
                
                <a href="{{ route('verifikasi.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition text-sm font-medium {{ request()->routeIs('verifikasi.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Verifikasi Berkas
                </a>
                
                <a href="{{ route('permit-types.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition text-sm font-medium {{ request()->routeIs('permit-types.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s-8-1.79-8-4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Master Perizinan
                </a>
            @endif

            <!-- Menu Khusus Camat -->
            @if(auth()->check() && auth()->user()->role === 'camat')
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2">Menu Pimpinan</p>
                
                <a href="{{ route('camat.persetujuan.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition text-sm font-medium {{ request()->routeIs('camat.persetujuan.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Persetujuan Dokumen
                </a>

                <!-- TAMBAHKAN MENU RIWAYAT -->
                <a href="{{ route('camat.riwayat.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition text-sm font-medium {{ request()->routeIs('camat.riwayat.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Pengesahan
                </a>
            @endif
        </nav>

        <!-- Tombol Logout Bawah Sidebar -->
    </aside>

    <!-- Area Konten Utama Kanan -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Navbar Atas -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10 shrink-0">
            <h1 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
            
            <div class="flex items-center gap-4">
                
                <!-- Profil Petugas (Bisa Diklik) -->
                <a href="{{ route('petugas.profil') }}" class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-slate-50 transition group" title="Pengaturan Profil">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition">{{ auth()->user()->nama_lengkap ?? 'Petugas' }}</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">{{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center border border-blue-200 group-hover:bg-blue-600 group-hover:text-white transition">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'P', 0, 1)) }}
                    </div>
                </a>

                <!-- Dropdown Notifikasi Petugas -->
                <div class="relative">
                    <button type="button" onclick="document.getElementById('notifDropdownPetugas').classList.toggle('hidden')" class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-full transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if(auth()->user()?->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                            </span>
                        @endif
                    </button>
                    
                    <div id="notifDropdownPetugas" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden z-50">
                        <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                            <span class="text-sm font-bold text-slate-800">Notifikasi</span>
                        </div>
                        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                            @forelse(auth()->user()?->unreadNotifications ?? [] as $notif)
                                <a href="{{ route('notifikasi.read', $notif->id) }}" class="block p-4 hover:bg-slate-50 transition">
                                    <p class="text-sm font-bold text-slate-800 mb-1">{{ $notif->data['title'] }}</p>
                                    <p class="text-xs text-slate-600 line-clamp-2">{{ $notif->data['message'] }}</p>
                                    <p class="text-xs text-slate-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                </a>
                            @empty
                                <div class="p-4 text-center text-sm text-slate-500">Tidak ada notifikasi tugas baru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Garis Pembatas -->
                <div class="h-6 w-px bg-slate-200"></div>

                <!-- Tombol Logout Navbar Atas -->
                <form action="{{ route('petugas.logout') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium transition" title="Keluar Sistem">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="hidden md:inline">Keluar</span>
                    </button>
                </form>

            </div>
        </header>

        <!-- Konten Halaman (Dashboard, Form, Tabel) -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-6 sm:p-8">
            @yield('content')
        </main>
        
    </div>
</body>
</html>