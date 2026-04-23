<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Role;

class UsersTemplateExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Example data
        return collect([
            [
                'John Doe',
                'john@example.com',
                'password123',
                'ADMIN'
            ],
            [
                'Jane Doe',
                'jane@example.com',
                'password123',
                'MAHASISWA'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Password',
            'Role'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Add a note about roles
                $roles = Role::pluck('nama_role')->toArray();
                $sheet->setCellValue('F1', 'DAFTAR ROLE YANG TERSEDIA:');
                $sheet->getStyle('F1')->getFont()->setBold(true);
                
                $row = 2;
                foreach($roles as $role) {
                    $sheet->setCellValue('F' . $row, $role);
                    $row++;
                }

                $sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                
                // Styling headers
                $sheet->getStyle('A1:D1')->getFont()->setBold(true);
                $sheet->getStyle('A1:D1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD3D3D3');
            },
        ];
    }
}
