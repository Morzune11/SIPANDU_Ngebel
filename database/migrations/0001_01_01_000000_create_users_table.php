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
        schema::create('users', function (Blueprint $table) {
        $table->id();
        // Tambahan 3 baris ini:
        $table->string('nik', 16)->unique();
        $table->enum('role', ['pemohon', 'admin', 'camat', 'admin_polsek', 'admin_koramil'])->default('pemohon');
        $table->string('no_telepon')->nullable();
        
        $table->string('nama_lengkap'); // Ganti 'name' menjadi 'nama_lengkap'
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });

        // Abaikan bagian password_reset_tokens dan sessions jika ada di bawahnya
        // Biarkan tabel reset password & session bawaan Laravel apa adanya
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};