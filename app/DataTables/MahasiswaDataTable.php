<?php

namespace App\DataTables;

use App\Models\Mahasiswa;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class MahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Mahasiswa> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', 'id')  // Pastikan kolom ini ada di database
            ->addColumn('user.name', function ($item) {
                return $item->user ? $item->user->name : '-'; 
            })
            ->addColumn('user.email', function ($item) {
                return $item->user ? $item->user->email : '-'; 
            })
            ->addColumn('programStudi.program_studi', function ($item) {
                return $item->programStudi ? $item->programStudi->program_studi : '-';
            })
            ->addColumn('action', function ($item) {
                $actions = '
                    <a href="'.route('mahasiswa.show', $item->id).'" class="btn btn-sm btn-dark text-white px-3 rounded" title="detail"><i class="fa-solid fa-eye"></i></a> 
                    <a href="'.route('mahasiswa.edit', $item->id).'" class="btn btn-sm btn-warning text-white px-3 rounded" title="edit"><i class="fa-solid fa-pen-to-square"></i></a> 
                ';
            
                if (Auth::user()->is_admin) {
                    $actions .= '
                        <form action="'.route('mahasiswa.destroy', $item->id).'" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm px-3 rounded" title="hapus"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    ';
                }
            
                return $actions;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'user.name', 'user.email', 'programStudi.program_studi', 'detail'])
            ->filterColumn('DT_RowIndex', function ($query, $keyword) {
                $query->where('id', 'like', "%{$keyword}%");
            })
            ->filterColumn('programStudi.program_studi', function ($query, $keyword) {
                $query->where('program_studi', 'like', "%{$keyword}%");
            });
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Mahasiswa>
     */
    public function query(Mahasiswa $model): QueryBuilder
    {
        // return $model->newQuery();
        // Query awal
        $query = $model->newQuery()->with('user', 'programStudi'); // eager load

        // Periksa apakah user adalah admin
        if (Auth::user()->is_admin) {
            // Admin bisa melihat semua data mahasiswa
            return $query;
        }

        // Periksa apakah user adalah mahasiswa
        if (Auth::user()->is_mahasiswa) {
            // Mahasiswa hanya melihat data miliknya sendiri
            return $query->where('users_id', Auth::id());
        }

        // Default: jika role tidak dikenali, tidak menampilkan data apapun
        return $query->whereRaw('1=0'); 
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('mahasiswa-table')
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
            Column::make('user.name')
                ->title('NAMA')
                ->addClass('text-start'),
            Column::make('user.email')
                ->title('EMAIL')
                ->addClass('text-center'),
            Column::make('programStudi.program_studi')
                ->title('PROGRAM STUDI')
                ->addClass('text-start'),
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
        return 'Mahasiswa_' . date('YmdHis');
    }
}
