<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find user by name (link to existing User)
        $user = User::where('name', $row['nama_pengguna'])->first();
        
        if (!$user) {
            return null; // Skip if user not found
        }

        // Find Program Studi by name
        $prodi = ProgramStudi::where('program_studi', 'like', '%' . $row['prodi'] . '%')->first();

        return new Mahasiswa([
            'users_id'           => $user->id,
            'npm'                => $row['npm'],
            'program_studi_id'   => $prodi ? $prodi->id : null,
            'fakultas'           => $row['fakultas'],
            'tempat_lahir'       => $row['tempat_lahir'] ?? '-',
            'tgl_lahir'          => $row['tanggal_lahir'] ?? null,
            'jenjang_pendidikan' => $row['jenjang'] ?? 'S1',
            'semester'           => $row['semester'] ?? 1,
            'alamat'             => $row['alamat'] ?? '-',
            'no_wa'              => $row['wa'] ?? '-',
            'status_cuti'        => 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_pengguna' => 'required|string',
            'npm'           => 'required|string|unique:mahasiswas,npm',
            'prodi'         => 'required|string',
            'fakultas'      => 'required|string',
        ];
    }
}
