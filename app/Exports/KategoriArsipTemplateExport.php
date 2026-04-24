<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KategoriArsipTemplateExport implements WithHeadings, WithTitle, WithStyles, FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            ['Laporan Harian'],
            ['Surat Keputusan'],
            ['Dokumen Kurikulum']
        ]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['TEMPLATE IMPORT KATEGORI ARSIP'],
            ['Petunjuk: Isi kolom di bawah ini. Pastikan judul kolom di Baris 3 tidak dihapus.'],
            ['Kategori Arsip']
        ];
    }

    public function title(): string
    {
        return 'Template Kategori Arsip';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(50);
        
        return [
            1    => ['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '046B26']]],
            2    => ['font' => ['italic' => true, 'color' => ['rgb' => 'FF0000']]],
            3    => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '004b8d']]], // Match new table header color
        ];
    }
}
