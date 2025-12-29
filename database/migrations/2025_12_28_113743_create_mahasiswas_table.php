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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_studi_id')->constrained()->cascadeOnDelete();
            $table->string('fakultas')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('npm')->nullable();
            $table->string('jenjang_pendidikan')->nullable();
            $table->string('semester')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('status_cuti')->default('Belum Pernah Cuti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
