<?php

namespace App\DataTables;

use App\Models\SkKepanitiaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SkKepanitiaanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SkKepanitiaan> $query Results from query() method.
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
            ->editColumn('jenissk_id', function ($item) {
                return $item->jenissk ? $item->jenissk->jenis_sk : '-';
            })
            ->addColumn('file', function ($item) {
                return '<a href="' . asset($item->file) . '" target="_blank"
                            class="btn btn-sm btn-success text-white px-3 rounded">
                            <i class="fa-solid fa-eye"></i> Lihat Dokumen
                        </a>';
            })
            ->addColumn('action', function ($item) {
                return '
                    <a href="' . route('skkepanitiaan.show', $item->id) . '" class="btn btn-dark btn-sm px-3 rounded" title="lihat">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="' . route('skkepanitiaan.edit', $item->id) . '" class="btn btn-warning btn-sm px-3 rounded" title="edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="' . route('skkepanitiaan.destroy', $item->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <button type="submit" class="btn btn-danger btn-sm px-3 rounded" title="hapus">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                ';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'file', 'users_id', 'tahun_akademik_id', 'jenissk_id']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SkKepanitiaan>
     */
    public function query(SkKepanitiaan $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model->newQuery()->with(['tahunAkademik', 'users', 'jenissk']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('skkepanitiaan-table')
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
            Column::make('tahun_akademik_id')
                ->title('TAHUN AKADEMIK'),
            Column::make('jenissk_id')
                ->title('JENIS SK'),
            Column::make('users_id')
                ->title('NAMA STAFF'),
            Column::make('fakultas')
                ->title('FAKULTAS'),
            Column::make('file')
                ->title('DOKUMEN'),
            Column::computed('action')
                ->title('AKSI')
                ->width('15%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SkKepanitiaan_' . date('YmdHis');
    }
}
