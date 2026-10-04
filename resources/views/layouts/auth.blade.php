<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Perizinan Kecamatan')</title>
    <!-- Tailwind CSS CDN (atau kompilasi via Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-between">

    <!-- Header Logo / Brand -->
    <header class="w-full py-6 px-4 text-center border-b bg-white shadow-sm">
        <div class="flex items-center justify-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                K
            </div>
            <div class="text-left">
                <h1 class="text-lg font-bold text-slate-800 leading-tight">Sistem Perizinan Kecamatan</h1>
                <p class="text-xs text-slate-500">Pelayanan Surat & Perizinan Mandiri</p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-4 sm:p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full py-4 text-center text-xs text-slate-500 bg-white border-t">
        &copy; {{ date('Y') }} Pemerintah Kecamatan. Hak Cipta Dilindungi.
    </footer>

</body>
</html>