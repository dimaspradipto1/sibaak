@extends('layouts.dashboard.template')

@section('content')
    @php
        use App\Models\Mahasiswa;
    @endphp


    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; border-top: 5px solid #046B26 !important;">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    @can('mahasiswa_create')
                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-success rounded btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg border-0 mr-1" style="background-color: #046B26;">
                        <i class="fa-solid fa-plus mr-1"></i> TAMBAH
                    </a>
                    <button type="button" class="btn btn-outline-success rounded btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg mr-1" data-toggle="modal" data-target="#importMahasiswaModal">
                        <i class="fa-solid fa-file-import mr-1"></i> IMPOR EXCEL
                    </button>
                    <a href="{{ route('mahasiswa.export-template') }}" class="btn btn-outline-info rounded btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg">
                        <i class="fa-solid fa-file-download mr-1"></i> DOWNLOAD FORMAT
                    </a>
                    @endcan

                    @if (auth()->user()->is_mahasiswa)
                        <form action="{{ route('suratAktif.pengajuan') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg border-0 mr-1" style="background-color: #046B26;">
                                <i class="fa-solid fa-plus mr-1"></i> PENGAJUAN SURAT AKTIF
                            </button>
                        </form>
                        <a href="{{ route('suratAkademik.create') }}" class="btn btn-secondary btn-sm font-weight-bold px-3 py-2 shadow-sm rounded-lg border-0">
                            <i class="fa-solid fa-plus mr-1"></i> PENGAJUAN SURAT AKADEMIK
                        </a>
                    @endif
                </div>
                <div class="col-md-4 text-right">
                    <h5 class="m-0 font-weight-bold text-dark">Data Mahasiswa</h5>
                </div>
            </div>
        </div>


        <!-- Import Modal -->
        <div class="modal fade" id="importMahasiswaModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Impor Data Mahasiswa</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-info border-0 shadow-none mb-4">
                                <i class="fa-solid fa-circle-info mr-2"></i> 
                                Sistem akan otomatis menghubungkan data mahasiswa dengan akun pengguna berdasarkan <strong>Nama Pengguna</strong> yang ada di sistem.
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
        #mahasiswa-table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            color: #5a5c69;
            border-bottom: 2px solid #e3e6f0;
            padding: 15px 10px;
            vertical-align: middle;
        }
        #mahasiswa-table tbody td {
            vertical-align: middle;
            padding: 12px 10px;
            color: #5a5c69;
            font-size: 13px;
        }
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
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
