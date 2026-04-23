@extends('layouts.dashboard.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-pen-to-square text-warning mr-2"></i>Edit Artikel
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $artikel->judul) }}" placeholder="Masukkan judul artikel" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Kategori <span class="text-danger">*</span></label>
                                <select name="tipe" class="form-control select2 @error('tipe') is-invalid @enderror" required>
                                    <option value="Informasi" {{ $artikel->tipe == 'Informasi' ? 'selected' : '' }}>Informasi</option>
                                    <option value="Berita" {{ $artikel->tipe == 'Berita' ? 'selected' : '' }}>Berita</option>
                                    <option value="Pengumuman" {{ $artikel->tipe == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                    <option value="Tutorial" {{ $artikel->tipe == 'Tutorial' ? 'selected' : '' }}>Tutorial</option>
                                </select>
                                @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted small uppercase mb-1">Konten Artikel <span class="text-danger">*</span></label>
                        <textarea name="konten" id="editor" class="form-control @error('konten') is-invalid @enderror" rows="10">{{ old('konten', $artikel->konten) }}</textarea>
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
                                    <input type="url" name="media_url" class="form-control border-left-0 @error('media_url') is-invalid @enderror" value="{{ old('media_url', $artikel->media_url) }}" placeholder="https://youtube.com/watch?v=...">
                                </div>
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
                                    <input type="text" name="keyword" class="form-control border-left-0 @error('keyword') is-invalid @enderror" value="{{ old('keyword', $artikel->keyword) }}" placeholder="Contoh: akreditasi, pedoman, wisuda">
                                </div>
                                <small class="text-muted">Gunakan koma sebagai pemisah kata kunci.</small>
                                @error('keyword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted small uppercase mb-1">Gambar Sampul (Biarkan kosong jika tidak diubah)</label>
                                @if($artikel->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Preview" class="rounded shadow-sm" style="max-height: 100px;">
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" name="gambar" class="custom-file-input @error('gambar') is-invalid @enderror" id="customFile">
                                    <label class="custom-file-label" for="customFile">Pilih gambar baru...</label>
                                </div>
                                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('artikel.index') }}" class="btn btn-light px-4 mr-2 border" style="border-radius: 50px !important;">Batal</a>
                        <button type="submit" class="btn btn-warning px-5 shadow-sm text-white" style="border-radius: 50px !important;">
                            <i class="fa-solid fa-save mr-2"></i>Simpan Perubahan
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
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('editor', {
            height: 400,
            baseFloatZIndex: 10005
        });
    }

    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush
