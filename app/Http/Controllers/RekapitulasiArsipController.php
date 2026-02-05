<?php

namespace App\Http\Controllers;

use App\Models\Pedoman;
use App\Models\Kurikulum;
use App\Models\Wasdalbin;
use App\Models\SopAkademik;
use Illuminate\Http\Request;
use App\Models\SkKepanitiaan;
use App\Models\TahunAkademik;
use App\Models\LpjKepanitiaan;
use App\Models\RekapitulasiArsip;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapitulasiArsipExport;

class RekapitulasiArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Rekapitulasi Arsip';
        $tahunAkademik = TahunAkademik::all();
        return view('pages.rekapitulasiarsip.index', compact('title', 'tahunAkademik'));
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        $tahun = $request->input('tahun');
        $tahunAkademikId = $request->input('tahun_akademik_id');
        $semester = $request->input('semester');
        $jenisArsip = $request->input('users_id'); // View menggunakan users_id untuk jenis arsip
        $fakultas = $request->input('homebase');   // View menggunakan homebase untuk fakultas

        return Excel::download(
            new RekapitulasiArsipExport($tahun, $tahunAkademikId, $semester, $jenisArsip, $fakultas),
            'rekapitulasi_arsip_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RekapitulasiArsip $rekapitulasiArsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekapitulasiArsip $rekapitulasiArsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekapitulasiArsip $rekapitulasiArsip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekapitulasiArsip $rekapitulasiArsip)
    {
        //
    }
}
