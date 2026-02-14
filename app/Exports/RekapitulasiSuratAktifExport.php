<?php

namespace App\Exports;

use App\Models\SuratAktif;
use App\Models\TahunAkademik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapitulasiSuratAktifExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    protected $tahunAkademikId;
    protected $semester;
    protected $fakultas;
    private $rowNumber = 0;
    private $linkPositions = [];

    public function __construct($tahunAkademikId, $semester, $fakultas)
    {
        $this->tahunAkademikId = $tahunAkademikId;
        $this->semester = $semester;
        $this->fakultas = $fakultas;
    }

    public function collection()
    {
        $query = SuratAktif::with(['users', 'programStudi']);

        return $query
            ->when($this->tahunAkademikId, function ($q) {
                $ta = TahunAkademik::find($this->tahunAkademikId);
                if ($ta) {
                    $q->where('tahun_akademik', $ta->tahun_akademik);
                }
            })
            ->when($this->semester, fn($q) => $q->where('status_semester', $this->semester)) // Input Ganjil/Genap -> status_semester
            ->when($this->fakultas, fn($q) => $q->where('fakultas', $this->fakultas))
            ->get();
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $url = route('suratAktif.show', $row);
        $this->linkPositions[$this->rowNumber + 6] = $url;

        return [
            $this->rowNumber,
            $row->no_surat,
            $row->users->name ?? '-',
            $row->npm,
            $row->programStudi->program_studi ?? '-',
            $row->fakultas,
            $row->semester,
            $row->tahun_akademik ?? '-',
            $row->status,
            $url,
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'No Surat',
            'Nama Mahasiswa',
            'NPM',
            'Program Studi',
            'Fakultas',
            'Semester',
            'Tahun Akademik',
            'Status',
            'Link Surat',
        ];
    }

    /**
     * @return array
     */
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Header Info Section
                $sheet->mergeCells('A2:B2');
                $sheet->setCellValue('A2', 'Fakultas');
                $sheet->setCellValue('C2', ': ' . ($this->fakultas ?: 'Semua Fakultas'));

                $sheet->mergeCells('A3:B3');
                $sheet->setCellValue('A3', 'Semester');
                $sheet->setCellValue('C3', ': ' . ($this->semester ?: 'Semua Semester'));

                $sheet->mergeCells('A4:B4');
                $sheet->setCellValue('A4', 'Periode Akademik');

                $tahunAkademikLabel = 'Semua Periode';
                if ($this->tahunAkademikId) {
                    $ta = TahunAkademik::find($this->tahunAkademikId);
                    $tahunAkademikLabel = $ta ? $ta->tahun_akademik : '-';
                }
                $sheet->setCellValue('C4', ': ' . $tahunAkademikLabel);

                // Styling for Labels (Bold)
                $sheet->getStyle('A2:A4')->getFont()->setBold(true);

                // Table Styling (Borders and Header)
                $lastRow = $sheet->getHighestRow();
                $tableRange = 'A6:J' . $lastRow;

                // Set borders
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Bold and Center Header
                $sheet->getStyle('A6:J6')->getFont()->setBold(true);
                $sheet->getStyle('A6:J6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Hyperlinks
                foreach ($this->linkPositions as $row => $link) {
                    $cell = 'J' . $row;
                    $sheet->getCell($cell)->getHyperlink()->setUrl($link);
                    $sheet->getStyle($cell)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => '0000FF'],
                            'underline' => 'single'
                        ]
                    ]);
                }

                // Auto size columns
                foreach (range('A', 'J') as $columnID) {
                    $event->sheet->getDelegate()->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}
