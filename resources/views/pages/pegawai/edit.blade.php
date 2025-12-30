@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Form Edit Pegawai</h5>
                </div>
                <div class="card-block">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Pegawai</label>
                            <div class="col-sm-10">
                                <select name="users_id" id="users_id"
                                    class="form-control rounded @error('users_id') is-invalid @enderror"
                                    data-live-search="true">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('users_id', $pegawai->users_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                                    class="form-control rounded @error('jabatan') is-invalid @enderror">
                                @error('jabatan')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIDN</label>
                            <div class="col-sm-10">
                                <input type="text" name="nidn" value="{{ old('nidn', $pegawai->nidn) }}"
                                    class="form-control rounded @error('nidn') is-invalid @enderror">
                                @error('nidn')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">URL TTD</label>
                            <div class="col-sm-10">
                                @if ($pegawai->url)
                                    <div class="mb-2">
                                        <img src="{{ asset($pegawai->url) }}" alt="TTD" width="150"
                                            class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="url"
                                    class="form-control rounded @error('url') is-invalid @enderror" accept="image/*">
                                @error('url')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah tanda tangan.</small>
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Update
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#users_id').select2();
        });
    </script>
@endpush
