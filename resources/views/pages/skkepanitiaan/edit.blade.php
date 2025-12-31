@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Edit SK Kepanitiaan</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('skkepanitiaan.update', $skkepanitiaan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-10">
                                <select name="tahun_akademik_id" class="form-control rounded">
                                    <option value="">Pilih Tahun Akademik</option>
                                    <option value="">=====================</option>
                                    @foreach ($tahunAkademik as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('tahun_akademik_id', $skkepanitiaan->tahun_akademik_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->tahun_akademik }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="" class="form-control rounded">
                                    <option value="">Pilih Semester</option>
                                    <option value="">=====================</option>
                                    <option value="Gasal"
                                        {{ old('semester', $skkepanitiaan->semester) == 'Gasal' ? 'selected' : '' }}>Gasal
                                    </option>
                                    <option value="Genap"
                                        {{ old('semester', $skkepanitiaan->semester) == 'Genap' ? 'selected' : '' }}>Genap
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama SK</label>
                            <div class="col-sm-10">
                                <textarea name="nama_sk" class="form-control rounded" id="" cols="30" rows="3">{{ old('nama_sk') ?? $skkepanitiaan->nama_sk }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor SK</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomor_sk"
                                    value="{{ old('nomor_sk') ?? $skkepanitiaan->nomor_sk }}" class="form-control rounded"
                                    placeholder="Masukkan nomor sk">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis SK</label>
                            <div class="col-sm-10">
                                <select name="jenissk_id" id="jenissk_id" class="form-control rounded">
                                    <option value="">{{ old('jenissk_id') ?? $skkepanitiaan->jenissk_id }}</option>
                                    <option value="">=====================</option>
                                    @foreach ($jenissks as $jenissk)
                                        <option value="{{ $jenissk->id }}"
                                            {{ old('jenissk_id', $skkepanitiaan->jenissk_id) == $jenissk->id ? 'selected' : '' }}>
                                            {{ $jenissk->jenis_sk }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Program Studi</label>
                            <div class="col-sm-10">
                                <select name="prodi" id="prodi" class="form-control rounded">
                                    <option value="">Pilih Program Studi</option>
                                    <option value="">=====================</option>
                                    <option value="Fakultas Ekonomi dan Bisnis"
                                        {{ old('prodi') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}
                                        {{ $skkepanitiaan->prodi == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>
                                        Fakultas
                                        Ekonomi dan Bisnis</option>
                                    <option value="Fakultas Sains dan Teknologi"
                                        {{ old('prodi') == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}
                                        {{ $skkepanitiaan->prodi == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}>
                                        Fakultas
                                        Sains dan Teknologi</option>
                                    <option value="Fakultas Ilmu Kesehatan"
                                        {{ old('prodi') == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}
                                        {{ $skkepanitiaan->prodi == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}>Fakultas
                                        Ilmu
                                        Kesehatan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload Dokumen</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" class="form-control rounded" id="file-input">
                            </div>
                        </div>

                        <!-- Preview File -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Preview Dokumen</label>
                            <div class="col-sm-10">
                                <div id="preview-container">
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>

                        <!-- Back button -->
                        <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
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
        document.getElementById('file-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewContainer = document.getElementById('preview-container');

            previewContainer.innerHTML = '';

            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    const iframe = document.createElement('iframe');
                    iframe.src = URL.createObjectURL(file);
                    iframe.width = '100%';
                    iframe.height = '500px';
                    previewContainer.appendChild(iframe);
                } else if (file.type === 'application/msword' || file.type ===
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    const fileUrl = URL.createObjectURL(file);
                    const link = document.createElement('a');
                    link.href = `https://docs.google.com/gview?url=${fileUrl}&embedded=true`;
                    link.target = "_blank";
                    link.textContent = `Preview Word: ${file.name}`;
                    previewContainer.appendChild(link);
                } else if (file.type === 'application/vnd.ms-excel' || file.type ===
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    const fileUrl = URL.createObjectURL(file);
                    const link = document.createElement('a');
                    link.href = `https://docs.google.com/gview?url=${fileUrl}&embedded=true`;
                    link.target = "_blank";
                    link.textContent = `Preview Excel: ${file.name}`;
                    previewContainer.appendChild(link);
                } else {
                    const fileName = document.createElement('p');
                    fileName.textContent = `File: ${file.name}`;
                    previewContainer.appendChild(fileName);
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#jenissk_id').select2();
        });
    </script>
@endpush
