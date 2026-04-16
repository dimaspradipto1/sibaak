<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nama_role' => 'MAHASISWA'],
            ['nama_role' => 'SUPER ADMIN'],
            ['nama_role' => 'ADMIN'],
            ['nama_role' => 'APPROVAL'],
            ['nama_role' => 'REKTOR'],
            ['nama_role' => 'WAKIL REKTOR 1'],
            ['nama_role' => 'WAKIL REKTOR 2'],
            ['nama_role' => 'WAKIL REKTOR 3'],

            ['nama_role' => 'KEPALA. BAAK'],
            ['nama_role' => 'KABID. AKADEMIK'],
            ['nama_role' => 'STAFF AKADEMIK FAKULTAS EKONOMI DAN BISNIS'],
            ['nama_role' => 'STAFF AKADEMIK FAKULTAS TEKNIK'],
            ['nama_role' => 'STAFF AKADEMIK FAKULTAS ILMU KESEHATAN'],

            ['nama_role' => 'KABID. ADMINISTRASI DAN LAYANAN KEMAHASISWAAN'],
            ['nama_role' => 'STAFF - SUPPORT LAYANAN NILAI DAN PERKULIAHAN'],
            ['nama_role' => 'STAFF - SUPPORT LAYANAN IJAZAH'],

            ['nama_role' => 'KEPALA PUSTAKA'],
            ['nama_role' => 'PUSTAKAWAN'],

            ['nama_role' => 'KABID. KEUANGAN'],
            ['nama_role' => 'KABID. KEMAHASISWAAN'],
            ['nama_role' => 'KA. BAUK'],
            ['nama_role' => 'KABID. KEUANGAN'],
            ['nama_role' => 'STAFF KEUANGAN'],
            ['nama_role' => 'KABID. SDM DAN UMUM'],
            ['nama_role' => 'OPERATOR SDM'],
            ['nama_role' => 'STAFF KEPEGAWAIAN'],
            ['nama_role' => 'KABID.SARANA DAN PRASARANA'],
            ['nama_role' => 'ADMIN UMUM SARPRAS'],
            ['nama_role' => 'STAFF SARPRAS'],
            ['nama_role' => 'TATA USAHA REKTORAT'],
            ['nama_role' => 'KEPALA LPTI'],
            ['nama_role' => 'DIVISI PENGEMBANGAN SISTEM INFORMASI DAN APLIKASI'],
            ['nama_role' => 'DIVISI INFRASTRUKTUR, JARINGAN, DAN LAYANAN TROUBLESHOOTING'],
            ['nama_role' => 'KEPALA BKAK'],
            ['nama_role' => 'KABID. HUMAS DAN PUBLIKASI'],
            ['nama_role' => 'STAFF DOKUMENTASI'],
            ['nama_role' => 'STAFF HUMAS'],
            ['nama_role' => 'STAFF WEBSITE'],
            ['nama_role' => 'KABID. KERJASAMA'],
            ['nama_role' => 'STAFF KERJASAMA'],
            ['nama_role' => 'KABID. KEMAHASISWAAN'],
            ['nama_role' => 'STAFF KEMAHASISWAAN - KIP'],
            ['nama_role' => 'STAFF KEMAHASISWAAN - PRESTASI OLAH RAGA'],
            ['nama_role' => 'STAFF KEMAHASISWAAN - PRESTASI SENI'],
            ['nama_role' => 'KABID. PUSAT KARIR, ALUMNI DAN KEWIRAUSAHAAN'],
            ['nama_role' => 'STAFF PUSAT KARIR, ALUMNI DAN KEWIRAUSAHAAN'],
            ['nama_role' => 'KABID. PERENCANAAN DAN PENGEMBANGAN'],
            ['nama_role' => 'KA. LPPM'],
            ['nama_role' => 'KABID. PENELITIAN'],
            ['nama_role' => 'KABID. PENGABDIAN KEPADA MASYARAKAT'],
            ['nama_role' => 'STAFF ADMINITRASI PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT'],
            ['nama_role' => 'KABID. HAKI DAN PUBLIKASI'],
            ['nama_role' => 'KA. LPMI'],
            ['nama_role' => 'KABID. PENGEMBANGAN SPMI DAN SDM SPMI'],
            ['nama_role' => 'KABID. SOSIALISASI SPMI DAN KERJASAMA SPMI'],
            ['nama_role' => 'KABID. AKREDITASI DAN DOKUMENTASI'],
            ['nama_role' => 'KABID. EVALUASI DAN AUDIT MUTU'],

            ['nama_role' => 'DEKAN FAKULTAS EKONOMI DAN BISNIS'],
            ['nama_role' => 'WAKIL DEKAN I FAKULTAS EKONOMI DAN BISNIS'],
            ['nama_role' => 'WAKIL DEKAN II FAKULTAS EKONOMI DAN BISNIS'],
            ['nama_role' => 'KETUA PROGRAM STUDI S1 MANAJEMEN'],
            ['nama_role' => 'SEKRETARIS PRODI S1 MANAJEMEN'],
            ['nama_role' => 'KETUA PROGRAM STUDI S1 AKUNTANSI'],
            ['nama_role' => 'SEKRETARIS PRODI S1 AKUNTANSI'],
            ['nama_role' => 'KETUA PROGRAM STUDI PASCASARJANA MAGISTER MANAJEMEN'],
            ['nama_role' => 'SEKRETARIS PRODI PASCASARJANA MAGISTER MANAJEMEN'],
            ['nama_role' => 'UPMI'],
            ['nama_role' => 'UPPM'],
            ['nama_role' => 'TATA USAHA SARJANA'],
            ['nama_role' => 'TATA USAHA PASCASARJANA'],
            ['nama_role' => 'HUMAS DAN PUBLIKASI WEB'],

            ['nama_role' => 'DEKAN FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'WAKIL DEKAN I FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'WAKIL DEKAN II FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'KETUA PROGRAM STUDI TEKNIK INDUSTRI'],
            ['nama_role' => 'SEKRETARIS PROGRAM STUDI TEKNIK INDUSTRI'],
            ['nama_role' => 'KETUA PROGRAM STUDI TEKNIK INFORMATIKA DAN PRODI SISTEM INFORMASI'],
            ['nama_role' => 'SEKRETARIS PROGRAM STUDI TEKNIK INFORMATIKA DAN PRODI SISTEM INFORMASI'],
            ['nama_role' => 'KETUA PROGRAM STUDI TEKNIK LOGISTIK DAN PERKAPALAN'],
            ['nama_role' => 'SEKRETARIS PROGRAM STUDI TEKNIK LOGISTIK DAN PERKAPALAN'],
            ['nama_role' => 'TATA USAHA FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'UPMI FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'KA. UPPM FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'STAFF UPPM FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'KA. LABORATORIUM FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'STAFF LABOR TEKNIK INDUSTRI FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'STAFF LABOR TEKNIK INFORMATIKA DAN PRODI SISTEM INFORMASI FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'STAFF LABOR TEKNIK LOGISTIK DAN PERKAPALAN FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'KA. HUMAS DAN PUBLIKASI FAKULTAS SAINS DAN TEKNOLOGI'],
            ['nama_role' => 'STAFF HUMAS DAN PUBLIKASI FAKULTAS SAINS DAN TEKNOLOGI'],

            ['nama_role' => 'DEKAN FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'WAKIL DEKAN I FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'WAKIL DEKAN II FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'KETUA PROGRAM STUDI K3'],
            ['nama_role' => 'SEKRETARIS PRODI K3'],
            ['nama_role' => 'KETUA PROGRAM STUDI KESLING'],
            ['nama_role' => 'SEKRETARIS PRODI KESLING'],
            ['nama_role' => 'UPMI FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'GKM FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'UPPM FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'LABORAN FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'TATA USAHA FAKULTAS ILMU KESEHATAN'],
            ['nama_role' => 'HUMAS DAN PUBLIKASI WEB FAKULTAS ILMU KESEHATAN'],

            
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
