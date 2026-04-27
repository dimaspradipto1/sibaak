<?php

namespace App\Exports;

use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SuratAkademikTemplateExport implements FromCollection, WithHeadings, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Template Surat Akademik';
    }

    public function collection()
    {
        return collect([
            [
                'Siti Aminah',          // nama_mahasiswa
                'S1-SISTEM INFORMASI',  // program_studi
                '2021001002',           // npm
                'Cuti Akademik',        // permohonan
                'Jl. Mawar No. 123',    // alamat
                '08123456789',          // no_wa
                '5',                    // semester
                'Belum Pernah Cuti',    // status_cuti
                'Masalah Keluarga',     // alasan_cuti
                'Dr. Ahmad, M.Pd',      // dosen_pembimbing_akademik
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
            'dosen_pembimbing_akademik',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ── Style header row (row 1) ──
                $headerRange = 'A1:J1';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                        'size'  => 11,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF00A551'], // UIS Green
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FF008240'],
                        ],
                    ],
                ]);

                // ── Style data rows ──
                $sheet->getStyle('A2:J100')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FFCCCCCC'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // ── Auto-size data columns ──
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // ── Set header row height ──
                $sheet->getRowDimension(1)->setRowHeight(32);

                // ── Reference column L: Daftar Program Studi ──
                $sheet->setCellValue('L1', 'REFERENSI PROGRAM STUDI');
                $sheet->getStyle('L1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF004B8D']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getColumnDimension('L')->setWidth(40);

                $prodis = ProgramStudi::pluck('program_studi')->toArray();
                $row = 2;
                foreach ($prodis as $p) {
                    $sheet->setCellValue('L' . $row, $p);
                    $sheet->getStyle('L' . $row)->applyFromArray([
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_HAIR, 'color' => ['argb' => 'FFCCCCCC']]],
                    ]);
                    $row++;
                }

                // ── Reference column M: Pilihan Permohonan ──
                $sheet->setCellValue('M1', 'PILIHAN PERMOHONAN');
                $sheet->getStyle('M1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF004B8D']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getColumnDimension('M')->setWidth(30);

                $permohonanOptions = ['Cuti Akademik', 'Aktif Kuliah', 'Mengundurkan Diri', 'Lainnya'];
                $row = 2;
                foreach ($permohonanOptions as $opt) {
                    $sheet->setCellValue('M' . $row, $opt);
                    $row++;
                }

                // ── Reference column N: Pilihan Status Cuti ──
                $sheet->setCellValue('N1', 'PILIHAN STATUS CUTI');
                $sheet->getStyle('N1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF004B8D']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getColumnDimension('N')->setWidth(28);

                $cutiOptions = ['Belum Pernah Cuti', 'Pernah Cuti', 'Sedang Cuti'];
                $row = 2;
                foreach ($cutiOptions as $opt) {
                    $sheet->setCellValue('N' . $row, $opt);
                    $row++;
                }

                // ── Freeze header row ──
                $sheet->freezePane('A2');

                // ── Add a note row at the top (insert above heading) ──
                // Sheet title in K1
                $sheet->setCellValue('K1', '⚠ Jangan ubah nama kolom (baris 1). Isi data mulai baris 2. Salin nilai dari kolom referensi di kanan.');
                $sheet->getStyle('K1')->applyFromArray([
                    'font'      => ['italic' => true, 'color' => ['argb' => 'FF888888'], 'size' => 9],
                    'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getColumnDimension('K')->setWidth(45);
            },
        ];
    }
}
