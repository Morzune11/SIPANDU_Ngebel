<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Cek apakah role pengguna ada di dalam daftar role yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Arahkan kembali ke dashboard masing-masing jika melanggar batas
            if ($userRole === 'pemohon') {
                return redirect()->route('pemohon.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman petugas.');
            }
            
            return redirect()->route('petugas.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}