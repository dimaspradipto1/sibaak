@extends('layouts.dashboard.template')
@section('content')
<div class="row"><div class="col-sm-12">
    <div class="card">
        <div class="card-header"><h5>Form Role</h5></div>
        <div class="card-block">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Role</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_role" value="{{ old('nama_role') }}" class="form-control rounded" placeholder="Masukkan nama role">
                        @error('nama_role')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary rounded btn-sm"><i class="fa-solid fa-save"></i> Submit</button>
                <a href="{{ route('role.index') }}" class="btn btn-danger rounded btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
</div></div>
@endsection
