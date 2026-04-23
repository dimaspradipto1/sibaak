<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DosenImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find Program Studi by name
        $prodi = ProgramStudi::where('program_studi', 'like', '%' . $row['prodi'] . '%')->first();

        return new Dosen([
            'nama_dosen'        => $row['nama_dosen'],
            'nidn'              => $row['nidn'],
            'nup'               => $row['nup'],
            'nuptk'             => $row['nuptk'],
            'email'             => $row['email'],
            'program_studi_id'  => $prodi ? $prodi->id : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_dosen' => 'required|string',
            'prodi'      => 'required|string',
            'email'      => 'nullable|email',
        ];
    }
}
