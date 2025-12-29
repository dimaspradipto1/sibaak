@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Jenis SK</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('jenissk.update', $jenissk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Jenis SK</label>
                            <div class="col-sm-10">
                                <input type="text" name="jenis_sk" value="{{ old('jenis_sk') ?? $jenissk->jenis_sk }}" class="form-control rounded"
                                    placeholder="Masukkan nama jenis sk" required>
                            </div>
                        </div>
                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Update
                        </button>
                        <a href="{{ route('jenissk.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
