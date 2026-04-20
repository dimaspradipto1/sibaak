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
        $suratAkademik = SuratAkademik::count();
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

        return view('layouts.dashboard.index', compact(
            'suratAktifpending',
            'suratAktifDiterima',
            'suratAktifDitolak',
            'totalUser',
            'mahasiswa',
            'pegawai',
            'dosen',
            'suratAkademik',
            'skKepanitiaanCount',
            'lpjKepanitiaanCount',
            'kurikulumCount',
            'pedomanCount',
            'sopAkademikCount',
            'wasdalbinCount',
            'chartData',
            'latestSuratAktif',
            'suratMenunggu',
            'roleName',
            'title'
        ));
    }
}
