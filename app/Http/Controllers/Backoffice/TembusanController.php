<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use Illuminate\Http\Request;

class TembusanController extends Controller
{
    public function index()
    {
        // Hanya tampilkan dokumen yang sudah berstatus 'selesai' (Di-ACC Camat)
        $applications = PermitApplication::with(['user', 'permitType'])
            ->where('status', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('petugas.tembusan.index', compact('applications'));
    }
}