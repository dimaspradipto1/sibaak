@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-gradient-primary text-white p-4 d-flex justify-content-between align-items-center" 
                     style="background: linear-gradient(45deg, #4099ff, #73b4ff);">
                    <div>
                        <h4 class="mb-1 font-weight-bold text-white"><i class="fa fa-shield-alt mr-2"></i> Konfigurasi Izin Akses</h4>
                        <p class="mb-0 opacity-80" style="font-size: 0.9rem;">Menentukan hak akses untuk role: <strong>{{ $role->nama_role }}</strong></p>
                    </div>
                    <a href="{{ route('role.index') }}" class="btn btn-light btn-sm px-4 font-weight-bold shadow-sm" style="border-radius: 50px !important;">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                
                <div class="card-body p-4 bg-light">
                    <form action="{{ route('role.update-permission', $role->id) }}" method="POST" id="permissionForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @foreach ($permissions as $module => $items)
                                <div class="col-xl-6 col-md-12 mb-4">
                                    <div class="card border-0 shadow-sm h-100 transition-hover" style="border-radius: 12px; overflow: hidden;">
                                        <div class="card-header border-0 bg-gradient-uis-green text-white py-3 px-4">
                                            <div class="d-flex align-items-center mb-0">
                                                <div class="module-icon bg-white text-success mr-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                                    @php
                                                        $icon = 'fa-folder';
                                                        if(str_contains($module, 'Arsip')) $icon = 'fa-archive';
                                                        if(str_contains($module, 'Master')) $icon = 'fa-database';
                                                        if(str_contains($module, 'Rekap')) $icon = 'fa-chart-pie';
                                                        if(str_contains($module, 'Layanan')) $icon = 'fa-user-graduate';
                                                        if(str_contains($module, 'Artikel')) $icon = 'fa-newspaper';
                                                    @endphp
                                                    <i class="fa {{ $icon }} sm"></i>
                                                </div>
                                                <h6 class="mb-0 font-weight-bold text-white">{{ strtoupper($module) }}</h6>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="check-all-module" data-module="{{ Str::slug($module) }}" id="checkAll-{{ Str::slug($module) }}">
                                                <label class="text-white small font-weight-bold mb-0 ml-1 cursor-pointer" for="checkAll-{{ Str::slug($module) }}">Select All</label>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive overflow-hidden">
                                                <table class="table table-borderless mb-0 permission-table w-100" data-module-target="{{ Str::slug($module) }}">
                                                    <thead class="bg-light border-bottom">
                                                        <tr style="background-color: #f1f4f9;">
                                                            <th class="py-2 px-3 small font-weight-bold text-muted border-0" style="width: 40%;">MODULE</th>
                                                            <th class="py-2 px-1 small font-weight-bold text-muted border-0 text-center" style="width: 12%;">VIEW</th>
                                                            <th class="py-2 px-1 small font-weight-bold text-muted border-0 text-center" style="width: 12%;">ADD</th>
                                                            <th class="py-2 px-1 small font-weight-bold text-muted border-0 text-center" style="width: 12%;">EDIT</th>
                                                            <th class="py-2 px-1 small font-weight-bold text-muted border-0 text-center" style="width: 12%;">DEL</th>
                                                            <th class="py-2 px-1 small font-weight-bold text-muted border-0 text-center" style="width: 12%;">ALL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $subModules = [];
                                                            foreach($items as $item) {
                                                                $name = $item->name;
                                                                $action = 'Other';
                                                                $target = $name;
                                                                
                                                                if(str_starts_with($name, 'Lihat ')) { $action = 'View'; $target = substr($name, 6); }
                                                                elseif(str_starts_with($name, 'Tambah ')) { $action = 'Add'; $target = substr($name, 7); }
                                                                elseif(str_starts_with($name, 'Edit ')) { $action = 'Edit'; $target = substr($name, 5); }
                                                                elseif(str_starts_with($name, 'Hapus ')) { $action = 'Delete'; $target = substr($name, 6); }
                                                                elseif(str_starts_with($name, 'Kelola ')) { $action = 'Manage'; $target = substr($name, 7); }
                                                                
                                                                $subModules[$target][$action] = $item;
                                                            }
                                                        @endphp

                                                        @foreach($subModules as $target => $actions)
                                                            <tr class="border-bottom-dashed">
                                                                <td class="py-2 px-3">
                                                                    <span class="font-weight-600 text-dark small d-block" style="white-space: normal;">{{ $target }}</span>
                                                                </td>
                                                                @foreach(['View', 'Add', 'Edit', 'Delete'] as $type)
                                                                    <td class="text-center py-2 px-1">
                                                                        @if(isset($actions[$type]))
                                                                            <div class="pretty p-svg p-curve p-jelly p-success m-0" style="font-size: 1.1rem;">
                                                                                <input type="checkbox" 
                                                                                       name="permissions[]" 
                                                                                       value="{{ $actions[$type]->id }}" 
                                                                                       {{ in_array($actions[$type]->id, $rolePermissions) ? 'checked' : '' }} />
                                                                                <div class="state p-success">
                                                                                    <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                                                        <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                                                                    </svg>
                                                                                    <label></label>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($type == 'View' && isset($actions['Manage']))
                                                                             {{-- Handle case like "Kelola Surat Aktif" --}}
                                                                             <div class="pretty p-svg p-curve p-jelly p-success m-0" style="font-size: 1.1rem;">
                                                                                <input type="checkbox" 
                                                                                       name="permissions[]" 
                                                                                       value="{{ $actions['Manage']->id }}" 
                                                                                       {{ in_array($actions['Manage']->id, $rolePermissions) ? 'checked' : '' }} />
                                                                                <div class="state p-success">
                                                                                    <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                                                        <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                                                                    </svg>
                                                                                    <label></label>
                                                                                </div>
                                                                            </div>
                                                                            <span class="d-block x-small text-muted" style="font-size: 0.55rem;">FULL</span>
                                                                        @else
                                                                             <span class="text-light">-</span>
                                                                        @endif
                                                                    </td>
                                                                @endforeach
                                                                <td class="text-center py-2 px-1">
                                                                    <div class="pretty p-svg p-curve p-jelly p-warning m-0 check-all-row" style="font-size: 1.1rem;">
                                                                        <input type="checkbox" class="row-checkbox" />
                                                                        <div class="state p-warning">
                                                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                                                <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                                                            </svg>
                                                                            <label></label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="sticky-footer mt-4 pt-4 border-top text-center">
                            <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold shadow-lg" 
                                    style="letter-spacing: 1px; border-radius: 50px !important;">
                                <i class="fa fa-save mr-2"></i> SIMPAN KONFIGURASI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.3/pretty-checkbox.min.css">
