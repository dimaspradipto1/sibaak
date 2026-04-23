<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\DataTables\UnitKerjaDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UnitKerjaController extends Controller
{
    public function index(UnitKerjaDataTable $dataTable)
    {
        $title = 'Master Unit Kerja';
        return $dataTable->render('pages.unitkerja.index', compact('title'));
    }

    public function create()
    {
        $title = 'Form Unit Kerja Baru';
        $parents = UnitKerja::orderBy('nama_unit')->get();
        return view('pages.unitkerja.create', compact('title', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'kode_unit' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:unit_kerjas,id'
        ]);

        UnitKerja::create($request->all());

        Alert::success('Berhasil', 'Unit Kerja berhasil ditambahkan');
        return redirect()->route('unitkerja.index');
    }

    public function edit(UnitKerja $unitkerja)
    {
        $title = 'Edit Unit Kerja';
        $parents = UnitKerja::where('id', '!=', $unitkerja->id)->orderBy('nama_unit')->get();
        return view('pages.unitkerja.edit', compact('title', 'unitkerja', 'parents'));
    }

    public function update(Request $request, UnitKerja $unitkerja)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'kode_unit' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:unit_kerjas,id'
        ]);

        $unitkerja->update($request->all());

        Alert::success('Berhasil', 'Unit Kerja berhasil diperbarui');
        return redirect()->route('unitkerja.index');
    }

    public function destroy(UnitKerja $unitkerja)
    {
        $unitkerja->delete();
        Alert::success('Berhasil', 'Unit Kerja berhasil dihapus');
        return redirect()->route('unitkerja.index');
    }
}
