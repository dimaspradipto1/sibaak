<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\UnitKerjaSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitKerjaSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            TahunAkademikSeeder::class,
            JenisskSeeder::class,
            ProgramStudiSeeder::class,
            MahasiswaSeeder::class,
            PegawaiSeeder::class,
            DosenSeeder::class,
        ]);
    }
}
