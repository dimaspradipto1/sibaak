@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Program Studi</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('programStudi.update', $programStudi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Program Studi</label>
                            <div class="col-sm-10">
                                <input type="text" name="program_studi"
                                    value="{{ old('program_studi') ?? $programStudi->program_studi }}"
                                    class="form-control rounded" placeholder="Masukkan nama program studi" required>
                            </div>
                        </div>
                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Update
                        </button>
                        <a href="{{ route('programStudi.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
