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
            transition: box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-bar-landing:hover,
        .search-bar-landing:focus-within {
            box-shadow: 0 1px 6px rgba(32, 33, 36, .28);
            border-color: rgba(223, 225, 229, 0);
        }

        /* Clean Input Styles */
        input {
            background-color: transparent !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #202124 !important;
            transition: background-color 5000s ease-in-out 0s;
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
            background: #fff;
            transition: box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-bar-results:focus-within {
            box-shadow: 0 1px 6px rgba(32, 33, 36, .28);
            border-color: rgba(223, 225, 229, 0);
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
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
            background: rgba(60, 64, 67, 0.08);
        }

        /* Gallery Grid Style (Google Images Layout) */
        .google-images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 4px;
        }

        .google-image-card {
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .google-image-card:hover {
            opacity: 0.92;
        }

        .google-image-thumb {
            display: block;
            width: 100%;
            height: 170px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            overflow: hidden;
        }

        .google-image-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        .google-image-info {
            padding: 6px 4px 10px;
        }

        .google-image-title {
            font-size: 12px;
            color: #202124;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .google-image-source {
            font-size: 11px;
            color: #70757a;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .xsmall {
            font-size: 11px;
        }

        /* Mobile Adjustments */
        /* Layout & Divider - Vertical Line Force */
        .results-right-sidebar {
            position: relative;
            padding-left: 45px !important;
        }

        .results-right-sidebar::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background-color: #dadce0;
            height: 100%;
        }

        /* Knowledge Panel Style Re-addition */
        .kp-clean-box {
            background: #fff;
            margin-bottom: 30px;
        }

        .kp-img-header {
            width: 100%;
            height: 200px;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .kp-img-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kp-title-text {
            font-size: 26px;
            color: #202124;
            letter-spacing: -0.5px;
            margin-bottom: 2px;
            line-height: 1.2;
        }

        .kp-type-text {
            font-size: 14px;
            color: #70757a;
            margin-bottom: 20px;
        }

        .kp-btn-group {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
            margin-bottom: 20px !important;
        }

        .google-pill-btn-final {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px 16px !important;
            border: 1px solid #dadce0 !important;
            border-radius: 100px !important;
            background: #fff !important;
            text-decoration: none !important;
            color: #1a73e8 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            min-height: 38px;
        }

        .google-pill-btn-final:hover {
            background: #f8f9fa !important;
            box-shadow: 0 1px 2px rgba(60, 64, 67, 0.3) !important;
        }

        .kp-divider {
            border-top: 1px solid #ebebeb;
            margin: 20px 0;
        }

        .kp-field {
            font-size: 13px;
            color: #202124;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        /* Tablet Adjustments (768px - 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) {
            .results-right-sidebar {
                padding-left: 20px !important;
            }

            .kp-title-text {
                font-size: 22px;
            }

            .google-pill-btn-final {
                padding: 6px 12px !important;
                font-size: 12px !important;
                min-height: 34px;
            }
        }

        /* Mobile Adjustments */
        @media (max-width: 767px) {
            .google-logo {
                font-size: 45px;
                letter-spacing: -2px;
                margin-bottom: 20px;
            }

        }
    </style>
</head>

<body>

    @if (!$query)
        <div class="top-right-nav d-flex align-items-center d-none d-lg-flex">
            <!-- Google Apps & Profile Links (Visible only on Desktop) -->
            <a href="https://mail.google.com" target="_blank"
                class="mr-3 text-muted small text-decoration-none hover-underline">Gmail</a>
            <a href="{{ route('semantic.index', ['tab' => 'gambar']) }}"
                class="mr-3 text-muted small text-decoration-none hover-underline">Gambar</a>

            <div class="google-apps-icon mr-2" title="Google Apps">
                <i class="fa-solid fa-grip" style="font-size: 20px;"></i>
            </div>

            @auth
                <div class="dropdown">
                    <div class="user-avatar" id="userMenu" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-3 text-center"
                        style="width: 280px; border-radius: 12px;">
                        <div class="user-avatar mx-auto mb-2" style="width: 60px; height: 60px; font-size: 24px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h6 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h6>
                        <p class="small text-muted mb-3">{{ Auth::user()->email }}</p>
                        <hr>
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-outline-secondary btn-block btn-sm mb-2 rounded-pill">Kelola Akun Dashbord</a>
                        <a href="{{ route('logout') }}"
                            class="btn btn-light btn-block btn-sm border rounded-pill">Keluar</a>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-google-login">Sign in</a>
            @endauth
        </div>

        <div class="landing-container">
            <div class="google-logo text-center position-relative">
                <span style="color: #4285F4;">A</span><span style="color: #EA4335;">r</span><span
                    style="color: #FBBC05;">s</span><span style="color: #34A853;">i</span><span
                    style="color: #EA4335;">p</span>
                <span style="color: #4285F4;">U</span><span style="color: #34A853;">I</span><span
                    style="color: #FBBC05;">S</span>
                @if ($tab == 'gambar')
                    <div
                        style="color: #4285F4; font-size: 16px; font-weight: 500; margin-top: -20px; text-transform: capitalize;">
                        gambar</div>
                @endif
            </div>

            <div class="search-wrapper px-3">
                <form action="{{ route('semantic.index') }}" method="GET">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="search-bar-landing">
                        <i class="fa-solid fa-magnifying-glass text-muted mr-3"></i>
                        <input type="text" name="q" class="form-control border-0 no-focus py-4"
                            placeholder="{{ $tab == 'gambar' ? 'Cari gambar arsip...' : 'Telusuri Arsip UIS atau ketik URL' }}"
                            autofocus autocomplete="off">
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
        <div class="results-header pt-2 pb-0 px-3 px-md-4">
            {{-- Tablet/Mobile Two-Row Header Layout --}}
            <div class="d-flex d-lg-none flex-column align-items-center w-100">
                {{-- Row 1: Utilities + Logo + Account --}}
                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                    <div class="col-auto px-0">
                        {{-- Mobile Icon (Flask/Lab icon style) --}}
                        <div class="d-md-none" style="color: #70757a; font-size: 20px;">
                            <i class="fa-solid fa-flask"></i>
                        </div>
                    </div>

                    <div class="col text-center">
                        <a href="{{ route('semantic.index') }}" class="results-logo" style="font-size: 22px;">
                            <span style="color: #4285F4;">A</span><span style="color: #EA4335;">r</span><span
                                style="color: #FBBC05;">s</span><span style="color: #4285F4;">i</span><span
                                style="color: #34A853;">p</span>
                            <span style="color: #4285F4;">U</span><span style="color: #34A853;">I</span><span
                                style="color: #FBBC05;">S</span>
                        </a>
                    </div>

                    <div class="col-auto px-0">
                        @auth
                            <div class="dropdown">
                                <div class="user-avatar" id="userMenuMobile" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="width: 32px; height: 32px; font-size: 14px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{-- Dropdown menu same as before --}}
                                <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-3 text-center"
                                    style="width: 280px; border-radius: 12px;">
                                    <div class="user-avatar mx-auto mb-2"
                                        style="width: 60px; height: 60px; font-size: 24px;">
                                        {{ substr(Auth::user()->name, 0, 1) }}</div>
                                    <h6 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h6>
                                    <p class="small text-muted mb-3">{{ Auth::user()->email }}</p>
                                    <hr>
                                    <a href="{{ route('dashboard') }}"
                                        class="btn btn-outline-secondary btn-block btn-sm mb-2 rounded-pill">Kelola Akun
                                        Dashbord</a>
                                    <a href="{{ route('logout') }}"
                                        class="btn btn-light btn-block btn-sm border rounded-pill">Keluar</a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn-google-login px-3 py-1"
                                style="font-size: 12px;">Sign in</a>
                        @endauth
                    </div>
                </div>

                {{-- Row 2: Full Width Search Bar --}}
                <div class="w-100 mb-2">
                    <div class="search-bar-results" style="max-width: 100%;">
                        <input type="text" name="q" class="form-control border-0 no-focus py-2"
                            value="{{ $query }}" form="searchForm" style="font-size: 14px;"
                            onkeydown="if(event.key === 'Enter') document.getElementById('searchForm').submit();">
                        <i class="fa-solid fa-magnifying-glass text-primary ml-auto cursor-pointer"
                            onclick="document.getElementById('searchForm').submit();"></i>
                    </div>
                </div>
            </div>

            {{-- Desktop Layout (Full Featured) --}}
            <div class="d-none d-lg-flex align-items-center w-100 py-2">
                <a href="{{ route('semantic.index') }}" class="results-logo mr-5">
                    <span style="color: #4285F4;">A</span><span style="color: #EA4335;">r</span><span
                        style="color: #FBBC05;">s</span><span style="color: #4285F4;">i</span><span
                        style="color: #34A853;">p</span>
                    <span style="color: #4285F4;">U</span><span style="color: #34A853;">I</span><span
                        style="color: #FBBC05;">S</span>
                </a>
                <div class="search-bar-results flex-grow-1" style="max-width: 692px;">
                    <input type="text" name="q" class="form-control border-0 no-focus py-2"
                        value="{{ $query }}" form="searchForm"
                        onkeydown="if(event.key === 'Enter') document.getElementById('searchForm').submit();">
                    <i class="fa-solid fa-magnifying-glass text-primary ml-auto cursor-pointer"
                        onclick="document.getElementById('searchForm').submit();"></i>
                </div>

                {{-- Desktop Right Nav: Gmail, Gambar, Grid, Account --}}
                <div class="d-flex align-items-center ml-auto">
                    <a href="https://mail.google.com" target="_blank"
                        class="mr-3 text-muted small text-decoration-none hover-underline">Gmail</a>
                    <a href="{{ route('semantic.index', ['tab' => 'gambar']) }}"
                        class="mr-3 text-muted small text-decoration-none hover-underline">Gambar</a>

                    <div class="google-apps-icon mr-3" title="Google Apps">
                        <i class="fa-solid fa-grip" style="font-size: 20px;"></i>
                    </div>

                    @auth
                        <div class="dropdown">
                            <div class="user-avatar" id="userMenuDesktop" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-3 text-center"
                                style="width: 280px; border-radius: 12px;">
                                <div class="user-avatar mx-auto mb-2" style="width: 60px; height: 60px; font-size: 24px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <h6 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h6>
                                <p class="small text-muted mb-3">{{ Auth::user()->email }}</p>
                                <hr>
                                <a href="{{ route('dashboard') }}"
                                    class="btn btn-outline-secondary btn-block btn-sm mb-2 rounded-pill">Kelola Akun
                                    Dashbord</a>
                                <a href="{{ route('logout') }}"
                                    class="btn btn-light btn-block btn-sm border rounded-pill">Keluar</a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-google-login">Sign in</a>
                    @endauth
                </div>

                <form id="searchForm" action="{{ route('semantic.index') }}" method="GET" class="d-none">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                </form>
            </div>
            <div class="d-flex overflow-auto mt-2">
                <div class="ml-0 ml-md-5 pl-0 pl-md-5 d-flex">
                    <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'semua']) }}"
                        class="nav-link-google {{ $tab == 'semua' ? 'active' : '' }}"><i
                            class="fa-solid fa-magnifying-glass mr-2"></i>Semua</a>
                    <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'gambar']) }}"
                        class="nav-link-google {{ $tab == 'gambar' ? 'active' : '' }}"><i
                            class="fa-solid fa-image mr-2"></i>Gambar</a>
                    <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'video']) }}"
                        class="nav-link-google {{ $tab == 'video' ? 'active' : '' }}"><i
                            class="fa-solid fa-play mr-2"></i>Video</a>
                    <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'berita']) }}"
                        class="nav-link-google {{ $tab == 'berita' ? 'active' : '' }}"><i
                            class="fa-solid fa-newspaper mr-2"></i>Berita</a>
                    <a href="{{ route('semantic.index', ['q' => $query, 'tab' => 'terbaru']) }}"
                        class="nav-link-google {{ $tab == 'terbaru' ? 'active' : '' }}"><i
                            class="fa-solid fa-calendar mr-2"></i>Terbaru</a>
                </div>
            </div>
        </div>

        <div class="container-fluid py-4 pl-3 pr-5">
            <div class="row ml-md-5 pl-md-5">
                <div class="{{ $tab == 'gambar' ? 'col-12' : 'col-md-7' }}">
                    <p class="text-muted small mb-4">Ditemukan {{ $results->count() }} hasil
                        ({{ round(microtime(true) - LARAVEL_START, 2) }} detik)</p>

                    @if ($results->isEmpty())
                        <div class="py-4">
                            <p>Penelusuran Anda - <b>{{ $query }}</b> - tidak cocok dengan dokumen apa pun.</p>
                        </div>
                    @else
                        @if ($tab == 'gambar')
                            <div class="google-images-grid">
                                @foreach ($results as $item)
                                    <div class="google-image-card">
                                        <a href="{{ $item->link }}" target="_blank" class="google-image-thumb">
                                            @if ($item->thumbnail)
                                                <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}"
                                                    onerror="this.parentElement.innerHTML='<i class=\'fa-solid {{ $item->icon }} {{ $item->color }}\' style=\'font-size: 60px;\'></i>'">
                                            @else
                                                <i class="fa-solid {{ $item->icon }} {{ $item->color }}"
                                                    style="font-size: 60px;"></i>
                                            @endif
                                        </a>
                                        <div class="google-image-info">
                                            <div class="google-image-title" title="{{ $item->title }}">{{ $item->title }}</div>
                                            <div class="google-image-source">{{ $item->type }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- List View -->
                            @foreach ($results as $item)
                                <div class="search-result-item mb-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="mr-2"
                                            style="width: 28px; height: 28px; background: #f1f3f4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            @if (isset($item->is_youtube) && $item->is_youtube)
                                                <i class="fa-brands fa-youtube text-danger"
                                                    style="font-size: 14px;"></i>
                                            @elseif(isset($item->is_facebook) && $item->is_facebook)
                                                <i class="fa-brands fa-facebook text-primary"
                                                    style="font-size: 16px;"></i>
                                            @else
                                                <i class="fa-solid {{ $item->icon }} {{ $item->color }}"
                                                    style="font-size: 14px;"></i>
                                            @endif
                                        </div>
                                        <cite class="text-truncate"
                                            style="max-width: 80%; font-size: 14px; color: #202124;">
                                            @if (isset($item->is_youtube) && $item->is_youtube)
                                                YouTube · {{ $item->title }}
                                            @elseif(isset($item->is_facebook) && $item->is_facebook)
                                                Facebook · Universitas Ibnu Sina <br>
                                                <span class="text-muted small">2,2 rb+ pengikut</span>
                                            @else
                                                {{ request()->root() . ' › ' . Str::slug($item->type) }}
                                            @endif
                                        </cite>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-grow-1">
                                            @if (isset($item->is_youtube) && $item->is_youtube && $item->thumbnail)
                                                <div class="mr-3 position-relative"
                                                    style="min-width: 150px; max-width: 150px;">
                                                    <a href="{{ $item->link }}" target="_blank"
                                                        class="text-decoration-none">
                                                        <img src="{{ $item->thumbnail }}" class="img-fluid rounded"
                                                            style="width: 150px; height: 84px; object-fit: cover; border: 1px solid #dfe1e5;">
                                                        <div
                                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 30px; height: 30px; background: rgba(0,0,0,0.6); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-play text-white"
                                                                style="font-size: 12px; margin-left: 2px;"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ $item->link }}" target="_blank"
                                                    class="text-decoration-none">
                                                    <h3 class="mb-1" style="font-size: 20px; color: #1a0dab;">
                                                        {{ $item->title }}</h3>
                                                </a>
                                                <div class="snippet"
                                                    style="font-size: 14px; color: #4d5156; line-height: 1.58;">
                                                    <span
                                                        class="text-muted">{{ $item->created_at->format('d M Y') }}</span>
                                                    —
                                                    {!! $item->description ?? 'Informasi terdaftar dalam kategori ' . ($item->kategori ?? $item->type) . '.' !!}
                                                </div>
                                                <div class="xsmall text-muted mt-1">
                                                    {{ $item->kategori ?? $item->type }}</div>
                                            </div>
                                        </div>

                                        @if (isset($item->is_facebook) && $item->is_facebook && $item->thumbnail)
                                            <div class="ml-3" style="min-width: 100px; max-width: 100px;">
                                                <a href="{{ $item->link }}" target="_blank"
                                                    class="text-decoration-none">
                                                    <img src="{{ $item->thumbnail }}" class="img-fluid rounded"
                                                        style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #dfe1e5;">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            {{-- Hasil Lainnya Button --}}
                            {{-- Box Pagination (Centered within content column) --}}
                            <div class="footer-pagination-area" style="padding: 40px 0; margin-top: 400px;">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="google-pagination text-center">
                                        <div class="pagination-wrapper d-inline-block">
                                            <div class="google-logo-pagination d-flex align-items-end justify-content-center mb-1"
                                                style="font-family: 'Outfit', Arial, sans-serif; font-size: 32px; font-weight: 500; letter-spacing: -1px;">
                                                <span style="color: #4285f4;">A</span>
                                                <span style="color: #ea4335;">r</span>
                                                <span style="color: #fbbc05;">s</span>
                                                @php
                                                    $total_pages = $results->lastPage();
                                                    $current_page = $results->currentPage();
                                                    $start = max(1, $current_page - 5);
                                                    $end = min($total_pages, $start + 9);
                                                    if ($end - $start < 9) {
                                                        $start = max(1, $end - 9);
                                                    }
                                                    $start = max(1, $start);
                                                @endphp

                                                @for ($i = $start; $i <= $end; $i++)
                                                    @if ($i == $start && $total_pages == 1)
                                                        <span style="color: #4285f4;">i</span>
                                                    @else
                                                        <span
                                                            style="color: {{ $i % 2 == 0 ? '#34a853' : '#4285f4' }};">i</span>
                                                    @endif
                                                @endfor

                                                <span style="color: #ea4335;">p</span>
                                                <span style="margin-left: 8px; color: #4285f4;">U</span>
                                                <span style="color: #ea4335;">I</span>
                                                <span style="color: #fbbc05;">S</span>

                                                @if ($results->hasMorePages())
                                                    <a href="{{ $results->nextPageUrl() }}" class="ml-2"
                                                        style="color: #4285f4; font-size: 24px; text-decoration: none;">
                                                        <i class="fas fa-chevron-right" style="font-size: 18px;"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="pagination-numbers d-flex justify-content-center"
                                                style="font-size: 13px;">
                                                @if (!$results->onFirstPage())
                                                    <a href="{{ $results->previousPageUrl() }}" class="mr-4"
                                                        style="color: #4285f4; text-decoration: none;">Sebelumnya</a>
                                                @endif

                                                @for ($i = $start; $i <= $end; $i++)
                                                    <div class="page-num-item" style="width: 20px;">
                                                        @if ($i == $current_page)
                                                            <div style="color: #202124;">{{ $i }}</div>
                                                        @else
                                                            <a href="{{ $results->url($i) }}"
                                                                style="color: #4285f4; text-decoration: none;">{{ $i }}</a>
                                                        @endif
                                                    </div>
                                                @endfor

                                                @if ($results->hasMorePages())
                                                    <a href="{{ $results->nextPageUrl() }}" class="ml-4"
                                                        style="color: #4285f4; text-decoration: none;">Berikutnya</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="col-md-4 results-right-sidebar d-none d-md-block {{ $tab == 'gambar' ? 'd-none' : '' }}" style="{{ $tab == 'gambar' ? 'display:none!important;' : '' }}">
                    @if ($top_result)
                        <div class="kp-clean-box">
                            @if ($top_result->thumbnail)
                                <div class="kp-img-header">
                                    <img src="{{ $top_result->thumbnail }}" alt="{{ $top_result->title }}">
                                </div>
                            @endif

                            <div style="margin-bottom: 2px; padding: 0 4px;">
                                <div class="kp-title-text"
                                    style="font-size: 26px; font-weight: 400; font-family: 'Google Sans', Roboto, sans-serif; margin-bottom: 2px;">
                                    {{ $top_result->title }}</div>
                                <div style="display: flex; align-items: center; font-size: 14px; margin-bottom: 4px;">
                                    <span style="color: #4d5156; margin-right: 4px;">4,3</span>
                                    <span style="color: #fbbc04; margin-right: 4px;">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star-half-alt"></i>
                                    </span>
                                    <a href="#" style="color: #1a73e8; text-decoration: none;">15 ulasan
                                        Google</a>
                                </div>
                                <div class="kp-type-text" style="color: #202124;">Universitas di Batam, Kepulauan Riau
                                </div>
                            </div>

                            {{-- Button Group Row 1 --}}
                            <div class="kp-btn-group"
                                style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 18px; margin-bottom: 8px;">
                                @if ($top_result->external_link)
                                    <a href="{{ $top_result->external_link }}" target="_blank"
                                        style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border: 1px solid #dfe1e5; border-radius: 36px; background: #fff; color: #1a73e8; text-decoration: none; font-size: 14px; font-weight: 500; min-height: 38px;">
                                        <i class="fa-solid fa-earth-asia" style="margin-right: 8px;"></i> Situs
                                    </a>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination=Universitas+Ibnu+Sina+Batam"
                                        target="_blank"
                                        style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border: 1px solid #dfe1e5; border-radius: 36px; background: #fff; color: #1a73e8; text-decoration: none; font-size: 14px; font-weight: 500; min-height: 38px;">
                                        <i class="fa-solid fa-route" style="margin-right: 8px;"></i> Rute
                                    </a>
                                @endif
                                <a href="https://www.google.com/search?q=Universitas+Ibnu+Sina+reviews"
                                    target="_blank"
                                    style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border: 1px solid #dfe1e5; border-radius: 36px; background: #fff; color: #1a73e8; text-decoration: none; font-size: 14px; font-weight: 500; min-height: 38px;">
                                    <i class="fa-solid fa-star-half-stroke" style="margin-right: 8px;"></i> Ulasan
                                </a>
                                <a href="javascript:void(0)"
                                    style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border: 1px solid #dfe1e5; border-radius: 36px; background: #fff; color: #1a73e8; text-decoration: none; font-size: 14px; font-weight: 500; min-height: 38px;">
                                    <i class="fa-solid fa-bookmark" style="margin-right: 8px;"></i> Simpan
                                </a>
                            </div>

                            {{-- Button Group Row 2 --}}
                            <div class="kp-btn-group"
                                style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 25px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                    target="_blank"
                                    style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border: 1px solid #dfe1e5; border-radius: 36px; background: #fff; color: #1a73e8; text-decoration: none; font-size: 14px; font-weight: 500; min-height: 38px;">
                                    <i class="fa-solid fa-share-nodes" style="margin-right: 8px;"></i> Bagikan
                                </a>
                                <a href="tel:082170078887"
                                    style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border: 1px solid #dfe1e5; border-radius: 36px; background: #fff; color: #1a73e8; text-decoration: none; font-size: 14px; font-weight: 500; min-height: 38px;">
                                    <i class="fa-solid fa-phone" style="margin-right: 8px;"></i> Telepon
                                </a>
                            </div>

                            <div class="kp-desc-text"
                                style="padding-top: 15px; border-top: 1px solid #ebebeb; font-size: 14px; line-height: 1.58; color: #202124; margin-bottom: 20px;">
                                {!! $top_result->description !!} <a href="https://id.wikipedia.org/wiki/Universitas_Ibnu_Sina"
                                    target="_blank" style="color: #1a73e8; text-decoration: none;">Wikipedia</a>
                            </div>

                            <div class="kp-field" style="margin-bottom: 12px; font-size: 14px; line-height: 1.4;">
                                <b>Alamat:</b> <a href="https://www.google.com/maps/search/Universitas+Ibnu+Sina+Batam"
                                    target="_blank" style="color: #1a73e8; text-decoration: none;">Lubuk Baja Kota,
                                    Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444</a>
                            </div>
                            <div class="kp-field" style="margin-bottom: 12px; font-size: 14px; line-height: 1.4;">
                                <b>Didirikan:</b> 26 Agustus 2019
                            </div>
                            <div class="kp-field" style="margin-bottom: 12px; font-size: 14px; line-height: 1.4;">
                                <b>Provinsi:</b> <a href="https://www.google.com/search?q=Kepulauan+Riau"
                                    target="_blank" style="color: #1a73e8; text-decoration: none;">Kepulauan Riau</a>
                            </div>
                            <div class="kp-field" style="margin-bottom: 12px; font-size: 14px; line-height: 1.4;">
                                <b>Telepon:</b> <a href="tel:082170078887"
                                    style="color: #1a73e8; text-decoration: none;">0821-7007-8887</a>
                            </div>
                            <div class="kp-field" style="margin-bottom: 12px; font-size: 14px; line-height: 1.4;">
                                <b>Produk dan Layanan:</b> <a href="https://uis.ac.id" target="_blank"
                                    style="color: #1a73e8; text-decoration: none;">uis.ac.id</a>
                            </div>
                            <div class="kp-field" style="margin-bottom: 12px; font-size: 14px; line-height: 1.4;">
                                <b>Jam:</b> <span style="color: #d93025; font-weight: 500;">Tutup</span> · Buka Sen
                                pukul 00.00 <i class="fas fa-chevron-down"
                                    style="font-size: 10px; margin-left: 2px;"></i>
                            </div>

                            <div style="margin-top: 25px; padding-top: 10px; font-size: 13px;">
                                <a href="https://www.google.com/search?q=Universitas+Ibnu+Sina+Batam&num=10&sca_esv=595262744&hl=id&gl=ID&authuser=0&tbm=lcl&ei=6V2WZdW-E4W2seMP8L-FmAQ&start=0&sa=N&sstk=A6O-u67t_T-k1m99o8z2p9r6p0Z1y-0v-X8&ved=2ahUKEwiVu6D777-DAxUFW2wGHfBfAUM4ChDy0wN6BAgBEAQ"
                                    style="color: #70757a; text-decoration: none; margin-right: 18px;">Sarankan
                                    edit</a>
                                <a href="#" style="color: #70757a; text-decoration: none;">Pemilik bisnis
                                    ini?</a>
                            </div>
                        </div>
                    @else
                        <div class="card border shadow-sm p-3">
                            <h6 class="font-weight-bold mb-3">About Mybaak UIS</h6>
                            <p class="small text-muted">Sistem Pencarian Semantik Mybaak UIS terintegrasi dengan
                                Google Drive API untuk memudahkan staf dan mahasiswa dalam menemukan dokumen
                                akreditasi dan administrasi secara cepat.</p>
                            <hr>
                            <span class="badge badge-light p-2 mb-2 text-left w-100">Status: Online</span>
                            <span class="badge badge-light p-2 text-left w-100">Security: TLS 1.3</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Final Global Footer --}}
        <div class="global-footer"
            style="background: #f2f2f2; border-top: 1px solid #dadce0; color: #70757a; font-size: 14px; font-family: arial, sans-serif;">
            <div class="container-fluid" style="padding-left: 5%; padding-right: 5%;">
                <div class="py-3" style="border-bottom: 1px solid #dadce0; font-size: 13px;">
                    Hasil dipersonalisasi - <a href="#" style="color: #1a0dab; text-decoration: none;">Coba
                        tanpa personalisasi</a>
                </div>
                <div class="py-3 d-flex align-items-center flex-wrap" style="font-size: 14px;">
                    <span class="mr-3 border-right pr-3">Indonesia</span>
                    <span class="d-flex align-items-center">
                        <i class="fas fa-circle mr-2" style="font-size: 8px; color: #70757a;"></i>
                        <b>Kec. Batu Aji, Kota Batam, Kepulauan Riau</b>
                        <span class="mx-2">-</span>
                        <span>Berdasarkan aktivitas Anda sebelumnya</span>
                        <span class="mx-2">-</span>
                        <a href="#" style="color: #1a0dab; text-decoration: none;">Perbarui lokasi</a>
                    </span>
                </div>
                <div class="py-2 d-flex flex-wrap" style="gap: 25px; font-size: 14px; padding-bottom: 25px;">
                    <a href="#" style="color: #70757a; text-decoration: none;">Bantuan</a>
                    <a href="#" style="color: #70757a; text-decoration: none;">Kirim masukan</a>
                    <a href="#" style="color: #70757a; text-decoration: none;">Privasi</a>
                    <a href="#" style="color: #70757a; text-decoration: none;">Persyaratan</a>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Knowledge Panel & Divider Adjustments */
        .results-right-sidebar {
            border-left: 2px solid #ebebeb;
            margin-left: -1px;
            padding-left: 45px;
        }

        @media (max-width: 768px) {
            .results-right-sidebar {
                border-left: none;
                padding-left: 15px;
            }

            .knowledge-panel {
                order: -1;
                margin: 0 15px 30px 15px;
            }

            .results-header {
                padding: 15px;
            }
        }
    </style>

    <!-- Scripts for Dropdown -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
