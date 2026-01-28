@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form SK</h5>
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
                    <form action="{{ route('skkepanitiaan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama SOP -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-10">
                                <select name="tahun_akademik_id" class="form-control rounded">
                                    <option value="">Pilih Tahun Akademik</option>
                                    <option value="">=====================</option>
                                    @foreach ($tahunAkademik as $item)
                                        <option value="{{ $item->id }}">{{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahun_akademik_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="" class="form-control rounded">
                                    <option value="">Pilih Semester</option>
                                    <option value="">=====================</option>
                                    <option value="Gasal">Gasal</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                @error('semester')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama SK</label>
                            <div class="col-sm-10">
                                <textarea name="nama_sk" class="form-control rounded" id="" cols="30" rows="3">{{ old('nama_sk') }}</textarea>
                                @error('nama_sk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor SK</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomor_sk" value="{{ old('nomor_sk') }}"
                                    class="form-control rounded" placeholder="Masukkan nomor sk">
                                @error('nomor_sk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis SK</label>
                            <div class="col-sm-10">
                                <select name="jenissk_id" id="jenissk_id" class="form-control rounded">
                                    <option value="">Pilih Jenis SK</option>
                                    <option value="">=====================</option>
                                    @foreach ($jenissks as $jenissk)
                                        <option value="{{ $jenissk->id }}">{{ $jenissk->jenis_sk }}</option>
                                    @endforeach
                                </select>
                                @error('jenissk_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fakultas</label>
                            <div class="col-sm-10">
                                <select name="prodi" id="prodi" class="form-control rounded">
                                    <option value="">Pilih Fakultas</option>
                                    <option value="">=====================</option>
                                    <option value="Fakultas Ekonomi dan Bisnis"
                                        {{ old('prodi') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas
                                        Ekonomi dan Bisnis</option>
                                    <option value="Fakultas Sains dan Teknologi"
                                        {{ old('prodi') == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}>Fakultas
                                        Sains dan Teknologi</option>
                                    <option value="Fakultas Ilmu Kesehatan"
                                        {{ old('prodi') == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}>Fakultas Ilmu
                                        Kesehatan</option>
                                </select>
                                @error('prodi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload Dokumen</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" class="form-control rounded" id="file-input">
                                @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
