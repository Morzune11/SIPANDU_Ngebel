<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir profil berdasarkan role pengguna.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Arahkan ke tampilan yang berbeda sesuai role
        return $user->role === 'pemohon' 
            ? view('pemohon.profil') 
            : view('petugas.profil');
    }

    /**
     * Memperbarui data profil ke database.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:users,nik,'.$user->id],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'no_telepon' => ['required', 'string', 'min:10', 'max:15', 'regex:/^[0-9]+$/'],
            
            // Ubah validasi menjadi dua field terpisah
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user->nik = $request->nik;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        
        if ($user->role === 'pemohon') {
            // Gabungkan tempat dan tanggal dengan aman menggunakan fungsi date() bawaan PHP
            if ($request->filled('tempat_lahir') && $request->filled('tanggal_lahir')) {
                $tanggal = date('d-m-Y', strtotime($request->tanggal_lahir));
                $user->tempat_tanggal_lahir = $request->tempat_lahir . ', ' . $tanggal;
            }
            
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->pekerjaan = $request->pekerjaan;
            $user->alamat = $request->alamat;
        }

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'Informasi profil Anda berhasil diperbarui.');
    }
}