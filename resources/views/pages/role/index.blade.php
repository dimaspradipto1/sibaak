@extends('layouts.dashboard.template')
@section('title', 'Role Akses')
@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; border-top: 5px solid #046B26 !important;">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 4px; height: 25px; background: #046B26; border-radius: 2px;" class="mr-2"></div>
                <h5 class="m-0 font-weight-bold text-dark">Data Role & Hak Akses</h5>
            </div>
            @can('role_create')
            <a href="{{ route('role.create') }}" class="btn btn-success btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg border-0" style="background-color: #046B26;">
                <i class="fas fa-plus mr-1"></i> TAMBAH
            </a>
            @endcan
        </div>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'style' => 'width:100%']) }}
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        #role-table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            color: #5a5c69;
            border-bottom: 2px solid #e3e6f0;
            padding: 15px 10px;
            vertical-align: middle;
        }
        #role-table tbody td {
            vertical-align: middle;
            padding: 12px 10px;
            color: #5a5c69;
            font-size: 13px;
        }
    </style>
@endpush

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
