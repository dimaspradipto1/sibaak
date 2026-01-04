@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Surat Akademik</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    {{-- <form action="{{ route('suratAkademik.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="semester" class="form-control rounded">
                                    <option selected disabled>Pilih Semester</option>
                                    <option disabled>=========================================</option>
                                    <option value="I (Satu)">I (Satu)</option>
                                    <option value="II (Dua)">II (Dua)</option>
                                    <option value="III (Tiga)">III (Tiga)</option>
                                    <option value="IV (Empat)">IV (Empat)</option>
                                    <option value="V (Lima)">V (Lima)</option>
                                    <option value="VI (Enam)">VI (Enam)</option>
                                    <option value="VII (Tujuh)">VII (Tujuh)</option>
                                    <option value="VIII (Delapan)">VIII (Delapan)</option>
                                    <option value="IX (Sembilan)">IX (Sembilan)</option>
                                    <option value="X (Sepuluh)">X (Sepuluh)</option>
                                    <option value="XI (Sebelas)">XI (Sebelas)</option>
                                    <option value="XII (Dua Belas)">XII (Dua Belas)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">permohonan</label>
                            <div class="col-sm-10">
                                <select name="permohonan" id="permohonan" class="form-control rounded">
                                    <option value="">Pilih Permohonan</option>
                                    <option disabled>=================================</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Pindah Kelas">Pindah Kelas</option>
                                    <option value="Pindah/Keluar">Pindah/Keluar</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alasan Cuti Akademik</label>
                            <div class="col-sm-10">
                                <textarea name="alasan_cuti" class="form-control rounded" id="alasan_cuti" cols="30" rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>
                        <a href="{{ route('suratAktif.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form> --}}
                    <form action="{{ route('suratAkademik.store') }}" method="POST">
                        @csrf

                        <!-- Input users_id -->
                        <input type="hidden" name="users_id" value="{{ Auth::id() }}">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester Saat ini</label>
                            <div class="col-sm-10">
                                <select name="semester" id="semester" class="form-control rounded" required>
                                    <option selected disabled>Pilih Semester</option>
                                    <option value="I (Satu)">I (Satu)</option>
                                    <option value="II (Dua)">II (Dua)</option>
                                    <option value="III (Tiga)">III (Tiga)</option>
                                    <option value="IV (Empat)">IV (Empat)</option>
                                    <option value="V (Lima)">V (Lima)</option>
                                    <option value="VI (Enam)">VI (Enam)</option>
                                    <option value="VII (Tujuh)">VII (Tujuh)</option>
                                    <option value="VIII (Delapan)">VIII (Delapan)</option>
                                    <option value="IX (Sembilan)">IX (Sembilan)</option>
                                    <option value="X (Sepuluh)">X (Sepuluh)</option>
                                    <option value="XI (Sebelas)">XI (Sebelas)</option>
                                    <option value="XII (Dua Belas)">XII (Dua Belas)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Permohonan</label>
                            <div class="col-sm-10">
                                <select name="permohonan" id="permohonan" class="form-control rounded" required>
                                    <option value="">Pilih Permohonan</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Pindah Kelas">Pindah Kelas</option>
                                    <option value="Pindah/Keluar">Pindah/Keluar</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alasan Cuti Akademik</label>
                            <div class="col-sm-10">
                                <textarea name="alasan_cuti" class="form-control rounded" id="alasan_cuti" cols="30" rows="4" required></textarea>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>
                        <a href="{{ route('suratAkademik.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
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
