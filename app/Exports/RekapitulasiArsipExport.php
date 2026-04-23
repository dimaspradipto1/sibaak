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
use App\Models\Role;

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
            'skKepanitiaan.users.role',
            'lpjKepanitiaan.users.role',
            'kurikulum.user.role',
            'pedoman.users.role',
            'sopAkademik.users.role',
            'wasdalbin.users.role'
        ]);

        return $query
            ->when($this->tahun, fn($q) => $q->where('tahun', $this->tahun))
            ->when($this->tahunAkademikId, fn($q) => $q->where('tahun_akademik_id', $this->tahunAkademikId))
            ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
            ->when($this->jenisArsip, fn($q) => $q->where('jenis_arsip', $this->jenisArsip))
            ->when($this->fakultas, function($q) {
                $roleId = $this->fakultas;
                $q->where(function($sub) use ($roleId) {
                    $sub->whereHas('skKepanitiaan.users', fn($u) => $u->where('role_id', $roleId))
                        ->orWhereHas('lpjKepanitiaan.users', fn($u) => $u->where('role_id', $roleId))
                        ->orWhereHas('kurikulum.users', fn($u) => $u->where('role_id', $roleId))
                        ->orWhereHas('pedoman.users', fn($u) => $u->where('role_id', $roleId))
                        ->orWhereHas('sopAkademik.users', fn($u) => $u->where('role_id', $roleId))
                        ->orWhereHas('wasdalbin.users', fn($u) => $u->where('role_id', $roleId))
                        ->orWhereHas('user', fn($u) => $u->where('role_id', $roleId));
                });
            })
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
        $roleName = '-';
        $arsip = null;

        switch ($row->jenis_arsip) {
            case 'ArsipUtama':
                $arsip = $row;
                $detailName = $row->nama_arsip ?? '-';
                $submitter = $row->user->name ?? '-';
                $roleName = $row->user->role->nama_role ?? '-';
                $fileId = $row->file_arsip;
                break;
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

        if ($arsip && $row->jenis_arsip != 'ArsipUtama') {
            $submitter = $arsip->users->name ?? '-';
            $roleName = $arsip->users->role->nama_role ?? '-';
            $fileId = $arsip->file ?? ($arsip->dokumen ?? null);
        }

        if (isset($fileId) && $fileId) {
            if (str_starts_with($fileId, 'http')) {
                $linkDokumen = $fileId;
            } else {
                $linkDokumen = "https://drive.google.com/file/d/{$fileId}/view";
            }
            $this->linkPositions[$this->rowNumber + 1] = $linkDokumen;
        }

        return [
            $this->rowNumber,
            $row->semester ?: '-',
            $row->jenis_arsip,
            $roleName,
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
            'Role Akses',
            'Nama Dokumen',
            'Submitter',
            'Link Dokumen',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Header Info Section
                $sheet->setCellValue('A2', 'Jenis Arsip');
                $sheet->setCellValue('C2', ': ' . ($this->jenisArsip ?: 'Semua Jenis Arsip'));
                $sheet->mergeCells('A2:B2');

                $sheet->setCellValue('A3', 'Role Akses');
                $roleNameFilter = 'Semua Role';
                if($this->fakultas) {
                    $role = Role::find($this->fakultas);
                    $roleNameFilter = $role ? $role->nama_role : 'Semua Role';
                }
                $sheet->setCellValue('C3', ': ' . $roleNameFilter);
                $sheet->mergeCells('A3:B3');

                $sheet->setCellValue('A4', 'Periode Semester');
                $sheet->setCellValue('C4', ': ' . ($this->semester ?: '-'));
                $sheet->mergeCells('A4:B4');

                $sheet->setCellValue('D2', 'Tahun');
                $sheet->setCellValue('F2', ': ' . ($this->tahun ?: '-'));
                $sheet->mergeCells('D2:E2');

                $sheet->setCellValue('D3', 'Periode Akademik');
                $tahunAkademikLabel = '-';
                if ($this->tahunAkademikId) {
                    $ta = TahunAkademik::find($this->tahunAkademikId);
                    $tahunAkademikLabel = $ta ? $ta->tahun_akademik : '-';
                }
                $sheet->setCellValue('F3', ': ' . $tahunAkademikLabel);
                $sheet->mergeCells('D3:E3');

                // Styling for Labels (Bold)
                $sheet->getStyle('A2:A4')->getFont()->setBold(true);
                $sheet->getStyle('D2:D3')->getFont()->setBold(true);

                // Table Styling
                $lastRow = $sheet->getHighestRow();
                $tableRange = 'A7:G' . $lastRow;

                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $sheet->getStyle('A7:G7')->getFont()->setBold(true);
                $sheet->getStyle('A7:G7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                foreach ($this->linkPositions as $row => $link) {
                    $cell = 'G' . ($row + 7);
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
