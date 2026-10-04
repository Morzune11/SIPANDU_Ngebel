<?php

namespace App\Http\Controllers;

use App\Models\PermitType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermitTypeController extends Controller
{
    public function index(): View
    {
        $permitTypes = PermitType::latest()->get();
        return view('permit_types.index', compact('permitTypes'));
    }

    public function create(): View
    {
        return view('permit_types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_izin' => ['required', 'string', 'max:255'],
            'persyaratan' => ['required', 'string'],
            'estimasi_hari' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        PermitType::create($validated);

        return redirect()->route('permit-types.index')
            ->with('status', 'Jenis perizinan berhasil ditambahkan.');
    }

    public function destroy(PermitType $permitType): RedirectResponse
    {
        $permitType->delete();

        return redirect()->route('permit-types.index')
            ->with('status', 'Jenis perizinan berhasil dihapus.');
    }
}