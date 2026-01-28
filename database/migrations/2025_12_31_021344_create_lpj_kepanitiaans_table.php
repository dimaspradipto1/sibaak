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
        Schema::create('lpj_kepanitiaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained()->cascadeOnDelete();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete();
            $table->string('semester');
            $table->text('nama_dokumen');
            $table->string('ketua');
            $table->string('sekretaris');
            $table->string('fakultas');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpj_kepanitiaans');
    }
};
