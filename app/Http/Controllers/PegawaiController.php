<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DataTables\PegawaiDataTable;
use App\Http\Requests\PegawaiRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PegawaiDataTable $pegawaiDataTable)
    {
        $title = 'Pegawai';
        return $pegawaiDataTable->render('pages.pegawai.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Pegawai';
        $users = User::all();
        return view('pages.pegawai.create', compact('users', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        try {
            $pegawai = new Pegawai();
            $pegawai->users_id = $request->users_id;
            $pegawai->jabatan  = $request->jabatan;
            $pegawai->nidn     = $request->nidn;

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->extension() ?: $file->getClientOriginalExtension();
                $extension = $file->extension();

                if ($pegawai->file && file_exists(public_path('storage/pegawai/' . $pegawai->file))) {
                    unlink(public_path('storage/pegawai/' . $pegawai->file));  // Menghapus file lama
                }

                $path = $file->storeAs('pegawai', $file->getClientOriginalName(), 'public');
                $pegawai->file = 'storage/' . $path;
            } else {
                $pegawai->file = null;
            }

            $pegawai->save();

            Alert::success('Success', 'Data created successfully')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('pegawai.index');
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan pegawai: ' . $e->getMessage());
            Alert::error('Error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-times-circle"></i>');
            return back()->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        return view('pages.pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $title = 'Form Pegawai';
        $users = User::all();
        return view('pages.pegawai.edit', compact('pegawai', 'users', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Pegawai $pegawai)
{
    // Validasi input
    $request->validate([
        'url'         => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // File opsional
        'users_id'    => 'required|exists:users,id',
        'jabatan'     => 'required|string',
        'nidn'        => 'required|string',
    ]);

    // Mengupdate data lainnya
    $pegawai->users_id = $request->users_id;
    $pegawai->jabatan  = $request->jabatan;
    $pegawai->nidn     = $request->nidn;

    // Cek jika ada file gambar yang diupload
    if ($request->hasFile('url')) {
        // Cek jika pegawai sudah memiliki file
        if ($pegawai->file && file_exists(public_path('storage/pegawai/' . $pegawai->file))) {
            // Hapus file lama jika ada
            unlink(public_path('storage/pegawai/' . $pegawai->file));  // Menghapus file lama
            Log::info('File lama dihapus: ' . public_path('storage/pegawai/' . $pegawai->file)); // Log penghapusan file
        }

        // Mengambil file yang diupload
        $file = $request->file('url');

        // Mendapatkan nama asli file yang diupload
        $filename = $file->getClientOriginalName();  // Nama file yang asli

        // Log nama file yang diupload
        Log::info('File baru yang diupload: ' . $filename); 

        // Simpan file baru dengan nama asli di folder 'pegawai' di storage
        $file->storeAs('pegawai', $filename, 'public');

        // Memperbarui path file di database
        $pegawai->file = 'storage/pegawai/' . $filename;
    }

    // Simpan perubahan data pegawai
    $pegawai->save();

    // Menampilkan notifikasi sukses
    Alert::success('Success', 'Data updated successfully')
        ->autoclose(3000)
        ->toToast()
        ->timerProgressBar()
        ->iconHtml('<i class="fa fa-check-circle"></i>');

    return redirect()->route('pegawai.index');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai = Pegawai::findOrFail($pegawai->id);

        if ($pegawai->file) {
            $fullPath = public_path($pegawai->file);

            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $pegawai->delete();

        Alert::success('Success', 'Data and file deleted successfully')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar();
        return redirect()->route('pegawai.index');
    }
}
