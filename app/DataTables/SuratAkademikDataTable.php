<?php

namespace App\DataTables;

use App\Models\SuratAkademik;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SuratAkademikDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SuratAkademik> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('users_id', function ($item) {
                return $item->user ? $item->user->name : '-';
            })
            ->addColumn('program_studi_id', function ($item) {
                return $item->programStudi ? $item->programStudi->program_studi : '-';
            })
            ->addColumn('status', function ($item) {
                return $item->status == 'pending' ? '<span class="badge badge-warning text-white px-3 py-2">Pending</span>' : ($item->status == 'diterima' ? '<span class="badge badge-success text-white px-3 py-2">Diterima</span>' : ($item->status == 'ditolak' ? '<span class="badge badge-danger text-white px-3 py-2">Ditolak</span>' : '-'));
            })
            ->addColumn('action', function ($item) {
                $showButton = '';
                $editButton = '';
                $updateStatusButton = '';
                $deleteButton = '';

                // Tombol cetak/print untuk yang punya akses edit atau delete (Staff/Admin)
                if (Gate::check('surat_akademik_edit') || Gate::check('surat_akademik_delete')) {
                    $showButton = '<a href="' . route('suratAkademik.show', $item->id) . '" class="btn btn-sm btn-success text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Cetak Surat" target="_blank"><i class="fa-solid fa-print"></i><span class="d-none d-md-inline"> Cetak Surat</span></a>';
                }
                if (Gate::check('surat_akademik_edit')) {
                    $editButton = '<a href="' . route('suratAkademik.edit', $item->id) . '" class="btn btn-sm btn-warning text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $updateStatusButton = '<a href="' . route('suratAkademik.editStatus', $item->id) . '" class="btn btn-sm btn-info text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Update Status"><i class="fa-solid fa-check-circle"></i><span class="d-none d-lg-inline"> Status</span></a>';
                }
                if (Gate::check('surat_akademik_delete')) {
                    $deleteButton = '
                        <form action="' . route('suratAkademik.destroy', $item->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Hapus" onclick="return confirm(\'Hapus data ini?\')"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    ';
                }

                // Tombol untuk mahasiswa
                if (Auth::user()->is_mahasiswa) {
                    if ($item->status == 'pending') {
                        $showButton = '<span class="text-info small font-italic"><i class="fa-solid fa-clock mr-1"></i>Estimasi surat diproses 3 hari kerja</span>';
                    } else {
                        $showButton = '<a href="' . route('suratAkademik.show', $item->id) . '" class="btn btn-sm btn-info text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Lihat Detail"><i class="fa-solid fa-eye"></i><span class="d-none d-md-inline"> Detail</span></a>';
                        
                        if ($item->status == 'diterima') {
                            $showButton .= '<a href="' . route('suratAkademik.show', $item->id) . '" class="btn btn-sm btn-success text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Cetak Surat" target="_blank"><i class="fa-solid fa-print"></i><span class="d-none d-md-inline"> Cetak Surat</span></a>';
                        }
                    }
                }

                $result = $showButton . $editButton . $updateStatusButton . $deleteButton;
                if (empty(trim($result))) {
                    $result = '<span class="text-muted small">-</span>';
                }
                return $result;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'users_id', 'program_studi_id', 'status']);
    }


    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SuratAkademik>
     */
    public function query(SuratAkademik $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['user', 'programStudi']);

        if (Auth::user()->is_mahasiswa) {
            $query->where('users_id', Auth::id());
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('suratakademik-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->scrollX(true)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('NO')
                ->width('5%')
                ->addClass('text-center'),
            Column::make('users_id')
                ->title('NAMA MAHASISWA')
                ->width('15%')
                ->addClass('text-start'),
            Column::make('program_studi_id')
                ->title('PROGRAM STUDI')
                ->width('15%')
                ->addClass('text-start'),
            Column::make('status')
                ->title('STATUS')
                ->width('10%')
                ->addClass('text-center'),
            Column::computed('action')
                ->title('AKSI')
                ->exportable(false)
                ->printable(false)
                ->width('20%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SuratAkademik_' . date('YmdHis');
    }
}
