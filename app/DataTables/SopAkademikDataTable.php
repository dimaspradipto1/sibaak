<?php

namespace App\DataTables;

use App\Models\SopAkademik;
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

class SopAkademikDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SopAkademik> $query Results from query() method.
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
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap: 5px;">';
                if (Gate::check('sop_akademik_edit')) {
                    $btn .= '<a href="' . route('sopakademik.edit', $item->id) . '" class="btn btn-sm btn-warning text-white rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Edit"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i></a>';
                }
                if (Gate::check('sop_akademik_delete')) {
                    $btn .= '<form action="' . route('sopakademik.destroy', $item->id) . '" method="POST" class="m-0">' . csrf_field() . method_field('delete') . '<button type="submit" class="btn btn-danger btn-sm rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Hapus" onclick="return confirm(\'Hapus data ini?\')"><i class="fa-solid fa-trash-can" style="font-size: 11px;"></i></button></form>';
                }
                $btn .= '</div>';
                
                if (Gate::check('sop_akademik_edit') || Gate::check('sop_akademik_delete')) {
                    return $btn;
                }
                return '<span class="text-muted small">-</span>';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'users_id', 'file', 'status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SopAkademik>
     */
    public function query(SopAkademik $model): QueryBuilder
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
            ->setTableId('sopakademik-table')
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
                ->title('NO')
                ->addClass('text-center')
                ->width('5%'),
            Column::make('nama_sop')
                ->title('NAMA SOP'),
            Column::make('fakultas')
                ->title('FAKULTAS'),
            Column::make('file')
                ->title('DOKUMEN'),
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
            ->exportable(false)
            ->title('AKSI')
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
        return 'SopAkademik_' . date('YmdHis');
    }
}
