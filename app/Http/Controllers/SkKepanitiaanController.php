<?php

namespace App\Http\Controllers;

use App\Models\JenisSK;
use Illuminate\Http\Request;
use App\Models\SkKepanitiaan;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\SkKepanitiaanDataTable;
use App\Http\Requests\SkKepanitiaanRequest;

class SkKepanitiaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkKepanitiaanDataTable $dataTable)
    {
        return $dataTable->render('pages.skkepanitiaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenissks = JenisSK::all();
        $tahunAkademik = TahunAkademik::all();
        return view('pages.skkepanitiaan.create', compact('jenissks', 'tahunAkademik'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(SkKepanitiaanRequest $request)
    {
        try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('sk_kepanitiaan', $filename, 'public');
                $data['file'] = 'storage/' . $path;
            }

            SkKepanitiaan::create($data);

            Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');
            return redirect()->route('skkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error storing SkKepanitiaan: ' . $th->getMessage());
            Alert::error('Gagal', 'Data Gagal Ditambahkan')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-times-circle"></i>');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(SkKepanitiaan $skkepanitiaan)
    {
        $jenissks = JenisSK::all();
        $tahunAkademik = TahunAkademik::all();
        return view('pages.skkepanitiaan.show', compact('skkepanitiaan', 'jenissks', 'tahunAkademik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkKepanitiaan $skkepanitiaan)
    {
        $jenissks = JenisSK::all();
        $tahunAkademik = TahunAkademik::all();
        return view('pages.skkepanitiaan.edit', compact('skkepanitiaan', 'jenissks', 'tahunAkademik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkKepanitiaanRequest $request, SkKepanitiaan $skkepanitiaan)
    {
        try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($skkepanitiaan->file) {
                    $oldPath = public_path($skkepanitiaan->file);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('sk_kepanitiaan', $filename, 'public');
                $data['file'] = 'storage/' . $path;
            } else {
                unset($data['file']);
            }

            $skkepanitiaan->update($data);

            Alert::success('Berhasil', 'Data Berhasil Diubah')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('skkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error updating SkKepanitiaan: ' . $th->getMessage());
            Alert::error('Gagal', 'Data Gagal Diubah')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-times-circle"></i>');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkKepanitiaan $skkepanitiaan)
    {
        $skkepanitiaan = SkKepanitiaan::findOrFail($skkepanitiaan->id);

        if ($skkepanitiaan->file) {
            $fullPath = public_path($skkepanitiaan->file);

            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $skkepanitiaan->delete();

        Alert::success('Success', 'Data and file deleted successfully')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar();
        return redirect()->route('skkepanitiaan.index');
    }
}
