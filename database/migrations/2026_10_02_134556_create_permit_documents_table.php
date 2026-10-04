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
    Schema::create('permit_documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('permit_application_id')->constrained('permit_applications')->onDelete('cascade');
        $table->string('nama_dokumen'); // Misal: "KTP", "Pengantar RT", dll
        $table->string('file_path');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_documents');
    }
};
