<?php

namespace App\Http\Controllers;

use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use App\Models\User;
use App\Models\TahunAkademik;
use App\Models\LpjKepanitiaan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\LpjKepanitiaanDataTable;
use App\Http\Requests\LpjKepanitiaanRequest;


use App\Traits\HandleGoogleDrive;



class LpjKepanitiaanController extends Controller
{
    use HandleGoogleDrive;

    /**
     * Display a listing of the resource.
     */
    public function index(LpjKepanitiaanDataTable $dataTable)
    {
        $title = 'LPJ Kepanitiaan';
        return $dataTable->render('pages.lpjkepanitiaan.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form LPJ Kepanitiaan';
        $tahunAkademik = TahunAkademik::all();
        $users = User::all();
        return view('pages.lpjkepanitiaan.create', compact('tahunAkademik', 'users', 'title'));
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
                $uploaded = $request->file('file');
                $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());
                $filename = $safeOriginal;

                // Upload via Google Drive API
                $service = $this->driveService();
                $lpjFolderId = env('GOOGLE_DRIVE_LPJ_FOLDER_ID');

                if (!$lpjFolderId) {
                    throw new \Exception('GOOGLE_DRIVE_LPJ_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name' => $filename,
                    'parents' => [$lpjFolderId],
                ]);

                $content = File::get($uploaded->getRealPath());

                $file = $service->files->create($fileMetadata, [
                    'data' => $content,
                    'uploadType' => 'multipart',
                    'fields' => 'id',
                ]);

                $fileId = $file->getId();

                // Jadikan public
                $this->makeDriveFilePublic($fileId);

                // Simpan link (tanpa spasi!)
                $data['file'] = "https://drive.google.com/file/d/{$fileId}/view";
            }

            LpjKepanitiaan::create($data);

            Alert::success('Berhasil', 'LPJ Kepanitiaan Berhasil Ditambahkan')
                ->autoclose(4000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('lpjkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error storing LpjKepanitiaan: ' . $th->getMessage());

            Alert::error('Gagal', 'Gagal menambahkan data: ' . $th->getMessage())
                ->autoclose(5000)
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
        $title = 'Form LPJ Kepanitiaan';
        $tahunAkademik = TahunAkademik::all();
        $users = User::all();
        return view('pages.lpjkepanitiaan.edit', compact('lpjkepanitiaan', 'tahunAkademik', 'users', 'title'));
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
                // Hapus file lama jika ada (Drive or Local)
                if ($lpjkepanitiaan->file) {
                    if (str_contains($lpjkepanitiaan->file, 'drive.google.com')) {
                        $this->deleteDriveFile($lpjkepanitiaan->file);
                    } else {
                        $oldPath = public_path($lpjkepanitiaan->file);
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                    }
                }

                $uploaded = $request->file('file');
                $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());
                $filename = $safeOriginal;

                // Upload via Google Drive API
                $service = $this->driveService();
                $lpjFolderId = env('GOOGLE_DRIVE_LPJ_FOLDER_ID');

                if (!$lpjFolderId) {
                    throw new \Exception('GOOGLE_DRIVE_LPJ_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name' => $filename,
                    'parents' => [$lpjFolderId],
                ]);

                $content = File::get($uploaded->getRealPath());

                $file = $service->files->create($fileMetadata, [
                    'data' => $content,
                    'uploadType' => 'multipart',
                    'fields' => 'id',
                ]);

                $fileId = $file->getId();
                $this->makeDriveFilePublic($fileId);
                $data['file'] = "https://drive.google.com/file/d/{$fileId}/view";
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
            Alert::error('Gagal', 'Data Gagal Diubah: ' . $th->getMessage())
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
            if (str_contains($lpjkepanitiaan->file, 'drive.google.com')) {
                $this->deleteDriveFile($lpjkepanitiaan->file);
            } else {
                $fullPath = public_path($lpjkepanitiaan->file);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
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
