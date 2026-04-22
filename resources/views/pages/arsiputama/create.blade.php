@extends('layouts.dashboard.template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Arsip Utama</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Form Inputs</h4>
                    <form action="{{ route('arsiputama.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <style>
                            .custom-input-group {
                                display: flex;
                                width: 100%;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                                border-radius: 10px;
                                overflow: hidden;
                                border: 1px solid #ced4da;
                                transition: all 0.3s ease;
                            }

                            .custom-input-group:focus-within {
                                border-color: #046B26;
                                box-shadow: 0 0 0 0.2rem rgba(4, 107, 38, 0.25);
                            }

                            .custom-input-group .form-control,
                            .custom-input-group .select2-container--default .select2-selection--single {
                                border: none !important;
                                border-radius: 0 !important;
                                height: 45px !important;
                                line-height: 45px !important;
                            }

                            .custom-input-group .select2-container--default .select2-selection--single .select2-selection__rendered {
                                line-height: 45px !important;
                                padding-left: 15px;
                            }

                            .custom-input-group .select2-container--default .select2-selection--single .select2-selection__arrow {
                                height: 45px !important;
                            }

                            .custom-input-group .btn {
                                border-radius: 0 !important;
                                height: 45px !important;
                                padding: 0 20px !important;
                                font-weight: 600;
                                text-transform: uppercase;
                                font-size: 0.8rem;
                                letter-spacing: 0.5px;
                                border: none !important;
                            }

                            .btn-save-ajax {
                                background-color: #046B26 !important;
                                color: white !important;
                            }

                            .btn-save-ajax:hover {
                                background-color: #035a20 !important;
                            }

                            .btn-toggle-ui {
                                background-color: #f8f9fa !important;
                                color: #046B26 !important;
                                border-left: 1px solid #eee !important;
                            }

                            .btn-toggle-ui:hover {
                                background-color: #e9ecef !important;
                            }
                        </style>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori Arsip</label>
                            <div class="col-sm-10">
                                <div id="select-kategori-container">
                                    <div class="custom-input-group">
                                        <div style="flex: 1;">
                                            <select name="kategori_arsip_id" id="kategori_arsip_id" class="form-control">
                                                <option value="">-- Pilih Kategori Arsip --</option>
                                                @foreach ($kategoriArsips as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ old('kategori_arsip_id') == $kategori->id ? 'selected' : '' }}>
                                                        {{ $kategori->kategori_arsip }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-toggle-ui" id="btn-toggle-custom">
                                            <i class="fa-solid fa-plus-circle mr-1"></i> Kategori Baru
                                        </button>
                                    </div>
                                </div>

                                <div id="custom-kategori-container" style="display: none;">
                                    <div class="custom-input-group">
                                        <input type="text" id="custom_kategori_name" class="form-control"
                                            placeholder="Ketik nama kategori baru di sini...">
                                        <button type="button" class="btn btn-save-ajax" id="btn-save-custom">
                                            <i class="fa-solid fa-check-circle mr-1"></i> Simpan
                                        </button>
                                        <button type="button" class="btn btn-danger" id="btn-toggle-select"
                                            style="background-color: #dc3545 !important;">
                                            <i class="fa-solid fa-times-circle mr-1"></i> Batal
                                        </button>
                                    </div>
                                    <small class="text-muted mt-2 d-block ml-1">
                                        <i class="fa-solid fa-info-circle text-success mr-1"></i> Simpan untuk menambahkan
                                        ke daftar pilihan secara otomatis.
                                    </small>
                                </div>

                                @error('kategori_arsip_id')
                                    <div class="text-danger small mt-2 ml-1"><i
                                            class="fa-solid fa-exclamation-triangle mr-1"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Arsip</label>
                            <div class="col-sm-10">
                                <input type="text" name="tahun_arsip" value="{{ old('tahun_arsip') }}"
                                    class="form-control rounded" placeholder="Contoh: 2025">
                                @error('tahun_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Arsip</label>
                            <div class="col-sm-10">
                                <textarea name="nama_arsip" class="form-control rounded" rows="3" placeholder="Masukkan nama arsip">{{ old('nama_arsip') }}</textarea>
                                @error('nama_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload Dokumen (PDF)</label>
                            <div class="col-sm-10">
                                <input type="file" name="file_arsip" class="form-control rounded" id="file-input"
                                    accept=".pdf">
                                @error('file_arsip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Preview Dokumen</label>
                            <div class="col-sm-10">
                                <div id="preview-container"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-save"></i> Submit
                        </button>
                        <a href="{{ route('arsiputama.index') }}" class="btn btn-danger rounded text-uppercase btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('file-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';
            if (file && file.type === 'application/pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = URL.createObjectURL(file);
                iframe.width = '100%';
                iframe.height = '500px';
                previewContainer.appendChild(iframe);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#kategori_arsip_id').select2({
                placeholder: "-- Pilih Kategori Arsip --",
                allowClear: true
            });
        });

        $('#btn-toggle-custom').on('click', function() {
            $('#select-kategori-container').hide();
            $('#custom-kategori-container').show();
            $('#kategori_arsip_id').val(null).trigger('change');
            $('#custom_kategori_name').focus();
        });

        $('#btn-toggle-select').on('click', function() {
            $('#custom-kategori-container').hide();
            $('#select-kategori-container').show();
            $('#custom_kategori_name').val('');
        });

        $('#btn-save-custom').on('click', function() {
            let name = $('#custom_kategori_name').val();
            if (!name) {
                Swal.fire('Peringatan', 'Nama kategori tidak boleh kosong', 'warning');
                return;
            }

            $.ajax({
                url: "{{ route('kategoriarsip.store-ajax') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    kategori_arsip: name
                },
                success: function(response) {
                    if (response.success) {
                        // Tambah ke select2
                        let newOption = new Option(response.data.kategori_arsip, response.data.id, true,
                            true);
                        $('#kategori_arsip_id').append(newOption).trigger('change');

                        // Switch back
                        $('#custom-kategori-container').hide();
                        $('#select-kategori-container').show();
                        $('#custom_kategori_name').val('');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kategori baru ditambahkan dan terpilih',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let msg = '';
                    $.each(errors, function(k, v) {
                        msg += v[0] + '<br>';
                    });
                    Swal.fire('Gagal', msg, 'error');
                }
            });
        });

        $('form').on('submit', function() {
            Swal.fire({
                title: 'Sedang Mengunggah...',
                text: 'Mohon tunggu sebentar, file sedang dikirim ke Google Drive.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            return true;
        });
    </script>
@endpush
