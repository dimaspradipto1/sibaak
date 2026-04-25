@extends('layouts.dashboard.template')

@section('title', 'Arsip Utama')

@section('content')
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-xl-3 col-lg-4">
            <!-- Header Utama Filter -->
            <div class="d-flex justify-content-between align-items-center bg-white p-3 mb-3 shadow-sm rounded"
                style="border-left: 5px solid #ff9800;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-filter mr-2 text-warning" style="font-size: 1.2rem;"></i>
                    <h6 class="m-0 font-weight-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">Filter</h6>
                </div>
                <button class="btn p-0 d-flex align-items-center justify-content-center shadow-sm"
                    style="width: 32px; height: 32px; background-color: #ff9800; border-radius: 6px; border: none;">
                    <i class="fas fa-angle-double-left text-white" style="font-size: 12px;"></i>
                </button>
            </div>

            <div class="accordion" id="filterAccordion">

                <!-- Box Unit / Program Studi -->
                <div class="card border-0 shadow-sm mb-3"
                    style="border-radius: 10px; border-top: 3px solid #ff9800 !important; overflow: hidden;">
                    <div class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center"
                        data-toggle="collapse" data-target="#collapseUnit" style="cursor: pointer;">
                        <span class="font-weight-bold text-dark" style="font-size: 14px;">Unit / Program Studi</span>
                        <i class="fas fa-chevron-down text-muted small"></i>
                    </div>
                    <div id="collapseUnit" class="collapse show" data-parent="#filterAccordion">
                        <div class="accent-bar bg-success"></div>
                        <div class="accent-bar bg-success ml-1" style="opacity: 0.5;"></div>
                        <div class="card-body p-3 pt-0">
                            <div class="p-2 bg-light rounded text-center mb-3">
                                <span class="x-small font-weight-bold text-success text-uppercase"
                                    style="font-size: 10px; letter-spacing: 1px;">Struktur Organisasi UIS</span>
                            </div>
                            <div class="tree-container" style="max-height: 480px; overflow-y: auto; padding-right: 5px;">
                                @php
                                    if (!function_exists('renderTree')) {
                                        function renderTree($units)
                                        {
                                            echo '<ul class="tree">';
                                            foreach ($units as $unit) {
                                                $hasChildren = $unit->children->count() > 0;
                                                $displayName = $unit->nama_unit;
                                                echo '<li>';
                                                if ($hasChildren) {
                                                    echo '<span class="tree-node parent" data-unit-id="' .
                                                        $unit->id .
                                                        '"><i class="fas fa-minus-square mr-1 text-success"></i> ' .
                                                        $displayName .
                                                        '</span>';
                                                    renderTree($unit->children);
                                                } else {
                                                    echo '<span class="tree-node leaf pl-1" data-unit-id="' .
                                                        $unit->id .
                                                        '"><i class="fas fa-circle mr-1 text-muted" style="font-size: 6px; vertical-align: middle;"></i> ' .
                                                        $displayName .
                                                        '</span>';
                                                }
                                                echo '</li>';
                                            }
                                            echo '</ul>';
                                        }
                                    }
                                @endphp

                                @if ($unitKerjas->count() > 0)
                                    {!! renderTree($unitKerjas) !!}
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-info-circle text-muted mb-2" style="font-size: 24px;"></i>
                                        <p class="small text-muted" style="font-size: 11px;">Belum ada data unit kerja yang
                                            terhubung dengan akun Anda atau unit belum diisi.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box Tahun Arsip -->
                <div class="card border-0 shadow-sm mb-3"
                    style="border-radius: 10px; border-top: 3px solid #ff9800 !important; overflow: hidden;">
                    <div class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center"
                        data-toggle="collapse" data-target="#collapseYear" style="cursor: pointer;">
                        <span class="font-weight-bold text-dark" style="font-size: 14px;">Tahun Arsip</span>
                        <i class="fas fa-chevron-down text-muted small"></i>
                    </div>
                    <div id="collapseYear" class="collapse show" data-parent="#filterAccordion">
                        <div class="card-body p-3 pt-0">
                            <select id="filterTahun" class="form-control form-control-sm select2-search"
                                style="width: 100%;">
                                <option value="">-- Semua Tahun --</option>
                                @for ($i = date('Y'); $i >= 2010; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Box Kategori Dokumen -->
                <div class="card border-0 shadow-sm mb-3"
                    style="border-radius: 10px; border-top: 3px solid #ff9800 !important; overflow: hidden;">
                    <div class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center"
                        data-toggle="collapse" data-target="#collapseCategory" style="cursor: pointer;">
                        <span class="font-weight-bold text-dark" style="font-size: 14px;">Kategori Dokumen</span>
                        <i class="fas fa-chevron-down text-muted small"></i>
                    </div>
                    <div id="collapseCategory" class="collapse show" data-parent="#filterAccordion">
                        <div class="card-body p-3 pt-0">
                            <select id="filterKategori" class="form-control form-control-sm select2-search"
                                style="width: 100%;">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoriArsips as $kat)
                                    <option value="{{ $kat->kategori_arsip }}">{{ $kat->kategori_arsip }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div> <!-- End Accordion -->
        </div> <!-- End Sidebar Col -->

        <!-- Data Table Area -->
        <div class="col-xl-9 col-lg-8">
            <div class="card border-0 shadow-sm mb-4"
                style="border-radius: 15px; overflow: hidden; border-top: 5px solid #046B26 !important;">
                <!-- Main Header -->
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="d-flex align-items-center">
                                <div class="d-flex mr-3">
                                    <div style="width: 4px; height: 25px; background: #046B26; border-radius: 2px;"></div>
                                    <div
                                        style="width: 4px; height: 25px; background: #046B26; border-radius: 2px; margin-left: 3px; opacity: 0.5;">
                                    </div>
                                </div>
                                <div>
                                    <h5 class="m-0 font-weight-bold text-dark">Daftar Arsip Utama</h5>
                                    <p class="text-xs text-muted mb-0" style="font-size: 11px;">Kelola dan pantau seluruh
                                        dokumen arsip institusi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-md-right mt-2 mt-md-0">
                            <div class="d-inline-flex shadow-sm overflow-hidden"
                                style="border: 1px solid #e3e6f0; border-radius: 30px;">
                                @can('arsip_utama_create')
                                    <a href="{{ route('arsiputama.create') }}"
                                        class="btn btn-success btn-xs font-weight-bold px-3 py-1 border-0"
                                        style="background-color: #046B26; color: white; font-size: 10px; height: 32px; line-height: 24px; border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                                        <i class="fas fa-plus mr-1"></i> TAMBAH
                                    </a>
                                @endcan
                                <button class="btn btn-white btn-xs px-3 py-1 border-0 border-left rounded-0 text-danger"
                                    id="btnBulkDelete" style="font-size: 10px; height: 32px; line-height: 24px;">
                                    <i class="fas fa-trash-alt mr-1"></i> HAPUS
                                </button>
                                <div class="dropdown d-inline-block border-left">
                                    <button
                                        class="btn btn-white btn-xs px-3 py-1 border-0 font-weight-bold dropdown-toggle"
                                        type="button" data-toggle="dropdown"
                                        style="font-size: 10px; height: 32px; line-height: 24px; border-top-right-radius: 30px; border-bottom-right-radius: 30px;">
                                        <i class="fas fa-file-export mr-1 text-primary"></i> EXPORT
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-1">
                                        <a class="dropdown-item py-2 small" href="#"><i
                                                class="fas fa-file-excel mr-2 text-success"></i> Excel</a>
                                        <a class="dropdown-item py-2 small" href="#"><i
                                                class="fas fa-file-pdf mr-2 text-danger"></i> PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Data Management Toolbar -->
                    <div class="px-4 py-2 border-bottom d-flex align-items-center justify-content-between bg-white">
                        <div class="d-flex align-items-center flex-grow-1">
                            <div class="ml-4 d-none d-lg-flex align-items-center">
                                <span
                                    class="badge badge-pill bg-white border text-muted px-2 py-1 font-weight-normal mr-2 d-flex align-items-center shadow-sm"
                                    style="font-size: 10px;">
                                    <span class="dot bg-primary mr-1"
                                        style="width: 6px; height: 6px; border-radius: 50%;"></span> Aktif
                                </span>
                                <span
                                    class="badge badge-pill bg-white border text-muted px-2 py-1 font-weight-normal d-flex align-items-center shadow-sm"
                                    style="font-size: 10px;">
                                    <span class="dot bg-info mr-1"
                                        style="width: 6px; height: 6px; border-radius: 50%;"></span> Inaktif
                                </span>
                            </div>
                        </div>
                        <button class="btn btn-xs btn-white border shadow-sm ml-2" id="btnRefreshTable"
                            title="Muat Ulang" style="width: 30px; height: 30px; border-radius: 8px;">
                            <i class="fas fa-sync-alt text-muted" style="font-size: 10px;"></i>
                        </button>
                    </div>

                    <div class="p-0">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'table table-hover mb-0 w-100', 'id' => 'arsiputama-table']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legend Support -->
            <div class="card mt-3 shadow-sm border-0 bg-light-yellow" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="row small text-dark">
                        <div class="col-md-3"><strong>Status Dokumen:</strong></div>
                        <div class="col-md-3"><span class="badge badge-primary badge-pill">A</span> Aktif</div>
                        <div class="col-md-3"><span class="badge badge-info badge-pill">I</span> Inaktif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Compact layout adjustments */
        .card {
            margin-bottom: 0.8rem !important;
        }

        .card-header {
            padding: 0.8rem 1.2rem !important;
        }

        .card-body,
        .card-block {
            padding: 0.8rem 1.2rem !important;
        }

        /* Sidebar Filter Compact */
        .bg-white.p-3.mb-3.shadow-sm.rounded {
            padding: 0.6rem 1rem !important;
            margin-bottom: 0.6rem !important;
        }

        .accordion .card.mb-3 {
            margin-bottom: 0.6rem !important;
        }

        .accordion .card-header.p-3 {
            padding: 0.6rem 1rem !important;
        }

        .accordion .card-body.p-3 {
            padding: 0.6rem 1rem 0.6rem !important;
        }

        .tree li {
            padding: 2px 0 !important;
        }

        .tree-node {
            font-size: 0.72rem !important;
            padding: 1px 5px !important;
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Main Table Area Compact */
        .card-header.bg-white.border-bottom.py-3.px-4 {
            padding: 0.6rem 1.2rem !important;
        }

        .px-4.py-3.border-bottom.bg-white {
            padding: 0.4rem 1.2rem !important;
        }

        /* Hide Default DataTables Elements */
        .dataTables_filter,
        .dataTables_length {
            display: none !important;
        }

        .bg-light-yellow {
            background: #fffcf0;
            border: 1px solid #ffeeba !important;
        }

        /* Tree View Styling */
        ul.tree,
        ul.tree ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        ul.tree ul {
            margin-left: 15px;
            position: relative;
        }

        ul.tree ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: -10px;
            border-left: 1px dotted #28a745;
        }

        ul.tree li {
            margin: 0;
            padding: 3px 0;
            line-height: normal;
            position: relative;
        }

        ul.tree li:before {
            content: "";
            display: block;
            width: 12px;
            height: 0;
            border-top: 1px dotted #28a745;
            position: absolute;
            top: 12px;
            left: -10px;
        }

        /* Premium Table Styles Compact */
        #arsiputama-table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.4px;
            color: #4e73df;
            border-top: none;
            border-bottom: 2px solid #e3e6f0;
            padding: 8px 10px !important;
        }

        #arsiputama-table tbody td {
            vertical-align: middle;
            padding: 6px 10px !important;
            color: #5a5c69;
            font-size: 12px;
            border-bottom: 1px solid #f1f3f9;
        }

        #arsiputama-table tbody tr:hover {
            background-color: #fcfdff;
        }

        /* Utility */
        .text-xs {
            font-size: 10px;
        }

        .dot {
            display: inline-block;
        }

        .rounded-lg {
            border-radius: 8px !important;
        }

        /* Fix Button Borders in Group */
        .btn-white {
            background-color: #fff;
            color: #6e707e;
        }

        .btn-white:hover {
            background-color: #f8f9fc;
            color: #4e73df;
        }

        .pagination .page-item.active .page-link {
            background-color: #ff9800;
            border-color: #ff9800;
        }

        /* Select2 Premium Customization Compact */
        .select2-container--default .select2-selection--single {
            border: 1px solid #e3e6f0 !important;
            height: 32px !important;
            padding: 2px !important;
            border-radius: 6px !important;
            transition: all 0.2s;
            background-color: #f8f9fc !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 30px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #6e707e !important;
            font-size: 12px !important;
            line-height: 24px !important;
        }
    </style>
@endsection

@push('scripts')
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
        $(document).ready(function() {
            var selectedUnitId = '';
            var tableId = 'arsiputama-table';

            // Fungsi untuk Refresh Tabel
            function reloadTable() {
                window.LaravelDataTables[tableId].draw();
            }

            // Inisialisasi Select2 dengan pengaturan Premium
            $('.select2-search').select2({
                placeholder: "Cari...",
                allowClear: true,
                width: '100%'
            });

            // 1. Filter: Klik pada Pohon Organisasi (Dinamis)
            $(document).on('click', '.tree-node', function(e) {
                e.preventDefault();
                $('.tree-node').removeClass('text-primary font-weight-bold text-success');
                $(this).addClass('text-primary font-weight-bold');

                selectedUnitId = $(this).data('unit-id');
                reloadTable();
            });

            // 2. Filter: Perubahan Dropdown Tahun
            $('#filterTahun').on('change', function() {
                reloadTable();
            });

            // 3. Filter: Perubahan Dropdown Kategori
            $('#filterKategori').on('change', function() {
                reloadTable();
            });

            // 4. Pencarian Kustom
            $('#customSearch').on('keyup', function() {
                window.LaravelDataTables[tableId].search($(this).val()).draw();
            });

            // 5. Tombol Refresh
            $('#btnRefreshTable').on('click', function() {
                selectedUnitId = '';
                $('.tree-node').removeClass('text-primary font-weight-bold text-success');
                $('#filterTahun, #filterKategori').val(null).trigger('change');
                $('#customSearch').val('');
                reloadTable();
            });

            // Ganti Ikon saat Collapse Tree
            $(document).on('click', '.tree-node.parent', function(e) {
                var $subMenu = $(this).next('ul');
                var $icon = $(this).find('i');
                $subMenu.slideToggle(200);
                $icon.toggleClass('fa-minus-square fa-plus-square');
            });

            // Intercept AJAX Request untuk mengirim Parameter Filter
            $('#' + tableId).on('preXhr.dt', function(e, settings, data) {
                data.unit_id = selectedUnitId;
                data.tahun = $('#filterTahun').val();
                data.kategori = $('#filterKategori').val();
            });

            // 6. Handle Toggle Status Manual (AJAX)
            $(document).on('click', '.btn-toggle-status', function() {
                var btn = $(this);
                var id = btn.data('id');
                var status = btn.data('status');

                $.ajax({
                    url: "{{ route('arsiputama.toggle-status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    beforeSend: function() {
                        btn.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        if (response.success) {
                            reloadTable();
                        } else {
                            alert(response.message);
                            reloadTable();
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat mengubah status.');
                        reloadTable();
                    }
                });
            });
        });
    </script>
@endpush
