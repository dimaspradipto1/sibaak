@extends('layouts.dashboard.template')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Form Pengguna')
@section('page-subtitle', 'Tambah Data Pengguna Baru')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Pengguna</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded"
                                    placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control rounded" placeholder="Masukkan email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Checkbox for status -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Role Akses</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_admin">Admin</label>
                                    @error('is_admin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_mahasiswa" id="is_mahasiswa" value="1" {{ old('is_mahasiswa') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_mahasiswa">Mahasiswa</label>
                                    @error('is_mahasiswa')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_tata_usaha" id="is_tata_usaha" value="1" {{ old('is_tata_usaha') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_tata_usaha">Tata Usaha</label>
                                    @error('is_tata_usaha')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_approval" id="is_approval" value="1" {{ old('is_approval') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_approval">Approval</label>
                                    @error('is_approval')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_staffbaak" id="is_staffbaak" value="1" {{ old('is_staffbaak') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_staffbaak">Staff BAAK</label>
                                    @error('is_staffbaak')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection
