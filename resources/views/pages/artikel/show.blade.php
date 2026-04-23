@extends('layouts.dashboard.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 16px;">
            <!-- Hero Image / Video Section -->
            @if($embed_url)
                <div class="embed-responsive embed-responsive-16by9 bg-black">
                    <iframe class="embed-responsive-item" src="{{ $embed_url }}" allowfullscreen></iframe>
                </div>
            @elseif($artikel->gambar)
                <div style="height: 400px; overflow: hidden; background: #f8f9fa;">
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-100 h-100" style="object-fit: cover;">
                </div>
            @endif

            <div class="card-body p-4 p-md-5">
                <!-- Meta Info -->
                <div class="d-flex align-items-center mb-4">
                    <span class="badge badge-info text-white px-3 py-2 mr-3 text-capitalize" style="font-size: 13px;">{{ $artikel->tipe }}</span>
                    <div class="text-muted small">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $artikel->created_at->format('d M Y, H:i') }} WIB
                        <span class="mx-2">|</span>
                        <i class="fa-solid fa-user-pen mr-1"></i> {{ $artikel->user->name }}
                    </div>
                </div>

                <!-- Title -->
                <h1 class="font-weight-bold text-dark mb-4" style="font-size: 2.5rem; line-height: 1.2;">{{ $artikel->judul }}</h1>

                <!-- Content -->
                <div class="article-content text-dark" style="font-size: 1.1rem; line-height: 1.8; color: #333 !important;">
                    {!! $artikel->konten !!}
                </div>

                <!-- External Link Section -->
                @if($artikel->media_url && !$embed_url)
                    <div class="mt-5 p-4 bg-light rounded shadow-sm border-left border-primary" style="border-left-width: 5px !important;">
                        <h6 class="font-weight-bold mb-2">Tautan Eksternal:</h6>
                        <a href="{{ $artikel->media_url }}" target="_blank" class="text-primary text-break">
                            <i class="fa-solid fa-external-link-alt mr-2"></i>{{ $artikel->media_url }}
                        </a>
                    </div>
                @endif

                <hr class="my-5">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('artikel.index') }}" class="btn btn-light px-4 border" style="border-radius: 50px !important;">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Portal
                    </a>
                    
                    @if(Auth::id() == $artikel->users_id || Auth::user()->is_admin || Auth::user()->is_superadmin)
                    <div>
                        <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn btn-warning text-white px-4 shadow-sm mr-2" style="border-radius: 50px !important;">
                            <i class="fa-solid fa-edit mr-1"></i>Ubah
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .article-content img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 8px;
        margin: 20px 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .bg-black { background: #000; }
</style>
@endsection
