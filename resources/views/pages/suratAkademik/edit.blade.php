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
                    <form action="{{ route('suratAktif.update', $suratAktif->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-10">
                                <select name="tahun_akademik" id="tahun_akademik" class="form-control rounded" data-live-search="true">
                                    <option value="">Pilih Tahun Akademik</option>
                                    @foreach ($tahunAkademik as $tahun)
                                        <option value="{{ $tahun->tahun_akademik }}">{{ $tahun->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status Semester</label>
                            <div class="col-sm-10">
                                <select name="status_semester" id="status_semester" class="form-control rounded">
                                    <option selected disabled>{{ $suratAktif->status_semester }}</option>
                                    <option disabled>=================================</option>
                                    <option value="Gasal" {{ $suratAktif->status_semester == 'Gasal' ? 'selected' : '' }}>Gasal</option>
                                    <option value="Genap" {{ $suratAktif->status_semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">status</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control rounded">
                                    <option selected disabled>{{ $suratAktif->status }}</option>
                                    <option disabled>=================================</option>
                                    <option value="pending" {{ $suratAktif->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diterima" {{ $suratAktif->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="ditolak" {{ $suratAktif->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Update
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
            $('#tahun_akademik_id').select2();
        });
    </script>
@endpush