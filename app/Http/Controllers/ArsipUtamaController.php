<?php

namespace App\Http\Controllers;

use App\Models\ArsipUtama;
use App\Models\KategoriArsip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\DataTables\ArsipUtamaDataTable;
use App\Http\Requests\ArsipUtamaRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Traits\HandleGoogleDrive;

use App\Imports\ArsipUtamaImport;
use App\Exports\ArsipUtamaTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class ArsipUtamaController extends Controller
{
    use HandleGoogleDrive;

    public function index(ArsipUtamaDataTable $dataTable)
    {
        $title = 'Arsip Utama';
        return $dataTable->render('pages.arsiputama.index', compact('title'));
    }

    public function create()
    {
        $title = 'Form Arsip Utama';
        $kategoriArsips = KategoriArsip::orderBy('kategori_arsip')->get();
        return view('pages.arsiputama.create', compact('title', 'kategoriArsips'));
    }

    public function store(ArsipUtamaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            if ($request->hasFile('file_arsip')) {
                $uploaded = $request->file('file_arsip');
                $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());

                $service     = $this->driveService();
                $folderId    = env('GOOGLE_DRIVE_ARSIP_UTAMA_FOLDER_ID');

                if (!$folderId) {
                    throw new \Exception('GOOGLE_DRIVE_ARSIP_UTAMA_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name'    => $safeOriginal,
                    'parents' => [$folderId],
                ]);

                $content = File::get($uploaded->getRealPath());
                $file    = $service->files->create($fileMetadata, [
                    'data'       => $content,
                    'uploadType' => 'multipart',
                    'fields'     => 'id',
                ]);

                $fileId = $file->getId();
                $this->makeDriveFilePublic($fileId);
                $data['file_arsip'] = "https://drive.google.com/file/d/{$fileId}/view";
            }

            ArsipUtama::create($data);

            Alert::success('Berhasil', 'Arsip Utama berhasil ditambahkan')
                ->autoclose(4000)->toToast()->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('arsiputama.index');
        } catch (\Throwable $th) {
            Log::error('Error storing ArsipUtama: ' . $th->getMessage());
            Alert::error('Gagal', 'Gagal menambahkan data: ' . $th->getMessage())
                ->autoclose(5000)->toToast()->timerProgressBar()
                ->iconHtml('<i class="fa fa-times-circle"></i>');
            return redirect()->back()->withInput();
        }
    }

    public function show(ArsipUtama $arsiputama)
    {
        //
    }

    public function edit(ArsipUtama $arsiputama)
    {
        $title = 'Edit Arsip Utama';
        $kategoriArsips = KategoriArsip::orderBy('kategori_arsip')->get();
        return view('pages.arsiputama.edit', compact('title', 'arsiputama', 'kategoriArsips'));
    }

    public function update(ArsipUtamaRequest $request, ArsipUtama $arsiputama)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            if ($request->hasFile('file_arsip')) {
                // Hapus file lama di Google Drive
                if ($arsiputama->file_arsip && str_contains($arsiputama->file_arsip, 'drive.google.com')) {
                    $this->deleteDriveFile($arsiputama->file_arsip);
                }

                $uploaded = $request->file('file_arsip');
                $safeOriginal = preg_replace('/[^A-Za-z0-9\.\-_ ]/', '', $uploaded->getClientOriginalName());

                $service  = $this->driveService();
                $folderId = env('GOOGLE_DRIVE_ARSIP_UTAMA_FOLDER_ID');

                if (!$folderId) {
                    throw new \Exception('GOOGLE_DRIVE_ARSIP_UTAMA_FOLDER_ID tidak ditemukan di .env');
                }

                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name'    => $safeOriginal,
                    'parents' => [$folderId],
                ]);

                $content = File::get($uploaded->getRealPath());
                $file    = $service->files->create($fileMetadata, [
                    'data'       => $content,
                    'uploadType' => 'multipart',
                    'fields'     => 'id',
                ]);

                $fileId = $file->getId();
                $this->makeDriveFilePublic($fileId);
                $data['file_arsip'] = "https://drive.google.com/file/d/{$fileId}/view";
            } else {
                unset($data['file_arsip']);
            }

            $arsiputama->update($data);

            Alert::success('Berhasil', 'Data Berhasil Diubah')
                ->autoclose(3000)->toToast()->timerProgressBar()
                ->iconHtml('<i class="fa fa-check-circle"></i>');

            return redirect()->route('arsiputama.index');
        } catch (\Throwable $th) {
            Log::error('Error updating ArsipUtama: ' . $th->getMessage());
            Alert::error('Gagal', 'Data Gagal Diubah: ' . $th->getMessage())
                ->autoclose(3000)->toToast()->timerProgressBar()
                ->iconHtml('<i class="fa fa-times-circle"></i>');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(ArsipUtama $arsiputama)
    {
        if ($arsiputama->file_arsip && str_contains($arsiputama->file_arsip, 'drive.google.com')) {
            $this->deleteDriveFile($arsiputama->file_arsip);
        }

        $arsiputama->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus')
            ->autoclose(3000)->toToast()->timerProgressBar()
            ->iconHtml('<i class="fa fa-check-circle"></i>');

        return redirect()->route('arsiputama.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ArsipUtamaImport, $request->file('file'));
            
            Alert::success('Sukses', 'Data Arsip Utama berhasil diimpor')
                ->autoclose(4000)
                ->toToast();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat impor: ' . $e->getMessage())
                ->autoclose(5000)
                ->toToast();
        }

        return redirect()->back();
    }

    public function exportTemplate()
    {
        return Excel::download(new ArsipUtamaTemplateExport, 'format_import_arsip_utama.xlsx');
    }
}
