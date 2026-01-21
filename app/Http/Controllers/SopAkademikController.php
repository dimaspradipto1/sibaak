<?php

namespace App\Http\Controllers;

use App\Models\SopAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\DataTables\SopAkademikDataTable;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\SopAkademikRequest;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\Permission;

class SopAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SopAkademikDataTable $datatable)
    {
        $title = 'SOP Akademik';
        return $datatable->render('pages.sopakademik.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form SOP Akademik';
        return view('pages.sopakademik.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(SopAkademikRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['users_id'] = Auth::id();

    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $filename = $file->getClientOriginalName();
    //             $path = $file->storeAs('sopakademik', $filename, 'public');
    //             $data['file'] = 'storage/' . $path;
    //         }

    //         SopAkademik::create($data);

    //         Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
    //             ->autoclose(3000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-check-circle"></i>');
    //         return redirect()->route('sopakademik.index');
    //     } catch (\Throwable $th) {
    //         Log::error('Error storing SOP Akademik: ' . $th->getMessage());
    //         Alert::error('Gagal', 'Data Gagal Ditambahkan')
    //             ->autoclose(3000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-times-circle"></i>');
    //         return redirect()->back()->withInput();
    //     }
    // }

    // TODO: SUBMIT TO GOOGLE DRIVE
    // public function store(SopAkademikRequest $request)
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
    //             $drivePath = 'SOP Akademik/' . $filename;

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

    //                 //fallback local
    //                 $localPath = $uploaded->storeAs('sopakademik', $filename, 'public');
    //                 $data['file'] = 'storage/' . $localPath;
    //             }
    //         }

    //         SopAkademik::create($data);

    //         Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
    //             ->autoclose(4000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-check-circle"></i>');

    //         return redirect()->route('sopakademik.index');
    //     } catch (\Throwable $th) {
    //         Log::error('Error storing SOP Akademik: ' . $th->getMessage());

    //         Alert::error('Gagal', 'Data Gagal Ditambahkan: ' . $th->getMessage())
    //             ->autoclose(5000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-times-circle"></i>');

    //         return redirect()->back()->withInput();
    //     }
    // }

    // /**
    //  * Google Drive service dari refresh token.
    //  */
    // private function driveService(): GoogleDrive
    // {
    //     $client = new GoogleClient();
    //     $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
    //     $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
    //     $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

    //     return new GoogleDrive($client);
    // }

    // /**
    //  * Cari fileId berdasarkan nama file di folder root yang dipakai disk google (GOOGLE_DRIVE_FOLDER).
    //  * GOOGLE_DRIVE_FOLDER kamu harus berisi Folder ID.
    //  */
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

    // /**
    //  * Set permission: anyone with link (reader)
    //  */
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
    public function store(SopAkademikRequest $request)
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
                $sopakademikFolderId = env('GOOGLE_DRIVE_SOP_FOLDER_ID');

                if (!$sopakademikFolderId) {
                    throw new \Exception('GOOGLE_DRIVE_SOP_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name' => $filename,
                    'parents' => [$sopakademikFolderId],
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

            SopAkademik::create($data);

            Alert::success('Berhasil', 'SOP Akademik Berhasil Ditambahkan')
                ->autoclose(4000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('sopakademik.index');

        } catch (\Throwable $th) {
            Log::error('Error storing SOP Akademik: ' . $th->getMessage());

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
    public function show(SopAkademik $sopAkademik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SopAkademik $sopakademik)
    {
        $title = 'Form SOP Akademik';
        return view('pages.sopakademik.edit', compact('sopakademik', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SopAkademikRequest $request, SopAkademik $sopakademik)
    {
        try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($sopakademik->file) {
                    $oldPath = public_path($sopakademik->file);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('sopakademik', $filename, 'public');
                $data['file'] = 'storage/' . $path;
            } else {
                unset($data['file']);
            }

            $sopakademik->update($data);

            Alert::success('Berhasil', 'Data Berhasil Diubah')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('sopakademik.index');
        } catch (\Throwable $th) {
            Log::error('Error updating SOP Akademik: ' . $th->getMessage());
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
    public function destroy(SopAkademik $sopakademik)
    {
        $sopakademik = SopAKademik::FindOrFail($sopakademik->id);

        if($sopakademik->file){
            $fullPath = public_path($sopakademik->file);

            if(File::EXISTS($fullPath)){
                File::delete($fullPath);
            }
        }

        $sopakademik->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('sopakademik.index');
    }
}
