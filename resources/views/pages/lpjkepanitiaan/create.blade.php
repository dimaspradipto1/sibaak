@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form LPJ Kepanitiaan</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('lpjkepanitiaan.store') }}" method="POST" enctype="multipart/form-data">
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
                                   <div class="text-danger mt-2">
                                       {{ $message }}
                                   </div>
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
                            <label class="col-sm-2 col-form-label">Nama LPJ</label>
                            <div class="col-sm-10">
                                <textarea name="nama_dokumen" class="form-control rounded" id="" cols="30" rows="3">{{ old('nama_dokumen') }}</textarea>
                                @error('nama_dokumen')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Ketua</label>
                            <div class="col-sm-10">
                                <input type="text" name="ketua" value="{{ old('ketua') }}"
                                    class="form-control rounded" placeholder="Masukkan nama ketua">
                                @error('ketua')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Sekretaris umum</label>
                            <div class="col-sm-10">
                                <input type="text" name="sekretaris" value="{{ old('sekretaris') }}"
                                    class="form-control rounded" placeholder="Masukkan nama sekretaris">
                                @error('sekretaris')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fakultas</label>
                            <div class="col-sm-10">
                               <select name="fakultas" id="fakultas" class="form-control rounded">
                                   <option value="">Pilih Fakultas</option>
                                   <option value="">=====================</option>
                                   <option value="Fakultas Ekonomi dan Bisnis" {{ old('fakultas') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                                   <option value="Fakultas Sains dan Teknologi" {{ old('fakultas') == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}>Fakultas Sains dan Teknologi</option>
                                   <option value="Fakultas Ilmu Kesehatan" {{ old('fakultas') == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}>Fakultas Ilmu Kesehatan</option>
                               </select>
                               @error('fakultas')
                                   <div class="text-danger mt-2">
                                       {{ $message }}
                                   </div>
                               @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload Dokumen</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" class="form-control rounded" id="file-input" >
                                @error('file')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
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
                        <a href="{{ route('lpjkepanitiaan.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
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
                } 
                else if (file.type === 'application/pdf') {
                    const iframe = document.createElement('iframe');
                    iframe.src = URL.createObjectURL(file);
                    iframe.width = '100%';
                    iframe.height = '500px';
                    previewContainer.appendChild(iframe);
                } 
                else if (file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    const fileUrl = URL.createObjectURL(file);
                    const link = document.createElement('a');
                    link.href = `https://docs.google.com/gview?url=${fileUrl}&embedded=true`;
                    link.target = "_blank";
                    link.textContent = `Preview Word: ${file.name}`;
                    previewContainer.appendChild(link);
                }
                else if (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    const fileUrl = URL.createObjectURL(file);
                    const link = document.createElement('a');
                    link.href = `https://docs.google.com/gview?url=${fileUrl}&embedded=true`;
                    link.target = "_blank";
                    link.textContent = `Preview Excel: ${file.name}`;
                    previewContainer.appendChild(link);
                } 
                else {
                    const fileName = document.createElement('p');
                    fileName.textContent = `File: ${file.name}`;
                    previewContainer.appendChild(fileName);
                }
            }
        });
    </script>
@endpush
