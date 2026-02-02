@extends('layouts.dashboard.template')

@section('content')

@php
    use App\Models\Mahasiswa;
@endphp


<div class="card">
    <div class="card-header">
        {{-- <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary rounded btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a> --}}

        {{-- @if (Auth::user()->is_admin || !Mahasiswa::where('users_id', Auth::id())->exists())
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary rounded btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        @endif --}}
        @if (Auth::user()->is_admin)
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary rounded btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        @endif

         @if(auth()->user()->is_mahasiswa)
            <!-- Tombol hanya untuk mahasiswa: Pengajuan -->
            <form action="{{ route('suratAktif.pengajuan') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success rounded btn-sm">
                    <i class="fa-solid fa-plus"></i> Pengajuan Surat Aktif
                </button>
            </form>

            <a href="{{ route('suratAkademik.create') }}" class="btn btn-secondary rounded btn-sm my-2">
                <i class="fa-solid fa-plus"></i> Pengajuan Surat Akademik
            </a>
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
                    'style' => 'width:100%; overflow-x: auto',
                ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
