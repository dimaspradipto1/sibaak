@extends('layouts.dashboard.template')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Tambah Dosen</h5>
                </div>
                <div class="card-block">
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                     <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Beserta Gelar</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_dosen" value="{{ old('nama_dosen') }}"
                                    class="form-control rounded @error('nama_dosen') is-invalid @enderror" placeholder="Masukkan Nama Beserta Gelar">
                                @error('nama_dosen')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control rounded @error('email') is-invalid @enderror" placeholder="Masukkan Email uis">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIDN</label>
                            <div class="col-sm-10">
                                <input type="number" name="nidn" value="{{ old('nidn') }}"
                                    class="form-control rounded @error('nidn') is-invalid @enderror" placeholder="Masukkan NIDN: boleh dikosongkan jika pakai NUPTK atau NUP">
                                @error('nidn')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NUP</label>
                            <div class="col-sm-10">
                                <input type="number" name="nup" value="{{ old('nup') }}"
                                    class="form-control rounded @error('nup') is-invalid @enderror" placeholder="Masukkan NUP: boleh dikosongkan jika pakai NIDN atau NUPTK">
                                @error('nup')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NUPTK</label>
                            <div class="col-sm-10">
                                <input type="number" name="nuptk" value="{{ old('nuptk') }}"
                                    class="form-control rounded @error('nuptk') is-invalid @enderror" placeholder="Masukkan NUPTK: boleh dikosongkan jika pakai NIDN atau NUP">
                                @error('nuptk')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Program Studi</label>
                            <div class="col-sm-10">
                                <select name="program_studi_id" class="form-control rounded @error('program_studi_id') is-invalid @enderror">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach ($program_studis as $program_studi)
                                        <option value="{{ $program_studi->id }}">{{ $program_studi->program_studi }}</option>
                                    @endforeach
                                </select>
                                @error('program_studi_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>

                        <!-- Back button -->
                        <a href="{{ route('dosen.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
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
