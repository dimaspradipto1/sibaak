<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\SuratAktif;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Auth;
use App\DataTables\SuratAktifDataTable;
use RealRashid\SweetAlert\Facades\Alert;

use App\Imports\SuratAktifImport;
use App\Exports\SuratAktifTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class SuratAktifController extends Controller
{
    public function exportTemplate()
    {
        return Excel::download(new SuratAktifTemplateExport, 'template_surat_aktif.xlsx');
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new SuratAktifImport, $request->file('file'));
            Alert::success('Berhasil', 'Data Surat Aktif berhasil diimport')->autoclose(3000)->toToast();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat import: ' . $e->getMessage())->autoclose(5000)->toToast();
        }

        return redirect()->route('suratAktif.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SuratAktifDataTable $dataTable)
    {
        $title = 'Surat Aktif';
        return $dataTable->render('pages.suratAktif.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Surat Aktif';
        
        if (Auth::user()->is_mahasiswa) {
            $users = User::where('id', Auth::id())->get();
        } else {
            $users = User::whereHas('role', function($query) {
                $query->where('nama_role', 'MAHASISWA');
            })->get();
        }
        
        $programStudi = ProgramStudi::all();
        return view('pages.suratAktif.create', compact('users', 'programStudi', 'title'));
    }

    public function pengajuan()
    {
        $mahasiswa = Mahasiswa::where('users_id', Auth::id())->first();

        if (!$mahasiswa) {
            Alert::error('Error', 'Data mahasiswa tidak ditemukan. Silahkan isi data mahasiswa terlebih dahulu.')->autoclose(10000)->toToast()->timerProgressBar();
            return redirect()->route('mahasiswa.create');
        }

        $lastSurat = SuratAktif::latest('no_surat')->first();
        $noSurat = $lastSurat ? $lastSurat->no_surat + 1 : 1;
        $noSuratFormatted = sprintf("%03d", $noSurat);

        $data = [
            'no_surat' => $noSuratFormatted,
            'users_id' => Auth::id(),
            'program_studi_id' => $mahasiswa->program_studi_id,
            'tempat_lahir' => $mahasiswa->tempat_lahir,
            'tgl_lahir' => $mahasiswa->tgl_lahir,
            'npm' => $mahasiswa->npm,
            'jenjang_pendidikan' => $mahasiswa->jenjang_pendidikan,
            'fakultas' => $mahasiswa->fakultas,
            'status' => 'pending',
            'semester' => $mahasiswa->semester ?? null,
            'status_semester' => $mahasiswa->status_semester ?? null,
            'tahun_akademik' => $mahasiswa->tahun_akademik ?? null,
        ];

        SuratAktif::create($data);

        // Menampilkan pesan sukses
        Alert::success('Success', 'Surat Aktif berhasil dibuat secara otomatis')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-check"></i>');
        return redirect()->route('suratAktif.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lastSurat = SuratAktif::latest('no_surat')->first();
        $noSurat = $lastSurat ? (int) $lastSurat->no_surat + 1 : 1;
        $noSuratFormatted = sprintf("%03d", $noSurat);
        $userId = Auth::user()->is_mahasiswa ? Auth::id() : $request->users_id;

        $data = [
            'no_surat' => $noSuratFormatted,
            'users_id' => $userId,
            'program_studi_id' => $request->program_studi_id,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'npm' => $request->npm,
            'jenjang_pendidikan' => $request->jenjang_pendidikan,
            'fakultas' => $request->fakultas,
            'status' => 'pending',
            'semester' => $request->semester ?? null,
            'status_semester' => $request->status_semester ?? null,
            'tahun_akademik' => $request->tahun_akademik ?? null,
        ];

        SuratAktif::create($data);
        Alert::success('Success', 'Data created successfully')->autoclose(3000)->toToast();
        return redirect()->route('suratAktif.index');
    }

    /**
     * Display the specified resource.
     */
    public function getBulanRomawi()
    {
        $bulan = Carbon::now()->format('F Y');

        $petaRomawi = [
            'January' => 'I',
            'February' => 'II',
            'March' => 'III',
            'April' => 'IV',
            'May' => 'V',
            'June' => 'VI',
            'July' => 'VII',
            'August' => 'VIII',
            'September' => 'IX',
            'October' => 'X',
            'November' => 'XI',
            'December' => 'XII',
        ];

        return $petaRomawi[date('F', strtotime($bulan))];
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratAktif $suratAktif)
    {
        $no_surat = $suratAktif->no_surat;
        $program_studi = ProgramStudi::find($suratAktif->program_studi_id)->program_studi;
        $user = User::with('pegawai')->whereHas('role', function($query) {
            $query->where('nama_role', 'APPROVAL');
        })->first();

        $pegawai = $user ? $user->pegawai : null;
        $bulanRomawi = $this->getBulanRomawi();
        return view('pages.suratAktif.show', compact('suratAktif', 'no_surat', 'program_studi', 'bulanRomawi', 'user', 'pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratAktif $suratAktif)
    {
        $title = 'Form Surat Aktif';
        $tahunAkademik = TahunAkademik::all();
        return view('pages.suratAktif.edit', compact('suratAktif', 'tahunAkademik', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratAktif $suratAktif)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'status_semester' => 'required',
            'status' => 'required',
        ]);

        $suratAktif->update([
            'tahun_akademik' => $request->tahun_akademik,
            'status_semester' => $request->status_semester,
            'status' => $request->status,
        ]);

        Alert::success('Berhasil!', 'Data Surat Aktif berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-check"></i>');

        return redirect()->route('suratAktif.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratAktif $suratAktif)
    {
        $suratAktif->delete();
        Alert::success('Success', 'Data deleted successfully')->autoclose(3000)->toToast();
        return redirect()->route('suratAktif.index');
    }

    public function validasi(SuratAktif $suratAktif)
    {
        $userApproval = User::with('pegawai')->whereHas('role', function($query) {
            $query->where('nama_role', 'APPROVAL');
        })->first();
        $pegawai = $userApproval ? $userApproval->pegawai : null;

        return view('pages.suratAktif.detailsuratakademik', compact('suratAktif', 'pegawai', 'userApproval'));
    }

    public function preview(SuratAktif $suratAktif)
    {
        $no_surat = $suratAktif->no_surat;
        $program_studi = ProgramStudi::find($suratAktif->program_studi_id)->program_studi;
        $user = User::with('pegawai')->whereHas('role', function($query) {
            $query->where('nama_role', 'APPROVAL');
        })->first();

        $pegawai = $user ? $user->pegawai : null;
        $bulanRomawi = $this->getBulanRomawi();
        $is_preview = true;
        return view('pages.suratAktif.show', compact('suratAktif', 'no_surat', 'program_studi', 'bulanRomawi', 'user', 'pegawai', 'is_preview'));
    }
    public function print(SuratAktif $suratAktif)
    {
        $no_surat = $suratAktif->no_surat;
        $program_studi = ProgramStudi::find($suratAktif->program_studi_id)->program_studi;
        $user = User::with('pegawai')->whereHas('role', function($query) {
            $query->where('nama_role', 'APPROVAL');
        })->first();

        $pegawai = $user ? $user->pegawai : null;
        $bulanRomawi = $this->getBulanRomawi();
        return view('pages.suratAktif.show', compact('suratAktif', 'no_surat', 'program_studi', 'bulanRomawi', 'user', 'pegawai'));
    }
}
