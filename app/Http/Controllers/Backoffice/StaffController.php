<?php

namespace App\Http\Controllers\Backoffice;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
class StaffController extends Controller
{
  public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil data user yang bukan pemohon
        $staffs = \App\Models\User::where('role', '!=', 'pemohon')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('role', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.index', compact('staffs', 'search'));
    }

    public function create(): View
    {
        return view('petugas.create');
    }

    public function store(Request $request): RedirectResponse
{
    // 1. Kumpulan pesan error dalam Bahasa Indonesia
    $messages = [
        'nik.required' => 'NIK wajib diisi.',
        'nik.size' => 'NIK harus berjumlah persis 16 digit.',
        'nik.regex' => 'NIK hanya boleh berisi angka.',
        'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
        
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        
        'email.required' => 'Email kedinasan wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah digunakan oleh petugas lain.',
        
        'no_telepon.required' => 'Nomor telepon wajib diisi.',
        'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka (0-9).',
        'no_telepon.min' => 'Nomor telepon minimal 10 digit.',
        'no_telepon.max' => 'Nomor telepon maksimal 15 digit.',
        
        'role.required' => 'Peran (Role) wajib dipilih.',
        'role.in' => 'Pilihan peran tidak valid.',
        
        'password.required' => 'Kata sandi awal wajib diisi.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
    ];

    // 2. Validasi input termasuk regex angka pada no_telepon
    $validated = $request->validate([
        'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:users,nik'],
        'nama_lengkap' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'no_telepon' => ['required', 'string', 'min:10', 'max:15', 'regex:/^[0-9]+$/'],
        'role' => ['required', 'in:admin,camat,admin_polsek,admin_koramil'],
        'password' => ['required', 'confirmed', Password::defaults()],
    ], $messages);

    // 3. Simpan data ke database
    User::create([
        'nik' => $validated['nik'],
        'nama_lengkap' => $validated['nama_lengkap'],
        'email' => $validated['email'],
        'no_telepon' => $validated['no_telepon'],
        'role' => $validated['role'],
        'password' => Hash::make($validated['password']),
    ]);

    // 4. Redirect diperbaiki dari 'petugas.index' menjadi 'staff.index'
    return redirect()->route('staff.index')
        ->with('status', 'Petugas baru berhasil ditambahkan.');
}

    public function destroy(Request $request, User $staff): RedirectResponse
    {
        // Mencegah admin menghapus dirinya sendiri
        if ($request->user()->id === $staff->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $staff->delete();

        // Redirect diperbaiki menjadi 'staff.index'
        return redirect()->route('staff.index')
            ->with('status', 'Akun petugas berhasil dihapus.');
    }
}