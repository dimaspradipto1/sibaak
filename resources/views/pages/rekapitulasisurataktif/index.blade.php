@extends('layouts.dashboard.template')

@section('title', 'Rekapitulasi Arsip')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Rekapitulasi Arsip</h5>
                </div>
                <div class="card-block">
                    {{-- <h4 class="sub-title">Form Inputs</h4> --}}
                    <form action="{{ route('rekapitulasisurataktif.index') }}" method="GET" id="filterForm">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Periode Akademik</label>
                            <div class="col-sm-10">
                                <select name="tahun_akademik_id" id="tahun_akademik_id"
                                    class="form-control rounded @error('tahun_akademik_id') is-invalid @enderror"
                                    data-live-search="true">
                                    <option value="">Pilih Periode Akademik</option>
                                    @foreach ($tahunAkademik as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('tahun_akademik_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahun_akademik_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="semester"
                                    class="form-control rounded @error('semester') is-invalid @enderror"
                                    data-live-search="true">
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                    </option>
                                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap
                                    </option>
                                </select>
                                @error('semester')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fakultas</label>
                            <div class="col-sm-10">
                                <select name="homebase" id="homebase" class="form-control rounded">
                                    <option value="">Pilih Fakultas</option>
                                    <option value="">=====================</option>
                                    <option value='Fakultas Ekonomi dan Bisnis'
                                        {{ request('homebase') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>
                                        Fakultas Ekonomi dan Bisnis (FEB)</option>
                                    <option value='Fakultas Sains dan Teknologi'
                                        {{ request('homebase') == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}>
                                        Fakultas Sains dan Teknologi (FST)</option>
                                    <option value="Fakultas Ilmu Kesehatan"
                                        {{ request('homebase') == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}>
                                        Fakultas Ilmu Kesehatan (FIKES)</option>
                                </select>
                                @error('homebase')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success rounded text-uppercase btn-sm"
                                    onclick="setFormAction('export')">
                                    <i class="fa-solid fa-eye"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setFormAction(type) {
            const form = document.getElementById('filterForm');
            if (type === 'export') {
                form.action = "{{ route('rekapitulasisurataktif.export') }}";
            } else {
                form.action = "{{ route('rekapitulasisurataktif.index') }}";
            }
        }
    </script>
    </div>
    </div>
    </div>
@endsection
