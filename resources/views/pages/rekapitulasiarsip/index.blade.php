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
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-10">
                                <select name="tahun_akademik_id" id="tahun_akademik_id"
                                    class="form-control rounded @error('tahun_akademik_id') is-invalid @enderror"
                                    data-live-search="true">
                                    <option value="">Pilih Tahun Akademik</option>
                                    @foreach ($tahunAkademik as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('tahun_akademik_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahun_akademik_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Arsip</label>
                            <div class="col-sm-10">
                                <select name="users_id" id="users_id"
                                    class="form-control rounded @error('users_id') is-invalid @enderror"
                                    data-live-search="true">
                                    <option value="">Pilih Arsip</option>
                                    <option value="SkKepanitiaan">SK Kepanitiaan</option>
                                    <option value="LpjKepanitiaan">LPJ Kepanitiaan</option>
                                    <option value="Kurikulum">Kurikulum</option>
                                    <option value="Pedoman">Pedoman</option>
                                    <option value="SopAkademik">SOP Akademik</option>
                                    <option value="Wasdalbin">Wasdalbin</option>
                                </select>
                                @error('users_id')
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
                                    <option value='Fakultas Ekonomi dan Bisnis (FEB)'
                                        {{ old('homebase') == 'Fakultas Ekonomi dan Bisnis (FEB)' ? 'selected' : '' }}>
                                        Fakultas Ekonomi dan Bisnis (FEB)</option>
                                    <option value='Fakultas Sains dan Teknologi (FST)'
                                        {{ old('homebase') == 'Fakultas Sains dan Teknologi (FST)' ? 'selected' : '' }}>
                                        Fakultas Sains dan Teknologi (FST)</option>
                                    <option value="Fakultas Ilmu Kesehatan (FIKES)"
                                        {{ old('homebase') == 'Fakultas Ilmu Kesehatan (FIKES)' ? 'selected' : '' }}>
                                        Fakultas Ilmu Kesehatan (FIKES)</option>
                                </select>
                                @error('homebase')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-eye"></i> Tampilkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
