<?php

namespace App\Http\Controllers;

use App\Models\KategoriArsip;
use Illuminate\Http\Request;
use App\DataTables\KategoriArsipDataTable;
use App\Http\Requests\KategoriArsipRequest;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KategoriArsipDataTable $dataTable)
    {
        $title = 'Kategori Arsip';
        return $dataTable->render('pages.kategoriarsip.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Kategori Arsip';
        return view('pages.kategoriarsip.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriArsipRequest $request)
    {
        $validated = $request->validated();
        KategoriArsip::create($validated);
        Alert::success('Data berhasil ditambahkan')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('kategoriarsip.index');
    }

    public function storeAjax(KategoriArsipRequest $request)
    {
        $validated = $request->validated();
        $kategori = KategoriArsip::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data'    => $kategori
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriArsip $kategoriarsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriArsip $kategoriarsip)
    {
        $title = 'Form Kategori Arsip';
        return view('pages.kategoriarsip.edit', compact('kategoriarsip', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriArsipRequest $request, KategoriArsip $kategoriarsip)
    {
        $kategoriarsip->update($request->validated());
        Alert::success('Data berhasil diupdate')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('kategoriarsip.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriArsip $kategoriarsip)
    {
        $kategoriarsip->delete();
        Alert::success('Data berhasil dihapus')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('kategoriarsip.index');
    }
}
