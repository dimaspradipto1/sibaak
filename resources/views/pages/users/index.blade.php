@extends('layouts.dashboard.template')


@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #046B26 !important;">
        <div class="card-header bg-white border-bottom py-2 px-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-inline-flex shadow-sm overflow-hidden" style="border: 1px solid #e3e6f0; border-radius: 30px;">
                        @can('users_create')
                        <a href="{{ route('users.create') }}" class="btn btn-success btn-xs font-weight-bold px-3 py-1 border-0" style="background-color: #046B26; color: white; font-size: 10px; height: 32px; line-height: 24px; border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                            <i class="fa-solid fa-plus mr-1"></i> TAMBAH
                        </a>
                        <button type="button" class="btn btn-white btn-xs px-3 py-1 border-0 border-left rounded-0 text-primary" data-toggle="modal" data-target="#importModal" style="font-size: 10px; height: 32px; line-height: 24px;">
                            <i class="fa-solid fa-file-import mr-1"></i> IMPOR EXCEL
                        </button>
                        <a href="{{ route('users.export-template') }}" class="btn btn-white btn-xs px-3 py-1 border-0 border-left font-weight-bold" style="font-size: 10px; height: 32px; line-height: 24px; border-top-right-radius: 30px; border-bottom-right-radius: 30px; color: #28a745;">
                            <i class="fa-solid fa-file-download mr-1"></i> DOWNLOAD FORMAT
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <h5 class="m-0 font-weight-bold text-dark" style="font-size: 1rem;">Data Pengguna</h5>
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

@push('styles')
    <style>
        /* Force override global table styles */
        #user-table {
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            border: 1px solid #dee2e6 !important;
            margin-top: 10px !important;
        }
        #user-table thead th {
            background-color: #004b8d !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: bold;
            padding: 12px 10px !important;
            vertical-align: middle;
            text-align: center;
        }
        #user-table tbody td {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle;
            padding: 10px 10px !important;
            color: #5a5c69;
            font-size: 12px;
            background-color: #fff !important; /* Override global tr bg */
        }
        #user-table tbody tr {
            background-color: #fff !important;
            box-shadow: none !important;
            transform: none !important;
        }
        #user-table tbody tr td:first-child, 
        #user-table tbody tr td:last-child {
            border-radius: 0 !important; /* Remove global rounding */
        }
        #user-table tbody tr:hover {
            background-color: rgba(0, 75, 141, 0.05) !important;
        }
        .btn-white { background-color: #fff; color: #6e707e; border: 1px solid #e3e6f0; }
        .btn-white:hover { background-color: #f8f9fc; color: #4e73df; }
    </style>
@endpush

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
