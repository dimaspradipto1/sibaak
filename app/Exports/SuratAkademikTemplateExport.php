<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratAkademikTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return collect([
            [
                'Siti Aminah', 
                'S1-SISTEM INFORMASI', 
                '2021001002', 
                'Cuti Akademik', 
                'Jl. Mawar No. 123', 
                '08123456789', 
                '5', 
                'Selesai Administrasi', 
                'Masalah Keluarga',
                'Dr. Ahmad, M.Pd'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'nama_mahasiswa',
            'program_studi',
            'npm',
            'permohonan',
            'alamat',
            'no_wa',
            'semester',
            'status_cuti',
            'alasan_cuti',
            'dosen_pembimbing_akademik'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
