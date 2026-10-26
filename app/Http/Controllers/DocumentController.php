<?php

namespace App\Http\Controllers;

use App\Models\PermitDocument;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Menampilkan dokumen persyaratan pemohon di tab baru secara aman
     */
    public function show(Request $request, $id): StreamedResponse
    {
        $document = PermitDocument::with('application')->findOrFail($id);
        $user = $request->user();

        // Keamanan: Hanya pemohon pemilik berkas atau petugas (admin, camat, polsek, koramil) yang dapat melihat
        if ($user->role === 'pemohon' && $document->application && $document->application->user_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses untuk melihat dokumen ini.');
        }

        // Jalur file pada storage
        $filePath = storage_path('app/public/' . $document->file_path);

        // Fallback jika path disimpan tanpa prefix public
        if (!file_exists($filePath)) {
            $filePath = storage_path('app/' . $document->file_path);
        }

        if (!file_exists($filePath)) {
            abort(404, 'File dokumen tidak ditemukan di penyimpanan server.');
        }

        $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
        $fileName = basename($document->nama_dokumen);

        return response()->stream(function () use ($filePath) {
            $stream = fopen($filePath, 'rb');
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Length' => filesize($filePath),
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }
}
