<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('permit_applications', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_pendaftaran')->unique();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('permit_type_id')->constrained('permit_types')->onDelete('cascade');
        $table->enum('status', ['diajukan', 'revisi', 'diproses', 'menunggu_tte', 'selesai', 'ditolak'])->default('diajukan');
        $table->text('catatan_revisi')->nullable();
        $table->string('file_surat_hasil')->nullable(); // Path PDF hasil akhir
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_applications');
    }
};
