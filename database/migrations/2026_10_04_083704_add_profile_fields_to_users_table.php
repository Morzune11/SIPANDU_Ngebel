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
    Schema::table('users', function (Blueprint $table) {
        $table->string('tempat_tanggal_lahir')->nullable();
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
        $table->string('pekerjaan')->nullable();
        $table->text('alamat')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['tempat_tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'alamat']);
    });
}
};
