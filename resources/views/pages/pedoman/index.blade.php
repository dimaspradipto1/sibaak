@extends('layouts.dashboard.template')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; border-top: 5px solid #046B26 !important;">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 4px; height: 25px; background: #046B26; border-radius: 2px;" class="mr-2"></div>
                <h5 class="m-0 font-weight-bold text-dark">Data Pedoman</h5>
            </div>
            @can('pedoman_create')
            <a href="{{ route('pedoman.create') }}" class="btn btn-success btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg border-0" style="background-color: #046B26;">
                <i class="fas fa-plus mr-1"></i> TAMBAH
            </a>
            @endcan
        </div>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
           {{ $dataTable->table([
                'class' => 'table table-striped table-bordered table-hover',
                'style'=>'width:100%; overflow-x: auto',
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        #pedoman-table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            color: #5a5c69;
            border-bottom: 2px solid #e3e6f0;
            padding: 15px 10px;
            vertical-align: middle;
        }
        #pedoman-table tbody td {
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-toggle-status', function() {
                var btn = $(this);
                var id = btn.data('id');
                var status = btn.data('status');

                $.ajax({
                    url: "{{ route('pedoman.toggle-status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    beforeSend: function() {
                        btn.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        if (response.success) {
                            window.LaravelDataTables['pedoman-table'].draw();
                        } else {
                            alert(response.message);
                            window.LaravelDataTables['pedoman-table'].draw();
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat mengubah status.');
                        window.LaravelDataTables['pedoman-table'].draw();
                    }
                });
            });
        });
    </script>
@endpush

