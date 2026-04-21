@extends('layouts.dashboard.template')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f1f1;">
                <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-sitemap mr-2 text-primary"></i> Master Unit Kerja</h5>
                <a href="{{ route('unitkerja.create') }}" class="btn btn-primary btn-sm shadow-sm px-3 rounded-lg">
                    <i class="fas fa-plus mr-1"></i> Tambah Unit
                </a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    {!! $dataTable->table(['class' => 'table table-hover table-bordered w-100', 'id' => 'unitkerja-table']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
    <style>
        #unitkerja-table thead th {
             background-color: #f8f9fa;
             text-transform: uppercase;
             font-size: 11px;
             letter-spacing: 0.5px;
             font-weight: 700;
             color: #333;
             border-bottom: 2px solid #eee;
        }
    </style>
@endpush
