<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\DataTables\ProgramStudiDataTable;
use App\Http\Requests\ProgramStudiRequest;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProgramStudiDataTable $dataTable)
    {
        return $dataTable->render('pages.programStudi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.programStudi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgramStudiRequest $request)
    {
        ProgramStudi::create($request->validated());
        return redirect()->route('programStudi.index')->with('success', 'Program Studi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudi $programStudi)
    {
        return view('pages.programStudi.edit', compact('programStudi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramStudiRequest $request, ProgramStudi $programStudi)
    {
        $programStudi->update($request->validated());
        return redirect()->route('programStudi.index')->with('success', 'Program Studi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {
        $programStudi->delete();
        return redirect()->route('programStudi.index')->with('success', 'Program Studi berhasil dihapus');
    }
}
