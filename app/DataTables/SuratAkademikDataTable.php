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
                    return $item->users ? $item->users->name : '-';
                })
                ->addColumn('program_studi_id', function ($item) {
                    return $item->programStudi ? $item->programStudi->program_studi : '-';
                })
                ->addColumn('action', function ($item) {
                    $editButton = '';
                    $deleteButton = '';
                    $showButton = '<a href="' . route('suratAkademik.show', $item->id) . '" class="btn btn-sm btn-dark text-white px-3 mr-2 rounded" title="show"><i class="fa-solid fa-print"></i></a>';

                    if (Auth::user()->is_admin || Auth::user()->is_staffbaak) {
                        $editButton = '<a href="' . route('suratAkademik.edit', $item->id) . '" class="btn btn-sm btn-warning text-white px-3 mr-2 rounded" title="edit"><i class="fa-solid fa-pen-to-square"></i></a>';
                        $deleteButton = '
                        <form action="' . route('suratAkademik.destroy', $item->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm px-3 mr-2 rounded" title="hapus"><i class="fa-solid fa-trash-can" ></i></button>
                        </form>
                    ';
                    }

                    return $showButton . $editButton . $deleteButton;
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
        return $model->newQuery();
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
                  ->width('15%')
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
