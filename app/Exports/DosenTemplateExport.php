<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\ProgramStudi;

class DosenTemplateExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'Dosen Example, M.Kom.',
                '1234567890',
                '9900112233',
                '8877665544',
                'dosen@example.com',
                'Informatika'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Dosen',
            'NIDN',
            'NUP',
            'NUPTK',
            'Email',
            'Prodi'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Add reference for Prodi
                $prodis = ProgramStudi::pluck('program_studi')->toArray();
                $sheet->setCellValue('H1', 'DAFTAR PRODI (Copy text di bawah):');
                $sheet->getStyle('H1')->getFont()->setBold(true);
                
                $row = 2;
                foreach($prodis as $p) {
                    $sheet->setCellValue('H' . $row, $p);
                    $row++;
                }

                $sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true);
                $sheet->getStyle('A1:F1')->getFont()->setBold(true);
                $sheet->getStyle('A1:F1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD3D3D3');
                
                // Set column widths
                foreach(range('A','F') as $column) {
                    $sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
