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
