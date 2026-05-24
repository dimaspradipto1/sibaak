@extends('layouts.dashboard.template')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #046B26 !important;">
    <div class="card-header bg-white border-bottom py-2 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 4px; height: 22px; background: #046B26; border-radius: 2px;" class="mr-2"></div>
                <h5 class="m-0 font-weight-bold text-dark" style="font-size: 1rem;">Data Unit Kerja</h5>
            </div>
            @can('unit_kerja_create')
            <div class="d-inline-flex shadow-sm overflow-hidden" style="border: 1px solid #e3e6f0; border-radius: 30px;">
                <a href="{{ route('unitkerja.create') }}" class="btn btn-success rounded btn-xs font-weight-bold px-3 py-1 border-0" style="background-color: #046B26; color: white; font-size: 10px; height: 32px; line-height: 24px;">
                    <i class="fas fa-plus mr-1"></i> TAMBAH
                </a>
            </div>
            @endcan
        </div>
    </div>
    <div class="card-block p-0">
        <div class="table-responsive">
           {{ $dataTable->table([
                'class' => 'table table-hover mb-0 w-100',
                'id' => 'unitkerja-table'
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
     @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush

