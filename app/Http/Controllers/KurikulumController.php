<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\DataTables\KurikulumDataTable;
use App\Http\Requests\KurikulumRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\Permission;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KurikulumDataTable $dataTable)
    {
        return $dataTable->render('pages.kurikulum.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('pages.kurikulum.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(KurikulumRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['users_id'] = Auth::id();

    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $filename = $file->getClientOriginalName();
    //             $path = $file->storeAs('kurikulum', $filename, 'public');
    //             $data['file'] = 'storage/' . $path;
    //         }

    //         Kurikulum::create($data);

    //         Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
    //             ->autoclose(3000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-check-circle"></i>');
    //         return redirect()->route('kurikulum.index');
    //     } catch (\Throwable $th) {
    //         Log::error('Error storing Kurikulum: ' . $th->getMessage());
    //         Alert::error('Gagal', 'Data Gagal Ditambahkan')
    //             ->autoclose(3000)
    //             ->toToast()
    //             ->timerProgressBar()
    //             ->iconHtml('<i class="fa fa-times-circle"></i>');
    //         return redirect()->back()->withInput();
    //     }
    // }

    // TODO: SUBMIT TO GOOGLE DRIVE
    public function store(KurikulumRequest $request)
    {
        try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                $uploaded = $request->file('file');

                // Mengambil nama asli file dan memastikan nama file aman
                $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());  // Menghapus karakter yang tidak diizinkan

                // Menggunakan nama file yang sudah aman tanpa underscore
                $filename = $safeOriginal;

                // Path file di Google Drive (tanpa bagian user ID)
                $drivePath = 'Kurikulum Prodi/' . $filename;

                try {
                    // 1) Upload ke Google Drive
                    Storage::disk('google')->put($drivePath, File::get($uploaded->getRealPath()));

                    // 2) Ambil fileId (dibutuhkan untuk set permission public)
                    $fileId = $this->findDriveFileIdByNameInRootFolder($filename);

                    if (!$fileId) {
                        throw new \Exception("Upload berhasil tapi fileId tidak ditemukan. Pastikan GOOGLE_DRIVE_FOLDER berisi Folder ID yang benar.");
                    }

                    // 3) Jadikan public (anyone with link)
                    $this->makeDriveFilePublic($fileId);

                    // 4) Simpan link share ke DB
                    $data['file'] = "https://drive.google.com/file/d/{$fileId}/view";
                } catch (\Throwable $e) {
                    Log::error('Google Drive Error (Fallback to Local): ' . $e->getMessage());

                    //fallback local
                    $localPath = $uploaded->storeAs('kurikulum', $filename, 'public');
                    $data['file'] = 'storage/' . $localPath;
                }
            }

            Kurikulum::create($data);

            Alert::success('Berhasil', 'Data Berhasil Ditambahkan')
                ->autoclose(4000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('kurikulum.index');
        } catch (\Throwable $th) {
            Log::error('Error storing Kurikulum: ' . $th->getMessage());

            Alert::error('Gagal', 'Data Gagal Ditambahkan: ' . $th->getMessage())
                ->autoclose(5000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-times-circle"></i>');

            return redirect()->back()->withInput();
        }
    }

    /**
     * Google Drive service dari refresh token.
     */
    private function driveService(): GoogleDrive
    {
        $client = new GoogleClient();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        return new GoogleDrive($client);
    }

    /**
     * Cari fileId berdasarkan nama file di folder root yang dipakai disk google (GOOGLE_DRIVE_FOLDER).
     * GOOGLE_DRIVE_FOLDER kamu harus berisi Folder ID.
     */
    private function findDriveFileIdByNameInRootFolder(string $filename): ?string
    {
        $service = $this->driveService();

        $rootFolderId = env('GOOGLE_DRIVE_FOLDER'); // ini folderId root kamu
        if (!$rootFolderId) {
            return null;
        }

        $escaped = str_replace("'", "\\'", $filename);
        $q = "name = '{$escaped}' and trashed = false and '{$rootFolderId}' in parents";

        $list = $service->files->listFiles([
            'q' => $q,
            'fields' => 'files(id,name,createdTime)',
            'orderBy' => 'createdTime desc',
            'pageSize' => 1,
            'supportsAllDrives' => true,      // aman kalau folder ada di shared drive
            'includeItemsFromAllDrives' => true,
        ]);

        $files = $list->getFiles();
        return count($files) ? $files[0]->getId() : null;
    }

    /**
     * Set permission: anyone with link (reader)
     */
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
    // TODO: END SUBMIT TO GOOGLE DRIVE

    /**
     * Display the specified resource.
     */
    public function show(Kurikulum $kurikulum)
    {
        // return view('pages.kurikulum.show', compact('kurikulum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kurikulum $kurikulum)
    {
        return view('pages.kurikulum.edit', compact('kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KurikulumRequest $request, Kurikulum $kurikulum)
    {
         try {
            $data = $request->validated();
            $data['users_id'] = Auth::id();

            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($kurikulum->file) {
                    $oldPath = public_path($kurikulum->file);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('kurikulum', $filename, 'public');
                $data['file'] = 'storage/' . $path;
            } else {
                unset($data['file']);
            }

            $kurikulum->update($data);

            Alert::success('Berhasil', 'Data Berhasil Diubah')
                ->autoclose(3000)
                ->toToast()
                ->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('kurikulum.index');
        } catch (\Throwable $th) {
            Log::error('Error updating Kurikulum: ' . $th->getMessage());
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
    public function destroy(Kurikulum $kurikulum)
    {
        $kurikulum = Kurikulum::findOrFail($kurikulum->id);

        if ($kurikulum->file) {
            $fullPath = public_path($kurikulum->file);

            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $kurikulum->delete();

        Alert::success('Success', 'Data and file deleted successfully')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar();
        return redirect()->route('kurikulum.index');
    }
}