<style>
    .bg-gradient-uis-green {
        background: linear-gradient(135deg, #00A551 0%, #008240 100%);
    }
    .bg-soft-primary {
        background-color: rgba(64, 153, 255, 0.1);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .border-bottom-dashed {
        border-bottom: 1px dashed #e9ecef;
    }
    .border-bottom-dashed:last-child {
        border-bottom: none;
    }
    .color-dark {
        color: #2c3e50;
    }
    .font-weight-600 {
        font-weight: 600;
    }
    .color-muted {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .sticky-footer {
        position: sticky;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        z-index: 10;
        margin: 0 -1.5rem;
    }
    .opacity-80 {
        opacity: 0.8;
    }
    
    .table th, .table td {
        vertical-align: middle !important;
    }
    
    /* Custom Styling for Pretty Checkbox */
    .pretty.p-success input:checked~.state.p-success:before, 
    .pretty.p-success.p-toggle .state.p-success:before {
        background-color: #00A551 !important;
    }
    .pretty.p-svg .state .svg {
        top: 2px !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle all checkboxes in a row
        $('.row-checkbox').on('change', function() {
            var isChecked = $(this).is(':checked');
            $(this).closest('tr').find('input[type="checkbox"]').not(this).prop('checked', isChecked);
        });

        // Toggle all checkboxes in a module card
        $('.check-all-module').on('change', function() {
            var isChecked = $(this).is(':checked');
            var moduleSlug = $(this).data('module');
            $('table[data-module-target="' + moduleSlug + '"]').find('input[type="checkbox"]').prop('checked', isChecked);
        });

        // Optional: Sync row-checkbox if all items in row are checked manually
        $('input[name="permissions[]"]').on('change', function() {
            var $row = $(this).closest('tr');
            var $allCheckboxes = $row.find('input[name="permissions[]"]');
            var $checkedCheckboxes = $row.find('input[name="permissions[]"]:checked');
            $row.find('.row-checkbox').prop('checked', $allCheckboxes.length === $checkedCheckboxes.length);
        });
    });
</script>
@endpush
