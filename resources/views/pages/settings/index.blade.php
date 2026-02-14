@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Pengaturan Akun</h5>
                </div>
                <div class="card-block">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h4 class="sub-title">Ganti Password</h4>
                    <form action="{{ route('settings.updatePassword') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password Saat Ini</label>
                            <div class="col-sm-10">
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="Masukkan password saat ini">
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password Baru</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        placeholder="Masukkan password baru (min. 8 karakter)">
                                    <span class="input-group-append">
                                        <button class="btn btn-default" type="button"
                                            onclick="togglePassword('new_password')">
                                            <i class="fa fa-eye" id="icon_new_password"></i>
                                        </button>
                                    </span>
                                </div>
                                @error('new_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="form-control" placeholder="Ulangi password baru">
                                    <span class="input-group-append">
                                        <button class="btn btn-default" type="button"
                                            onclick="togglePassword('new_password_confirmation')">
                                            <i class="fa fa-eye" id="icon_new_password_confirmation"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                                    <i class="fa-solid fa-save"></i> Simpan Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            var icon = document.getElementById('icon_' + fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
