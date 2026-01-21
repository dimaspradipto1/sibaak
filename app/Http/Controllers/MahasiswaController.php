<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\MahasiswaDataTable;
use App\Http\Requests\MahasiswaRequest;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MahasiswaDataTable $dataTable)
    {
        $title ='Mahasiswa';
        return $dataTable->render('pages.mahasiswa.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Mahasiswa';
        $isMahasiswa = Mahasiswa::where('users_id', Auth::id())->exists();
        $programStudi = ProgramStudi::all();
        $users = User::where('is_mahasiswa', true)->get();
        return view('pages.mahasiswa.create', compact('users', 'programStudi', 'isMahasiswa', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request)
    {
        $data = $request->validated();

        if (Auth::user()->is_mahasiswa) {
            // Menambahkan `users_id` dari user yang login
            $data['users_id'] = Auth::id();
        }

        Mahasiswa::create($data);
        Alert::success('Mahasiswa berhasil ditambahkan')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('mahasiswa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        // Memuat relasi 'user' dan 'programStudi'
        $mahasiswa = Mahasiswa::with('user', 'programStudi')->findOrFail($mahasiswa->id);
        $programStudi = ProgramStudi::all();
        return view('pages.mahasiswa.show', compact('mahasiswa', 'programStudi'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $title = 'Form Mahasiswa';
        $users = User::where('is_mahasiswa', true)->get();
        $programStudi = ProgramStudi::all();
        return view('pages.mahasiswa.edit', compact('mahasiswa', 'programStudi', 'users', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($request->all());
        Alert::success('Mahasiswa berhasil diupdate')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        Alert::success('Mahasiswa berhasil dihapus')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('mahasiswa.index');
    }
}
