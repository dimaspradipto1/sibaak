<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratAktifTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Memberikan satu baris contoh data agar user paham formatnya
        return collect([
            [
                'Budi Santoso', 
                'S1-SISTEM INFORMASI', 
                '001', 
                'Jakarta', 
                '2002-05-20', 
                '2021001001', 
                'S1',
                'ILMU KESEHATAN',
                'Pending',
                '4', 
                'Genap',
                '2023/2024'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'nama_mahasiswa',
            'program_studi',
            'no_surat',
            'tempat_lahir',
            'tgl_lahir',
            'npm',
            'jenjang_pendidikan',
            'fakultas',
            'status',
            'semester',
            'status_semester',
            'tahun_akademik'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Tebalkan header
            1 => ['font' => ['bold' => true]],
        ];
    }
}
