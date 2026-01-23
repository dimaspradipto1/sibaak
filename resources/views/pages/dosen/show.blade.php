@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pegawai</h5>
                </div>
                <div class="card-block">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <td width="20%">Nama Pegawai</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $pegawai->user->name }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Jabatan</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $pegawai->jabatan }}</td>
                        </tr>
                        <tr>
                            <td width="20%">NIDN</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $pegawai->nidn }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Digital Signature (TTD)</td>
                            <td width="1%">:</td>
                            <td width="79%">
                                @if ($pegawai->url)
                                    <img src="{{ asset($pegawai->url) }}" alt="TTD" width="200"
                                        class="img-thumbnail">
                                @else
                                    <span class="text-muted">Tidak ada tanda tangan</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                            class="btn btn-warning text-white rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
