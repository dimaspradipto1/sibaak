@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Detail LPJ Kepanitiaan</h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="users_id">Nama Staff</label>
                                <input type="text" class="form-control" id="users_id"
                                    value="{{ $lpjkepanitiaan->users->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun_akademik">Tahun Akademik</label>
                                <input type="text" class="form-control" id="tahun_akademik"
                                    value="{{ $lpjkepanitiaan->tahunAkademik->tahun_akademik }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <input type="text" class="form-control" id="semester"
                                    value="{{ $lpjkepanitiaan->semester }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_sk">Nama LPJ</label>
                                <input type="text" class="form-control" id="nama_sk"
                                    value="{{ $lpjkepanitiaan->nama_dokumen }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fakultas">Fakultas</label>
                                <input type="text" class="form-control" id="fakultas"
                                    value="{{ $lpjkepanitiaan->fakultas }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file">File</label>
                                <br>
                                <a href="{{ asset($lpjkepanitiaan->file) }}" target="_blank" class="btn btn-primary btn-sm rounded btn-block">
                                    <i class="fa fa-eye"></i> Lihat Dokumen
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('lpjkepanitiaan.index') }}" class="btn btn-danger btn-sm rounded">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
