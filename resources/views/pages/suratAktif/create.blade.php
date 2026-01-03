@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Surat Aktif</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('suratAktif.store') }}" method="POST">
                        @csrf
                        {{-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                            <div class="col-sm-10">
                                <select name="users_id" id="users_id" class="form-control rounded" data-live-search="true">
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NPM</label>
                            <div class="col-sm-10">
                                <input type="number" name="npm" value="{{ old('npm') }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Program Studi</label>
                            <div class="col-sm-10">
                                <select name="program_studi_id" id="program_studi_id" class="form-control rounded"
                                    data-live-search="true">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach ($programStudi as $programStudi)
                                        <option value="{{ $programStudi->id }}">{{ $programStudi->program_studi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenjang Pendidikan</label>
                            <div class="col-sm-10">
                                <select name="jenjang_pendidikan" id="jenjang_pendidikan" class="form-control rounded">
                                    <option selected disabled>Pilih Jenjang Pendidikan</option>
                                    <option disabled>=================================</option>
                                    <option value="S-1">S-1</option>
                                    <option value="S-2">S-2</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fakultas</label>
                            <div class="col-sm-10">
                                <select name="fakultas" id="fakultas" class="form-control rounded">
                                    <option selected disabled>Pilih Fakultas</option>
                                    <option disabled>=================================</option>
                                    <option value="Fakultas Sains dan Teknologi">Fakultas Sains dan Teknologi</option>
                                    <option value="Fakultas Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                                    <option value="Fakultas Ilmu Kesehatan">Fakultas Ilmu Kesehatan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>
                        <a href="{{ route('suratAktif.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#users_id').select2();
        });
    </script>
@endpush
