@extends('layouts.dashboard.template')

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
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control rounded"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="{{ $user->email }}"
                                    class="form-control rounded" placeholder="Masukkan email" required>
                            </div>
                        </div>


                        <!-- Checkbox for status -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Role Akses</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin" {{ $user->is_admin ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_mahasiswa" id="is_mahasiswa" {{ $user->is_mahasiswa ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_mahasiswa">Mahasiswa</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_tata_usaha" id="is_tata_usaha" {{ $user->is_tata_usaha ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_tata_usaha">Tata Usaha</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_approval" id="is_approval" {{ $user->is_approval ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_approval">Approval</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_staffbaak" id="is_staffbaak" {{ $user->is_staffbaak ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_staffbaak">Staff BAAK</label>
                                </div>
                            </div>
                        </div>


                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Update
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
