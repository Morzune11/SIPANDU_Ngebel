<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StaffAuthController extends Controller
{
    /**
     * Menampilkan formulir login khusus petugas.
     */
    public function showLoginForm(): View
    {
        return view('auth.staff.staff-login');
    }

    /**
     * Memproses autentikasi login Petugas (Admin / Camat).
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $role = Auth::user()->role;

            // Pastikan yang login adalah admin atau camat
            if (in_array($role, ['admin', 'camat', 'admin_polsek', 'admin_koramil'])) {
                $request->session()->regenerate();
                return redirect()->intended(route('petugas.dashboard'))
                    ->with('status', 'Berhasil masuk ke Portal Petugas.');
            }

            // Jika pemohon mencoba login lewat portal petugas, paksa keluar
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun ini terdaftar sebagai Pemohon. Silakan login melalui portal masyarakat.',
            ]);
        }

        return back()->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Kredensial yang Anda masukkan salah atau tidak terdaftar.',
            ]);
    }



    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('petugas.login')
            ->with('status', 'Anda berhasil keluar dari sistem.');
    }
}
