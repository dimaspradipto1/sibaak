@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Edit Mahasiswa</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                            <div class="col-sm-10">
                                <select name="users_id" id="users_id" class="form-control rounded" data-live-search="true">
                                    <option selected disabled>
                                        {{ $mahasiswa->user ? $mahasiswa->user->name : 'User tidak ditemukan' }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('users_id', $mahasiswa->users_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $mahasiswa->tempat_lahir) }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $mahasiswa->tgl_lahir) }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NPM</label>
                            <div class="col-sm-10">
                                <input type="number" name="npm" value="{{ old('npm', $mahasiswa->npm) }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Program Studi</label>
                            <div class="col-sm-10">
                                <select name="program_studi_id" id="program_studi_id" class="form-control rounded" required>
                                    <option value="">Pilih Program Studi</option>
                                    @foreach ($programStudi as $program)
                                        <option value="{{ $program->id }}"
                                            {{ old('program_studi_id', $mahasiswa->program_studi_id) == $program->id ? 'selected' : '' }}>
                                            {{ $program->program_studi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fakultas</label>
                            <div class="col-sm-10">
                               <select name="fakultas" id="fakultas" class="form-control rounded">
                                <option value="">{{ old('fakultas', $mahasiswa->fakultas) }}</option>
                                <option disabled>=================================</option>
                            <option value="Fakultas Sains dan Teknologi" {{ old('fakultas', $mahasiswa->fakultas) == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}>Fakultas Sains dan Teknologi</option>
                            <option value="Fakultas Ekonomi dan Bisnis" {{ old('fakultas', $mahasiswa->fakultas) == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                            <option value="Fakultas Ilmu Kesehatan" {{ old('fakultas', $mahasiswa->fakultas) == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}>Fakultas Ilmu Kesehatan</option>
                               </select>
                            </div>
                        </div>


                       <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenjang Pendidikan</label>
                            <div class="col-sm-10">
                               <select name="jenjang_pendidikan" id="jenjang_pendidikan" class="form-control rounded">
                                <option value="">{{ old('jenjang_pendidikan', $mahasiswa->jenjang_pendidikan) }}</option>
                                <option disabled>=================================</option>
                                <option value="S-1" {{ old('jenjang_pendidikan', $mahasiswa->jenjang_pendidikan) == 'S-1' ? 'selected' : '' }}>S-1</option>
                                <option value="S-2" {{ old('jenjang_pendidikan', $mahasiswa->jenjang_pendidikan) == 'S-2' ? 'selected' : '' }}>S-2</option>
                               </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="semester" class="form-control rounded">
                                    <option selected disabled>{{ $mahasiswa->semester }}</option>
                                    <option disabled>=========================================</option>
                                    <option value="I (Satu)" {{ old('semester', $mahasiswa->semester) == 'I (Satu)' ? 'selected' : '' }}>I (Satu)</option>
                                    <option value="II (Dua)" {{ old('semester', $mahasiswa->semester) == 'II (Dua)' ? 'selected' : '' }}>II (Dua)</option>
                                    <option value="III (Tiga)" {{ old('semester', $mahasiswa->semester) == 'III (Tiga)' ? 'selected' : '' }}>III (Tiga)</option>
                                    <option value="IV (Empat)" {{ old('semester', $mahasiswa->semester) == 'IV (Empat)' ? 'selected' : '' }}>IV (Empat)</option>
                                    <option value="V (Lima)" {{ old('semester', $mahasiswa->semester) == 'V (Lima)' ? 'selected' : '' }}>V (Lima)</option>
                                    <option value="VI (Enam)" {{ old('semester', $mahasiswa->semester) == 'VI (Enam)' ? 'selected' : '' }}>VI (Enam)</option>
                                    <option value="VII (Tujuh)" {{ old('semester', $mahasiswa->semester) == 'VII (Tujuh)' ? 'selected' : '' }}>VII (Tujuh)</option>
                                    <option value="VIII (Delapan)" {{ old('semester', $mahasiswa->semester) == 'VIII (Delapan)' ? 'selected' : '' }}>VIII (Delapan)</option>
                                    <option value="IX (Sembilan)" {{ old('semester', $mahasiswa->semester) == 'IX (Sembilan)' ? 'selected' : '' }}>IX (Sembilan)</option>
                                    <option value="X (Sepuluh)" {{ old('semester', $mahasiswa->semester) == 'X (Sepuluh)' ? 'selected' : '' }}>X (Sepuluh)</option>
                                    <option value="XI (Sebelas)" {{ old('semester', $mahasiswa->semester) == 'XI (Sebelas)' ? 'selected' : '' }}>XI (Sebelas)</option>
                                    <option value="XII (Dua Belas)" {{ old('semester', $mahasiswa->semester) == 'XII (Dua Belas)' ? 'selected' : '' }}>XII (Dua Belas)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" class="form-control rounded">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NO WA</label>
                            <div class="col-sm-10">
                                <input type="number" name="no_wa" value="{{ old('no_wa', $mahasiswa->no_wa) }}"
                                    class="form-control rounded">
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Update
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
