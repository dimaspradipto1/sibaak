@extends('layouts.dashboard.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0" style="border-radius: 15px;">
            <div class="card-header bg-white py-3" style="border-bottom: 2px solid #f8f9fa;">
                <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-edit mr-2 text-warning"></i> Edit Unit Kerja</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('unitkerja.update', $unitkerja->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-muted">Nama Unit Kerja</label>
                        <input type="text" name="nama_unit" class="form-control rounded-lg shadow-sm @error('nama_unit') is-invalid @enderror" value="{{ $unitkerja->nama_unit }}" required>
                        @error('nama_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-muted">Kode Unit (Optional)</label>
                        <input type="text" name="kode_unit" class="form-control rounded-lg shadow-sm" value="{{ $unitkerja->kode_unit }}">
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-muted">Atasan / Parent Unit</label>
                        <select name="parent_id" class="form-control select2 rounded-lg shadow-sm">
                            <option value="">-- Tanpa Atasan (Root) --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ $unitkerja->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <a href="{{ route('unitkerja.index') }}" class="btn btn-light px-4 mr-2 rounded-lg">Batal</a>
                        <button type="submit" class="btn btn-warning text-white px-4 rounded-lg shadow-sm">Update Unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    });
</script>
@endpush
