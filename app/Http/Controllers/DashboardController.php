<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Pegawai;
use App\Models\Mahasiswa;
use App\Models\SuratAktif;
use App\Models\Wasdalbin;
use App\Models\SkKepanitiaan;
use App\Models\LpjKepanitiaan;
use App\Models\Kurikulum;
use App\Models\Pedoman;
use App\Models\SopAkademik;
use Illuminate\Http\Request;
use App\Models\SuratAkademik;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $user = auth()->user();
        $roleName = $user->role->nama_role ?? '';

        // Data Umum (Untuk Admin/Super Admin)
        $totalUser = User::count();
        $pegawai = Pegawai::count();
        $mahasiswa = Mahasiswa::count();
        $suratAkademikCount = SuratAkademik::count();
        $dosen = Dosen::count();

        // Data Arsip
        $skKepanitiaanCount = SkKepanitiaan::count();
        $lpjKepanitiaanCount = LpjKepanitiaan::count();
        $kurikulumCount = Kurikulum::count();
        $pedomanCount = Pedoman::count();
        $sopAkademikCount = SopAkademik::count();
        $wasdalbinCount = Wasdalbin::count();

        // Statistik Surat Aktif
        $suratAktifpending = SuratAktif::where('status', 'pending')->count() ?: 0;
        $suratAktifDiterima = SuratAktif::where('status', 'diterima')->count() ?: 0;
        $suratAktifDitolak = SuratAktif::where('status', 'ditolak')->count() ?: 0;

        // Dashboard Mahasiswa & User-specific
        $latestSuratAktif = SuratAktif::where('users_id', auth()->id())->latest()->first();
        
        // Data Khusus untuk Role Tertentu (Monitoring)
        $suratMenunggu = [];
        if (str_contains($roleName, 'APPROVAL')) {
            $suratMenunggu = SuratAktif::where('status', 'pending')->latest()->take(5)->get();
        } elseif (str_contains($roleName, 'TATA USAHA')) {
            $suratMenunggu = SuratAktif::latest()->take(5)->get();
        }

        // Data untuk grafik 5 tahun terakhir
        $currentYear = date('Y');
        $chartData = [];
        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - (4 - $i); // Menampilkan 5 tahun terakhir ke belakang
            $chartData[] = [
                'year' => $year,
                'pending' => SuratAktif::where('status', 'pending')->whereYear('created_at', $year)->count(),
                'diterima' => SuratAktif::where('status', 'diterima')->whereYear('created_at', $year)->count(),
                'ditolak' => SuratAktif::where('status', 'ditolak')->whereYear('created_at', $year)->count(),
                'akademik' => SuratAkademik::whereYear('created_at', $year)->count()
            ];
        }

        // Rekapitulasi per Semester (Gasal & Genap)
        // Fetch paginated academic years (5 years per page = 10 rows in the table)
        $yearsPaginated = \App\Models\TahunAkademik::latest()->paginate(5, ['*'], 'rekap_page');
        $rekapSemester = [];

        foreach ($yearsPaginated as $y_obj) {
            $y = $y_obj->tahun_akademik;
            // Logic for Year Row (e.g. 2025/2026)
            $startYear = explode('/', $y)[0];
            $endYear = explode('/', $y)[1] ?? $startYear;

            // Gasal (Ganjil)
            $rekapSemester[$y . ' - Gasal'] = [
                'aktif_pending' => SuratAktif::where('tahun_akademik', $y)->whereIn('status_semester', ['Gasal', 'Ganjil'])->where('status', 'pending')->count(),
                'aktif_diterima' => SuratAktif::where('tahun_akademik', $y)->whereIn('status_semester', ['Gasal', 'Ganjil'])->where('status', 'diterima')->count(),
                'akademik_pending' => SuratAkademik::whereYear('created_at', $startYear)->where(function($q) {
                    $q->where('semester', 'LIKE', '%Ganjil%')->orWhere('semester', 'LIKE', '%Gasal%')->orWhere('semester', 'LIKE', '%I%')->orWhere('semester', 'LIKE', '%III%')->orWhere('semester', 'LIKE', '%V%')->orWhere('semester', 'LIKE', '%VII%');
                })->count(),
                'akademik_diterima' => 0,
            ];

            // Genap
            $rekapSemester[$y . ' - Genap'] = [
                'aktif_pending' => SuratAktif::where('tahun_akademik', $y)->where('status_semester', 'Genap')->where('status', 'pending')->count(),
                'aktif_diterima' => SuratAktif::where('tahun_akademik', $y)->where('status_semester', 'Genap')->where('status', 'diterima')->count(),
                'akademik_pending' => SuratAkademik::whereYear('created_at', $endYear)->where(function($q) {
                    $q->where('semester', 'LIKE', '%Genap%')->orWhere('semester', 'LIKE', '%II%')->orWhere('semester', 'LIKE', '%IV%')->orWhere('semester', 'LIKE', '%VI%')->orWhere('semester', 'LIKE', '%VIII%');
                })->count(),
                'akademik_diterima' => 0,
            ];
        }

        return view('layouts.dashboard.index', compact(
            'yearsPaginated',
            'suratAktifpending',
            'suratAktifDiterima',
            'suratAktifDitolak',
            'totalUser',
            'mahasiswa',
            'pegawai',
            'dosen',
            'suratAkademikCount',
            'skKepanitiaanCount',
            'lpjKepanitiaanCount',
            'kurikulumCount',
            'pedomanCount',
            'sopAkademikCount',
            'wasdalbinCount',
            'chartData',
            'rekapSemester',
            'latestSuratAktif',
            'suratMenunggu',
            'roleName',
            'title'
        ));
    }
}
