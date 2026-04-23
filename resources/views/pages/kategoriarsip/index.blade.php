@extends('layouts.dashboard.template')

@section('title', 'Kategori Arsip')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #046B26 !important;">
    <div class="card-header bg-white border-bottom py-2 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 4px; height: 22px; background: #046B26; border-radius: 2px;" class="mr-2"></div>
                <h5 class="m-0 font-weight-bold text-dark" style="font-size: 1rem;">Data Kategori Arsip</h5>
            </div>
            <div class="d-inline-flex shadow-sm overflow-hidden" style="border: 1px solid #e3e6f0; border-radius: 30px;">
                @can('kategori_arsip_create')
                <a href="{{ route('kategoriarsip.create') }}" class="btn btn-success btn-xs font-weight-bold px-3 py-1 border-0" style="background-color: #046B26; color: white; font-size: 10px; height: 32px; line-height: 24px; border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                    <i class="fas fa-plus mr-1"></i> TAMBAH
                </a>
                @endcan
                <button type="button" class="btn btn-white btn-xs px-3 py-1 border-0 border-left rounded-0 text-primary" data-toggle="modal" data-target="#modalImport" style="font-size: 10px; height: 32px; line-height: 24px;">
                    <i class="fas fa-file-import mr-1"></i> IMPORT
                </button>
                <a href="{{ route('kategoriarsip.export-template') }}" class="btn btn-white btn-xs px-3 py-1 border-0 border-left font-weight-bold" style="font-size: 10px; height: 32px; line-height: 24px; border-top-right-radius: 30px; border-bottom-right-radius: 30px; color: #28a745;">
                    <i class="fas fa-file-excel mr-1"></i> TEMPLATE
                </a>
            </div>
        </div>
    </div>
    <div class="card-block p-0">
        <div class="table-responsive">
           {{ $dataTable->table([
                    'class' => 'table table-hover mb-0 w-100',
                    'id' => 'kategoriarsip-table'
                ]) }}
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold" id="modalImportLabel" style="font-size: 1rem;">Import Kategori Arsip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kategoriarsip.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small">Pilih File Excel (.xlsx, .xls)</label>
                        <input type="file" name="file" class="form-control-file border p-2 rounded w-100" required>
                        <small class="text-muted d-block mt-2">Gunakan template yang tersedia untuk memastikan format data benar.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        /* Compact Design Consistent with Arsip Utama */
        #kategoriarsip-table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.4px;
            color: #4e73df;
            border-bottom: 2px solid #e3e6f0;
            padding: 8px 10px !important;
            vertical-align: middle;
        }
        #kategoriarsip-table tbody td {
            vertical-align: middle;
            padding: 6px 10px !important;
            color: #5a5c69;
            font-size: 12px;
            border-bottom: 1px solid #f1f3f9;
        }
        #kategoriarsip-table tbody tr:hover {
            background-color: #fcfdff;
        }
        
        .btn-white {
            background-color: #fff;
            color: #6e707e;
        }
        .btn-white:hover {
            background-color: #f8f9fc;
            color: #4e73df;
        }
        .rounded-md { border-radius: 6px !important; }
    </style>
@endpush

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
