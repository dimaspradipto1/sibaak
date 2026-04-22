<?php

namespace App\DataTables;

use App\Models\TahunAkademik;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TahunAkademikDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<TahunAkademik> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()  
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($item) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap: 5px;">';
                if (Gate::check('tahun_akademik_edit')) {
                    $btn .= '<a href="' . route('tahunAkademik.edit', $item->id) . '" class="btn btn-sm btn-warning text-white rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Edit"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i></a>';
                }
                if (Gate::check('tahun_akademik_delete')) {
                    $btn .= '<form action="' . route('tahunAkademik.destroy', $item->id) . '" method="POST" class="m-0">' . csrf_field() . method_field('delete') . '<button type="submit" class="btn btn-danger btn-sm rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Hapus" onclick="return confirm(\'Hapus data ini?\')"><i class="fa-solid fa-trash-can" style="font-size: 11px;"></i></button></form>';
                }
                $btn .= '</div>';
                
                if (Gate::check('tahun_akademik_edit') || Gate::check('tahun_akademik_delete')) {
                    return $btn;
                }
                return '<span class="text-muted small">-</span>';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action'])
            ->filterColumn('tahun_akademik', function ($query, $keyword) {
                $query->where('tahun_akademik', 'like', "%{$keyword}%");
            });
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<TahunAkademik>
     */
    public function query(TahunAkademik $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tahunakademik-table')
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
            Column::make('tahun_akademik')
                ->title('TAHUN AKADEMIK'),
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
        return 'TahunAkademik_' . date('YmdHis');
    }
}
