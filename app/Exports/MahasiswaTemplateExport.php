<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\ProgramStudi;

class MahasiswaTemplateExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            [
                'Jane Doe',
                '2024001',
                'S1-TEKNIK INFORMATIKA',
                'Fakultas Sains dan Teknologi',
                'Cianjur',
                '2002-05-20',
                'S1',
                'I (Satu)',
                'Jl. Raya No. 12',
                '08123456789'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NPM',
            'Prodi',
            'Fakultas',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenjang',
            'Semester',
            'Alamat',
            'WA'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Add reference for Prodi
                $prodis = ProgramStudi::pluck('program_studi')->toArray();
                $sheet->setCellValue('L1', 'DAFTAR PRODI:');
                $sheet->getStyle('L1')->getFont()->setBold(true);

                $row = 2;
                foreach ($prodis as $p) {
                    $sheet->setCellValue('L' . $row, $p);
                    $row++;
                }

                // Add reference for Semester
                $semesters = [
                    'I (Satu)',
                    'II (Dua)',
                    'III (Tiga)',
                    'IV (Empat)',
                    'V (Lima)',
                    'VI (Enam)',
                    'VII (Tujuh)',
                    'VIII (Delapan)',
                    'IX (Sembilan)',
                    'X (Sepuluh)',
                    'XI (Sebelas)',
                    'XII (Dua Belas)'
                ];
                $sheet->setCellValue('N1', 'DAFTAR SEMESTER:');
                $sheet->getStyle('N1')->getFont()->setBold(true);

                $row = 2;
                foreach ($semesters as $s) {
                    $sheet->setCellValue('N' . $row, $s);
                    $row++;
                }

                $sheet->getDelegate()->getColumnDimension('L')->setAutoSize(true);
                $sheet->getDelegate()->getColumnDimension('N')->setAutoSize(true);
                $sheet->getStyle('A1:J1')->getFont()->setBold(true);
                $sheet->getStyle('A1:J1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD3D3D3');
            },
        ];
    }
}
