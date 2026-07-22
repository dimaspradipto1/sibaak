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
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'nip')) {
                $table->string('nip')->nullable()->after('npm');
            }
            if (!Schema::hasColumn('profiles', 'nidn')) {
                $table->string('nidn')->nullable()->after('nip');
            }
            if (!Schema::hasColumn('profiles', 'nuptk')) {
                $table->string('nuptk')->nullable()->after('nidn');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['nip', 'nidn', 'nuptk']);
        });
    }
};
