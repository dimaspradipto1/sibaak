@extends('layouts.dashboard.template')

@section('content')
<div class="card">
    <div class="card-header">
        @if(Auth::user()->is_admin || Auth::user()->is_staffbaak)
            <a href="{{ route('suratAktif.create') }}" class="btn btn-primary rounded btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a>
        @endif

        @if(auth()->user()->is_mahasiswa)
            <!-- Tombol hanya untuk mahasiswa: Pengajuan -->
            <form action="{{ route('suratAktif.pengajuan') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success rounded btn-sm">
                    <i class="fa-solid fa-plus"></i> Pengajuan
                </button>
            </form>
        @endif

        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                <li><i class="fa fa-window-maximize full-card"></i></li>
                <li><i class="fa fa-minus minimize-card"></i></li>
                <li><i class="fa fa-refresh reload-card"></i></li>
                <li><i class="fa fa-trash close-card"></i></li>
            </ul>
        </div>
    </div>
      

    <div class="card-block table-border-style">
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered',
                'style' => 'width: 100%; overflow-x: auto;',
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
