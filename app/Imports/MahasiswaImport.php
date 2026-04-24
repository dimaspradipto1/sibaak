<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Support common heading variants (Nama, Nama Pengguna, Nama Pen)
        $nameKey = $row['nama_pengguna'] ?? $row['nama'] ?? $row['nama_pen'] ?? null;
        if (!$nameKey) return null;

        $npm = $row['npm'] ?? '000000';

        // 1. Find or CREATE the User account
        $user = User::where('name', 'like', '%' . trim($nameKey) . '%')->first();
        
        if (!$user) {
            // Get Mahasiswa role
            $role = Role::where('nama_role', 'MAHASISWA')->first();
            
            $user = User::create([
                'name'      => trim($nameKey),
                'email'     => $npm . '@uis.ac.id', // Default email using NPM
                'password'  => Hash::make($npm),      // Default password using NPM
                'role_id'   => $role ? $role->id : null,
                'is_active' => 1,
            ]);
        }

        // 2. Find Program Studi by name
        $prodiName = $row['prodi'] ?? $row['program_studi'] ?? null;
        $prodi = ProgramStudi::where('program_studi', 'like', '%' . trim($prodiName) . '%')->first();

        // 3. Normalize Semester format: convert numbers to "Roman (Name)" if needed
        $semester = $row['semester'] ?? '1';
        $semesterMap = [
            '1' => 'I (Satu)', '2' => 'II (Dua)', '3' => 'III (Tiga)', '4' => 'IV (Empat)',
            '5' => 'V (Lima)', '6' => 'VI (Enam)', '7' => 'VII (Tujuh)', '8' => 'VIII (Delapan)',
            '9' => 'IX (Sembilan)', '10' => 'X (Sepuluh)', '11' => 'XI (Sebelas)', '12' => 'XII (Dua Belas)'
        ];
        
        if (isset($semesterMap[trim($semester)])) {
            $semester = $semesterMap[trim($semester)];
        }

        // 4. Create or Update Mahasiswa record
        return new Mahasiswa([
            'users_id'           => $user->id,
            'npm'                => $npm,
            'program_studi_id'   => $prodi ? $prodi->id : null,
            'fakultas'           => $row['fakultas'] ?? 'Fakultas Teknik',
            'tempat_lahir'       => $row['tempat_lahir'] ?? '-',
            'tgl_lahir'          => $row['tanggal_lahir'] ?? null,
            'jenjang_pendidikan' => $row['jenjang'] ?? 'S1',
            'semester'           => $semester,
            'alamat'             => $row['alamat'] ?? '-',
            'no_wa'              => $row['wa'] ?? '-',
            'status_cuti'        => 0,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.npm'   => 'required',
            '*.prodi' => 'required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Handled by controller
    }
}
