<?php

namespace App\Http\Controllers;

use App\Models\JenisSK;
use Illuminate\Http\Request;
use App\DataTables\JenisSKDataTable;
use App\Http\Requests\JenisSKRequest;
use RealRashid\SweetAlert\Facades\Alert;

class JenisSKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( JenisSKDataTable $dataTable)
    {
        return $dataTable->render('pages.jenissk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.jenissk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisSKRequest $request)
    {
        $validated = $request->validated();
        JenisSK::create($validated);
        Alert::success('Data berhasil ditambahkan')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('jenissk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisSK $jenisSK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisSK $jenissk)
    {
        return view('pages.jenissk.edit', compact('jenissk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisSKRequest $request, JenisSK $jenissk)
    {
      
        $jenissk->update($request->validated());
        Alert::success('Data berhasil diupdate')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('jenissk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisSK $jenissk)
    {
        $jenissk->delete();
        Alert::success('Data berhasil dihapus')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('jenissk.index');
    }
}
