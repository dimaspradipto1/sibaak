<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logouis.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #fff;
            color: #202124;
            margin: 0;
            padding: 0;
        }

        .no-focus:focus {
            box-shadow: none;
            outline: none;
        }

        .shadow-hover:hover {
            box-shadow: 0 1px 6px rgba(32, 33, 36, .28) !important;
        }

        .transition {
            transition: all 0.2s ease-in-out;
        }

        .hover-underline:hover {
            text-decoration: underline !important;
        }

        .shortcut-item {
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none !important;
        }

        .shortcut-item:hover .icon-circle {
            background: #f8f9fa !important;
            transform: scale(1.05);
        }

        /* Landing Style */
        .landing-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
        }

        .google-logo {
            font-size: 90px;
            font-weight: 500;
            letter-spacing: -4px;
            margin-bottom: 30px;
        }

        .search-wrapper {
            width: 100%;
            max-width: 584px;
            margin: 0 auto;
        }

        .search-bar-landing {
            border: 1px solid #dfe1e5;
            border-radius: 24px;
            display: flex;
            align-items: center;
            padding: 5px 15px;
            background: #fff;
        }

        .search-bar-landing:hover,
        .search-bar-landing:focus-within {
            box-shadow: 0 1px 6px rgba(32, 33, 36, .28);
            border-color: rgba(223, 225, 229, 0);
        }

        /* Results Style */
        .results-header {
            border-bottom: 1px solid #ebebeb;
            padding: 20px 30px;
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 100;
        }

        .results-logo {
            font-size: 24px;
            font-weight: 700;
            text-decoration: none !important;
        }

        .search-bar-results {
            border: 1px solid #dfe1e5;
            border-radius: 24px;
            display: flex;
            align-items: center;
            padding: 2px 15px;
            width: 100%;
            max-width: 692px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .nav-link-google {
            color: #70757a;
            font-size: 14px;
            padding: 10px 0;
            margin-right: 20px;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            text-decoration: none !important;
        }

        .nav-link-google:hover {
            color: #202124;
        }

        .nav-link-google.active {
            color: #1a73e8;
            border-bottom: 3px solid #1a73e8;
        }

        .top-right-nav {
            position: absolute;
            top: 15px;
            right: 30px;
            z-index: 1000;
        }

        .btn-google-login {
            background-color: #1a73e8;
            color: #fff;
            border-radius: 4px;
            padding: 8px 24px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none !important;
        }

        .btn-google-login:hover {
            color: #fff;
            background-color: #1557b0;
        }

        .result-item {
            margin-bottom: 30px;
            max-width: 652px;
        }

        .result-item cite {
            font-style: normal;
            color: #202124;
            font-size: 14px;
        }

        .result-item h3 {
            color: #1a0dab;
            font-size: 20px;
            font-weight: 400;
            margin-top: 4px;
        }

        .result-item .snippet {
            color: #4d5156;
            font-size: 14px;
            line-height: 1.58;
        }

        .footer {
            background: #f2f2f2;
            padding: 15px 30px;
            border-top: 1px solid #dadce0;
            color: #70757a;
            font-size: 14px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* Account Avatar Style */
        .user-avatar {
            width: 32px;
            height: 32px;
            background-color: #0d9488;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: box-shadow 0.2s;
        }
        .user-avatar:hover {
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .google-apps-icon {
            font-size: 18px;
            color: #5f6368;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.2s;
        }
        .google-apps-icon:hover {
            background: rgba(60,64,67,0.08);
        }

        /* Gallery Grid Style */
        .gallery-item {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #dadce0;
            transition: all 0.2s;
            background: #fff;
            position: relative;
        }

        .gallery-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .gallery-preview {
            height: 200px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            overflow: hidden;
        }
        .gallery-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        .gallery-info {
            padding: 12px;
            border-top: 1px solid #ebebeb;
        }

        .gallery-title {
            font-size: 13px;
            color: #202124;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .xsmall { font-size: 11px; }
    </style>
</head>

<body>

    <div class="top-right-nav d-flex align-items-center">
        <!-- Google Apps & Profile Links -->
        <a href="https://mail.google.com" target="_blank" class="mr-3 text-muted small d-none d-md-inline text-decoration-none hover-underline">Gmail</a>
        <span class="mr-3 text-muted small d-none d-md-inline" style="cursor: pointer;">Gambar</span>
        
        <div class="google-apps-icon mr-2">
            <i class="fa-solid fa-ellipsis-vertical" style="transform: rotate(90deg);"></i>
        </div>

        @auth
            <div class="dropdown">
                <div class="user-avatar" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-3 text-center" style="width: 280px; border-radius: 12px;">
                    <div class="user-avatar mx-auto mb-2" style="width: 60px; height: 60px; font-size: 24px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h6 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h6>
                    <p class="small text-muted mb-3">{{ Auth::user()->email }}</p>
                    <hr>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-block btn-sm mb-2 rounded-pill">Kelola Akun Dashbord</a>
                    <a href="{{ route('logout') }}" class="btn btn-light btn-block btn-sm border rounded-pill">Keluar</a>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-google-login">Sign in</a>
        @endauth
    </div>

    @if (!$query)
        <div class="landing-container">
            <div class="google-logo">
                <span style="color: #4285F4;">M</span><span style="color: #EA4335;">y</span><span
                    style="color: #FBBC05;">b</span><span style="color: #4285F4;">a</span><span
                    style="color: #34A853;">a</span><span style="color: #EA4335;">k</span>
            </div>

            <div class="search-wrapper px-3">
                <form action="{{ route('semantic.index') }}" method="GET">
                    <div class="search-bar-landing">
                        <i class="fa-solid fa-magnifying-glass text-muted mr-3"></i>
                        <input type="text" name="q" class="form-control border-0 no-focus py-4"
                            placeholder="Cari arsip UIS..." autofocus autocomplete="off">
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-light px-4 py-2 mr-2 border-0 shadow-sm"
                            style="background: #f8f9fa;">UIS Search</button>
                        <button type="button" class="btn btn-light px-4 py-2 border-0 shadow-sm"
                            style="background: #f8f9fa;">I'm Feeling Lucky</button>
                    </div>
                </form>
            </div>

            <div class="d-flex mt-5">
                <a href="{{ route('semantic.index', ['q' => 'SK', 'tab' => 'gambar']) }}"
                    class="shortcut-item text-center mx-4">
                    <div class="icon-circle bg-light mb-2 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px; border-radius: 50%;">
                        <i class="fa-solid fa-file-pdf text-danger"></i>
                    </div>
                    <span class="small text-muted">SK</span>
                </a>
                <a href="{{ route('semantic.index', ['q' => 'LPJ', 'tab' => 'gambar']) }}"
                    class="shortcut-item text-center mx-4">
                    <div class="icon-circle bg-light mb-2 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px; border-radius: 50%;">
                        <i class="fa-solid fa-file-word text-primary"></i>
                    </div>
                    <span class="small text-muted">LPJ</span>
                </a>
                <a href="{{ route('semantic.index', ['q' => 'Arsip', 'tab' => 'terbaru']) }}"
                    class="shortcut-item text-center mx-4">
                    <div class="icon-circle bg-light mb-2 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px; border-radius: 50%;">
                        <i class="fa-solid fa-file-excel text-success"></i>
                    </div>
                    <span class="small text-muted">Arsip</span>
                </a>
            </div>
        </div>
        <div class="footer d-flex justify-content-between">
            <div class="d-flex">
                <span class="mr-4">Indonesia</span>
            </div>
            <div class="d-flex">
                <span class="ml-4">Privacy</span>
                <span class="ml-4">Terms</span>
                <span class="ml-4">Settings</span>
            </div>
        </div>
    @else
        <div class="results-header d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('semantic.index') }}" class="results-logo mr-5">
                    <span style="color: #4285F4;">M</span><span style="color: #EA4335;">y</span><span
                        style="color: #FBBC05;">b</span><span style="color: #4285F4;">a</span><span
                        style="color: #34A853;">a</span><span style="color: #EA4335;">k</span>
                </a>
                <div class="search-bar-results ml-2">
                    <input type="text" name="q" class="form-control border-0 no-focus py-2"
                        value="{{ $query }}" form="searchForm">
                    <i class="fa-solid fa-magnifying-glass text-primary ml-auto cursor-pointer"
                        onclick="document.getElementById('searchForm').submit();"></i>
                </div>
                <form id="searchForm" action="{{ route('semantic.index') }}" method="GET" class="d-none">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                </form>
            </div>
            <div class="d-flex ml-5 pl-5">
                <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'semua']) }}"
                    class="nav-link-google {{ $tab == 'semua' ? 'active' : '' }}"><i
                        class="fa-solid fa-magnifying-glass mr-2"></i>Semua</a>
                <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'gambar']) }}"
                    class="nav-link-google {{ $tab == 'gambar' ? 'active' : '' }}"><i
                        class="fa-solid fa-image mr-2"></i>Gambar</a>
                <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'terbaru']) }}"
                    class="nav-link-google {{ $tab == 'terbaru' ? 'active' : '' }}"><i
                        class="fa-solid fa-calendar mr-2"></i>Terbaru</a>
            </div>
        </div>

        <div class="container-fluid py-4 pl-3 pr-5">
            <div class="row">
                <div class="col-12 ml-md-5 pl-md-5">
                    <p class="text-muted small mb-4">Ditemukan {{ $results->count() }} hasil
                        ({{ round(microtime(true) - LARAVEL_START, 2) }} detik)</p>

                    @if ($results->isEmpty())
                        <div class="py-4">
                            <p>Penelusuran Anda - <b>{{ $query }}</b> - tidak cocok dengan dokumen apa pun.</p>
                        </div>
                    @else
                        @if ($tab == 'gambar')
                            <!-- Gallery View -->
                            <div class="row">
                                @foreach ($results as $item)
                                    <div class="col-6 col-md-3 col-lg-2 mb-4">
                                        <div class="gallery-item shadow-sm">
                                            <a href="{{ $item->link }}" target="_blank" class="gallery-preview">
                                                @if ($item->thumbnail)
                                                    <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}"
                                                        onerror="this.parentElement.innerHTML='<i class=\'fa-solid {{ $item->icon }} {{ $item->color }}\' style=\'font-size: 60px;\'></i>'">
                                                @else
                                                    <i class="fa-solid {{ $item->icon }} {{ $item->color }}"
                                                        style="font-size: 60px;"></i>
                                                @endif
                                            </a>
                                            <div class="gallery-info">
                                                <div class="gallery-title" title="{{ $item->title }}">
                                                    {{ $item->title }}</div>
                                                <div class="xsmall text-muted mt-1">{{ $item->type }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- List View -->
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach ($results as $item)
                                        <div class="result-item">
                                            <cite>{{ request()->root() }} &rsaquo; {{ Str::slug($item->type) }}</cite>
                                            <a href="{{ $item->link }}" target="_blank" class="text-decoration-none">
                                                <h3>{{ $item->title }}</h3>
                                            </a>
                                            <div class="snippet mt-1">
                                                <span class="text-muted">{{ $item->created_at->format('d M Y') }}</span>
                                                —
                                                Arsip digital ini terdaftar dalam kategori <b>{{ $item->type }}</b>.
                                                Diunggah
                                                melalui sistem otomatis UIS. Klik judul untuk membuka dokumen asli.
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-3 ml-auto px-4">
                                    <div class="card border shadow-sm p-3">
                                        <h6 class="font-weight-bold mb-3">About UIS Archive</h6>
                                        <p class="small text-muted">Sistem Pencarian Semantik UIS terintegrasi dengan
                                            Google Drive API untuk memudahkan staf dan mahasiswa dalam menemukan dokumen
                                            akreditasi dan administrasi secara cepat.</p>
                                        <hr>
                                        <span class="badge badge-light p-2 mb-2 text-left w-100">Status: Online</span>
                                        <span class="badge badge-light p-2 text-left w-100">Security: TLS 1.3</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Scripts for Dropdown -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
