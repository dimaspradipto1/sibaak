<?php

namespace App\Http\Controllers;

use App\Models\JenisSK;
use Illuminate\Http\Request;
use App\Models\SkKepanitiaan;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\SkKepanitiaanDataTable;
use App\Http\Requests\SkKepanitiaanRequest;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\Permission;


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

    // public function store(SkKepanitiaanRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['users_id'] = Auth::id();

    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $filename = $file->getClientOriginalName();
    //             $path = $file->storeAs('sk_kepanitiaan', $filename, 'public');
    //             $data['file'] = 'storage/' . $path;
    //         }

    //         SkKepanitiaan::create($data);

    //         Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
    //             ->autoclose(3000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-check-circle"></i>');
    //         return redirect()->route('skkepanitiaan.index');
    //     } catch (\Throwable $th) {
    //         Log::error('Error storing SkKepanitiaan: ' . $th->getMessage());
    //         Alert::error('Gagal', 'Data Gagal Ditambahkan')
    //             ->autoclose(3000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-times-circle"></i>');
    //         return redirect()->back()->withInput();
    //     }
    // }

    // TODO: SUBMIT TO GOOGLE DRIVE
    // public function store(SkKepanitiaanRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['users_id'] = Auth::id();

    //         if ($request->hasFile('file')) {
    //             $uploaded = $request->file('file');

    //             // Mengambil nama asli file dan memastikan nama file aman
    //             $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());  // Menghapus karakter yang tidak diizinkan

    //             // Menggunakan nama file yang sudah aman tanpa underscore
    //             $filename = $safeOriginal;

    //             // Path file di Google Drive (tanpa bagian user ID)
    //             $drivePath = 'SK Kepanitiaan/' . $filename;

    //             try {
    //                 // 1) Upload ke Google Drive
    //                 Storage::disk('google')->put($drivePath, File::get($uploaded->getRealPath()));

    //                 // 2) Ambil fileId (dibutuhkan untuk set permission public)
    //                 $fileId = $this->findDriveFileIdByNameInRootFolder($filename);

    //                 if (!$fileId) {
    //                     throw new \Exception("Upload berhasil tapi fileId tidak ditemukan. Pastikan GOOGLE_DRIVE_FOLDER berisi Folder ID yang benar.");
    //                 }

    //                 // 3) Jadikan public (anyone with link)
    //                 $this->makeDriveFilePublic($fileId);

    //                 // 4) Simpan link share ke DB
    //                 $data['file'] = "https://drive.google.com/file/d/{$fileId}/view";
    //             } catch (\Throwable $e) {
    //                 Log::error('Google Drive Error (Fallback to Local): ' . $e->getMessage());

    //                 // fallback local
    //                 $localPath = $uploaded->storeAs('sk_kepanitiaan', $filename, 'public');
    //                 $data['file'] = 'storage/' . $localPath;
    //             }
    //         }

    //         SkKepanitiaan::create($data);

    //         Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
    //             ->autoclose(4000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-check-circle"></i>');

    //         return redirect()->route('skkepanitiaan.index');
    //     } catch (\Throwable $th) {
    //         Log::error('Error storing SkKepanitiaan: ' . $th->getMessage());

    //         Alert::error('Gagal', 'Data Gagal Ditambahkan: ' . $th->getMessage())
    //             ->autoclose(5000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-times-circle"></i>');

    //         return redirect()->back()->withInput();
    //     }
    // }

    // TODO: Google Drive service dari refresh token.
    // private function driveService(): GoogleDrive
    // {
    //     $client = new GoogleClient();
    //     $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
    //     $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
    //     $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

    //     return new GoogleDrive($client);
    // }

    // TODO: Cari fileId berdasarkan nama file di folder root yang dipakai disk google (GOOGLE_DRIVE_FOLDER).
    // private function findDriveFileIdByNameInRootFolder(string $filename): ?string
    // {
    //     $service = $this->driveService();

    //     $rootFolderId = env('GOOGLE_DRIVE_FOLDER'); // ini folderId root kamu
    //     if (!$rootFolderId) {
    //         return null;
    //     }

    //     $escaped = str_replace("'", "\\'", $filename);
    //     $q = "name = '{$escaped}' and trashed = false and '{$rootFolderId}' in parents";

    //     $list = $service->files->listFiles([
    //         'q' => $q,
    //         'fields' => 'files(id,name,createdTime)',
    //         'orderBy' => 'createdTime desc',
    //         'pageSize' => 1,
    //         'supportsAllDrives' => true,      // aman kalau folder ada di shared drive
    //         'includeItemsFromAllDrives' => true,
    //     ]);

    //     $files = $list->getFiles();
    //     return count($files) ? $files[0]->getId() : null;
    // }

    // private function makeDriveFilePublic(string $fileId): void
    // {
    //     $service = $this->driveService();

    //     $permission = new Permission([
    //         'type' => 'anyone',
    //         'role' => 'reader',
    //     ]);

    //     $service->permissions->create($fileId, $permission, [
    //         'fields' => 'id',
    //         'supportsAllDrives' => true,
    //     ]);
    // }
    // TODO: END SUBMIT TO GOOGLE DRIVE

    //? fix code
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

    private function driveService(): GoogleDrive
    {
        $client = new GoogleClient();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));

        $refreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN');
        if (!$refreshToken) {
            throw new \Exception('Refresh token tidak ditemukan di .env');
        }

        $client->fetchAccessTokenWithRefreshToken($refreshToken);
        return new GoogleDrive($client);
    }

    private function makeDriveFilePublic(string $fileId): void
    {
        $service = $this->driveService();
        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);

        $service->permissions->create($fileId, $permission, [
            'fields' => 'id',
            'supportsAllDrives' => true,
        ]);
    }
    //? end fix code drive

   

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
