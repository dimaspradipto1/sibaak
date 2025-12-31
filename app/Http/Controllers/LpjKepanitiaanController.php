<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use App\Models\LpjKepanitiaan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\LpjKepanitiaanDataTable;
use App\Http\Requests\LpjKepanitiaanRequest;

class LpjKepanitiaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LpjKepanitiaanDataTable $dataTable)
    {
        return $dataTable->render('pages.lpjkepanitiaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAkademik = TahunAkademik::all();
        $users = User::all();
        return view('pages.lpjkepanitiaan.create', compact('tahunAkademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LpjKepanitiaanRequest $request)
    {
        try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('lpj_kepanitiaan', $filename, 'public');
                $data['file'] = 'storage/' . $path;
            }

            LpjKepanitiaan::create($data);

            Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');
            return redirect()->route('lpjkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error storing LpjKepanitiaan: ' . $th->getMessage());
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
    public function show(LpjKepanitiaan $lpjkepanitiaan)
    {
        $tahunAkademik = TahunAkademik::all();
        $users = User::all();
        return view('pages.lpjkepanitiaan.show', compact('lpjkepanitiaan', 'tahunAkademik', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LpjKepanitiaan $lpjkepanitiaan)
    {
        $tahunAkademik = TahunAkademik::all();
        $users = User::all();
        return view('pages.lpjkepanitiaan.edit', compact('lpjkepanitiaan', 'tahunAkademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LpjKepanitiaanRequest $request, LpjKepanitiaan $lpjkepanitiaan)
    {
        try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($lpjkepanitiaan->file) {
                    $oldPath = public_path($lpjkepanitiaan->file);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('lpj_kepanitiaan', $filename, 'public');
                $data['file'] = 'storage/' . $path;
            } else {
                unset($data['file']);
            }

            $lpjkepanitiaan->update($data);

            Alert::success('Berhasil', 'Data Berhasil Diubah')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('lpjkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error updating LpjKepanitiaan: ' . $th->getMessage());
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
    public function destroy(LpjKepanitiaan $lpjkepanitiaan)
    {
        $lpjkepanitiaan = LpjKepanitiaan::findOrFail($lpjkepanitiaan->id);

        if ($lpjkepanitiaan->file) {
            $fullPath = public_path($lpjkepanitiaan->file);

            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $lpjkepanitiaan->delete();

        Alert::success('Success', 'Data and file deleted successfully')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar();
        return redirect()->route('lpjkepanitiaan.index');
    }
}
