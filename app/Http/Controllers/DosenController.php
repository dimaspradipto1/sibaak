<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\DataTables\DosenDataTable;
use App\Http\Requests\DosenRequest;
use RealRashid\SweetAlert\Facades\Alert;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DosenDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Dosen';
        $program_studis = ProgramStudi::all();
        return view('pages.dosen.create', compact('program_studis', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DosenRequest $request)
    {
        $data = $request->validated();
        Dosen::create($data);
        Alert::success('Dosen berhasil ditambahkan')
            ->autoClose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('dosen.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        $title = 'Edit Dosen';
        $program_studis = ProgramStudi::all();
        return view('pages.dosen.edit', compact('program_studis', 'title', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DosenRequest $request, Dosen $dosen)
    {
        $dosen->update($request->validated());
        Alert::success('Dosen berhasil diupdate')
            ->autoClose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('dosen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        Alert::success('Dosen berhasil dihapus')
            ->autoClose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('dosen.index');
    }
}
