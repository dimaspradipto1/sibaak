@extends('layouts.dashboard.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0" style="border-radius: 15px;">
            <div class="card-header bg-white py-3" style="border-bottom: 2px solid #f8f9fa;">
                <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-plus-circle mr-2 text-success"></i> Tambah Unit Kerja</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('unitkerja.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-muted">Nama Unit Kerja</label>
                        <input type="text" name="nama_unit" class="form-control rounded-lg shadow-sm @error('nama_unit') is-invalid @enderror" placeholder="Misal: UPT TEKNIK INFO & KOMUNIKASI" required>
                        @error('nama_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-muted">Kode Unit (Optional)</label>
                        <input type="text" name="kode_unit" class="form-control rounded-lg shadow-sm" placeholder="Misal: LPTI">
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-muted">Atasan / Parent Unit</label>
                        <select name="parent_id" class="form-control select2 rounded-lg shadow-sm">
                            <option value="">-- Tanpa Atasan (Root) --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->nama_unit }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-2 d-block">Pilih unit atasan untuk membangun hirarki akses.</small>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <a href="{{ route('unitkerja.index') }}" class="btn btn-light px-4 mr-2 rounded-lg">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-lg shadow-sm">Simpan Unit</button>
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
