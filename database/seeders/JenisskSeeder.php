<?php

namespace Database\Seeders;

use App\Models\JenisSK;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenissks = [
            [
                'jenis_sk' => 'SK Penerimaan Mahasiswa Baru (PMB)',
            ],
            [
                'jenis_sk' => 'SK PANITA KONVERSI',
            ],
            [
                'jenis_sk' => 'SK Semester Pendek (SP)',
            ],
            [
                'jenis_sk' => 'SK Kartu Rencana Studi (KRS)',
            ],
            [
                'jenis_sk' => 'SK Kuliah Pengabdian Masyarakat (KPM)',
            ],
            [
                'jenis_sk' => 'SK ESQ',
            ],
            [
                'jenis_sk' => 'SK Yudisium',
            ],
            [
                'jenis_sk' => 'SK Wisuda',
            ],
            [
                'jenis_sk' => 'SK SEMINAR PROPOSAL DAN SIDANG AKHIR',
            ],
            [
                'jenis_sk' => 'SK TOEFL',
            ],
            [
                'jenis_sk' => 'SK BKD',
            ],
            [
                'jenis_sk' => 'SK Ujian Tengah Semester (UTS)',
            ],
            [
                'jenis_sk' => 'SK Ujian Akhir Semester (UAS)',
            ],
            [
                'jenis_sk' => 'SK dan lainnya',
            ],
            [
                'jenis_sk' => 'SK Reviewer',
            ]
        ];

        foreach ($jenissks as $jenissk) {
           JenisSK::create($jenissk);
        }
    }
}
