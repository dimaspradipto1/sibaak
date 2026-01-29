@extends('layouts.dashboard.template')

@section('content')
    <div class="card">
        <div class="card-header">
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
                <h3 class="text-capitalize"
                    style="background-color: #104819; color: #ffffff; font-weight: bold; font-size: 30px; text-align: center; padding: 15px; border-radius: 5px;">
                    archive service letter
                </h3>
                <br>
                <br>
                <h5 style="color: #104819; font-weight: bold; font-size: 30px;">Manajeman Arsip BAAK</h5>
                <div class="card-block">
                    <div class="list-group">
                        @foreach ($userguidepenggunatatausaha as $item)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 py-3"
                                style="border-bottom: 2px solid #f0f0f0 !important;">
                                <h5 style="color: #019C24; font-weight: bold; font-size: 20px; margin: 0;">
                                    {{ $item->title }}
                                </h5>

                                <a href="{{ $item->link_dokumen }}" target="_blank" class="btn btn-sm px-5 py-3 rounded"
                                    style="background-color: #104819; color: #ffffff; font-weight: bold;">
                                    Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('style')
    <style>
        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush
