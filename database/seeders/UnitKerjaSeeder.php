<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UnitKerja::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. REKTORAT UIS (ROOT)
        $rektorat = UnitKerja::create(['nama_unit' => 'Rektorat UIS', 'kode_unit' => 'UIS', 'parent_id' => null]);
        $rektor = UnitKerja::create(['nama_unit' => 'Rektor', 'kode_unit' => 'REK', 'parent_id' => $rektorat->id]);

        // --- WAKIL REKTOR I ---
        $wr1 = UnitKerja::create(['nama_unit' => 'Wakil Rektor I', 'kode_unit' => 'WR1', 'parent_id' => $rektor->id]);
        $baak = UnitKerja::create(['nama_unit' => 'Ka. Biro Administrasi Akademik Kemahasiswaan (BAAK)', 'kode_unit' => 'BAAK', 'parent_id' => $wr1->id]);

        $kabidAkademik = UnitKerja::create(['nama_unit' => 'Kabid. Akademik', 'kode_unit' => 'K-AKA', 'parent_id' => $baak->id]);
        UnitKerja::create(['nama_unit' => 'Staff Akademik Fakultas Ekonomi Dan Bisnis', 'parent_id' => $kabidAkademik->id]);
        UnitKerja::create(['nama_unit' => 'Staff Akademik Fakultas Sains Dan Teknologi', 'parent_id' => $kabidAkademik->id]);
        UnitKerja::create(['nama_unit' => 'Staff Akademik Fakultas Ilmu Kesehatan', 'parent_id' => $kabidAkademik->id]);

        $kabidLayanan = UnitKerja::create(['nama_unit' => 'Kabid. Administrasi Dan Layanan Kemahasiswaan', 'parent_id' => $baak->id]);
        UnitKerja::create(['nama_unit' => 'Staff Support Layanan Nilai Dan Perkuliahan', 'parent_id' => $kabidLayanan->id]);
        UnitKerja::create(['nama_unit' => 'Staff Support Layanan Ijazah', 'parent_id' => $kabidLayanan->id]);

        $perpus = UnitKerja::create(['nama_unit' => 'Perpustakaan', 'parent_id' => $wr1->id]);
        $kaPerpus = UnitKerja::create(['nama_unit' => 'Kepala Perpustakaan', 'parent_id' => $perpus->id]);
        UnitKerja::create(['nama_unit' => 'Pustakawan', 'parent_id' => $kaPerpus->id]);

        // --- WAKIL REKTOR II ---
        $wr2 = UnitKerja::create(['nama_unit' => 'Wakil Rektor II', 'kode_unit' => 'WR2', 'parent_id' => $rektor->id]);
        $bauk = UnitKerja::create(['nama_unit' => 'Ka. Biro Administrasi Umum Dan Keuangan', 'kode_unit' => 'BAUK', 'parent_id' => $wr2->id]);

        $kabidKeu = UnitKerja::create(['nama_unit' => 'Kabid. Keuangan', 'parent_id' => $bauk->id]);
        UnitKerja::create(['nama_unit' => 'Kasir Rektorat', 'parent_id' => $kabidKeu->id]);
        UnitKerja::create(['nama_unit' => 'Staff Keuangan Fakultas Ekonomi Dan Bisnis', 'parent_id' => $kabidKeu->id]);
        UnitKerja::create(['nama_unit' => 'Staff Keuangan Fakultas Sains Dan Teknologi', 'parent_id' => $kabidKeu->id]);
        UnitKerja::create(['nama_unit' => 'Staff Keuangan Fakultas Ilmu Kesehatan', 'parent_id' => $kabidKeu->id]);

        $kabidSdm = UnitKerja::create(['nama_unit' => 'Kabid. SDM Dan Umum', 'parent_id' => $bauk->id]);
        UnitKerja::create(['nama_unit' => 'Operator SDM', 'parent_id' => $kabidSdm->id]);
        UnitKerja::create(['nama_unit' => 'Staff Kepegawaian', 'parent_id' => $kabidSdm->id]);

        $kabidSarpras = UnitKerja::create(['nama_unit' => 'Kabid. Sarana Dan Prasarana', 'parent_id' => $bauk->id]);
        UnitKerja::create(['nama_unit' => 'Admin Umum Sarpras', 'parent_id' => $kabidSarpras->id]);
        UnitKerja::create(['nama_unit' => 'Staff Sarpras', 'parent_id' => $kabidSarpras->id]);

        UnitKerja::create(['nama_unit' => 'Tata Usaha Rektorat', 'parent_id' => $bauk->id]);

        // --- LPTI ---
        $uptTik = UnitKerja::create(['nama_unit' => 'Lembaga Pengembangan Teknologi dan Informasi (LPTI)', 'kode_unit' => 'LPTI', 'parent_id' => $rektor->id]);
        $kaLpti = UnitKerja::create(['nama_unit' => 'Kepala LPTI', 'parent_id' => $uptTik->id]);
        UnitKerja::create(['nama_unit' => 'Divisi Pengembangan Sistem Informasi Dan Aplikasi', 'parent_id' => $kaLpti->id]);
        UnitKerja::create(['nama_unit' => 'Divisi Infrastruktur, Jaringan, Dan Layanan Troubleshooting', 'parent_id' => $kaLpti->id]);

        // --- WAKIL REKTOR III ---
        $wr3 = UnitKerja::create(['nama_unit' => 'Wakil Rektor III', 'kode_unit' => 'WR3', 'parent_id' => $rektor->id]);
        $kaBiro3 = UnitKerja::create(['nama_unit' => 'Ka. Biro Kemahasiswaan, Alumni, Kerjasama, Perencanaan Dan Pengembangan', 'parent_id' => $wr3->id]);

        $kabidHumas = UnitKerja::create(['nama_unit' => 'Kabid. Humas Dan Publikasi', 'parent_id' => $kaBiro3->id]);
        UnitKerja::create(['nama_unit' => 'Staff Dokumentasi', 'parent_id' => $kabidHumas->id]);
        UnitKerja::create(['nama_unit' => 'Staff Humas', 'parent_id' => $kabidHumas->id]);
        UnitKerja::create(['nama_unit' => 'Staff Website', 'parent_id' => $kabidHumas->id]);

        $kabidKerjasama = UnitKerja::create(['nama_unit' => 'Kabid. Kerjasama', 'parent_id' => $kaBiro3->id]);
        UnitKerja::create(['nama_unit' => 'Staff Kerjasama - Internasional', 'parent_id' => $kabidKerjasama->id]);
        UnitKerja::create(['nama_unit' => 'Staff Kerjasama - Nasional', 'parent_id' => $kabidKerjasama->id]);

        $kabidKemahasiswaan = UnitKerja::create(['nama_unit' => 'Kabid. Kemahasiswaan', 'parent_id' => $kaBiro3->id]);
        UnitKerja::create(['nama_unit' => 'Staff Kemahasiswaan - KIP', 'parent_id' => $kabidKemahasiswaan->id]);
        UnitKerja::create(['nama_unit' => 'Staff Kemahasiswaan - Prestasi Olah Raga', 'parent_id' => $kabidKemahasiswaan->id]);
        UnitKerja::create(['nama_unit' => 'Staff Kemahasiswaan - Prestasi Seni', 'parent_id' => $kabidKemahasiswaan->id]);

        $kabidKarir = UnitKerja::create(['nama_unit' => 'Kabid. Pusat Karir, Alumni Dan Kewirausahaan', 'parent_id' => $kaBiro3->id]);
        UnitKerja::create(['nama_unit' => 'Staff Pusat Karir, Alumni Dan Kewirausahaan', 'parent_id' => $kabidKarir->id]);

        $kabidRenbang = UnitKerja::create(['nama_unit' => 'Kabid. Perencanaan Dan Pengembangan', 'parent_id' => $kaBiro3->id]);
        UnitKerja::create(['nama_unit' => 'Staff Perencanaan Dan Pengembangan', 'parent_id' => $kabidRenbang->id]);

        // 2. LEMBAGA
        $lppm = UnitKerja::create(['nama_unit' => 'LPPM', 'parent_id' => $rektor->id]);
        $kaLppm = UnitKerja::create(['nama_unit' => 'Ka. LPPM', 'parent_id' => $lppm->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Penelitian', 'parent_id' => $kaLppm->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Pengabdian Kepada Masyarakat', 'parent_id' => $kaLppm->id]);
        UnitKerja::create(['nama_unit' => 'Staff Administrasi Penelitian Dan Pengabdian Kepada Masyarakat', 'parent_id' => $kaLppm->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Haki Dan Publikasi', 'parent_id' => $kaLppm->id]);

        $lpmi = UnitKerja::create(['nama_unit' => 'LPMI', 'parent_id' => $rektor->id]);
        $kaLpmi = UnitKerja::create(['nama_unit' => 'Ka. LPMI', 'parent_id' => $lpmi->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Pengembangan SPMI Dan SDM SPMI', 'parent_id' => $kaLpmi->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Sosialisasi SPMI Dan Kerjasama SPMI', 'parent_id' => $kaLpmi->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Akreditasi Dan Dokumentasi', 'parent_id' => $kaLpmi->id]);
        UnitKerja::create(['nama_unit' => 'Kabid. Evaluasi Dan Audit Mutu', 'parent_id' => $kaLpmi->id]);

        // 3. FAKULTAS EKONOMI DAN BISNIS
        $feb = UnitKerja::create(['nama_unit' => 'Fakultas Ekonomi Dan Bisnis', 'parent_id' => $rektor->id]);
        $dekanFeb = UnitKerja::create(['nama_unit' => 'Dekan FEB', 'parent_id' => $feb->id]);
        UnitKerja::create(['nama_unit' => 'Wakil Dekan I (Akademik, Kemahasiswaan Dan Pusat Karir) FEB', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Wakil Dekan II (Administrasi Dan SDM) FEB', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi S1 Manajemen', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Prodi S1 Manajemen', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi S1 Akuntansi', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Prodi S1 Akuntansi', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi Pascasarjana Magister Manajemen', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Prodi Pascasarjana Magister Manajemen', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'UPMI FEB', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'UPPM FEB', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Tata Usaha FEB', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Tata Usaha Pascasarjana FEB', 'parent_id' => $dekanFeb->id]);
        UnitKerja::create(['nama_unit' => 'Humas Dan Publikasi Web FEB', 'parent_id' => $dekanFeb->id]);

        // 4. FAKULTAS SAINS DAN TEKNOLOGI
        $fst = UnitKerja::create(['nama_unit' => 'Fakultas Sains Dan Teknologi', 'parent_id' => $rektor->id]);
        $dekanFst = UnitKerja::create(['nama_unit' => 'Dekan FST', 'parent_id' => $fst->id]);
        UnitKerja::create(['nama_unit' => 'Wakil Dekan I (Akademik, Kemahasiswaan Dan Pusat Karir) FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Wakil Dekan II (Administrasi Dan SDM) FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi Teknik Industri', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Program Studi Teknik Industri', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi Teknik Informatika Dan Prodi Sistem Informasi', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Program Studi Teknik Informatika Dan Prodi Sistem Informasi', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi Teknik Logistik Dan Perkapalan', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Program Studi Teknik Logistik Dan Perkapalan', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Tata Usaha FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'UPMI FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Ka. UPPM FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Staff UPPM FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Ka. Laboratorium Fakultas Sains Dan Teknologi', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Staff Labor Teknik Industri', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Staff Labor Teknik Komputer', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Staff Labor Proses Produksi', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Ka. Humas Dan Publikasi FST', 'parent_id' => $dekanFst->id]);
        UnitKerja::create(['nama_unit' => 'Staff Humas Dan Publikasi FST', 'parent_id' => $dekanFst->id]);

        // 5. FAKULTAS ILMU KESEHATAN
        $fikes = UnitKerja::create(['nama_unit' => 'Fakultas Ilmu Kesehatan', 'parent_id' => $rektor->id]);
        $dekanFikes = UnitKerja::create(['nama_unit' => 'Dekan FIKES', 'parent_id' => $fikes->id]);
        UnitKerja::create(['nama_unit' => 'Wakil Dekan I (Akademik, Kemahasiswaan Dan Pusat Karir) FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Wakil Dekan II (Administrasi Dan SDM) FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi K3', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Prodi K3', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Ketua Program Studi Kesling', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Sekretaris Prodi Kesling', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'UPMI FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'GKM FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'UPPM FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Laboran FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Tata Usaha FIKES', 'parent_id' => $dekanFikes->id]);
        UnitKerja::create(['nama_unit' => 'Humas Dan Publikasi Web FIKES', 'parent_id' => $dekanFikes->id]);
    }
}
