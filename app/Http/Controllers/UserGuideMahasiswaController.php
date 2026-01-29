<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGuideMahasiswa;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\UserGuideMahasiswaDataTable;
use App\Http\Requests\UserGuidemahasiswaRequest;

class UserGuideMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserGuideMahasiswaDataTable $dataTable)
    {
        $title = 'User Guide Mahasiswa';
        return $dataTable->render('pages.userguidemahasiswa.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah User Guide Mahasiswa';
        return view('pages.userguidemahasiswa.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserGuidemahasiswaRequest $request)
    {
        $data = $request->validated();
        UserGuideMahasiswa::create($data);
        Alert::success('success', 'Data berhasil ditambahkan')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('userGuideMahasiswa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserGuideMahasiswa $userGuideMahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserGuideMahasiswa $userGuideMahasiswa)
    {
        $title = 'Edit User Guide Mahasiswa';
        return view('pages.userguidemahasiswa.edit', compact('title', 'userGuideMahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserGuidemahasiswaRequest $request, UserGuideMahasiswa $userGuideMahasiswa)
    {
        $data = $request->validated();
        $userGuideMahasiswa->update($data);
        Alert::success('success', 'Data berhasil diupdate')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('userGuideMahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserGuideMahasiswa $userGuideMahasiswa)
    {
        $userGuideMahasiswa->delete();
        Alert::success('success', 'Data berhasil dihapus')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('userGuideMahasiswa.index');
    }
}
