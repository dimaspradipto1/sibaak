<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawai = [
            [
                'users_id' => 2,
                'nama_staff' => 'LENI UTAMI, S.Si., M.KM',
                'jabatan' => 'KA. BIRO ADMINISTRASI AKADEMIK KEMAHASISWAAN (BAAK)',
                'nidn' => '1001057904',
                'nup' => '-',
                'homebase' => 'Fakultas Ilmu Kesehatan (FIKES)',
            ],
            [
                'users_id' => 3,
                'nama_staff' => 'Andi Hidayatul Fadlilah, SE,M. Si.AK',
                'jabatan' => 'KA. BIRO ADMINISTRASI UMUM DAN KEUANGAN',
                'nidn' => '1011088401',
                'nup' => '-',
                'homebase' => 'Fakultas Ekonomi dan Bisnis (FEB)',
            ],
        ];

        foreach ($pegawai as $pegawaiData) {
            $p = \App\Models\Pegawai::create($pegawaiData);

            // Link ke Profile
            $user = \App\Models\User::find($p->users_id);
            if ($user && $user->profile) {
                $user->profile->update([
                    'pegawai_id' => $p->id,
                    'nidk' => $p->nidn, // Menggunakan NIDN sebagai NIDK sementara jika diperlukan sesuai screenshot
                    'tempat_lahir' => $p->tempat_lahir,
                    'tgl_lahir' => $p->tgl_lahir,
                    'no_wa' => $p->no_wa,
                    'alamat' => $p->alamat,
                ]);
            }
        }
    }
}
