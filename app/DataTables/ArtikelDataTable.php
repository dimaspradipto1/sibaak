<?php

namespace App\DataTables;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArtikelDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Artikel> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('users_id', function ($item) {
                return $item->user ? $item->user->name : '-';
            })
            ->addColumn('tipe', function ($item) {
                return '<span class="badge badge-info text-white px-3 py-2 text-capitalize">' . $item->tipe . '</span>';
            })
            ->addColumn('media_url', function ($item) {
                if ($item->media_url) {
                    $icon = strpos($item->media_url, 'youtube.com') !== false || strpos($item->media_url, 'youtu.be') !== false 
                        ? '<i class="fa-brands fa-youtube text-danger mr-1"></i>' 
                        : '<i class="fa-solid fa-link text-primary mr-1"></i>';
                    return $icon . '<a href="' . $item->media_url . '" target="_blank" class="small text-truncate d-inline-block" style="max-width: 150px;">' . $item->media_url . '</a>';
                }
                return '<span class="text-muted small">Tidak ada link</span>';
            })
            ->addColumn('action', function ($item) {
                $actions = '<div class="d-flex align-items-center justify-content-center" style="gap: 5px; flex-wrap: nowrap;">';
                
                // Preview button
                $actions .= '<a href="' . route('artikel.show', $item->id) . '" class="btn btn-sm btn-info text-white p-2 rounded" title="Lihat Detail">
                                <i class="fa-solid fa-eye"></i>
                             </a>';

                if (Gate::check('artikel_edit')) {
                    $actions .= '<a href="' . route('artikel.edit', $item->id) . '" class="btn btn-sm btn-warning text-white p-2 rounded" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                 </a>';
                }

                if (Gate::check('artikel_delete')) {
                    $actions .= '
                        <form action="' . route('artikel.destroy', $item->id) . '" method="POST" class="d-inline mb-0">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm p-2 rounded" title="Hapus" onclick="return confirm(\'Hapus artikel ini?\')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    ';
                }

                $actions .= '</div>';
                return $actions;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'tipe', 'media_url']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Artikel>
     */
    public function query(Artikel $model): QueryBuilder
    {
        return $model->newQuery()->with('user');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('artikel-table')
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
            Column::make('judul')
                ->title('JUDUL ARTIKEL'),
            Column::make('tipe')
                ->title('KATEGORI')
                ->addClass('text-center'),
            Column::make('users_id')
                ->title('PENULIS'),
            Column::make('media_url')
                ->title('MEDIA/LINK'),
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
        return 'Artikel_' . date('YmdHis');
    }
}
