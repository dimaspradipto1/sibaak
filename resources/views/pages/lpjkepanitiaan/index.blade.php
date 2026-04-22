@extends('layouts.dashboard.template')


@section('content')
    <div class="card">
        <div class="card-header">
            @can('lpj_kepanitiaan_create')
            <a href="{{ route('lpjkepanitiaan.create') }}" class="btn btn-primary rounded btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a>
            @endcan
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                    <li><i class="fa fa-window-maximize full-card"></i></li>
                    <li><i class="fa fa-minus minimize-card"></i></li>
                    <li><i class="fa fa-refresh reload-card"></i></li>
                    <li><i class="fa fa-trash close-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                {{ $dataTable->table([
                    'class' => 'table table-striped table-bordered table-hover text-nowrap',
                    'style' => 'width:100%',
                ]) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (app()->environment('production'))
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
