<?php

namespace App\DataTables;

use App\Models\KategoriArsip;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KategoriArsipDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<KategoriArsip> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($item) {
                $btn = '';
                if (Gate::check('kategori_arsip_edit')) {
                    $btn .= '
                        <a href="' . route('kategoriarsip.edit', $item->id) . '" class="btn btn-warning btn-sm px-3 rounded mx-1" title="edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    ';
                }
                if (Gate::check('kategori_arsip_delete')) {
                    $btn .= '
                        <form action="' . route('kategoriarsip.destroy', $item->id) . '" method="POST" class="d-inline">
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
            ->setRowId('id')
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<KategoriArsip>
     */
    public function query(KategoriArsip $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kategoriarsip-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'scrollX' => true,
                    ])
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
            Column::make('kategori_arsip')
                ->title('KATEGORI ARSIP'),
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
        return 'KategoriArsip_' . date('YmdHis');
    }
}
