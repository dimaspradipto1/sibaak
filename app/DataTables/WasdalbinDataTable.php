<?php

namespace App\DataTables;

use App\Models\Wasdalbin;
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

class WasdalbinDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Wasdalbin> $query Results from query() method.
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
                            class="btn btn-sm btn-success text-white px-3 rounded">
                            <i class="fa-solid fa-eye"></i> Lihat Dokumen
                        </a>';
            })
            ->addColumn('status', function ($item) {
                if ($item->is_active) {
                    return '
                        <button type="button" class="btn btn-sm btn-primary badge-pill shadow-sm px-3 py-1 btn-toggle-status" data-id="' . $item->id . '" data-status="0" style="font-size: 10px; min-width: 80px; border: none;">
                            <i class="fas fa-toggle-on mr-1"></i> AKTIF
                        </button>
                    ';
                } else {
                    return '
                        <button type="button" class="btn btn-sm btn-secondary badge-pill shadow-sm px-3 py-1 btn-toggle-status" data-id="' . $item->id . '" data-status="1" style="font-size: 10px; min-width: 80px; border: none; background: #e0e0e0; color: #777;">
                            <i class="fas fa-toggle-off mr-1"></i> INAKTIF
                        </button>
                    ';
                }
            })
            ->addColumn('action', function ($item) {
                $btn = '';
                if (Gate::check('wasdalbin_edit')) {
                    $btn .= '
                        <a href="' . route('wasdalbin.edit', $item->id) . '" class="btn btn-warning btn-sm px-3 rounded mx-1" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    ';
                }
                if (Gate::check('wasdalbin_delete')) {
                    $btn .= '
                        <form action="' . route('wasdalbin.destroy', $item->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm px-3 rounded mx-1" title="Hapus" onclick="return confirm(\'Hapus data ini?\')"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    ';
                }
                if (empty(trim($btn))) {
                    $btn = '<span class="text-muted small">-</span>';
                }
                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'file', 'users_id', 'status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Wasdalbin>
     */
    public function query(Wasdalbin $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['users']);

        // Jika bukan superadmin atau admin, hanya tampilkan data milik sendiri (kecuali memiliki akses view)
        if (Auth::check() && !Auth::user()->is_superadmin && !Auth::user()->is_admin && !Gate::allows('wasdalbin_view')) {
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
            ->setTableId('wasdalbin-table')
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
        $columns = [
            Column::make('DT_RowIndex')
                ->title('No')
                ->width('5%')
                ->addClass('text-center'),
            Column::make('tahun')
                ->title('TAHUN'),
            Column::make('nama_wasdalbin')
                ->title('NAMA WASDALBIN'),
            Column::make('fakultas')
                ->title('FAKULTAS'),
            Column::make('file')
                ->title('DOKUMEN')
                ->addClass('text-center'),
            Column::computed('status')
                ->title('STATUS')
                ->width('10%')
                ->addClass('text-center'),
        ];

        if (Auth::check() && Auth::user()->can_see_staff_name) {
            $columns[] = Column::make('users_id')
                ->title('DIAJUKAN OLEH');
        }

        $columns[] = Column::computed('action')
            ->title('AKSI')
            ->exportable(false)
            ->printable(false)
            ->width('15%')
            ->addClass('text-center');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Wasdalbin_' . date('YmdHis');
    }
}
