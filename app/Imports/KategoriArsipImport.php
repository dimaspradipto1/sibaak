<?php

namespace App\Imports;

use App\Models\KategoriArsip;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KategoriArsipImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row[0])) {
            return null;
        }

        return KategoriArsip::firstOrCreate([
            'kategori_arsip' => $row[0],
        ]);
    }

    public function startRow(): int
    {
        return 4;
    }
}
