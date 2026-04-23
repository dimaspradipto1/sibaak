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
                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                        <a href="' . route('role.edit-permission', $item->id) . '" 
                           class="btn btn-sm btn-success text-white rounded shadow-sm d-flex align-items-center px-3" 
                           style="height: 30px; background-color: #00A551; border: none;"
                           title="Pengaturan Hak Akses">
                            <i class="fa-solid fa-shield-halved mr-1" style="font-size: 11px;"></i> <span style="font-size: 11px; font-weight: 600;">AKSES</span>
                        </a>
                        <a href="' . route('role.edit', $item->id) . '" 
                           class="btn btn-sm btn-info text-white rounded shadow-sm d-flex align-items-center justify-content-center" 
                           style="width: 30px; height: 30px; background-color: #4099ff; border: none;"
                           title="Edit Role">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i>
                        </a>
                        <form action="' . route('role.destroy', $item->id) . '" method="POST" class="m-0">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" 
                                    class="btn btn-sm btn-danger text-white rounded shadow-sm d-flex align-items-center justify-content-center" 
                                    style="width: 30px; height: 30px; background-color: #FF5370; border: none;"
                                    title="Hapus Role"
                                    onclick="return confirm(\'Anda yakin ingin menghapus role ini?\')">
                                <i class="fa-solid fa-trash-can" style="font-size: 11px;"></i>
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
