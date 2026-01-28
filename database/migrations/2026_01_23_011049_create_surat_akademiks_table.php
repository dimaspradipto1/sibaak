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
        Schema::create('surat_akademiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_studi_id')->constrained()->cascadeOnDelete();
            $table->string('npm')->nullable();
            $table->string('status_cuti')->default('Belum Pernah Cuti');
            $table->text('alamat')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('semester')->nullable();
            $table->string('permohonan')->nullable();
            $table->text('alasan_cuti')->nullable();
            $table->foreignId('dosen_pembimbing_akademik')->constrained('dosens')->cascadeOnDelete();
            $table->foreignId('kaprodi')->constrained('dosens')->cascadeOnDelete();
            $table->foreignId('kabaak')->constrained('pegawais')->cascadeOnDelete();
            $table->foreignId('kabauk')->constrained('pegawais')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_akademiks');
    }
};
