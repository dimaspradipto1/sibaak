@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Detail SK Kepanitiaan</h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="users_id">Nama Staff</label>
                                <input type="text" class="form-control" id="users_id"
                                    value="{{ $skkepanitiaan->users->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun_akademik">Tahun Akademik</label>
                                <input type="text" class="form-control" id="tahun_akademik"
                                    value="{{ $skkepanitiaan->tahunAkademik->tahun_akademik }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <input type="text" class="form-control" id="semester"
                                    value="{{ $skkepanitiaan->semester }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_sk">Nama SK</label>
                                <input type="text" class="form-control" id="nama_sk"
                                    value="{{ $skkepanitiaan->nama_sk }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_sk">Nomor SK</label>
                                <input type="text" class="form-control" id="nomor_sk"
                                    value="{{ $skkepanitiaan->nomor_sk }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenissk_id">Jenis SK</label>
                                <input type="text" class="form-control" id="jenissk_id"
                                    value="{{ $skkepanitiaan->jenissk->jenis_sk }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prodi">Program Studi</label>
                                <input type="text" class="form-control" id="prodi"
                                    value="{{ $skkepanitiaan->prodi }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file">File</label>
                                <br>
                                <a href="{{ asset($skkepanitiaan->file) }}" target="_blank" class="btn btn-primary btn-sm rounded btn-block">
                                    <i class="fa fa-eye"></i> Lihat Dokumen
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-danger btn-sm rounded">
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
