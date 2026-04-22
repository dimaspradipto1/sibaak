<?php

namespace App\DataTables;

use App\Models\Pedoman;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
            ->filterColumn('users_id', function ($query, $keyword) {
                $query->whereHas('users', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('file', function ($item) {
                return '<a href="' . asset($item->file) . '" target="_blank"
                            class="btn btn-sm btn-info text-white rounded shadow-sm d-flex align-items-center justify-content-center px-3" style="height: 30px;">
                            <i class="fa-solid fa-eye mr-2" style="font-size: 11px;"></i> <span style="font-size: 11px; font-weight: 600;">DOKUMEN</span>
                        </a>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap: 5px;">';
                if (Gate::check('pedoman_edit')) {
                    $btn .= '<a href="' . route('pedoman.edit', $row->id) . '" class="btn btn-sm btn-warning text-white rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Edit"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i></a>';
                }
                if (Gate::check('pedoman_delete')) {
                    $btn .= '<form action="' . route('pedoman.destroy', $row->id) . '" method="POST" class="m-0">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Hapus" onclick="return confirm(\'Hapus data ini?\')"><i class="fa-solid fa-trash-can" style="font-size: 11px;"></i></button></form>';
                }
                $btn .= '</div>';
                
                if (Gate::check('pedoman_edit') || Gate::check('pedoman_delete')) {
                    return $btn;
                }
                return '<span class="text-muted small">-</span>';
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
        $query = $model->newQuery()->with(['users']);

        // Jika bukan superadmin atau admin, hanya tampilkan data milik sendiri
        if (Auth::check() && !Auth::user()->is_superadmin && !Auth::user()->is_admin) {
            $query->where('users_id', Auth::id());
        }

        return $query;
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
            Column::make('fakultas')
                ->title('FAKULTAS'),
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
