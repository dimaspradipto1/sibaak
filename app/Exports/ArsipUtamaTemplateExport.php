<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\KategoriArsip;

class ArsipUtamaTemplateExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        return collect([
            [
                'Umum',
                '2024',
                'Arsip SK Rektor 2024',
                'https://drive.google.com/file/d/...',
                'Keterangan arsip'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Tahun',
            'Nama Arsip',
            'Link File Drive',
            'Keterangan'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $kategori = KategoriArsip::pluck('kategori_arsip')->toArray();
                $sheet->setCellValue('G1', 'DAFTAR KATEGORI:');
                $sheet->getStyle('G1')->getFont()->setBold(true);

                $row = 2;
                foreach ($kategori as $k) {
                    $sheet->setCellValue('G' . $row, $k);
                    $row++;
                }

                $sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true);
                $sheet->getStyle('A1:E1')->getFont()->setBold(true);
                $sheet->getStyle('A1:E1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD3D3D3');
            },
        ];
    }
}
