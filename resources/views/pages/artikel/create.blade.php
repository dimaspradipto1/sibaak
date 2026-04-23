@extends('layouts.dashboard.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-plus-circle text-primary mr-2"></i>Buat Artikel Baru
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul artikel" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Kategori <span class="text-danger">*</span></label>
                                <select name="tipe" class="form-control select2 @error('tipe') is-invalid @enderror" required>
                                    <option value="Informasi">Informasi</option>
                                    <option value="Berita">Berita</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                    <option value="Tutorial">Tutorial</option>
                                </select>
                                @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small uppercase mb-1">Konten Artikel <span class="text-danger">*</span></label>
                        <textarea name="konten" id="editor" class="form-control @error('konten') is-invalid @enderror" rows="10">{{ old('konten') }}</textarea>
                        @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Link YouTube / External URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0"><i class="fa-solid fa-link text-muted"></i></span>
                                    </div>
                                    <input type="url" name="media_url" class="form-control border-left-0 @error('media_url') is-invalid @enderror" value="{{ old('media_url') }}" placeholder="https://youtube.com/watch?v=...">
                                </div>
                                <small class="text-muted">Opsional. Masukkan link video YouTube atau website luar.</small>
                                @error('media_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Kata Kunci (Keywords)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0"><i class="fa-solid fa-tags text-muted"></i></span>
                                    </div>
                                    <input type="text" name="keyword" class="form-control border-left-0 @error('keyword') is-invalid @enderror" value="{{ old('keyword') }}" placeholder="Contoh: akreditasi, pedoman, wisuda">
                                </div>
                                <small class="text-muted">Gunakan koma sebagai pemisah kata kunci.</small>
                                @error('keyword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Gambar Sampul (Thumbnail)</label>
                                <div class="custom-file">
                                    <input type="file" name="gambar" class="custom-file-input @error('gambar') is-invalid @enderror" id="customFile">
                                    <label class="custom-file-label" for="customFile">Pilih gambar...</label>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, Max 2MB.</small>
                                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('artikel.index') }}" class="btn btn-light px-4 mr-2 border" style="border-radius: 50px !important;">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm" style="border-radius: 50px !important;">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Publikasikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize CKEditor
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('editor', {
            height: 400,
            baseFloatZIndex: 10005,
            removeButtons: 'PasteFromWord'
        });
    }

    // Custom File Input Label
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush
