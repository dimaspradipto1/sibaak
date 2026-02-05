<?php

namespace App\Exports;

use App\Models\RekapitulasiArsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use App\Models\TahunAkademik;

class RekapitulasiArsipExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    protected $tahun;
    protected $tahunAkademikId;
    protected $semester;
    protected $jenisArsip;
    protected $fakultas;
    private $rowNumber = 0;
    private $linkPositions = [];

    public function __construct($tahun, $tahunAkademikId, $semester, $jenisArsip, $fakultas)
    {
        $this->tahun = $tahun;
        $this->tahunAkademikId = $tahunAkademikId;
        $this->semester = $semester;
        $this->jenisArsip = $jenisArsip;
        $this->fakultas = $fakultas;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = RekapitulasiArsip::with([
            'tahunAkademik',
            'skKepanitiaan.users',
            'lpjKepanitiaan.users',
            'kurikulum.users',
            'pedoman.users',
            'sopAkademik.users',
            'wasdalbin.users'
        ]);

        return $query
            ->when($this->tahun, fn($q) => $q->where('tahun', $this->tahun))
            ->when($this->tahunAkademikId, fn($q) => $q->where('tahun_akademik_id', $this->tahunAkademikId))
            ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
            ->when($this->jenisArsip, fn($q) => $q->where('jenis_arsip', $this->jenisArsip))
            ->when($this->fakultas, fn($q) => $q->where('fakultas', $this->fakultas))
            ->get();
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $detailName = '-';
        $linkDokumen = '-';
        $submitter = '-';
        $arsip = null;

        // Cari data asli berdasarkan jenis arsip
        switch ($row->jenis_arsip) {
            case 'SkKepanitiaan':
                $arsip = $row->skKepanitiaan;
                $detailName = $arsip->nama_dokumen ?? '-';
                break;
            case 'LpjKepanitiaan':
                $arsip = $row->lpjKepanitiaan;
                $detailName = $arsip->nama_dokumen ?? '-';
                break;
            case 'Kurikulum':
                $arsip = $row->kurikulum;
                $detailName = $arsip->nama_kurikulum ?? '-';
                break;
            case 'Pedoman':
                $arsip = $row->pedoman;
                $detailName = $arsip->nama_pedoman ?? '-';
                break;
            case 'SOP Akademik':
                $arsip = $row->sopAkademik;
                $detailName = $arsip->nama_sop ?? '-';
                break;
            case 'Wasdalbin':
                $arsip = $row->wasdalbin;
                $detailName = $arsip->nama_wasdalbin ?? '-';
                break;
        }

        if ($arsip) {
            $fileId = $arsip->file ?? ($arsip->dokumen ?? null);
            if ($fileId) {
                // Jika sudah full URL (dimulai dengan http), gunakan langsung. 
                // Jika hanya ID, buatkan format Google Drive view.
                if (str_starts_with($fileId, 'http')) {
                    $linkDokumen = $fileId;
                } else {
                    $linkDokumen = "https://drive.google.com/file/d/{$fileId}/view";
                }

                // Simpan baris dan link untuk dijadikan Hyperlink di AfterSheet
                $this->linkPositions[$this->rowNumber + 1] = $linkDokumen;
            }

            // Ambil nama user yang submit
            $submitter = $arsip->users->name ?? ($arsip->user->name ?? '-');
        }

        return [
            $this->rowNumber,
            $row->semester ?: '-',
            $row->jenis_arsip,
            $row->fakultas,
            $detailName,
            $submitter,
            $linkDokumen,
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'Semester',
            'Jenis Arsip',
            'Fakultas',
            'Nama Dokumen',
            'Submitter',
            'Link Dokumen',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Header Info Section (Rows 2-4)
                $sheet->mergeCells('A2:B2');
                $sheet->setCellValue('A2', 'Jenis Arsip');
                $sheet->setCellValue('C2', ': ' . ($this->jenisArsip ?: 'Semua Jenis Arsip'));

                $sheet->mergeCells('A3:B3');
                $sheet->setCellValue('A3', 'Fakultas');
                $sheet->setCellValue('C3', ': ' . ($this->fakultas ?: 'Semua Fakultas'));

                $sheet->mergeCells('A4:B4');
                $sheet->setCellValue('A4', 'Periode Semester');
                $sheet->setCellValue('C4', ': ' . ($this->semester ?: '-'));

                $sheet->mergeCells('D2:E2');
                $sheet->setCellValue('D2', 'Tahun');
                $sheet->setCellValue('E2', ': ' . ($this->tahun ?: '-'));

                $sheet->mergeCells('D3:E3');
                $sheet->setCellValue('D3', 'Periode Akademik');

                $tahunAkademikLabel = '-';
                if ($this->tahunAkademikId) {
                    $ta = TahunAkademik::find($this->tahunAkademikId);
                    $tahunAkademikLabel = $ta ? $ta->tahun_akademik : '-';
                }
                $sheet->setCellValue('E3', ': ' . $tahunAkademikLabel);

                // Styling for Labels (Bold)
                $sheet->getStyle('A2:A4')->getFont()->setBold(true);
                $sheet->getStyle('D2:D3')->getFont()->setBold(true);

                // Table Styling (Borders and Header)
                $lastRow = $sheet->getHighestRow();
                $tableRange = 'A7:G' . $lastRow;

                // Set borders
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Bold and Center Header
                $sheet->getStyle('A7:G7')->getFont()->setBold(true);
                $sheet->getStyle('A7:G7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                // Hyperlinks for column G starting from Row 8 (Header is at 7)
                foreach ($this->linkPositions as $row => $link) {
                    $cell = 'G' . ($row + 7); // Data starts at Row 8 (+7 from mapping rowNumber)
                    $event->sheet->getCell($cell)->getHyperlink()->setUrl($link);

                    $event->sheet->getStyle($cell)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => '0000FF'],
                            'underline' => 'single'
                        ]
                    ]);
                }

                foreach (range('A', 'G') as $columnID) {
                    $event->sheet->getDelegate()->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}
