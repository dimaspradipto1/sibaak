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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->string('npm')->nullable();
            $table->string('nidk')->nullable();
            $table->string('nupn')->nullable();
            $table->string('nbm')->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('email_pribadi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
