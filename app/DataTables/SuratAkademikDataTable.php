<?php

namespace App\DataTables;

use App\Models\SuratAkademik;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
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
            ->addColumn('action', function ($item) {
                $editButton = '';
                $updateStatusButton = '';
                $deleteButton = '';
                $showButton = '<a href="' . route('suratAkademik.show', $item->id) . '" class="btn btn-sm btn-success text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Silahkan Cetak Surat" target="_blank"><i class="fa-solid fa-print"></i><span class="d-none d-md-inline"> Silahkan Cetak Surat</span></a>';

                if (Auth::user()->is_admin || Auth::user()->is_staffbaak) {
                    $editButton = '<a href="' . route('suratAkademik.edit', $item->id) . '" class="btn btn-sm btn-warning text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $updateStatusButton = '<a href="' . route('suratAkademik.editStatus', $item->id) . '" class="btn btn-sm btn-info text-white py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Update Status"><i class="fa-solid fa-check-circle"></i><span class="d-none d-lg-inline"> Status</span></a>';
                    $deleteButton = '
                <form action="' . route('suratAkademik.destroy', $item->id) . '" method="POST" class="d-inline">
                    ' . csrf_field() . '
                    ' . method_field('delete') . '
                    <button type="submit" class="btn btn-danger btn-sm py-2 px-2 px-md-3 mb-1 mr-1 mr-md-2 rounded" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                </form>
            ';
                }

                return $showButton . $editButton . $updateStatusButton . $deleteButton;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'users_id', 'program_studi_id']);
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
