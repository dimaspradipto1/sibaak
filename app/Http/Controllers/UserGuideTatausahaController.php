<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGuideTatausaha;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\UserGuideTatausahaDataTable;
use App\Http\Requests\UserGuideTatausahaRequest;

class UserGuideTatausahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserGuideTatausahaDataTable $dataTable)
    {
        $title = 'User Guide Tata Usaha';
        return $dataTable->render('pages.userguidetatausaha.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah User Guide Tata Usaha';
        return view('pages.userguidetatausaha.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserGuideTatausahaRequest $request)
    {
        $data = $request->validated();
        UserGuideTatausaha::create($data);
        Alert::success('Success', 'User Guide Tata Usaha berhasil ditambahkan')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('userGuideTatausaha.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserGuideTatausaha $userGuideTatausaha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserGuideTatausaha $userGuideTatausaha)
    {
        $title = 'Edit User Guide Tata Usaha';
        return view('pages.userguidetatausaha.edit', compact('title', 'userGuideTatausaha'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserGuideTatausahaRequest $request, UserGuideTatausaha $userGuideTatausaha)
    {
        $data = $request->validated();
        $userGuideTatausaha->update($data);
        Alert::success('Success', 'User Guide Tata Usaha berhasil diupdate')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('userGuideTatausaha.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserGuideTatausaha $userGuideTatausaha)
    {
        $userGuideTatausaha->delete();
        Alert::success('Success', 'User Guide Tata Usaha berhasil dihapus')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('userGuideTatausaha.index');
    }
}
