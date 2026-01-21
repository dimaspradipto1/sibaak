<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Mahasiswa;
use App\Models\SuratAktif;
use Illuminate\Http\Request;
use App\Models\SuratAkademik;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $user = User::count();
        $pegawai = Pegawai::count();
        $mahasiswa = Mahasiswa::count();
        $suratAkademik = SuratAkademik::count();

        $suratAktifpending = SuratAktif::where('status', 'pending')->count() ?: 0;
        $suratAktifDiterima = SuratAktif::where('status', 'diterima')->count() ?: 0;
        $suratAktifDitolak = SuratAktif::where('status', 'ditolak')->count() ?: 0;

        // Data untuk grafik 5 tahun terakhir
        $currentYear = date('Y');
        $chartData = [];

        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear + $i;

            $pending = SuratAktif::where('status', 'pending')
                ->whereYear('created_at', $year)
                ->count();

            $diterima = SuratAktif::where('status', 'diterima')
                ->whereYear('created_at', $year)
                ->count();

            $ditolak = SuratAktif::where('status', 'ditolak')
                ->whereYear('created_at', $year)
                ->count();

            $akademik = SuratAkademik::whereYear('created_at', $year)
                ->count();

            $chartData[] = [
                'year' => $year,
                'pending' => $pending,
                'diterima' => $diterima,
                'ditolak' => $ditolak,
                'akademik' => $akademik
            ];
        }

        $latestSuratAktif = SuratAktif::where('users_id', auth()->id())->latest()->first();

        return view('layouts.dashboard.index', compact(
            'suratAktifpending',
            'suratAktifDiterima',
            'suratAktifDitolak',
            'user',
            'mahasiswa',
            'pegawai',
            'suratAkademik',
            'chartData',
            'latestSuratAktif',
            'title' 
        ));
    }
}
