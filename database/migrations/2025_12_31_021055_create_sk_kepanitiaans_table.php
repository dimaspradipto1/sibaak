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
        Schema::create('sk_kepanitiaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained()->cascadeOnDelete();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenissk_id')->constrained('jenis_s_k_s')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('semester');
            $table->string('nomor_sk');
            $table->string('fakultas');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_kepanitiaans');
    }
};
