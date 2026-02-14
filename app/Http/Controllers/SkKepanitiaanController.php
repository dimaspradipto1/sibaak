<?php

namespace App\Http\Controllers;

use App\Models\JenisSK;
use Illuminate\Http\Request;
use App\Models\SkKepanitiaan;
use App\Models\TahunAkademik;
use App\Models\RekapitulasiArsip;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Log;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Google\Service\Drive as GoogleDrive;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\SkKepanitiaanDataTable;
use App\Http\Requests\SkKepanitiaanRequest;

use App\Traits\HandleGoogleDrive;


class SkKepanitiaanController extends Controller
{
    use HandleGoogleDrive;

    /**
     * Display a listing of the resource.
     */
    public function index(SkKepanitiaanDataTable $dataTable)
    {
        $title = 'SK Kepanitiaan';
        return $dataTable->render('pages.skkepanitiaan.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form SK Kepanitiaan';
        $jenissks = JenisSK::all();
        $tahunAkademik = TahunAkademik::all();
        return view('pages.skkepanitiaan.create', compact('jenissks', 'tahunAkademik', 'title'));
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
                $uploaded = $request->file('file');
                $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());
                $filename = $safeOriginal;

                // Upload via Google Drive API
                $service = $this->driveService();
                $skFolderId = env('GOOGLE_DRIVE_SK_FOLDER_ID');

                if (!$skFolderId) {
                    throw new \Exception('GOOGLE_DRIVE_SK_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name' => $filename,
                    'parents' => [$skFolderId],
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

            SkKepanitiaan::create($data);

            Alert::success('Berhasil', 'SK Kepanitiaan Berhasil Ditambahkan')
                ->autoclose(4000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('skkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error storing SkKepanitiaan: ' . $th->getMessage());

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
        $title = 'Form SK Kepanitiaan';
        $jenissks = JenisSK::all();
        $tahunAkademik = TahunAkademik::all();
        return view('pages.skkepanitiaan.edit', compact('skkepanitiaan', 'jenissks', 'tahunAkademik', 'title'));
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
                // Hapus file lama jika ada (Drive or Local)
                if ($skkepanitiaan->file) {
                    if (str_contains($skkepanitiaan->file, 'drive.google.com')) {
                        $this->deleteDriveFile($skkepanitiaan->file);
                    } else {
                        $oldPath = public_path($skkepanitiaan->file);
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
                $skFolderId = env('GOOGLE_DRIVE_SK_FOLDER_ID');

                if (!$skFolderId) {
                    throw new \Exception('GOOGLE_DRIVE_SK_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name' => $filename,
                    'parents' => [$skFolderId],
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

            $skkepanitiaan->update($data);

            Alert::success('Berhasil', 'Data Berhasil Diubah')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('skkepanitiaan.index');
        } catch (\Throwable $th) {
            Log::error('Error updating SkKepanitiaan: ' . $th->getMessage());
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
    public function destroy(SkKepanitiaan $skkepanitiaan)
    {
        $skkepanitiaan = SkKepanitiaan::findOrFail($skkepanitiaan->id);

        if ($skkepanitiaan->file) {
            if (str_contains($skkepanitiaan->file, 'drive.google.com')) {
                $this->deleteDriveFile($skkepanitiaan->file);
            } else {
                $fullPath = public_path($skkepanitiaan->file);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
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
