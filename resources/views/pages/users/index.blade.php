@extends('layouts.dashboard.template')


@section('content')
    <div class="card">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    @can('users_create')
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-round btn-sm px-3 shadow-sm mr-2">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah
                    </a>
                    <button type="button" class="btn btn-outline-success btn-round btn-sm px-3 shadow-sm mr-2" data-toggle="modal" data-target="#importModal">
                        <i class="fa-solid fa-file-import mr-1"></i> Impor Excel
                    </button>
                    <a href="{{ route('users.export-template') }}" class="btn btn-outline-info btn-round btn-sm px-3 shadow-sm">
                        <i class="fa-solid fa-file-download mr-1"></i> Download Format
                    </a>
                    @endcan
                </div>
                <div class="col-md-6 text-right">
                    <h5 class="m-0 font-weight-bold text-dark">Manajemen Pengguna</h5>
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Impor Data Pengguna</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-info border-0 shadow-none mb-4">
                                <i class="fa-solid fa-circle-info mr-2"></i> 
                                Pastikan format file sesuai dengan <strong>Format Import</strong> yang telah disediakan.
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Pilih Berkas Excel (.xlsx / .csv)</label>
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="importFile" required>
                                    <label class="custom-file-label" for="importFile">Pilih file...</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary btn-round btn-sm px-4" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success btn-round btn-sm px-4 shadow-sm">
                                <i class="fa-solid fa-cloud-upload mr-1"></i> Mulai Impor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                {{ $dataTable->table([
                    'class' => 'table table-striped table-bordered',
                    'style' => 'width:100%; overflow-x: auto',
                ]) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Update custom file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
