<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class DosenImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Flexible key mapping (supports 'nama' or 'nama_dosen')
        $nama = $row['nama_dosen'] ?? $row['nama'] ?? null;
        $prodiName = $row['prodi'] ?? $row['program_studi'] ?? null;

        if (!$nama || !$prodiName) {
            return null;
        }

        // Find Program Studi by name (more robust search)
        $prodi = ProgramStudi::where('program_studi', 'like', '%' . trim($prodiName) . '%')->first();

        return new Dosen([
            'nama_dosen'        => trim($nama),
            'nidn'              => $row['nidn'] ?? null,
            'nup'               => $row['nup'] ?? null,
            'nuptk'             => $row['nuptk'] ?? null,
            'email'             => $row['email'] ?? null,
            'program_studi_id'  => $prodi ? $prodi->id : null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nama_dosen' => 'nullable|string',
            '*.nama'       => 'nullable|string',
            '*.prodi'      => 'required|string',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Failures are handled by the controller
    }
}
