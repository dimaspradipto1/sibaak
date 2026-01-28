@extends('layouts.dashboard.template')

@section('title', 'Dashboard')

@section('content')

    @if (Auth::user()->is_admin || Auth::user()->is_staffbaak)
        <div class="row">
            <!-- Material statustic card start -->
            <div class="col-xl-4 col-md-12">
                <div class="card mat-stat-card">
                    <div class="card-block">
                        <div class="row align-items-center b-b-default">
                            <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                <div class="row align-items-center text-center">
                                    <div class="col-4 p-r-0">
                                        <i class="fa-solid fa-user-group text-c-purple f-24"></i>
                                    </div>
                                    <div class="col-8 p-l-0">
                                        <h5>{{ $user }}</h5>
                                        <p class="text-muted m-b-0">PENGGUNA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 p-b-20 p-t-20">
                                <div class="row align-items-center text-center">
                                    <div class="col-4 p-r-0">
                                        <i class="fas fa-user-graduate text-c-green f-24"></i>
                                    </div>
                                    <div class="col-8 p-l-0">
                                        <h5>{{ $mahasiswa }}</h5>
                                        <p class="text-muted m-b-0">MAHASISWA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                <div class="row align-items-center text-center">
                                    <div class="col-4 p-r-0">
                                        <i class="fa-solid fa-users text-c-blue f-24"></i>
                                    </div>
                                    <div class="col-8 p-l-0">
                                        <h5>{{ $pegawai }}</h5>
                                        <p class="text-muted m-b-0">STAFF</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 p-b-20 p-t-20">
                                <div class="row align-items-center text-center">
                                    <div class="col-4 p-r-0">
                                        <i class="fa-solid fa-user-group text-c-purple f-24"></i>
                                    </div>
                                    <div class="col-8 p-l-0">
                                        <h5>{{$dosen}}</h5>
                                        <p class="text-muted m-b-0">Dosen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card mat-stat-card">
                    <div class="card-block">
                        <div class="row align-items-center b-b-default">
                            <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                <div class="row align-items-center text-center">
                                    <div class="col-3 p-r-0">
                                        <i class="fa-solid fa-envelope-circle-check text-c-green f-24"></i>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <h5>{{ $suratAktifDiterima }}</h5>
                                        <p class="text-muted m-b-0">Surat Aktif Diterima</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 p-b-20 p-t-20">
                                <div class="row align-items-center text-center">
                                    <div class="col-3 p-r-0">
                                        <i class="fa-solid fa-envelope text-c-red f-24"></i>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <h5>{{ $suratAktifDitolak }}</h5>
                                        <p class="text-muted m-b-0">Surat Aktif Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                <div class="row align-items-center text-center">
                                    <div class="col-3 p-r-0">
                                        <i class="fa-solid fa-envelope text-c-yellow f-24"></i>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <h5>{{ $suratAktifpending }}</h5>
                                        <p class="text-muted m-b-0">Surat Aktif pending</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 p-b-20 p-t-20">
                                <div class="row align-items-center text-center">
                                    <div class="col-3 p-r-0">
                                        <i class="fa-solid fa-envelope text-c-secondary f-24"></i>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <h5>{{ $suratAkademik }}</h5>
                                        <p class="text-muted m-b-0">Surat Akademik</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card mat-clr-stat-card text-white green ">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-3 text-center bg-c-green">
                                <i class="fas fa-file mat-icon f-24"></i>
                            </div>
                            <a href="{{ route('suratAktif.create') }}">
                                <div class="col-9 cst-cont text-white">
                                    <span> Pengajuan Surat Aktif</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mat-clr-stat-card text-white blue">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-3 text-center bg-c-blue">
                                <i class="fas fa-file mat-icon f-24"></i>
                            </div>
                            <a href="{{ route('suratAkademik.create') }}">
                                <div class="col-9 cst-cont text-white">
                                    <span>Pengajuan Surat Akademik</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Material statustic card end -->

            <!--  Statistik Pengajuan Surat -->
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Statistik Pengajuan Surat</h5>
                        <span>Grafik pengajuan surat aktif dan surat akademik - Multi Tahun ({{ date('Y') }} -
                            {{ date('Y') + 4 }})</span>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa fa fa-wrench open-card-option"></i>
                                </li>
                                <li><i class="fa fa-window-maximize full-card"></i>
                                </li>
                                <li><i class="fa fa-minus minimize-card"></i></li>
                                <li><i class="fa fa-refresh reload-card"></i></li>
                                <li><i class="fa fa-trash close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div id="morris-bar-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            @push('scripts')
                <!-- Morris Chart -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

                <script>
                    $(document).ready(function() {
                        Morris.Bar({
                            element: 'morris-bar-chart',
                            data: [
                                @foreach ($chartData as $data)
                                    {
                                        y: '{{ $data['year'] }}',
                                        pending: {{ $data['pending'] }},
                                        diterima: {{ $data['diterima'] }},
                                        ditolak: {{ $data['ditolak'] }},
                                        akademik: {{ $data['akademik'] }}
                                    },
                                @endforeach
                            ],
                            xkey: 'y',
                            ykeys: ['pending', 'diterima', 'ditolak', 'akademik'],
                            labels: ['pending', 'Diterima', 'Ditolak', 'Akademik'],
                            barColors: ['#FFC107', '#28A745', '#DC3545', '#007BFF'],
                            hideHover: 'auto',
                            gridLineColor: '#eef0f2',
                            resize: true,
                            barSizeRatio: 0.5,
                            gridTextSize: 14,
                            xLabelAngle: 0
                        });
                    });
                </script>
            @endpush
            {{-- <div class="col-xl-6 col-md-12">
        <div class="row">
            <!-- sale card start -->

            <div class="col-md-6">
                <div class="card text-center order-visitor-card">
                    <div class="card-block">
                        <h6 class="m-b-0">Total Subscription</h6>
                        <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>7652
                        </h4>
                        <p class="m-b-0">48% From Last 24 Hours</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center order-visitor-card">
                    <div class="card-block">
                        <h6 class="m-b-0">Order Status</h6>
                        <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>6325
                        </h4>
                        <p class="m-b-0">36% From Last 6 Months</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-c-red total-card">
                    <div class="card-block">
                        <div class="text-left">
                            <h4>489</h4>
                            <p class="m-0">Total Comment</p>
                        </div>
                        <span class="label bg-c-red value-badges">15%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-c-green total-card">
                    <div class="card-block">
                        <div class="text-left">
                            <h4>$5782</h4>
                            <p class="m-0">Income Status</p>
                        </div>
                        <span class="label bg-c-green value-badges">20%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center order-visitor-card">
                    <div class="card-block">
                        <h6 class="m-b-0">Unique Visitors</h6>
                        <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652
                        </h4>
                        <p class="m-b-0">36% From Last 6 Months</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center order-visitor-card">
                    <div class="card-block">
                        <h6 class="m-b-0">Monthly Earnings</h6>
                        <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963
                        </h4>
                        <p class="m-b-0">36% From Last 6 Months</p>
                    </div>
                </div>
            </div>
            <!-- sale card end -->
        </div>
    </div> --}}

            <!-- end Statistik Pengajuan Surat -->

            <!-- Project statustic start -->
            {{-- <div class="col-xl-12">
        <div class="card proj-progress-card">
            <div class="card-block">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <h6>Published Project</h6>
                        <h5 class="m-b-30 f-w-700">532<span class="text-c-green m-l-10">+1.69%</span></h5>
                        <div class="progress">
                            <div class="progress-bar bg-c-red" style="width:25%"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <h6>Completed Task</h6>
                        <h5 class="m-b-30 f-w-700">4,569<span class="text-c-red m-l-10">-0.5%</span></h5>
                        <div class="progress">
                            <div class="progress-bar bg-c-blue" style="width:65%"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <h6>Successfull Task</h6>
                        <h5 class="m-b-30 f-w-700">89%<span class="text-c-green m-l-10">+0.99%</span></h5>
                        <div class="progress">
                            <div class="progress-bar bg-c-green" style="width:85%"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <h6>Ongoing Project</h6>
                        <h5 class="m-b-30 f-w-700">365<span class="text-c-green m-l-10">+0.35%</span></h5>
                        <div class="progress">
                            <div class="progress-bar bg-c-yellow" style="width:45%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
            <!-- Project statustic end -->
        </div>
    @endif

    @if (Auth::user()->is_mahasiswa)
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-c-green total-card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-3 text-center bg-c-green">
                                        <img src="{{ asset('assets/icon/pdf.svg') }}" alt="">
                                    </div>
                                    <a href="{{ route('suratAktif.create') }}">
                                        <div class="text-left">
                                            <p class="m-0">Pengajuan Surat Aktif<br> Perkuliah</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card bg-c-yellow total-card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-3 text-center bg-c-yellow">
                                        <img src="{{ asset('assets/icon/pdf.svg') }}" alt="">
                                    </div>
                                    <a href="{{ route('suratAkademik.create') }}">
                                        <div class="text-left">
                                            <p class="m-0">Pengajuan Surat Akademik <br>(Cuti/Pindah Kelas/Keluar)</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h4 class="m-b-0">Status Pengajuan Surat Aktif</h4>
                    @if ($latestSuratAktif)
                        @if ($latestSuratAktif->status == 'pending')
                            <h4 class="m-t-15 m-b-15 text-c-yellow">Pending</h4>
                            <p class="m-b-0">Estimasi 3 hari kerja</p>
                        @elseif($latestSuratAktif->status == 'diterima')
                            <h4 class="m-t-15 m-b-15 text-c-green">Diterima</h4>
                            <a href="{{ route('suratAktif.show', $latestSuratAktif->id) }}"
                                class="btn btn-sm btn-primary rounded">Lihat Surat</a>
                        @elseif($latestSuratAktif->status == 'ditolak')
                            <h4 class="m-t-15 m-b-15 text-c-red">Ditolak</h4>
                            <a href="{{ route('suratAktif.create') }}" class="btn btn-sm btn-danger rounded">Ajukan
                                Kembali</a>
                        @endif
                    @else
                        <h4 class="m-t-15 m-b-15">Belum Ada Pengajuan</h4>
                        <p class="m-b-0"><a href="{{ route('suratAktif.create') }}">Ajukan sekarang</a></p>
                    @endif
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Order Status</h6>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-md-6">
                <div class="card text-center order-visitor-card">
                    <div class="card-block">
                        <h6 class="m-b-0">Unique Visitors</h6>
                        <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652
                        </h4>
                        <p class="m-b-0">36% From Last 6 Months</p>
                    </div>
                </div>
            </div> --}}
        {{-- <div class="col-md-6">
                <div class="card text-center order-visitor-card">
                    <div class="card-block">
                        <h6 class="m-b-0">Monthly Earnings</h6>
                        <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963
                        </h4>
                        <p class="m-b-0">36% From Last 6 Months</p>
                    </div>
                </div>
            </div> --}}
        <!-- sale card end -->
        </div>
        </div>
        </div>
    @endif
@endsection
