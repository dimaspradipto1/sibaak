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
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

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

        // 4. Parse tanggal lahir (handle all Excel date formats)
        $rawDate = $row['tanggal_lahir'] ?? $row['tgl_lahir'] ?? null;
        $tglLahir = $this->parseDate($rawDate);

        // 5. Create or Update Mahasiswa record
        return new Mahasiswa([
            'users_id'           => $user->id,
            'npm'                => $npm,
            'program_studi_id'   => $prodi ? $prodi->id : null,
            'fakultas'           => $row['fakultas'] ?? 'Fakultas Teknik',
            'tempat_lahir'       => $row['tempat_lahir'] ?? '-',
            'tgl_lahir'          => $tglLahir,
            'jenjang_pendidikan' => $row['jenjang'] ?? 'S1',
            'semester'           => $semester,
            'alamat'             => $row['alamat'] ?? '-',
            'no_wa'              => $row['wa'] ?? '-',
            'status_cuti'        => 0,
        ]);
    }

    /**
     * Universal date parser untuk semua format tanggal dari Excel.
     * Mendukung: angka serial Excel, dd/mm/yyyy, mm/dd/yyyy, yyyy-mm-dd,
     * d-m-Y, d.m.Y, teks "20 Januari 2000", dan lainnya.
     */
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // 1. Jika berupa angka → anggap sebagai Excel serial date
        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject((float) $value)
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                // Lanjut ke pengecekan lain
            }
        }

        $value = trim($value);

        // 2. Daftar format yang umum digunakan
        $formats = [
            'Y-m-d',       // 2000-05-20
            'd/m/Y',       // 20/05/2000
            'm/d/Y',       // 05/20/2000
            'd-m-Y',       // 20-05-2000
            'd.m.Y',       // 20.05.2000
            'Y/m/d',       // 2000/05/20
            'd/m/y',       // 20/05/00
            'd-m-y',       // 20-05-00
            'j F Y',       // 20 May 2000
            'd F Y',       // 20 May 2000 (padded)
            'F j, Y',      // May 20, 2000
            'Y-m-d H:i:s', // 2000-05-20 00:00:00
            'd/m/Y H:i:s', // 20/05/2000 00:00:00
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date !== false && $date->format($format) === $value) {
                    return $date->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // 3. Fallback: biarkan Carbon parse secara otomatis
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Tidak bisa diparse → null
        }
    }

    public function rules(): array
    {
        return [
            '*.npm'   => 'required|unique:mahasiswas,npm',
            '*.prodi' => 'required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Handled by controller
    }
}
