@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Edit Surat Akademik</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('suratAkademik.update', $suratAkademik->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input users_id -->
                        <input type="hidden" name="users_id" value="{{ Auth::id() }}">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="semester" class="form-control rounded" required>
                                    <option selected disabled>Pilih Semester</option>
                                    <option value="I (Satu)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'I (Satu)' ? 'selected' : '' }}>
                                        I (Satu)</option>
                                    <option value="II (Dua)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'II (Dua)' ? 'selected' : '' }}>
                                        II (Dua)</option>
                                    <option value="III (Tiga)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'III (Tiga)' ? 'selected' : '' }}>
                                        III (Tiga)</option>
                                    <option value="IV (Empat)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'IV (Empat)' ? 'selected' : '' }}>
                                        IV (Empat)</option>
                                    <option value="V (Lima)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'V (Lima)' ? 'selected' : '' }}>
                                        V (Lima)</option>
                                    <option value="VI (Enam)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'VI (Enam)' ? 'selected' : '' }}>
                                        VI (Enam)</option>
                                    <option value="VII (Tujuh)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'VII (Tujuh)' ? 'selected' : '' }}>
                                        VII (Tujuh)</option>
                                    <option value="VIII (Delapan)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'VIII (Delapan)' ? 'selected' : '' }}>
                                        VIII (Delapan)</option>
                                    <option value="IX (Sembilan)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'IX (Sembilan)' ? 'selected' : '' }}>
                                        IX (Sembilan)</option>
                                    <option value="X (Sepuluh)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'X (Sepuluh)' ? 'selected' : '' }}>
                                        X (Sepuluh)</option>
                                    <option value="XI (Sebelas)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'XI (Sebelas)' ? 'selected' : '' }}>
                                        XI (Sebelas)</option>
                                    <option value="XII (Dua Belas)"
                                        {{ isset($suratAkademik->semester) && $suratAkademik->semester == 'XII (Dua Belas)' ? 'selected' : '' }}>
                                        XII (Dua Belas)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Permohonan</label>
                            <div class="col-sm-10">
                                <select name="permohonan" id="permohonan" class="form-control rounded" required>
                                    <option value="">Pilih Permohonan</option>
                                    <option value="Cuti"
                                        {{ isset($suratAkademik->permohonan) && $suratAkademik->permohonan == 'Cuti' ? 'selected' : '' }}>
                                        Cuti</option>
                                    <option value="Pindah Kelas"
                                        {{ isset($suratAkademik->permohonan) && $suratAkademik->permohonan == 'Pindah Kelas' ? 'selected' : '' }}>
                                        Pindah Kelas</option>
                                    <option value="Pindah/Keluar"
                                        {{ isset($suratAkademik->permohonan) && $suratAkademik->permohonan == 'Pindah/Keluar' ? 'selected' : '' }}>
                                        Pindah/Keluar</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Dosen PA</label>
                            <div class="col-sm-10">
                                <select name="dosen_pembimbing_akademik" id="dosen_pembimbing_akademik"
                                    class="form-control rounded" data-live-search="true" required>
                                    <option value="">Pilih Dosen Pembimbing Akademik</option>
                                    @foreach ($dosens as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($suratAkademik->dosen_pembimbing_akademik) && $suratAkademik->dosen_pembimbing_akademik == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_dosen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Ka. Prodi</label>
                            <div class="col-sm-10">
                                <select name="kaprodi" id="kaprodi" class="form-control rounded" required>
                                    <option value="">Pilih Ka. Prodi</option>
                                    @foreach ($dosens as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($suratAkademik->kaprodi) && $suratAkademik->kaprodi == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_dosen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alasan Cuti Akademik</label>
                            <div class="col-sm-10">
                                <textarea name="alasan_cuti" class="form-control rounded" id="alasan_cuti" cols="30" rows="4" required>{{ $suratAkademik->alasan_cuti }}</textarea>
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
            $('#dosen_pembimbing_akademik').select2();
            $('#kaprodi').select2();
        });
    </script>
@endpush
