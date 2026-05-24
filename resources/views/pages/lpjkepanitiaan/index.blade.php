@extends('layouts.dashboard.template')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #046B26 !important;">
    <div class="card-header bg-white border-bottom py-2 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 4px; height: 22px; background: #046B26; border-radius: 2px;" class="mr-2"></div>
                <h5 class="m-0 font-weight-bold text-dark" style="font-size: 1rem;">Data LPJ Kepanitiaan</h5>
            </div>
            @can('lpj_kepanitiaan_create')
            <div class="d-inline-flex shadow-sm overflow-hidden" style="border: 1px solid #e3e6f0; border-radius: 30px;">
                <a href="{{ route('lpjkepanitiaan.create') }}" class="btn btn-success rounded btn-xs font-weight-bold px-3 py-1 border-0" style="background-color: #046B26; color: white; font-size: 10px; height: 32px; line-height: 24px;">
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
                'id' => 'lpjkepanitiaan-table'
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-toggle-status', function() {
                var btn = $(this);
                var id = btn.data('id');
                var status = btn.data('status');

                $.ajax({
                    url: "{{ route('lpjkepanitiaan.toggle-status') }}",
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
                            window.LaravelDataTables['lpjkepanitiaan-table'].draw();
                        } else {
                            alert(response.message);
                            window.LaravelDataTables['lpjkepanitiaan-table'].draw();
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat mengubah status.');
                        window.LaravelDataTables['lpjkepanitiaan-table'].draw();
                    }
                });
            });
        });
    </script>
@endpush
