@extends('layouts.dashboard.template')

@section('content')
    <style>
        .profile-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-photo {
            width: 100%;
            max-width: 225px;
            height: 285px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .btn-photo {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            padding: 5px 10px;
            font-size: 12px;
            position: absolute;
            top: 10px;
            right: 10px;
            border-radius: 4px;
        }

        .profile-info-label {
            color: #4a69bd;
            font-size: 14px;
            font-weight: 700;
            width: 180px;
        }

        .profile-info-value {
            color: #333;
            font-size: 14px;
        }

        .profile-info-value input,
        .profile-info-value select,
        .profile-info-value textarea {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 10px;
            width: 100%;
            font-weight: 400;
            background: #fdfdfd;
        }

        .nav-tabs-custom .nav-link {
            border-radius: 4px;
            margin-right: 5px;
            background: #f4f4f4;
            color: #666;
            border: none;
            font-size: 13px;
            padding: 8px 20px;
        }

        .nav-tabs-custom .nav-link.active {
            background: #3c4b64;
            color: #fff;
        }

        .table-info-profile td {
            border-bottom: 2px solid #eeeeee !important;
            padding: 12px 5px;
            vertical-align: top;
        }

        .table-info-profile tr:last-child td {
            border-bottom: none !important;
        }

        .table-info-profile {
            width: 100%;
        }

        .section-title {
            border-left: 4px solid #4a69bd;
            padding-left: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .profile-card {
                padding: 15px;
            }

            .col-md-10.border-left {
                border-left: none !important;
                margin-top: 20px;
            }

            .col-md-6.border-right {
                border-right: none !important;
            }

            .table-info-profile {
                display: block;
                width: 100%;
                border: 1px solid #eee;
                border-radius: 8px;
                margin-bottom: 15px;
            }

            .table-info-profile tbody {
                display: block;
                width: 100%;
            }

            .table-info-profile tr {
                display: block;
                width: 100%;
                padding: 12px 15px;
                border-bottom: 1px solid #eee;
            }

            .table-info-profile tr:last-child {
                border-bottom: none;
            }

            .profile-info-label {
                width: 100%;
                display: block;
                font-size: 14px;
                color: #4a69bd;
                font-weight: bold;
                padding: 0 !important;
                margin-bottom: 5px;
                border: none !important;
            }

            .table-info-profile td:nth-child(2) {
                display: none !important;
            }

            .profile-info-value {
                width: 100%;
                display: block;
                font-size: 14px;
                color: #333;
                padding: 0 !important;
                border: none !important;
            }

            .profile-photo {
                max-width: 150px;
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            .btn-photo {
                left: 50%;
                transform: translateX(-50%);
                right: auto;
                bottom: -10px;
                top: auto;
                width: 100px;
            }

            .nav-tabs-custom {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 5px;
                -webkit-overflow-scrolling: touch;
            }

            .nav-tabs-custom .nav-item {
                flex: 0 0 auto;
            }

            .table-info-profile td {
                display: block;
                width: 100%;
                padding: 0 !important;
                border: none !important;
            }
        }

        @media (max-width: 576px) {
            .profile-info-label {
                width: 110px;
            }

            .table-info-profile td:nth-child(2) {
                width: 5px !important;
            }
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('profile.update', 0) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-0">
                            @if ($user->is_mahasiswa || $mahasiswa)
                                Data Mahasiswa
                            @elseif($dosen)
                                Data Dosen
                            @elseif($pegawai)
                                Data Pegawai
                            @else
                                Data Profil
                            @endif
                            <small class="text-muted">{{ request('edit') ? 'Edit Profil' : 'Detail Profil' }}</small>
                        </h4>
                    </div>
                    <div class="d-flex">
                        @if (request('edit'))
                            <button type="submit" class="btn btn-success btn-sm mr-2 py-2 px-3 rounded"><i
                                    class="fa fa-save"></i> Simpan</button>
                            <a href="{{ route('profile.index') }}"
                                class="btn btn-warning btn-sm text-white py-2 px-3 rounded"><i class="fa fa-undo"></i>
                                Batal</a>
                        @else
                            <a href="{{ route('profile.index', ['edit' => 1]) }}"
                                class="btn btn-primary btn-sm mr-2 py-2 px-3 rounded"><i class="fa fa-edit"></i> Edit</a>
                        @endif
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="profile-card">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="position-relative mb-3">
                                <img src="{{ $profile && $profile->foto ? asset('storage/' . $profile->foto) : asset('assets/images/user.png') }}"
                                    alt="Profile Photo" class="profile-photo w-100" id="profileImagePreview">
                                <button type="button" class="btn-photo"
                                    onclick="document.getElementById('fotoInput').click()">Ganti Foto</button>
                                <input type="file" name="foto" id="fotoInput" style="display: none;" accept="image/*">
                            </div>
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item px-0 py-2 border-0"><a href="#"
                                        class="text-primary font-weight-bold">{{ request('edit') ? 'Edit Detail Profil' : 'Detail Profil' }}</a>
                                </li>
                                @if (!request('edit'))
                                    <li class="list-group-item px-0 py-2 border-0"><a href="#"
                                            class="text-dark">Jadwal
                                            Minggu
                                            Ini</a></li>
                                    <li class="list-group-item px-0 py-2 border-0"><a href="#"
                                            class="text-dark">Akademik</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-10 border-left">
                            <div class="row">
                                <div class="col-md-6 border-right">
                                    <table class="table-info-profile">
                                        @if ($user->is_mahasiswa || $mahasiswa)
                                            <tr>
                                                <td class="profile-info-label">NPM</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <input type="text" name="npm"
                                                            value="{{ old('npm', $mahasiswa->npm ?? '') }}">
                                                    @else
                                                        {{ $mahasiswa->npm ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="profile-info-label">Fakultas</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <select name="fakultas" id="fakultas" class="form-control rounded">
                                                            <option value="">Pilih Fakultas</option>
                                                            <option disabled>=================================</option>
                                                            <option value="Fakultas Sains dan Teknologi"
                                                                {{ old('fakultas', $mahasiswa->fakultas ?? '') == 'Fakultas Sains dan Teknologi' ? 'selected' : '' }}>
                                                                Fakultas Sains dan Teknologi</option>
                                                            <option value="Fakultas Ekonomi dan Bisnis"
                                                                {{ old('fakultas', $mahasiswa->fakultas ?? '') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>
                                                                Fakultas Ekonomi dan Bisnis</option>
                                                            <option value="Fakultas Ilmu Kesehatan"
                                                                {{ old('fakultas', $mahasiswa->fakultas ?? '') == 'Fakultas Ilmu Kesehatan' ? 'selected' : '' }}>
                                                                Fakultas Ilmu Kesehatan</option>
                                                        </select>
                                                    @else
                                                        {{ $mahasiswa->fakultas ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="profile-info-label">Program Studi</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <select name="program_studi_id" id="program_studi_id"
                                                            class="form-control rounded" data-live-search="true">
                                                            <option value="">Pilih Program Studi</option>
                                                            @foreach ($programStudis as $ps)
                                                                <option value="{{ $ps->id }}"
                                                                    {{ old('program_studi_id', $mahasiswa->program_studi_id ?? '') == $ps->id ? 'selected' : '' }}>
                                                                    {{ $ps->program_studi }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        {{ $mahasiswa->programStudi->program_studi ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if (request('edit'))
                                                <tr>
                                                    <td class="profile-info-label">Jenjang Pendidikan</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">
                                                        <select name="jenjang_pendidikan" id="jenjang_pendidikan"
                                                            class="form-control rounded">
                                                            <option selected disabled>Pilih Jenjang Pendidikan</option>
                                                            <option disabled>=================================</option>
                                                            <option value="S-1"
                                                                {{ old('jenjang_pendidikan', $mahasiswa->jenjang_pendidikan ?? '') == 'S-1' ? 'selected' : '' }}>
                                                                S-1</option>
                                                            <option value="S-2"
                                                                {{ old('jenjang_pendidikan', $mahasiswa->jenjang_pendidikan ?? '') == 'S-2' ? 'selected' : '' }}>
                                                                S-2</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr>
                                                <td class="profile-info-label">NIP</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <input type="text" name="nip"
                                                            value="{{ old('nip', $pegawai->nip ?? ($dosen->nip ?? '')) }}">
                                                    @else
                                                        {{ $pegawai->nip ?? ($dosen->nip ?? '-') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="profile-info-label">NIDN</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <input type="text" name="nidn"
                                                            value="{{ old('nidn', $pegawai->nidn ?? ($dosen->nidn ?? '')) }}">
                                                    @else
                                                        {{ $pegawai->nidn ?? ($dosen->nidn ?? '-') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="profile-info-label">NUPTK</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <input type="text" name="nuptk"
                                                            value="{{ old('nuptk', $dosen->nuptk ?? '') }}">
                                                    @else
                                                        {{ $dosen->nuptk ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="profile-info-label">NIDK</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="text" name="nidk"
                                                        value="{{ old('nidk', $profile->nidk ?? '') }}">
                                                @else
                                                    {{ $profile->nidk ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="profile-info-label">NUPN</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="text" name="nupn"
                                                        value="{{ old('nupn', $profile->nupn ?? '') }}">
                                                @else
                                                    {{ $profile->nupn ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="profile-info-label">NBM</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="text" name="nbm"
                                                        value="{{ old('nbm', $profile->nbm ?? '') }}">
                                                @else
                                                    {{ $profile->nbm ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="profile-info-label">Nama @if ($user->is_mahasiswa || $mahasiswa)
                                                    Mahasiswa
                                                @elseif($dosen)
                                                    Dosen
                                                @else
                                                    Pegawai
                                                @endif
                                            </td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="text" name="name"
                                                        value="{{ old('name', $user->name) }}" required>
                                                @else
                                                    {{ $user->is_mahasiswa || $mahasiswa ? $user->name : $dosen->nama_dosen ?? ($pegawai->nama_staff ?? $user->name) }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table-info-profile">
                                        @if (!($user->is_mahasiswa || $mahasiswa))
                                            <tr>
                                                <td class="profile-info-label">Gelar Depan</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <input type="text" name="gelar_depan"
                                                            value="{{ old('gelar_depan', $profile->gelar_depan ?? '') }}">
                                                    @else
                                                        {{ $profile->gelar_depan ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="profile-info-label">Gelar Belakang</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <input type="text" name="gelar_belakang"
                                                            value="{{ old('gelar_belakang', $profile->gelar_belakang ?? '') }}">
                                                    @else
                                                        {{ $profile->gelar_belakang ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="profile-info-label">Jenis Kelamin</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <select name="jenis_kelamin">
                                                        <option value="">- Pilih -</option>
                                                        <option value="L"
                                                            {{ old('jenis_kelamin', $profile->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                                                            Laki-laki</option>
                                                        <option value="P"
                                                            {{ old('jenis_kelamin', $profile->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                                                            Perempuan</option>
                                                    </select>
                                                @else
                                                    {{ ($profile->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : (($profile->jenis_kelamin ?? '') == 'P' ? 'Perempuan' : '-') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="profile-info-label">Tempat Lahir</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="text" name="tempat_lahir"
                                                        value="{{ old('tempat_lahir', $profile->tempat_lahir ?? ($mahasiswa->tempat_lahir ?? ($pegawai->tempat_lahir ?? ($dosen->tempat_lahir ?? '')))) }}">
                                                @else
                                                    {{ $profile->tempat_lahir ?? ($mahasiswa->tempat_lahir ?? ($pegawai->tempat_lahir ?? ($dosen->tempat_lahir ?? '-'))) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="profile-info-label">Tanggal Lahir</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="date" name="tgl_lahir"
                                                        value="{{ old('tgl_lahir', $profile->tgl_lahir ?? ($mahasiswa->tgl_lahir ?? ($pegawai->tgl_lahir ?? ($dosen->tgl_lahir ?? '')))) }}">
                                                @else
                                                    @php
                                                        $tgl =
                                                            $profile->tgl_lahir ??
                                                            ($mahasiswa->tgl_lahir ??
                                                                ($pegawai->tgl_lahir ?? ($dosen->tgl_lahir ?? null)));
                                                    @endphp
                                                    {{ $tgl ? \Carbon\Carbon::parse($tgl)->isoFormat('D MMMM YYYY') : '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="profile-info-label">Agama</td>
                                            <td style="width: 10px;">:</td>
                                            <td class="profile-info-value">
                                                @if (request('edit'))
                                                    <input type="text" name="agama"
                                                        value="{{ old('agama', $profile->agama ?? '') }}">
                                                @else
                                                    {{ $profile->agama ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($user->is_mahasiswa || $mahasiswa)
                                            <tr>
                                                <td class="profile-info-label">Semester</td>
                                                <td style="width: 10px;">:</td>
                                                <td class="profile-info-value">
                                                    @if (request('edit'))
                                                        <select name="semester" id="semester"
                                                            class="form-control rounded">
                                                            <option selected disabled>Pilih Semester</option>
                                                            <option disabled>=========================================
                                                            </option>
                                                            @php
                                                                $semesters = [
                                                                    'I (Satu)',
                                                                    'II (Dua)',
                                                                    'III (Tiga)',
                                                                    'IV (Empat)',
                                                                    'V (Lima)',
                                                                    'VI (Enam)',
                                                                    'VII (Tujuh)',
                                                                    'VIII (Delapan)',
                                                                    'IX (Sembilan)',
                                                                    'X (Sepuluh)',
                                                                    'XI (Sebelas)',
                                                                    'XII (Dua Belas)',
                                                                ];
                                                            @endphp
                                                            @foreach ($semesters as $s)
                                                                <option value="{{ $s }}"
                                                                    {{ old('semester', $mahasiswa->semester ?? '') == $s ? 'selected' : '' }}>
                                                                    {{ $s }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        {{ $mahasiswa->semester ?? '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <ul class="nav nav-tabs nav-tabs-custom mt-4 mb-3 border-0" id="profileTab"role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="kontak-tab" data-toggle="tab" href="#kontak"
                                        role="tab">Kontak</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="kepegawaian-tab" data-toggle="tab" href="#kepegawaian"
                                        role="tab">
                                        @if ($user->is_mahasiswa || $mahasiswa)
                                            Akademik
                                        @else
                                            Kepegawaian
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pembimbing-tab" data-toggle="tab" href="#pembimbing"
                                        role="tab">Pembimbing</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lain-tab" data-toggle="tab" href="#lain"
                                        role="tab">Lain-lain</a>
                                </li>
                            </ul>

                            <div class="tab-content px-2" id="profileTabContent">
                                <div class="tab-pane fade show active" id="kontak" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 border-right">
                                            <table class="table-info-profile">
                                                <tr>
                                                    <td class="profile-info-label">No. Telepon</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">
                                                        @if (request('edit'))
                                                            <input type="text" name="no_telp"
                                                                value="{{ old('no_telp', $profile->no_telp ?? '') }}">
                                                        @else
                                                            {{ $profile->no_telp ?? '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="profile-info-label">No. HP Utama</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">
                                                        @if (request('edit'))
                                                            <input type="text" name="no_wa"
                                                                value="{{ old('no_wa', $profile->no_wa ?? ($mahasiswa->no_wa ?? ($pegawai->no_wa ?? ($dosen->no_wa ?? '')))) }}">
                                                        @else
                                                            {{ $profile->no_wa ?? ($mahasiswa->no_wa ?? ($pegawai->no_wa ?? ($dosen->no_wa ?? '-'))) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="profile-info-label">Kepemilikan No HP
                                                        Utama</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">Milik Sendiri</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table-info-profile">
                                                <tr>
                                                    <td class="profile-info-label">Email Kampus</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="profile-info-label">Email Pribadi</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">
                                                        @if (request('edit'))
                                                            <input type="email" name="email_pribadi"
                                                                value="{{ old('email_pribadi', $profile->email_pribadi ?? '') }}">
                                                        @else
                                                            {{ $profile->email_pribadi ?? '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="profile-info-label">Alamat Rumah</td>
                                                    <td style="width: 10px;">:</td>
                                                    <td class="profile-info-value">
                                                        @if (request('edit'))
                                                            <textarea name="alamat" rows="2">{{ old('alamat', $profile->alamat ?? ($mahasiswa->alamat ?? ($pegawai->alamat ?? ($dosen->alamat ?? '')))) }}</textarea>
                                                        @else
                                                            {{ $profile->alamat ?? ($mahasiswa->alamat ?? ($pegawai->alamat ?? ($dosen->alamat ?? '-'))) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kepegawaian" role="tabpanel">
                                    <p class="p-3 text-muted">Informasi @if ($user->is_mahasiswa || $mahasiswa)
                                            akademik
                                        @else
                                            kepegawaian
                                        @endif belum tersedia.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('fotoInput').onchange = function(evt) {
            const [file] = this.files
            if (file) {
                document.getElementById('profileImagePreview').src = URL.createObjectURL(file);

                // Auto submit jika tidak sedang dalam mode edit profil
                @if (!request('edit'))
                    this.closest('form').submit();
                @endif
            }
        }
    </script>
@endpush
