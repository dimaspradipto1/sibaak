@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Update Status Surat Akademik</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Update Status</h4>
                    <form action="{{ route('suratAkademik.updateStatus', $suratAkademik->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-10">
                                <select name="tahun_akademik" id="tahun_akademik" class="form-control rounded"
                                    data-live-search="true">
                                    <option value="">Pilih Tahun Akademik</option>
                                    @foreach ($tahunAkademik as $tahun)
                                        <option value="{{ $tahun->tahun_akademik }}"
                                            {{ isset($suratAkademik->tahun_akademik) && $suratAkademik->tahun_akademik == $tahun->tahun_akademik ? 'selected' : '' }}>
                                            {{ $tahun->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status Semester</label>
                            <div class="col-sm-10">
                                <select name="status_semester" id="status_semester" class="form-control rounded">
                                    <option value="">Pilih Status Semester</option>
                                    <option value="Gasal"
                                        {{ isset($suratAkademik->status_semester) && $suratAkademik->status_semester == 'Gasal' ? 'selected' : '' }}>
                                        Gasal</option>
                                    <option value="Genap"
                                        {{ isset($suratAkademik->status_semester) && $suratAkademik->status_semester == 'Genap' ? 'selected' : '' }}>
                                        Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control rounded">
                                    <option value="">Pilih Status</option>
                                    <option value="pending"
                                        {{ isset($suratAkademik->status) && $suratAkademik->status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="diterima"
                                        {{ isset($suratAkademik->status) && $suratAkademik->status == 'diterima' ? 'selected' : '' }}>
                                        Diterima</option>
                                    <option value="ditolak"
                                        {{ isset($suratAkademik->status) && $suratAkademik->status == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Update
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
            $('#tahun_akademik_id').select2();
        });
    </script>
@endpush
