<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ApplicantAuthController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran pemohon.
     */
    public function showRegisterForm(): View
    {
        return view('auth.applicant.register');
    }

    /**
     * Memproses pendaftaran akun pemohon baru.
     */
    public function register(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:users,nik'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_telepon' => ['required', 'string', 'min:10', 'max:15', 'regex:/^[0-9]+$/'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // 2. Simpan ke tabel users
        $user = User::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => 'pemohon', // Kunci (Hardcode) role sebagai pemohon
        ]);

        // 3. Langsung login-kan user setelah berhasil mendaftar
        // Auth::login($user);

        // 4. Arahkan ke dashboard masyarakat
        return redirect()->route('login')
            ->with('status', 'Pendaftaran akun berhasil! Silakan login');
    }

    /**
     * Menampilkan formulir login pemohon.
     */
    public function showLoginForm(): View
    {
        return view('auth.applicant.login');
    }

    /**
     * Memproses autentikasi login (Mendukung NIK maupun Email).
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi Input Login
        $credentials = $request->validate([
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'identity.required' => 'Silakan masukkan NIK atau Email Anda.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // 2. Deteksi apakah input berupa Email atau NIK
        $fieldType = filter_var($credentials['identity'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        $authField = [
            $fieldType => $credentials['identity'],
            'password' => $credentials['password'],
            'role' => 'pemohon', // Memastikan hanya role pemohon yang bisa login dari portal ini
        ];

        $remember = $request->boolean('remember');

        // 3. Percobaan Autentikasi
        if (Auth::attempt($authField, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('pemohon.dashboard'))
                ->with('status', 'Berhasil masuk.');
        }

        // 4. Jika Autentikasi Gagal
        return back()->withInput($request->only('identity', 'remember'))
            ->withErrors([
                'login_error' => 'NIK/Email atau kata sandi yang Anda masukkan salah, atau akun Anda tidak terdaftar sebagai pemohon.',
            ]);
    }

    /**
     * Memproses keluar (logout) dari sistem.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Anda telah berhasil keluar.');
    }
}