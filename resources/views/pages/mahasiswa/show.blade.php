@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Detail Mahasiswa</h5>
                </div>
                <div class="card-block">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <td width="20%">Nama Mahasiswa</td>
                            <td width="1%">:</td>
                            <td width="79%">
                                @if($mahasiswa->user)
                                    {{ $mahasiswa->user->name }}
                                @else
                                    <span class="text-danger">User tidak ditemukan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">NPM</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->npm }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Tempat/Tgl Lahir</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->tempat_lahir }} /
                                {{ \Carbon\Carbon::parse($mahasiswa->tgl_lahir)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Program Studi</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->programStudi->program_studi }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Fakultas</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->fakultas }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Jenjang Pendidikan</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->jenjang_pendidikan }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Semester</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->semester }}</td>
                        </tr>
                        <tr>
                            <td width="20%">Alamat</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->alamat }}</td>
                        </tr>
                        <tr>
                            <td width="20%">No WA</td>
                            <td width="1%">:</td>
                            <td width="79%">{{ $mahasiswa->no_wa }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
