<?php

namespace App\Imports;

use App\Models\KategoriArsip;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class KategoriArsipImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function headingRow(): int
    {
        return 3;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $val = $row['kategori_arsip'] ?? $row['kategori'] ?? null;
        
        if (empty(trim($val))) {
            return null;
        }

        return KategoriArsip::firstOrCreate([
            'kategori_arsip' => trim($val),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.kategori_arsip' => 'nullable|string',
            '*.kategori'       => 'nullable|string',
        ];
    }
}
