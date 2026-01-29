    @extends('layouts.dashboard.template')

    @section('content')
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Form Inputs card start -->
                <div class="card">
                    <div class="card-header">
                        <h5>Form {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <h4 class="sub-title">Form {{ $title }}</h4>
                        <form action="{{ route('userGuideTatausaha.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        class="form-control rounded" placeholder="Masukkan title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Link Dokumen Gdrive</label>
                                <div class="col-sm-10">
                                    <textarea name="link_dokumen" id="editor_link_dokumen" class="form-control rounded" placeholder="Masukkan link dokumen google drive">{{ old('link_dokumen') }}</textarea>
                                    @error('link_dokumen')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Submit buttons -->
                            <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                                <i class="fa-solid fa-save"></i> Submit
                            </button>
                            <a href="{{ route('userGuideTatausaha.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                                <i class="fa-solid fa-arrow-left"></i> Back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Form Inputs card end -->
    @endsection

