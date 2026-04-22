@extends('layouts.dashboard.template')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; overflow: hidden; border-top: 5px solid #046B26 !important;">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div style="width: 4px; height: 25px; background: #046B26; border-radius: 2px;" class="mr-2"></div>
                        <h5 class="m-0 font-weight-bold text-dark">Data Unit Kerja</h5>
                    </div>
                    @can('unit_kerja_create')
                    <a href="{{ route('unitkerja.create') }}" class="btn btn-success btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg border-0" style="background-color: #046B26;">
                        <i class="fas fa-plus mr-1"></i> TAMBAH
                    </a>
                    @endcan
                </div>
            </div>
            <div class="card-body p-0">
                <div class="p-4">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover mb-0 w-100', 'id' => 'unitkerja-table']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        #unitkerja-table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            color: #5a5c69;
            border-bottom: 2px solid #e3e6f0;
            padding: 15px 10px;
            vertical-align: middle;
        }
        #unitkerja-table tbody td {
            vertical-align: middle;
            padding: 12px 10px;
            color: #5a5c69;
            font-size: 13px;
        }
    </style>
@endpush

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

