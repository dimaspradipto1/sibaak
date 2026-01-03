<?php

namespace App\DataTables;

use App\Models\SuratAktif;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SuratAktifDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SuratAktif> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('users_id', function ($item) {
                return $item->users ? $item->users->name : '-';
            })
            ->addColumn('program_studi_id', function ($item) {
                return $item->programStudi ? $item->programStudi->program_studi : '-';
            })
            ->addColumn('status', function ($item) {
                return $item->status == 'pending' ? '<span class="badge badge-warning text-white px-3 py-2">Pending</span>' : ($item->status == 'diterima' ? '<span class="badge badge-success text-white px-3 py-2">Diterima</span>' : ($item->status == 'ditolak' ? '<span class="badge badge-danger text-white px-3 py-2">Ditolak</span>' : '-'));
            })
            ->addColumn('action', function ($item) {
                $actions = '';
                if (Auth::user()->is_admin || Auth::user()->is_staffbaak) {
                    $actions .= '
                            <a href="' . route('suratAktif.show', $item->id) . '" class="btn btn-sm btn-primary text-white px-3 rounded" title="print"><i class="fa-solid fa-print"></i></a>
                            <a href="' . route('suratAktif.show', $item->id) . '" class="btn btn-sm btn-info text-white px-3 rounded" title="detail"><i class="fa-solid fa-eye"></i></a> 
                            <a href="' . route('suratAktif.edit', $item->id) . '" class="btn btn-sm btn-warning text-white px-3 rounded" title="edit"><i class="fa-solid fa-pen-to-square"></i></a> 
                            <form action="' . route('suratAktif.destroy', $item->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('delete') . '
                                <button type="submit" class="btn btn-danger btn-sm px-3 rounded" title="hapus"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        ';
                }

                if ($item->status == 'diterima' && Auth::user()->is_mahasiswa) {
                    $actions .= '
                            <a href="' . route('suratAktif.show', $item->id) . '" class="btn btn-sm btn-primary text-white px-3 rounded" title="print"><i class="fa-solid fa-print"></i></a>
                        ';
                }

                return $actions;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'users_id', 'program_studi_id', 'status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SuratAktif>
     */
    public function query(SuratAktif $model): QueryBuilder
    {
        // return $model->newQuery();
        $query = $model->newQuery()
            ->with(['users', 'programStudi']); // eager load biar cepat

        if (Auth::user()->is_admin || Auth::user()->is_staffbaak) {
            // Admin & Staff BAAK lihat semua
            return $query;
        }

        if (Auth::user()->is_mahasiswa) {
            // Mahasiswa hanya lihat miliknya
            return $query->where('users_id', Auth::id());
        }

        // Role lain: kosong
        return $query->whereRaw('1=0');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('surataktif-table')
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
            Column::make('users_id')
                ->title('NAMA MAHASISWA')
                ->width('15%')
                ->addClass('text-start'),
            Column::make('program_studi_id')
                ->title('PROGRAM STUDI')
                ->width('15%')
                ->addClass('text-start'),
            Column::make('status')
                ->title('STATUS')
                ->width('10%')
                ->addClass('text-center'),
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
        return 'SuratAktif_' . date('YmdHis');
    }
}
