<?php

namespace App\DataTables;

use App\Models\ArsipUtama;
use App\Models\KategoriArsip;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArsipUtamaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('kategori_arsip_id', function ($item) {
                return $item->kategoriArsip ? $item->kategoriArsip->kategori_arsip : '-';
            })
            ->filterColumn('kategori_arsip_id', function ($query, $keyword) {
                $query->whereHas('kategoriArsip', function ($q) use ($keyword) {
                    $q->where('kategori_arsip', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('user_id', function ($item) {
                return $item->user ? $item->user->name : '-';
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('file_arsip', function ($item) {
                if (!$item->file_arsip) return '-';
                return '<a href="' . asset($item->file_arsip) . '" target="_blank"
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
                $hasEdit = Gate::check('arsip_utama_edit');
                $hasDelete = Gate::check('arsip_utama_delete');

                if (!$hasEdit && !$hasDelete) {
                    return '<span class="text-muted small">-</span>';
                }

                $btn = '<div class="d-flex justify-content-center align-items-center">';

                if ($hasEdit) {
                    $btn .= '
                        <a href="' . route('arsiputama.edit', $item->id) . '" class="btn btn-warning btn-sm shadow-sm border-0 rounded mx-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Edit">
                            <i class="fas fa-edit text-white" style="font-size: 13px;"></i>
                        </a>
                    ';
                }

                if ($hasDelete) {
                    $btn .= '
                        <form action="' . route('arsiputama.destroy', $item->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn btn-danger btn-sm shadow-sm border-0 rounded mx-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Hapus" onclick="return confirm(\'Hapus data ini?\')">'
                        . '<i class="fas fa-trash-alt" style="font-size: 13px;"></i>
                            </button>
                        </form>
                    ';
                }

                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('nama_arsip', function ($item) {
                $plain = strip_tags($item->nama_arsip);
                $preview = mb_strimwidth($plain, 0, 120, '...');
                $html = htmlspecialchars($item->nama_arsip, ENT_QUOTES);
                return '<span title="' . $html . '" data-toggle="tooltip" data-placement="top"'
                    . ' data-html="true" style="cursor:default;">' . e($preview) . '</span>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'file_arsip', 'status', 'nama_arsip']);
    }

    public function query(ArsipUtama $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['kategoriArsip', 'user.role']);
        $user = Auth::user();

        // 1. Logika Hak Akses Hirarki Berdasarkan Unit Kerja
        $isHigherLevel = $user->is_superadmin || $user->is_admin || ($user->role && strtoupper($user->role->nama_role) == 'REKTOR');

        if (!$isHigherLevel) {
            $unitKerja = $user->role?->unitKerja;

            if ($unitKerja) {
                $roleName = strtoupper($user->role->nama_role);

                // Jika jabatan mengandung kata kunci pimpinan (KEPALA, KA. BIRO, WAKIL REKTOR, dsb)
                if (str_contains($roleName, 'KEPALA') || str_contains($roleName, 'KA. BIRO') || str_contains($roleName, 'REKTOR')) {
                    $accessibleUnitIds = $unitKerja->getAllDescendantIds();

                    $query->whereHas('user.role', function ($q) use ($accessibleUnitIds) {
                        $q->whereIn('unit_kerja_id', $accessibleUnitIds);
                    });
                } else {
                    // Jika STAFF biasa, hanya melihat miliknya sendiri
                    $query->where('user_id', $user->id);
                }
            } else {
                // Jika Role belum mapping ke Unit Kerja, hanya liat punya sendiri (safety fallback)
                $query->where('user_id', $user->id);
            }
        }

        // 2. Filter dari Sidebar (Search/Filter Logic)
        // 2. Filter dari Sidebar (Hierarki Unit)
        if ($unitId = request('unit_id')) {
            $selectedUnit = UnitKerja::find($unitId);
            if ($selectedUnit) {
                $descendantIds = $selectedUnit->getAllDescendantIds();
                $query->whereHas('user.role', function ($q) use ($descendantIds) {
                    $q->whereIn('unit_kerja_id', $descendantIds);
                });
            }
        }

        if ($tahun = request('tahun')) {
            $query->where('tahun_arsip', $tahun);
        }

        if ($kategori = request('kategori')) {
            $query->whereHas('kategoriArsip', function ($q) use ($kategori) {
                $q->where('kategori_arsip', $kategori);
            });
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('arsiputama-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'scrollX' => true,
                'processing' => false,
                'responsive' => false,
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(30)
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('kategori_arsip_id')
                ->title('KATEGORI ARSIP'),
            Column::make('tahun_arsip')
                ->title('TAHUN')
                ->width('8%')
                ->addClass('text-center'),
            Column::computed('status')
                ->title('STATUS')
                ->width('10%')
                ->addClass('text-center'),
            Column::make('nama_arsip')
                ->title('NAMA ARSIP'),
            Column::make('user_id')
                ->title('DIAJUKAN OLEH'),
            Column::make('file_arsip')
                ->title('DOKUMEN'),
            Column::computed('action')
                ->title('AKSI')
                ->exportable(false)
                ->printable(false)
                ->width('12%')
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ArsipUtama_' . date('YmdHis');
    }
}
