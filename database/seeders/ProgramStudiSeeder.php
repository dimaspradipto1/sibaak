<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programStudis = [
            [
                'program_studi' => 'S1-KESEHATAN DAN KESEHATAN KERJA',
            ],
            [
                'program_studi' => 'S1-KESEHATAN LINGKUNGAN',
            ],
            [
                'program_studi' => 'S1-AKUNTANSI',
            ],
            [
                'program_studi' => 'S1-MANAJEMEN',
            ],
            [
                'program_studi' => 'S1-SISTEM INFORMASI',
            ],
            [
                'program_studi' => 'S1-TEKNIK INDUSTRI',
            ],
            [
                'program_studi' => 'S1-TEKNIK INFORMATIKA',
            ],
            [
                'program_studi' => 'S1-TEKNIK LOGISTIK',
            ],
            [
                'program_studi' => 'S1-TEKNIK PERKAPALAN',
            ],
            [
                'program_studi' => 'S2-MAGISTER KESEHATAN MASYARAKAT',
            ],
            [
                'program_studi' => 'S2-MANAJEMEN',
            ]
        ];

        foreach ($programStudis as $programStudi) {
            ProgramStudi::create($programStudi);
        }
    }
}
