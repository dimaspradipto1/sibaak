<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $pegawai = $user->pegawai;
        $dosen = $user->dosen;
        $profile = $user->profile;
        $programStudis = \App\Models\ProgramStudi::all();
        $title = 'Profil Saya';

        return view('pages.profile.index', compact('user', 'mahasiswa', 'pegawai', 'dosen', 'profile', 'programStudis', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        // Update User Name
        if ($request->filled('name')) {
            $user->update(['name' => $request->name]);
        }

        // Update Profile (General Personal Info)
        $profileData = array_filter($request->only([
            'nidk',
            'nupn',
            'nbm',
            'gelar_depan',
            'gelar_belakang',
            'tempat_lahir',
            'tgl_lahir',
            'agama',
            'jenis_kelamin',
            'no_wa',
            'no_telp',
            'email_pribadi',
            'alamat'
        ]), fn($value) => !is_null($value));

        // Handle Photo Upload
        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $oldFile = $user->profile->foto ?? null;
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            $path = $request->file('foto')->store('profiles', 'public');
            $profileData['foto'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['users_id' => $user->id],
            $profileData
        );

        // Update based on Role (Specific Institutional Info)
        if ($user->is_mahasiswa) {
            $currentMahasiswa = $user->mahasiswa;
            $mahasiswaData = [
                'npm' => $request->npm ?? ($currentMahasiswa->npm ?? null),
                'program_studi_id' => $request->program_studi_id ?? ($currentMahasiswa->program_studi_id ?? null),
                'fakultas' => $request->fakultas ?? ($currentMahasiswa->fakultas ?? null),
                'jenjang_pendidikan' => $request->jenjang_pendidikan ?? ($currentMahasiswa->jenjang_pendidikan ?? null),
                'semester' => $request->semester ?? ($currentMahasiswa->semester ?? null),
                'status_cuti' => $request->status_cuti ?? ($currentMahasiswa->status_cuti ?? 'Belum Pernah Cuti'),
            ];

            $mahasiswa = $user->mahasiswa()->updateOrCreate(
                ['users_id' => $user->id],
                $mahasiswaData
            );
            $user->profile->update(['mahasiswa_id' => $mahasiswa->id, 'npm' => $mahasiswa->npm]);
        }

        if ($user->pegawai || $user->is_tata_usaha || $user->is_staffbaak) {
            $currentPegawai = $user->pegawai;
            $pegawaiData = [
                'nama_staff' => $request->name ?? ($currentPegawai->nama_staff ?? $user->name),
                'jabatan' => $request->jabatan ?? ($currentPegawai->jabatan ?? null),
                'nidn' => $request->nidn ?? ($currentPegawai->nidn ?? null),
                'nup' => $request->nup ?? ($currentPegawai->nup ?? null),
                'homebase' => $request->homebase ?? ($currentPegawai->homebase ?? null),
            ];

            $pegawai = $user->pegawai()->updateOrCreate(
                ['users_id' => $user->id],
                $pegawaiData
            );
            $user->profile->update(['pegawai_id' => $pegawai->id]);
        }

        if ($user->dosen) {
            $currentDosen = $user->dosen;
            $dosenData = [
                'nama_dosen' => $request->name ?? ($currentDosen->nama_dosen ?? $user->name),
                'nidn' => $request->nidn ?? ($currentDosen->nidn ?? null),
                'nup' => $request->nup ?? ($currentDosen->nup ?? null),
                'nuptk' => $request->nuptk ?? ($currentDosen->nuptk ?? null),
            ];

            $dosen = $user->dosen()->updateOrCreate(
                ['email' => $user->email],
                $dosenData
            );
            $user->profile->update(['dosen_id' => $dosen->id]);
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
