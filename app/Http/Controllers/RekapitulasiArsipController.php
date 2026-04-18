<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Pedoman;
use App\Models\Kurikulum;
use App\Models\Wasdalbin;
use App\Models\ArsipUtama;
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
    public function index(Request $request)
    {
        $title = 'Rekapitulasi Arsip';
        $tahunAkademik = TahunAkademik::all();
        $roles = Role::all();
        
        $jenisArsip = $request->input('users_id');
        $rekapitulasis = collect();

        if ($jenisArsip == 'ArsipUtama') {
            $query = ArsipUtama::query();
            
            if ($request->filled('tahun')) {
                $query->where('tahun_arsip', $request->tahun);
            }

            if ($request->filled('homebase')) { // now used for role_id
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('role_id', $request->homebase);
                });
            }

            $rekapitulasis = $query->with('user')->latest()->paginate(10)->through(function($item) {
                // Map to a common format or keep as object and handle in view
                $item->jenis_arsip = 'ArsipUtama';
                return $item;
            });
            $rekapitulasis->appends($request->all());
        } else {
            $query = RekapitulasiArsip::query();

            if ($request->filled('tahun_akademik_id')) {
                $query->where('tahun_akademik_id', $request->tahun_akademik_id);
            }

            if ($request->filled('semester')) {
                $query->where('semester', $request->semester);
            }

            if ($request->filled('users_id')) {
                $query->where('jenis_arsip', $request->users_id);
            }

            if ($request->filled('homebase')) { // now used for role_id
                $roleId = $request->homebase;
                $query->where(function($q) use ($roleId) {
                    $q->whereHas('skKepanitiaan.users', function($sub) use ($roleId) { $sub->where('role_id', $roleId); })
                      ->orWhereHas('lpjKepanitiaan.users', function($sub) use ($roleId) { $sub->where('role_id', $roleId); })
                      ->orWhereHas('kurikulum.user', function($sub) use ($roleId) { $sub->where('role_id', $roleId); })
                      ->orWhereHas('pedoman.users', function($sub) use ($roleId) { $sub->where('role_id', $roleId); })
                      ->orWhereHas('sopAkademik.users', function($sub) use ($roleId) { $sub->where('role_id', $roleId); })
                      ->orWhereHas('wasdalbin.users', function($sub) use ($roleId) { $sub->where('role_id', $roleId); });
                });
            }

            $rekapitulasis = $query->with(['tahunAkademik', 'skKepanitiaan', 'kurikulum', 'pedoman', 'sopAkademik', 'wasdalbin', 'lpjKepanitiaan'])
                                   ->latest()
                                   ->paginate(10)
                                   ->appends($request->all());
        }

        return view('pages.rekapitulasiarsip.index', compact('title', 'tahunAkademik', 'rekapitulasis', 'roles'));
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        $tahun = $request->input('tahun');
        $tahunAkademikId = $request->input('tahun_akademik_id');
        $semester = $request->input('semester');
        $jenisArsip = $request->input('users_id');
        $fakultas = $request->input('homebase');

        if ($jenisArsip == 'ArsipUtama') {
            // We might need a separate export or update the existing one
            // For now, let's stick to the pattern if possible
        }

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
