<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="{{ asset('assets/images/user.png') }}" alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details">{{ Auth::user()->name }}<i class="fa fa-caret-down"></i></span>
                </div>
            </div>
            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                        <a href="#!"><i class="ti-settings"></i>Settings</a>
                        <a href="{{ route('logout') }}"><i class="ti-layout-sidebar-left"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- <div class="p-15 p-b-0">
            <form class="form-material">
                <div class="form-group form-primary">
                    <input type="text" name="footer-email" class="form-control">
                    <span class="form-bar"></span>
                    <label class="float-label"><i class="fa fa-search m-r-10"></i>Search
                        Friend</label>
                </div>
            </form>
        </div> --}}
        {{-- <div class="pcoded-navigation-label">Navigation</div> --}}
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="{{ route('dashboard') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext">Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>


        @if (Auth::user()->is_admin || Auth::user()->is_mahasiswa || Auth::user()->is_staffbaak)
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa-solid fa-users"></i></span>
                        <span class="pcoded-mtext text-capitalize">layanan mahasiswa</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class=" ">
                            <a href="{{ route('suratAktif.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">surat keterangan aktif</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('suratAkademik.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">surat layanan akademik</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif

        @if (Auth::user()->is_admin || Auth::user()->is_tata_usaha || Auth::user()->is_operator || Auth::user()->is_staffbaak)
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa-solid fa-folder-open"></i></span>
                        <span class="pcoded-mtext text-capitalize">arsip</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class=" ">
                            <a href="{{ route('skkepanitiaan.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">SK Kepanitiaan</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('lpjkepanitiaan.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">LPJ kepanitiaan</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class=" ">
                            <a href="{{ route('kurikulum.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">kurikulum prodi</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('pedoman.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">pedoman</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('sopakademik.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">SOP akademik</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('wasdalbin.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext text-capitalize">wasdalbin</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        @endif

        @if (Auth::user()->is_admin)
            <div class="pcoded-navigation-label">Master</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu ">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa-solid fa-folder-open"></i><b>A</b></span>
                        <span class="pcoded-mtext">Master Data</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="">
                            <a href="{{ route('users.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-users-gear"></i></span>
                                <span class="pcoded-mtext text-capitalize">pengguna</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('pegawai.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-user-gear"></i></span>
                                <span class="pcoded-mtext text-capitalize">Staff</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('dosen.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-user-gear"></i></span>
                                <span class="pcoded-mtext text-capitalize">dosen</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('mahasiswa.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-users-gear"></i></span>
                                <span class="pcoded-mtext text-capitalize">mahasiswa</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('jenissk.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-users-gear"></i></span>
                                <span class="pcoded-mtext text-capitalize">jenis SK</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('tahunAkademik.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-calendar-days"></i></span>
                                <span class="pcoded-mtext">tahun akademik</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('programStudi.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="fa-solid fa-folder-closed"></i></span>
                                <span class="pcoded-mtext text-capitalize">program studi</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif

        {{-- @if (Auth::user()->is_admin)
        <div class="pcoded-navigation-label">Forms</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ route('tahunAkademik.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa-solid fa-calendar-days"></i></span>
                    <span class="pcoded-mtext">tahun akademik</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigation-label">Tables</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ route('users.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa-solid fa-users-gear"></i></span>
                    <span class="pcoded-mtext text-capitalize">pengguna</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ route('programStudi.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa-solid fa-folder-closed"></i></span>
                    <span class="pcoded-mtext text-capitalize">program studi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ route('mahasiswa.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa-solid fa-users-gear"></i></span>
                    <span class="pcoded-mtext text-capitalize">mahasiswa</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ route('pegawai.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa-solid fa-user-gear"></i></span>
                    <span class="pcoded-mtext text-capitalize">pegawai</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        @endif --}}
        {{-- <div class="pcoded-navigation-label">Chart And Maps</div> --}}
        {{-- <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="chart-morris.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-bar-chart-alt"></i><b>C</b></span>
                    <span class="pcoded-mtext">Charts</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="map-google.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-map-alt"></i><b>M</b></span>
                    <span class="pcoded-mtext">Maps</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul> --}}
        {{-- <div class="pcoded-navigation-label">Pages</div> --}}
        {{-- <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu ">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-id-badge"></i><b>A</b></span>
                    <span class="pcoded-mtext">Pages</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="auth-normal-sign-in.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Login</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="auth-sign-up.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Registration</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="sample-page.html" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-sidebar-left"></i><b>S</b></span>
                            <span class="pcoded-mtext">Sample Page</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul> --}}
    </div>
</nav>
