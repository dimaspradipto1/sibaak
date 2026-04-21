@extends('layouts.dashboard.template')
@section('content')
<div class="row"><div class="col-sm-12">
    <div class="card">
        <div class="card-header"><h5>Edit Role</h5></div>
        <div class="card-block">
            <form action="{{ route('role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Role</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_role" value="{{ old('nama_role', $role->nama_role) }}" class="form-control rounded" placeholder="Masukkan nama role">
                        @error('nama_role')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Unit Kerja</label>
                    <div class="col-sm-10">
                        <select name="unit_kerja_id" class="form-control rounded">
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach($unitKerjas as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $role->unit_kerja_id) == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih unit kerja untuk menentukan hirarki akses dokumen.</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary rounded btn-sm"><i class="fa-solid fa-save"></i> Update</button>
                <a href="{{ route('role.index') }}" class="btn btn-danger rounded btn-sm"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
</div></div>
@endsection
