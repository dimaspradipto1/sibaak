<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('name', function ($item) {
                return $item->name;
            })
            ->addColumn('email', function ($item) {
                return $item->email;
            })
            ->addColumn('status', function ($item) {
                return $item->role?->nama_role ?? '-';
            })
            ->addColumn('action', function ($user) {
                $btn = '';
                if (Gate::check('users_edit')) {
                    $btn .= '<a href="' . route('users.updatePassword', $user->id) . '" class="btn btn-sm btn-info text-white px-3 rounded mx-1"><i class="fa-solid fa-key"></i></a>';
                    $btn .= '<a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-warning text-white px-3 rounded mx-1"><i class="fa-solid fa-pen-to-square"></i></a>';
                }
                if (Gate::check('users_delete')) {
                    $btn .= '
                        <form action="' . route('users.destroy', $user->id) . '" method="POST" style="display: inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger px-3 rounded mx-1" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    ';
                }
                if (empty(trim($btn))) {
                    $btn = '<span class="text-muted small">-</span>';
                }
                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'status'])
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->where('email', 'like', "%{$keyword}%");
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereHas('role', function ($q) use ($keyword) {
                    $q->where('nama_role', 'like', "%{$keyword}%");
                });
            });
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with('role');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
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
            Column::make('name')
                ->title('Nama Pengguna'),
            Column::make('email')
                ->title('Email'),
            Column::make('status')
                ->title('Hak Akses'),
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
        return 'User_' . date('YmdHis');
    }
}
