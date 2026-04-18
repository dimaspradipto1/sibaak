<?php

namespace App\Imports;

use App\Models\ArsipUtama;
use App\Models\KategoriArsip;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ArsipUtamaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $kategori = KategoriArsip::where('kategori', 'like', '%' . $row['kategori'] . '%')->first();

        return new ArsipUtama([
            'users_id'       => Auth::id(),
            'kategori_id'    => $kategori ? $kategori->id : null,
            'tahun_arsip'    => $row['tahun'],
            'nama_arsip'     => $row['nama_arsip'],
            'file_arsip'     => $row['link_file_drive'] ?? null,
            'keterangan'     => $row['keterangan'] ?? '-',
        ]);
    }

    public function rules(): array
    {
        return [
            'kategori'   => 'required|string',
            'tahun'      => 'required|numeric',
            'nama_arsip' => 'required|string',
        ];
    }
}
