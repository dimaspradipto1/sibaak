<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosen = [
            [
                'program_studi_id' => 7,
                'nama_dosen' => 'Dr. Army Trilidia Devega, S.Kom, M.Pd.T',
                'nidn' => '1021049204',
                'nup' => '7771019694',
                'nuptk' => '-',
                'email' => 'army@uis.ac.id',
            ],
            [
                'program_studi_id' => 7,
                'nama_dosen' => 'Afrina, S.Kom, M.SI',
                'nidn' => '1003048603',
                'nup' => '7771019699',
                'nuptk' => '-',
                'email' => 'afrina@uis.ac.id',
            ],
        ];

        foreach ($dosen as $dosenData) {
            $d = \App\Models\Dosen::create($dosenData);

            // Link ke Profile
            $user = \App\Models\User::where('email', $d->email)->first();
            if ($user && $user->profile) {
                $user->profile->update([
                    'dosen_id' => $d->id,
                    'nidk' => $d->nidn,
                    'nupn' => $d->nup,
                ]);
            }
        }
    }
}
