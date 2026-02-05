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
        Schema::create('rekapitulasi_arsips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_akademik_id')->nullable();
            $table->string('semester')->nullable();
            $table->string('tahun')->nullable();
            $table->string('jenis_arsip');
            $table->string('fakultas');
            $table->foreignId('pedoman_id')->nullable()->constrained('pedomen')->onDelete('cascade');
            $table->foreignId('sop_akademik_id')->nullable()->constrained('sop_akademiks')->onDelete('cascade');
            $table->foreignId('kurikulum_id')->nullable()->constrained('kurikulums')->onDelete('cascade');
            $table->foreignId('wasdalbin_id')->nullable()->constrained('wasdalbins')->onDelete('cascade');
            $table->foreignId('sk_kepanitiaan_id')->nullable()->constrained('sk_kepanitiaans')->onDelete('cascade');
            $table->foreignId('lpj_kepanitiaan_id')->nullable()->constrained('lpj_kepanitiaans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekapitulasi_arsips');
    }
};
