<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaData = [
            [
                'email'           => 'mahasiswa@uis.ac.id',
                'program_studi_id'=> 7,
                'npm'             => '20240101001',
                'tempat_lahir'    => 'Pekanbaru',
                'tgl_lahir'       => '2002-05-15',
                'no_wa'           => '081234567890',
                'alamat'          => 'Jl. Jend. Sudirman No. 12',
                'semester'        => 4,
                'fakultas'        => 'Fakultas Sains dan Teknologi',
                'jenjang_pendidikan' => 'S1',
            ],
            [
                'email'           => 'mahasiswa2@uis.ac.id',
                'program_studi_id'=> 7,
                'npm'             => '20240101002',
                'tempat_lahir'    => 'Jakarta',
                'tgl_lahir'       => '2003-08-20',
                'no_wa'           => '081234567891',
                'alamat'          => 'Jl. Gatot Subroto No. 45',
                'semester'        => 2,
                'fakultas'        => 'Fakultas Sains dan Teknologi',
                'jenjang_pendidikan' => 'S1',
            ],
        ];

        foreach ($mahasiswaData as $data) {
            $email = $data['email'];
            unset($data['email']);

            $user = User::where('email', $email)->first();
            if (!$user) continue;

            $data['users_id'] = $user->id;
            $m = Mahasiswa::create($data);

            // Link ke Profile
            if ($user->profile) {
                $user->profile->update([
                    'mahasiswa_id' => $m->id,
                    'npm'          => $m->npm,
                    'tempat_lahir' => $m->tempat_lahir,
                    'tgl_lahir'    => $m->tgl_lahir,
                    'no_wa'        => $m->no_wa,
                    'alamat'       => $m->alamat,
                ]);
            }
        }
    }
}
