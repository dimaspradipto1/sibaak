<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - {{ env('APP_NAME') }}</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords"
        content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/logouis.png') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet text-css">
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }
        .card {
            transition: all 0.3s ease;
        }
    </style>
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome-n.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    {{--  datatables CSS  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css">

    {{-- select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* UIS BRANDING Integration */
        :root {
            --uis-green: #00A551;
            --uis-yellow: #FFF742;
            --uis-green-dark: #008240;
        }

        .pcoded-header {
            background: linear-gradient(135deg, var(--uis-green) 0%, #008240 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }

        .pcoded-header .navbar-logo {
            background-color: transparent !important;
        }

        .main-menu-header {
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url("{{ asset('assets/images/gedunguis.JPG') }}") !important;
            background-size: cover !important;
            background-position: center !important;
            border-bottom: 3px solid var(--uis-yellow) !important;
        }

        .page-header {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url("{{ asset('assets/images/gedunguis.JPG') }}") !important;
            background-size: cover !important;
            background-position: center !important;
            border-bottom: 4px solid var(--uis-yellow) !important;
        }

        .pcoded-navbar .pcoded-item > li.active > a,
        .pcoded-navbar .pcoded-item > li.pcoded-trigger > a {
            background: var(--uis-green) !important;
            color: #ffffff !important;
            border-left: 4px solid var(--uis-yellow) !important;
        }

        .pcoded-navbar .pcoded-item > li.active > a .pcoded-micon,
        .pcoded-navbar .pcoded-item > li.pcoded-trigger > a .pcoded-micon {
            color: #ffffff !important;
        }

        .pcoded-navbar .pcoded-item li a:hover {
            color: var(--uis-green) !important;
        }

        .pcoded-navbar .pcoded-item li.active a:hover,
        .pcoded-navbar .pcoded-item li.pcoded-trigger a:hover {
            color: #ffffff !important;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--uis-green), var(--uis-green-dark)) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0, 165, 81, 0.3) !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 165, 81, 0.4) !important;
        }

        .pcoded-header,
        .main-menu-header,
        .page-header {
            border: none !important;
        }

        .main-menu-header {
            height: 150px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
        }

        .main-menu-header img {
            width: 60px !important;
            height: 60px !important;
            margin-bottom: 5px !important;
        }

        .user-details {
            margin-top: 0 !important;
        }

        .page-header {
            height: 140px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 40px !important;
            margin-bottom: 0 !important;
        }

        .page-header:before {
            display: none !important;
        }

        .page-header .page-block {
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
        }

        .page-header .page-block>.row {
            width: 100% !important;
            margin: 0 !important;
        }

        /* Gap and border fixes */
        .pcoded-navbar {
            border-right: none !important;
        }

        .pcoded-main-container {
            background: #f8f9fc !important;
        }

        /* Modern Table Styling */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
        }
        .table thead th {
            border: none !important;
            background-color: #f8f9fa !important;
            color: #333 !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 1px !important;
            padding: 15px !important;
        }
        .table tbody tr {
            background-color: #ffffff !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02) !important;
            transition: all 0.2s ease !important;
        }
        .table tbody tr:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
            transform: scale(1.002) !important;
        }
        .table tbody td {
            padding: 15px !important;
            vertical-align: middle !important;
            border: none !important;
        }
        .table tbody tr td:first-child { border-radius: 10px 0 0 10px !important; }
        .table tbody tr td:last-child { border-radius: 0 10px 10px 0 !important; }

        /* Card Customization */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
        }
        .card-header h5 {
            font-weight: 700 !important;
            color: #2c3e50 !important;
        }
    </style>
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            @include('layouts.dashboard.navbar')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    @include('layouts.dashboard.sidebar')

                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Dashboard</h5>
                                            <p class="m-b-0">Welcome to Sistem Informasi {{ env('APP_NAME') }} </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item"><a
                                                    href="#!">{{ $title ?? 'Dashboard' }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        @include('sweetalert::alert')
                                        @yield('content')
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- waves js -->
    <script src="{{ asset('assets/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- slimscroll js -->
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

    <!-- menu js -->
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/vertical/vertical-layout.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>

    {{-- fontawesome --}}
    <script src="https://kit.fontawesome.com/63b8672806.js" crossorigin="anonymous"></script>

    {{-- datatables --}}
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>


    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- ckeditor --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.2/ckeditor.js"></script>



    @stack('script')
    @stack('scripts')
    @stack('style')
</body>

</html>
