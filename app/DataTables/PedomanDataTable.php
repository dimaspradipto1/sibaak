<?php

namespace App\DataTables;

use App\Models\Pedoman;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PedomanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Pedoman> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->editColumn('users_id', function ($item) {
                return $item->users ? $item->users->name : '-';
            })
            ->addColumn('file', function ($item) {
                return '<a href="' . asset($item->file) . '" target="_blank"
                            class="btn btn-sm btn-success text-white px-3 rounded">
                            <i class="fa-solid fa-eye"></i> Lihat Dokumen
                        </a>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('pedoman.edit', $row->id) . '" class="btn btn-warning btn-sm px-3 rounded" title="edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                <form action="' . route("pedoman.destroy", $row->id) . '" method="POST" class="d-inline">
                ' . csrf_field() . '
                ' . method_field("DELETE") . '
                <button type="submit" class="btn btn-danger btn-sm px-3 rounded">
                <i class="fa-solid fa-trash-can"></i>
                </button>
                </form>';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'file', 'users_id']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Pedoman>
     */
    public function query(Pedoman $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pedoman-table')
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
                ->width('5%'),
            Column::make('tahun')
                ->title('TAHUN'),
            Column::make('nama_pedoman')
                ->title('NAMA PEDOMAN'),
            Column::make('users_id')
                ->title('DIKIRIM OLEH')
                ->width('15%'),
            Column::make('file')
                ->title('DOKUMEN')
                ->width('15%'),
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
        return 'Pedoman_' . date('YmdHis');
    }
}
