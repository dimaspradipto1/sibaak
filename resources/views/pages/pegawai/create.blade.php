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
                    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Pegawai</label>
                            <div class="col-sm-10">
                                <select name="users_id" id="users_id"
                                    class="form-control rounded @error('users_id') is-invalid @enderror"
                                    data-live-search="true">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('users_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Staff Lengkap dengan Gelar</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_staff" value="{{ old('nama_staff') }}"
                                    class="form-control rounded @error('nama_staff') is-invalid @enderror">
                                @error('nama_staff')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                                    class="form-control rounded @error('jabatan') is-invalid @enderror">
                                @error('jabatan')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NUP</label>
                            <div class="col-sm-10">
                                <input type="number" name="nup" value="{{ old('nup') }}"
                                    class="form-control rounded @error('nidn') is-invalid @enderror">
                                @error('nup')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIDN</label>
                            <div class="col-sm-10">
                                <input type="number" name="nidn" value="{{ old('nidn') }}"
                                    class="form-control rounded @error('nidn') is-invalid @enderror">
                                @error('nidn')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">HOMEBASE</label>
                            <div class="col-sm-10">
                               <select name="homebase" id="homebase" class="form-control rounded">
                                <option value="">Pilih Program Studi</option>
                                <option value="">=====================</option>
                                <option value='Fakultas Ekonomi dan Bisnis (FEB)' {{ old('homebase') == 'Fakultas Ekonomi dan Bisnis (FEB)' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis (FEB)</option>
                                <option value='Fakultas Sains dan Teknologi (FST)' {{ old('homebase') ==  'Fakultas Sains dan Teknologi (FST)' ?  'selected' : ''}}>Fakultas Sains dan Teknologi (FST)</option>
                                <option value="Fakultas Ilmu Kesehatan (FIKES)" {{ old('homebase') == 'Fakultas Ilmu Kesehatan (FIKES)' ? 'selected' : '' }}>Fakultas Ilmu Kesehatan (FIKES)</option>
                               </select>
                               @error('homebase')
                                    <span class="text-danger small">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload TTD</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" accept="image/*"
                                    class="form-control rounded @error('file') is-invalid @enderror" id="file-input">
                                @error('file')
                                    <span class="text-danger small">{{ $message }}</span>
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
                        <a href="{{ route('pegawai.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
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
            $('#users_id').select2();
        });
    </script>
@endpush
