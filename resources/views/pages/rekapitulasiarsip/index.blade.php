@extends('layouts.dashboard.template')

@section('title', 'Rekapitulasi Arsip')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <!-- Filter Card -->
            <div class="card shadow-sm mb-4 border-top-warning">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fa-solid fa-file-invoice text-warning fa-2x"></i>
                        </div>
                        <div class="col">
                            <h5 class="mb-0 font-weight-bold text-dark">Rekapitulasi Arsip</h5>
                            <p class="text-muted small mb-0">Saring dan ekspor data arsip sesuai kebutuhan</p>
                        </div>
                    </div>
                </div>
                <div class="card-block p-4">
                    <form action="{{ route('rekapitulasiarsip.index') }}" method="GET" id="filterForm">
                        <div class="row custom-filter-row">
                            <!-- Left Column -->
                            <div class="col-md-6 border-right">
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-sm-4 font-weight-bold text-dark mb-0">Tahun</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="tahun" id="tahun"
                                            class="form-control"
                                            value="{{ request('tahun') }}" placeholder="Contoh: 2026">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-sm-4 font-weight-bold text-dark mb-0">Periode Akademik</label>
                                    <div class="col-sm-8">
                                        <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control select2">
                                            <option value="">-- Semua Periode --</option>
                                            @foreach ($tahunAkademik as $item)
                                                <option value="{{ $item->id }}" {{ request('tahun_akademik_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->tahun_akademik }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-sm-4 font-weight-bold text-dark mb-0">Semester</label>
                                    <div class="col-sm-8">
                                        <select name="semester" id="semester" class="form-control select2">
                                            <option value="">-- Semua Semester --</option>
                                            <option value="Gasal" {{ request('semester') == 'Gasal' ? 'selected' : '' }}>Gasal</option>
                                            <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-sm-4 font-weight-bold text-dark mb-0">Jenis Arsip</label>
                                    <div class="col-sm-8">
                                        <select name="users_id" id="users_id" class="form-control select2">
                                            <option value="">-- Semua Jenis Arsip --</option>
                                            <option value="ArsipUtama" {{ request('users_id') == 'ArsipUtama' ? 'selected' : '' }}>Arsip Utama</option>
                                            <option value="SkKepanitiaan" {{ request('users_id') == 'SkKepanitiaan' ? 'selected' : '' }}>SK Kepanitiaan</option>
                                            <option value="LpjKepanitiaan" {{ request('users_id') == 'LpjKepanitiaan' ? 'selected' : '' }}>LPJ Kepanitiaan</option>
                                            <option value="Kurikulum" {{ request('users_id') == 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                                            <option value="Pedoman" {{ request('users_id') == 'Pedoman' ? 'selected' : '' }}>Pedoman</option>
                                            <option value="SOP Akademik" {{ request('users_id') == 'SOP Akademik' ? 'selected' : '' }}>SOP Akademik</option>
                                            <option value="Wasdalbin" {{ request('users_id') == 'Wasdalbin' ? 'selected' : '' }}>Wasdalbin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-sm-4 font-weight-bold text-dark mb-0">Role Akses</label>
                                    <div class="col-sm-8">
                                        <select name="homebase" id="homebase" class="form-control select2">
                                            <option value="">-- Semua Role --</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ request('homebase') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-round mr-2 px-4 shadow-sm" onclick="setFormAction('index')">
                                <i class="fa-solid fa-magnifying-glass mr-1"></i> TAMPILKAN
                            </button>
                            <button type="submit" class="btn btn-success btn-round px-4 shadow-sm" onclick="setFormAction('export')">
                                <i class="fa-solid fa-file-excel mr-1"></i> CETAK EXCEL
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Card -->
            <div class="card shadow-sm border-0 mt-4 overflow-hidden border-top-success">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="row align-items-center justify-content-between">
                        <div class="col">
                            <h6 class="mb-0 font-weight-bold text-dark"><i class="fa-solid fa-table-list mr-2 text-success"></i>Hasil Rekapitulasi</h6>
                        </div>
                        <div class="col-md-5">
                            <div class="search-wrapper">
                                <i class="fa-solid fa-search search-icon"></i>
                                <input type="text" id="tableSearch" class="form-control" placeholder="Saring hasil yang tampil...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle" id="rekapTable">
                            <thead class="bg-primary-dark">
                                <tr>
                                    <th class="px-4 py-3 text-center text-white" style="width: 50px;">NO</th>
                                    <th class="py-3 text-white">PERIODE & SEMESTER</th>
                                    <th class="py-3 text-white">ROLE & JENIS ARSIP</th>
                                    <th class="py-3 text-white">JUDUL DOKUMEN</th>
                                    <th class="px-4 py-3 text-center text-white">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapitulasis ?? [] as $index => $item)
                                    <tr>
                                        <td class="text-center px-4 font-weight-bold">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="text-dark font-weight-bold">{{ $item->tahunAkademik->tahun_akademik ?? '-' }}</div>
                                            <span class="text-muted small uppercase">{{ $item->semester ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $userRole = '-';
                                                if($item->jenis_arsip == 'ArsipUtama') {
                                                    $userRole = $item->user->role->nama_role ?? '-';
                                                } else {
                                                    $related = null;
                                                    switch($item->jenis_arsip) {
                                                        case 'SkKepanitiaan': $related = $item->skKepanitiaan; break;
                                                        case 'LpjKepanitiaan': $related = $item->lpjKepanitiaan; break;
                                                        case 'Kurikulum': $related = $item->kurikulum; break;
                                                        case 'Pedoman': $related = $item->pedoman; break;
                                                        case 'SOP Akademik': $related = $item->sopAkademik; break;
                                                        case 'Wasdalbin': $related = $item->wasdalbin; break;
                                                    }
                                                    
                                                    if($item->jenis_arsip == 'Kurikulum') {
                                                        $userRole = $related->user->role->nama_role ?? '-';
                                                    } else {
                                                        $userRole = $related->users->role->nama_role ?? '-';
                                                    }
                                                }
                                            @endphp
                                            <div class="text-info font-weight-bold small mb-1">{{ strtoupper($userRole) }}</div>
                                            <div class="badge badge-success px-2 py-1 small">{{ $item->jenis_arsip }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $related = null;
                                                $title = '-';
                                                switch($item->jenis_arsip) {
                                                    case 'ArsipUtama':
                                                        $related = $item;
                                                        $title = $item->nama_arsip ?? '-';
                                                        break;
                                                    case 'SkKepanitiaan': 
                                                        $related = $item->skKepanitiaan; 
                                                        $title = $related->nama_dokumen ?? '-';
                                                        break;
                                                    case 'LpjKepanitiaan': 
                                                        $related = $item->lpjKepanitiaan; 
                                                        $title = $related->nama_dokumen ?? '-';
                                                        break;
                                                    case 'Kurikulum': 
                                                        $related = $item->kurikulum; 
                                                        $title = $related->nama_kurikulum ?? '-';
                                                        break;
                                                    case 'Pedoman': 
                                                        $related = $item->pedoman; 
                                                        $title = $related->nama_pedoman ?? '-';
                                                        break;
                                                    case 'SOP Akademik': 
                                                        $related = $item->sopAkademik; 
                                                        $title = $related->nama_sop ?? '-';
                                                        break;
                                                    case 'Wasdalbin': 
                                                        $related = $item->wasdalbin; 
                                                        $title = $related->nama_wasdalbin ?? '-';
                                                        break;
                                                }
                                            @endphp
                                            <span class="text-dark">{{ $title }}</span>
                                        </td>
                                        <td class="text-center px-4">
                                            @php
                                                $url = '#';
                                                $hasFile = false;
                                                if($item->jenis_arsip == 'ArsipUtama' && $item->file_arsip) {
                                                    $url = $item->file_arsip;
                                                    $hasFile = true;
                                                } elseif($related && isset($related->file)) {
                                                    $url = $related->file;
                                                    $hasFile = true;
                                                }
                                                
                                                if($hasFile && !str_starts_with($url, 'http')) {
                                                    $url = asset('storage/' . $url);
                                                }
                                            @endphp
                                            
                                            @if($hasFile)
                                                <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm px-3 shadow-none">
                                                    <i class="fa fa-file-invoice mr-1"></i> Dokumen
                                                </a>
                                            @else
                                                <span class="text-muted small">No File</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fa-solid fa-folder-open fa-4x text-light mb-3"></i>
                                            <p class="text-muted font-weight-bold">Silahkan gunakan filter untuk menampilkan data</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(method_exists($rekapitulasis, 'links'))
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Menampilkan {{ $rekapitulasis->firstItem() ?? 0 }} sampai {{ $rekapitulasis->lastItem() ?? 0 }} dari {{ $rekapitulasis->total() }} data
                                </div>
                                <div class="pagination-sm">
                                    {{ $rekapitulasis->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .border-top-warning { border-top: 4px solid #ffb64d !important; }
        .border-top-success { border-top: 4px solid #00A551 !important; }
        .bg-primary-dark { background-color: #0d47a1 !important; }
        .text-warning { color: #ffb64d !important; }
        .btn-round { border-radius: 4px; }
        .uppercase { text-transform: uppercase; }
        .table thead th { font-weight: 700; letter-spacing: 0.5px; border: none; font-size: 0.75rem; }
        .table td { vertical-align: middle !important; border-top: 1px solid #f2f2f2; }
        .card { border-radius: 4px; border: none; }
        
        /* Select2 Customization to match reference UI */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ddd !important;
            height: 38px !important;
            border-radius: 4px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
            padding-left: 12px !important;
            color: #444 !important;
            font-size: 0.9rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
        
        /* Custom Search Wrapper */
        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .search-icon {
            position: absolute;
            right: 15px;
            color: #adb5bd;
            pointer-events: none;
            z-index: 10;
        }
        #tableSearch {
            height: 38px !important;
            border-color: #ddd;
            font-size: 0.85rem;
            padding-right: 40px !important; /* Space for icon on the right */
            width: 100%;
            border-radius: 4px;
        }
        #tableSearch:focus { 
            border-color: #ffb64d;
            box-shadow: 0 0 0 0.2rem rgba(255, 182, 77, 0.1);
        }
        #tableSearch:focus + .search-icon {
            color: #ffb64d;
        }
        
        .pagination { margin-bottom: 0; }
        .page-item.active .page-link { background-color: #00A551; border-color: #00A551; }
        .page-link { color: #00A551; }
        
        .custom-filter-row .col-md-6 { padding: 0 25px; }
        label { font-size: 0.85rem; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                theme: 'default'
            });

            $("#tableSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#rekapTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function setFormAction(type) {
            const form = document.getElementById('filterForm');
            if (type === 'export') {
                form.action = "{{ route('rekapitulasiarsip.export') }}";
            } else {
                form.action = "{{ route('rekapitulasiarsip.index') }}";
            }
        }
    </script>
    @endpush
@endsection
