<?php

namespace App\DataTables;

use App\Models\UserGuideMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserGuideMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<UserGuideMahasiswa> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($item) {
                return '<a href="' . route('userGuideMahasiswa.edit', $item->id) . '" class="btn btn-sm btn-warning text-white px-3 rounded" title="edit"><i class="fa-solid fa-pen-to-square"></i></a> 
                        <form action="' . route('userGuideMahasiswa.destroy', $item->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <button type="submit" class="btn btn-danger btn-sm px-3 rounded" title="hapus"><i class="fa-solid fa-trash-can" ></i></button>
                        </form>';
            })
            ->editColumn('deskripsi', function ($item) {
                return strip_tags($item->deskripsi);
            })
            ->addColumn('liat_dokumen', function ($item) {
                return '<a href="' . $item->link_dokumen . '" target="_blank" style="background-color: #104819; color: #ffffff;" class="btn btn-sm px-3 rounded" title="Lihat Dokumen"><i class="fa-solid fa-eye"></i> Detail</a>';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'liat_dokumen']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<UserGuideMahasiswa>
     */
    public function query(UserGuideMahasiswa $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userguidemahasiswa-table')
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
                ->title('No')
                ->width('5%'),
            Column::make('title')
                ->title('Title'),
            Column::make('deskripsi')
                ->title('Deskripsi'),
            Column::computed('liat_dokumen')
                ->title('Link Dokumen')
                ->addClass('text-center'),
            Column::computed('action')
                ->title('Aksi')
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
        return 'UserGuideMahasiswa_' . date('YmdHis');
    }
}
