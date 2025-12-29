<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\TahunAkademikDataTable;
use App\Http\Requests\TahunAkademikRequest;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TahunAkademikDataTable $tahunAkademikDataTable)
    {
        return $tahunAkademikDataTable->render('pages.tahunakademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tahunAkademik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAkademikRequest $request)
    {
        TahunAkademik::create($request->validated());
        Alert::success('success', 'data created successfully')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('tahunAkademik.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAkademik $tahunAkademik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAkademik $tahunAkademik)
    {
        return view('pages.tahunAkademik.edit', compact('tahunAkademik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TahunAkademikRequest $request, TahunAkademik $tahunAkademik)
    {
        $tahunAkademik->update($request->validated());
        Alert::success('success', 'data updated successfully')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('tahunAkademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAkademik $tahunAkademik)
    {
        $tahunAkademik->delete();
        Alert::success('success', 'data deleted successfully')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('tahunAkademik.index');
    }
}
