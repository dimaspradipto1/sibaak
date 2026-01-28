<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\SuratAkademik;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\SuratAkademikDataTable;

class SuratAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SuratAkademikDataTable $dataTable)
    {
        $title = 'Surat Akademik';
        return $dataTable->render('pages.suratAkademik.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::all();
        $title = 'Form Surat Akademik';
        $users = User::where('is_mahasiswa', true)->get();
        $programStudi = ProgramStudi::all();
        return view('pages.suratAkademik.create', compact('users', 'programStudi', 'title', 'dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('users_id', $request->users_id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan!');
        }

        if (!$mahasiswa->programStudi) {
            return redirect()->back()->with('error', 'Program studi mahasiswa tidak ditemukan!');
        }

        $data = [
            'users_id' => $request->users_id,
            'program_studi_id' => $mahasiswa->programStudi->id,
            'npm' => $mahasiswa->npm,
            'status_cuti' => 'Belum Pernah Cuti',
            'alamat' => $mahasiswa->alamat,
            'no_wa' => $mahasiswa->no_wa,
            'semester' => $request->semester,
            'permohonan' => $request->permohonan,
            'alasan_cuti' => $request->alasan_cuti,
            'dosen_pembimbing_akademik' => $request->dosen_pembimbing_akademik,
            'kaprodi' => $request->kaprodi,
            'kabaak'=>$request->kabaak,
            'kabauk'=>$request->kabauk,
        ];

        SuratAkademik::create($data);
        Alert::success('success', 'Data berhasil dibuat')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-circle-check"></i>');

        return redirect()->route('suratAkademik.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratAkademik $suratAkademik)
    {

        $mahasiswa = Mahasiswa::where('users_id', $suratAkademik->users_id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan!');
        }

        $dosen = Dosen::find($suratAkademik->dosen_pembimbing_akademik);
        $kaprodi = Dosen::find($suratAkademik->kaprodi);
        $programStudi = ProgramStudi::find($mahasiswa->program_studi_id);
        $fakultas = $mahasiswa->fakultas;
        $user = User::find($suratAkademik->users_id);
        $no_surat = SuratAkademik::count();
        return view('pages.suratAkademik.show', compact('suratAkademik', 'mahasiswa', 'programStudi', 'user', 'no_surat', 'fakultas', 'dosen', 'kaprodi')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratAkademik $suratAkademik)
    {
        $title = 'Form Surat Akademik';
        return view('pages.suratAkademik.edit', compact('suratAkademik', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratAkademik $suratAkademik)
    {
        $suratAkademik->update($request->all());
        Alert::success('success', 'data updated successfully')->autoclose(3000)->toToast();
        return redirect()->route('suratAkademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratAkademik $suratAkademik)
    {
        $suratAkademik->delete();
        Alert::success('success', 'data deleted successfully')->autoclose(3000)->toToast();
        return redirect()->route('suratAkademik.index');
    }
}
