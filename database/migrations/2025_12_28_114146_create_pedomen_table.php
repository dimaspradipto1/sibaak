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
        Schema::create('pedomen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete();
            $table->string('tahun');
            $table->string('nama_pedoman');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedomen');
    }
};
