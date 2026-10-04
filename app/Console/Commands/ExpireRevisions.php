<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PermitApplication;
use Carbon\Carbon;

class ExpireRevisions extends Command
{
    protected $signature = 'permits:expire';
    protected $description = 'Menutup pengajuan berstatus revisi yang tidak diperbaiki selama lebih dari 30 hari';

    public function handle()
    {
        // Cari pengajuan yang berstatus revisi, dan terakhir diupdate 30 hari yang lalu
        $deadline = Carbon::now()->subDays(30);
        
        $expiredPermits = PermitApplication::where('status', 'revisi')
                            ->where('updated_at', '<', $deadline)
                            ->get();

        foreach ($expiredPermits as $permit) {
            $permit->update([
                'status' => 'ditolak', // Atau Anda bisa tambah status baru 'dibatalkan' di database
                'catatan_revisi' => 'Sistem Otomatis: Pengajuan ditutup karena melewati batas waktu revisi 30 hari tanpa ada perbaikan.',
            ]);
            
            // Opsional: Kirim notifikasi ke pemohon
            $permit->user->notify(new \App\Notifications\PermitNotification(
                'Pengajuan Ditutup',
                'Pengajuan izin Anda dibatalkan otomatis karena melewati batas waktu revisi.',
                route('pemohon.pengajuan.show', $permit->id)
            ));
        }

        $this->info(count($expiredPermits) . ' pengajuan revisi berhasil ditutup.');
    }
}