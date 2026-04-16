@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Edit Pedoman</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('pedoman.update', $pedoman->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun</label>
                            <div class="col-sm-10">
                                <input type="number" name="tahun" value="{{ old('tahun') ?? $pedoman->tahun }}"
                                    class="form-control rounded" placeholder="Masukkan tahun akademik">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Pedoman</label>
                            <div class="col-sm-10">
                                <textarea name="nama_pedoman" class="form-control rounded" id="" cols="30" rows="3">{{ old('nama_pedoman') ?? $pedoman->nama_pedoman }}</textarea>
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
                        <a href="{{ route('pedoman.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
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
@endpush
