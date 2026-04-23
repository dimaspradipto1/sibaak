@extends('layouts.dashboard.template')


@section('content')
<div class="card">
    <div class="card-header">
        @can('surat_akademik_create')
            <a href="{{ route('suratAkademik.create') }}" class="btn btn-primary rounded btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a>
            <button type="button" class="btn btn-info rounded btn-sm" data-toggle="modal" data-target="#importModalAkademik">
                <i class="fa-solid fa-file-excel"></i> Import
            </button>
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
                    'class' => 'table table-striped table-bordered',
                    'style' => 'width:100%; overflow-x: auto',
                ]) }}
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModalAkademik" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('suratAkademik.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Surat Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Download Template</label><br>
                        <a href="{{ route('suratAkademik.export-template') }}" class="btn btn-link p-0 text-primary">
                            <i class="fa-solid fa-download"></i> Klik untuk download template Excel
                        </a>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Pilih File Excel</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx, .xls">
                        <small class="text-muted">Format kolom: nama_mahasiswa, program_studi, npm, permohonan, alamat, no_wa, semester, status_cuti, alasan_cuti.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Upload & Import</button>
                </div>
            </div>
        </form>
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