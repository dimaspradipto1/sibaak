<?php

namespace App\DataTables;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($item) {
                return '
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="' . route('role.edit-permission', $item->id) . '" 
                           class="btn btn-sm rounded shadow-sm d-inline-flex align-items-center mx-1" 
                           style="background-color: #00A551; color: white; border: none; padding: 6px 12px;"
                           title="Pengaturan Hak Akses">
                            <i class="fa-solid fa-shield-halved mr-1" style="font-size: 0.85rem;"></i> <span style="font-size: 0.85rem; font-weight: 600;">Akses</span>
                        </a>
                        <a href="' . route('role.edit', $item->id) . '" 
                           class="btn btn-sm rounded shadow-sm d-inline-flex align-items-center justify-content-center mx-1" 
                           style="background-color: #4099ff; color: white; border: none; width: 34px; height: 34px;"
                           title="Edit Role">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 0.85rem;"></i>
                        </a>
                        <form action="' . route('role.destroy', $item->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" 
                                    class="btn btn-sm rounded shadow-sm d-inline-flex align-items-center justify-content-center mx-1" 
                                    style="background-color: #FF5370; color: white; border: none; width: 34px; height: 34px;"
                                    title="Hapus Role"
                                    onclick="return confirm(\'Anda yakin ingin menghapus role ini?\')">
                                <i class="fa-solid fa-trash-can" style="font-size: 0.85rem;"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->setRowId('id')
            ->rawColumns(['action']);
    }

    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('role-table')
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
            Column::make('nama_role')
                ->title('NAMA ROLE'),
            Column::computed('action')
                ->title('AKSI')
                ->exportable(false)
                ->printable(false)
                ->width('15%')
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
