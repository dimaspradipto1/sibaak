<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use App\Models\SuratAktif;
use App\Exports\RekapitulasiSuratAktifExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapitulasiSuratAktifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Rekapitulasi Surat Aktif';
        $tahunAkademik = TahunAkademik::all();
        $query = SuratAktif::query();

        if ($request->filled('tahun_akademik_id')) {
            $ta = TahunAkademik::find($request->tahun_akademik_id);
            if ($ta) {
                $query->where('tahun_akademik', $ta->tahun_akademik);
            }
        }

        if ($request->filled('semester')) {
            $query->where('status_semester', $request->semester);
        }

        if ($request->filled('homebase')) {
            $query->where('fakultas', $request->homebase);
        }

        $rekapitulasiSuratAktif = $query->latest()->get();
        return view('pages.rekapitulasisurataktif.index', compact('title', 'tahunAkademik', 'rekapitulasiSuratAktif'));
    }

    public function export(Request $request)
    {
        $tahunAkademikId = $request->input('tahun_akademik_id');
        $semester = $request->input('semester'); // Ini Ganjil/Genap, mapping ke status_semester
        $fakultas = $request->input('homebase');

        return Excel::download(new RekapitulasiSuratAktifExport($tahunAkademikId, $semester, $fakultas), 'Rekapitulasi_Surat_Aktif.xlsx');
    }
}
