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
        Schema::create('surat_aktifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_studi_id')->constrained()->cascadeOnDelete();
            $table->integer('no_surat');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('npm');
            $table->string('jenjang_pendidikan');
            $table->string('fakultas');
            $table->string('status')->default('pending');
            $table->string('semester');
            $table->string('status_semester')->nullable();
            $table->string('tahun_akademik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_aktifs');
    }
};
