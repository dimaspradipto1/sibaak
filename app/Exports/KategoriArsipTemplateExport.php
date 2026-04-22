<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KategoriArsipTemplateExport implements WithHeadings, WithTitle, WithStyles
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['TEMPLATE IMPORT KATEGORI ARSIP'],
            ['Petunjuk: Isi kolom di bawah ini. Jangan menghapus baris judul (Baris 3).'],
            ['Kategori Arsip']
        ];
    }

    public function title(): string
    {
        return 'Template Kategori Arsip';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            2    => ['font' => ['italic' => true, 'color' => ['rgb' => 'FF0000']]],
            3    => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '046B26']]],
        ];
    }
}
