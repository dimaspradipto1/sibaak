<?php

namespace App\DataTables;

use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProgramStudiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ProgramStudi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($item) {
                $btn = '';
                if (Gate::check('program_studi_edit')) {
                    $btn .= '<a href="' . route('programStudi.edit', $item->id) . '" class="btn btn-sm btn-warning text-white px-3 rounded mx-1" title="edit"><i class="fa-solid fa-pen-to-square"></i></a>';
                }
                if (Gate::check('program_studi_delete')) {
                    $btn .= '
                        <form action="' . route('programStudi.destroy', $item->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <button type="submit" class="btn btn-danger btn-sm px-3 rounded mx-1" title="hapus" onclick="return confirm(\'Hapus data ini?\')">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        </form>
                    ';
                }
                if (empty(trim($btn))) {
                    $btn = '<span class="text-muted small">-</span>';
                }
                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action'])
            ->filterColumn('DT_RowIndex', function ($query, $keyword) {
                $query->where('id', 'like', "%{$keyword}%");
            })
            ->filterColumn('program_studi', function ($query, $keyword) {
                $query->where('program_studi', 'like', "%{$keyword}%");
            });
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ProgramStudi>
     */
    public function query(ProgramStudi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('programstudi-table')
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
            Column::make('program_studi')
                ->title('PROGRAM STUDI')
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
        return 'ProgramStudi_' . date('YmdHis');
    }
}
