<?php

namespace App\DataTables;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UnitKerjaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('parent', function ($item) {
                return $item->parent ? $item->parent->nama_unit : '<span class="badge badge-secondary">Root (Top Level)</span>';
            })
            ->addColumn('action', function ($item) {
                return '
                <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                    <a href="' . route('unitkerja.edit', $item->id) . '" class="btn btn-sm btn-warning text-white rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Edit"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i></a>
                    <form action="' . route('unitkerja.destroy', $item->id) . '" method="POST" class="m-0">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <button type="submit" class="btn btn-danger btn-sm rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Hapus" onclick="return confirm(\'Hapus unit ini?\')"><i class="fa-solid fa-trash-can" style="font-size: 11px;"></i></button>
                    </form>
                </div>';
            })
            ->rawColumns(['action', 'parent'])
            ->setRowId('id');
    }

    public function query(UnitKerja $model): QueryBuilder
    {
        return $model->newQuery()->with('parent');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('unitkerja-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                         'scrollX' => true,
                         'language' => ['searchPlaceholder' => 'Cari unit...']
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('NO')
                ->width('5%')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('nama_unit')->title('NAMA UNIT'),
            Column::make('kode_unit')->title('KODE UNIT')->addClass('text-center'),
            Column::computed('parent')->title('ATASAN / PARENT'),
            Column::computed('action')->title('AKSI')->width('15%')->addClass('text-center'),
        ];
    }
}
