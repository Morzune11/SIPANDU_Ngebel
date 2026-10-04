<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Layanan Masyarakat')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    
    <!-- Navbar Atas -->
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Judul -->
                <a href="{{ route('pemohon.dashboard') }}" class="flex items-center gap-2.5 hover:opacity-80 transition group">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-blue-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-lg font-bold text-slate-800 hidden sm:block">Layanan Perizinan</span>
                </a>

                <!-- Menu Navigasi -->
                <div class="flex items-center gap-1 sm:gap-3">
                    
                    <a href="{{ route('pemohon.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('pemohon.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Beranda
                    </a>
                    
                    <a href="{{ route('pemohon.pengajuan.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('pemohon.pengajuan.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Riwayat
                    </a>
                    
                    <a href="{{ route('pemohon.profil') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('pemohon.profil') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Profil Saya
                    </a>

                    <!-- Dropdown Notifikasi -->
                    <div class="relative">
                        <button type="button" onclick="document.getElementById('notifDropdownUser').classList.toggle('hidden')" class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-full transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if(auth()->user()?->unreadNotifications->count() > 0)
                                <span class="absolute top-1 right-1 flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                </span>
                            @endif
                        </button>
                        
                        <!-- Panel Notif -->
                        <div id="notifDropdownUser" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden z-50">
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
                                    <div class="p-4 text-center text-sm text-slate-500">Belum ada notifikasi baru.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Garis Pemisah (Divider) -->
                    <div class="h-6 w-px bg-slate-200 mx-1"></div>

                    <!-- Tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-bold text-red-500 hover:bg-red-50 hover:text-red-700 transition" title="Keluar dari sistem">
                            <span class="hidden sm:inline">Keluar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <!-- Area Konten Utama -->
    <main class="flex-1 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center text-sm text-slate-500 flex flex-col md:flex-row justify-between items-center gap-3">
            <p>&copy; {{ date('Y') }} Sistem Informasi Pelayanan Kecamatan Ngebel.</p>
            <p class="text-xs">Dikembangkan untuk efisiensi pelayanan masyarakat.</p>
        </div>
    </footer>
</body>
</html>