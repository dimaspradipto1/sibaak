<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="javascript:void(0)">
                <i class="ti-menu"></i>
            </a>
            <div class="mobile-search waves-effect waves-light">
                <div class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-prepend search-close"><i
                                    class="ti-close input-group-text"></i></span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-append search-btn"><i
                                    class="ti-search input-group-text"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logouis.png') }}" style="width: 30px; height: 30px;"
                    alt="UIS Logo" />
            </a>
            <span class="navbar-brand mb-0 text-white ml-2">MYBAAK UIS</span>
            <a class="mobile-options waves-effect waves-light">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="header-notification">
                    <a href="javascript:void(0)" class="waves-effect waves-light">
                        <i class="ti-bell"></i>
                        @if ($totalPending > 0)
                            <span class="badge bg-c-red">{{ $totalPending }}</span>
                        @endif
                    </a>
                    <ul class="show-notification">
                        <li>
                            <h6>Notifikasi</h6>
                            @if ($totalPending > 0)
                                <label class="label label-danger">New</label>
                            @endif
                        </li>

                        {{-- Notifikasi Surat Aktif --}}
                        @if ($pendingSuratAktifCount > 0)
                            <li class="waves-effect waves-light">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="notification-user">Surat Aktif</h5>
                                        <p class="notification-msg">Ada {{ $pendingSuratAktifCount }} pengajuan surat
                                            aktif pending.</p>
                                        @if (Auth::check() && (Auth::user()->is_admin || Auth::user()->is_superadmin || Auth::user()->is_staffbaak))
                                            <a href="{{ route('suratAktif.index') }}" class="text-primary small">Lihat
                                                Detail</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif

                        {{-- Notifikasi Surat Akademik --}}
                        @if ($pendingSuratAkademikCount > 0)
                            <li class="waves-effect waves-light">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="notification-user">Surat Akademik</h5>
                                        <p class="notification-msg">Ada {{ $pendingSuratAkademikCount }} pengajuan surat
                                            akademik pending.</p>
                                        @if (Auth::check() && (Auth::user()->is_admin || Auth::user()->is_superadmin || Auth::user()->is_staffbaak))
                                            <a href="{{ route('suratAkademik.index') }}"
                                                class="text-primary small">Lihat Detail</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif

                        {{-- Data Arsip Terbaru --}}
                        @if (Auth::check() && (Auth::user()->is_admin || Auth::user()->is_superadmin || Auth::user()->is_tata_usaha || Auth::user()->is_operator || Auth::user()->is_staffbaak))
                            <li class="waves-effect waves-light">
                                <h6 class="p-2 bg-light small font-weight-bold">Arsip Terbaru</h6>
                            </li>
                            @forelse($recentArsip as $arsip)
                                <li class="waves-effect waves-light">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="notification-user">
                                                {{ str_replace(['SkKepanitiaan', 'LpjKepanitiaan'], ['SK Kepanitiaan', 'LPJ Kepanitiaan'], $arsip->jenis_arsip) }}
                                            </h5>
                                            <p class="notification-msg">Data arsip baru ditambahkan pada
                                                {{ $arsip->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="waves-effect waves-light text-center p-2">
                                    <small class="text-muted">Tidak ada arsip terbaru</small>
                                </li>
                            @endforelse
                        @endif
                    </ul>
                </li>
                <li class="user-profile header-notification">
                    @auth
                    <a href="javascript:void(0)" class="waves-effect waves-light">
                        <img src="{{ Auth::user()->profile && Auth::user()->profile->foto ? asset('storage/' . Auth::user()->profile->foto) : asset('assets/images/user.png') }}"
                            class="img-radius" alt="User-Profile-Image"
                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li class="waves-effect waves-light">
                            <a href="{{ route('semantic.index') }}">
                                <i class="ti-settings"></i> Search Engine
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('settings.index') }}">
                                <i class="ti-settings"></i> Settings
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('profile.index') }}">
                                <i class="ti-user"></i> Profile
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('userGuide.index') }}">
                                <i class="fa-regular fa-file-lines"></i> User Guide
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="https://docs.google.com/spreadsheets/d/1BMulYA5yhLsgtMXJ4fMs55jG2d-CT86kSI43tGqMSQE/edit?usp=sharing" target="_blank">
                                <i class="ti-user"></i> Feedback
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('logout') }}">
                                <i class="ti-layout-sidebar-left"></i> Logout
                            </a>
                        </li>
                    </ul>
                    @else
                    <a href="{{ route('login') }}" class="waves-effect waves-light btn btn-primary btn-sm text-white px-3 mt-2" style="border-radius: 20px;">
                        <i class="fa-solid fa-right-to-bracket mr-1"></i> Login
                    </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
