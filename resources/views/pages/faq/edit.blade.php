@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form FAQ</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="{{ old('title', $faq->title) }}" class="form-control rounded"
                                    placeholder="Masukkan title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea name="deskripsi" class="form-control rounded" placeholder="Masukkan deskripsi">{{ old('deskripsi', $faq->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Update
                        </button>
                        <a href="{{ route('faq.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
