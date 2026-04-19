@extends('layouts.dashboard.template')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-newspaper text-info mr-2"></i>Portal Artikel & Informasi
                </h5>
                @can('artikel_create')
                <a href="{{ route('artikel.create') }}" class="btn btn-primary btn-sm px-4 shadow-sm" style="border-radius: 50px !important;">
                    <i class="fa-solid fa-plus mr-1"></i>Tambah Artikel
                </a>
                @endcan
            </div>
            <div class="card-block px-4 py-4">
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table table-hover border-0', 'id' => 'artikel-table']) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
