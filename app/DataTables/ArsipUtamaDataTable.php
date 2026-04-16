<?php

namespace App\DataTables;

use App\Models\ArsipUtama;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArsipUtamaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->editColumn('kategori_arsip_id', function ($item) {
                return $item->kategoriArsip ? $item->kategoriArsip->kategori_arsip : '-';
            })
            ->filterColumn('kategori_arsip_id', function ($query, $keyword) {
                $query->whereHas('kategoriArsip', function ($q) use ($keyword) {
                    $q->where('kategori_arsip', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('user_id', function ($item) {
                return $item->user ? $item->user->name : '-';
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('file_arsip', function ($item) {
                if (!$item->file_arsip) return '-';
                return '<a href="' . asset($item->file_arsip) . '" target="_blank"
                            class="btn btn-sm btn-success text-white px-3 rounded">
                            <i class="fa-solid fa-eye"></i> Lihat Dokumen
                        </a>';
            })
            ->addColumn('action', function ($item) {
                $btn = '
                    <a href="' . route('arsiputama.edit', $item->id) . '" class="btn btn-warning btn-sm px-3 rounded" title="edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                ';
                if (!Auth::user()->is_tata_usaha) {
                    $btn .= '
                        <form action="' . route('arsiputama.destroy', $item->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm px-3 rounded" title="hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    ';
                }
                return $btn;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'file_arsip']);
    }

    public function query(ArsipUtama $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['kategoriArsip', 'user']);

        if (Auth::check() && Auth::user()->is_tata_usaha) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('arsiputama-table')
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
                        Button::make('reload'),
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('NO')
                ->width('5%')
                ->addClass('text-center'),
            Column::make('kategori_arsip_id')
                ->title('KATEGORI ARSIP'),
            Column::make('tahun_arsip')
                ->title('TAHUN')
                ->width('10%')
                ->addClass('text-center'),
            Column::make('nama_arsip')
                ->title('NAMA ARSIP'),
            Column::make('user_id')
                ->title('DIAJUKAN OLEH'),
            Column::make('file_arsip')
                ->title('DOKUMEN'),
            Column::computed('action')
                ->title('AKSI')
                ->exportable(false)
                ->printable(false)
                ->width('12%')
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ArsipUtama_' . date('YmdHis');
    }
}
