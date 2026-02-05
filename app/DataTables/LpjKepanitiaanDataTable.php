<?php

namespace App\DataTables;

use App\Models\LpjKepanitiaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LpjKepanitiaanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<LpjKepanitiaan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            // ->editColumn('tahun_akademik_id', function ($item) {
            //     return $item->tahunAkademik->tahun_akademik;
            // })
            ->editColumn('tahun_akademik_id', function ($item) {
                $ta  = optional($item->tahunAkademik)->tahun_akademik;
                $smt = $item->semester;

                return trim($ta . ' - ' . $smt, ' -');
            })
            ->editColumn('users_id', function ($item) {
                return $item->users ? $item->users->name : '-';
            })
            ->addColumn('file', function ($item) {
                return '<a href="' . asset($item->file) . '" target="_blank"
                            class="btn btn-sm btn-success text-white px-3 rounded">
                            <i class="fa-solid fa-eye"></i> Lihat Dokumen
                        </a>';
            })
            ->addColumn('action', function ($item) {
                return '
                    <a href="' . route('lpjkepanitiaan.show', $item->id) . '" class="btn btn-dark btn-sm px-3 rounded" title="show">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="' . route('lpjkepanitiaan.edit', $item->id) . '" class="btn btn-warning btn-sm px-3 rounded" title="edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="' . route('lpjkepanitiaan.destroy', $item->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <button type="submit" class="btn btn-danger btn-sm px-3 rounded" title="hapus">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                ';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'file', 'users_id', 'tahun_akademik_id', 'semester']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<LpjKepanitiaan>
     */
    public function query(LpjKepanitiaan $model): QueryBuilder
    {
        return $model->newQuery()->with(['tahunAkademik', 'users', 'jenissk']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('lpjkepanitiaan-table')
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
                ->width('5%'),
            Column::make('users_id')
                ->title('NAMA STAFF'),
            Column::make('tahun_akademik_id')
                ->title('TAHUN AKADEMIK')
                ->width('20%'),
            Column::make('nama_dokumen')
                ->title('NAMA LPJ'),
            Column::make('ketua')
                ->title('KETUA')
                ->width('30%'),
            Column::make('sekretaris')
                ->title('SEKRETARIS')
                ->width('30%'),
            Column::make('fakultas')
                ->title('FAKULTAS'),
            Column::make('file')
                ->title('DOKUMEN'),
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
        return 'LpjKepanitiaan_' . date('YmdHis');
    }
}
