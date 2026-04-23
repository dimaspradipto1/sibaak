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
        Schema::table('arsip_utamas', function (Blueprint $wrapper) {
            $wrapper->boolean('is_active')->default(true)->after('tahun_arsip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip_utamas', function (Blueprint $wrapper) {
            $wrapper->dropColumn('is_active');
        });
    }
};
