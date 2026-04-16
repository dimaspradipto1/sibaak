@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Arsip Utama</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('arsiputama.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori Arsip</label>
                            <div class="col-sm-10">
                                <select name="kategori_arsip_id" id="kategori_arsip_id" class="form-control rounded">
                                    <option value="">-- Pilih Kategori Arsip --</option>
                                    @foreach ($kategoriArsips as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_arsip_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->kategori_arsip }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_arsip_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Arsip</label>
                            <div class="col-sm-10">
                                <input type="text" name="tahun_arsip" value="{{ old('tahun_arsip') }}"
                                    class="form-control rounded" placeholder="Contoh: 2025">
                                @error('tahun_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Arsip</label>
                            <div class="col-sm-10">
                                <textarea name="nama_arsip" class="form-control rounded" rows="3"
                                    placeholder="Masukkan nama arsip">{{ old('nama_arsip') }}</textarea>
                                @error('nama_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload Dokumen (PDF)</label>
                            <div class="col-sm-10">
                                <input type="file" name="file_arsip" class="form-control rounded" id="file-input" accept=".pdf">
                                @error('file_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Preview Dokumen</label>
                            <div class="col-sm-10">
                                <div id="preview-container"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>
                        <a href="{{ route('arsiputama.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('file-input').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';
            if (file && file.type === 'application/pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = URL.createObjectURL(file);
                iframe.width = '100%';
                iframe.height = '500px';
                previewContainer.appendChild(iframe);
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#kategori_arsip_id').select2();
        });
    </script>
@endpush
