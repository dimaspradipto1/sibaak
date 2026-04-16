@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Arsip Utama</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('arsiputama.update', $arsiputama->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori Arsip</label>
                            <div class="col-sm-10">
                                <select name="kategori_arsip_id" id="kategori_arsip_id" class="form-control rounded">
                                    <option value="">-- Pilih Kategori Arsip --</option>
                                    @foreach ($kategoriArsips as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('kategori_arsip_id', $arsiputama->kategori_arsip_id) == $kategori->id ? 'selected' : '' }}>
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
                                <input type="text" name="tahun_arsip"
                                    value="{{ old('tahun_arsip', $arsiputama->tahun_arsip) }}"
                                    class="form-control rounded" placeholder="Contoh: 2025">
                                @error('tahun_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Arsip</label>
                            <div class="col-sm-10">
                                <textarea name="nama_arsip" class="form-control rounded" rows="3">{{ old('nama_arsip', $arsiputama->nama_arsip) }}</textarea>
                                @error('nama_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Dokumen Saat Ini</label>
                            <div class="col-sm-10">
                                @if ($arsiputama->file_arsip)
                                    <a href="{{ $arsiputama->file_arsip }}" target="_blank" class="btn btn-sm btn-success px-3 rounded mb-2">
                                        <i class="fa-solid fa-eye"></i> Lihat Dokumen
                                    </a>
                                @else
                                    <span class="text-muted">Belum ada dokumen</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Ganti Dokumen (PDF)</label>
                            <div class="col-sm-10">
                                <input type="file" name="file_arsip" class="form-control rounded" id="file-input" accept=".pdf">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                                @error('file_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Preview Dokumen Baru</label>
                            <div class="col-sm-10">
                                <div id="preview-container"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Update
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
