<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Aktif</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/logouis.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #525659;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            color: #333;
            font-size: 13px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            background: #fff;
            padding: 20px 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                padding: 20px 40px;
                box-shadow: none;
                width: 100%;
                min-height: auto;
            }

            .catatan {
                margin-top: 100px !important;
            }
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat img {
            float: left;
            width: 100px;
            margin-right: 10px;
        }

        .kop-surat h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: green;
        }

        .kop-surat h2 {
            font-size: 36px;
            margin: 0;
            color: green;
        }

        .kop-surat h3 {
            font-size: 24px;
            margin: 0;
            color: red;
        }

        .kop-surat p {
            font-size: 16px;
            margin: 5px 0;
            color: black;
            margin-left: 110px;
        }

        .kop-surat .contact-info {
            margin-top: 5px;
            font-size: 14px;
        }

        .kop-surat hr {
            border: none;
            border-top: 3px solid green;
            margin: 2px 0;
        }

        .kop-surat hr.thin {
            border-top: 1px solid green;
        }

        .letter-header {
            width: 100%;
            margin-bottom: 20px;
        }

        .letter-header td {
            vertical-align: top;
        }

        .letter-header .left {
            text-align: left;
        }

        .letter-header .right {
            text-align: right;
        }

        .subject {
            margin-top: 20px;
            font-weight: bold;
        }

        .content {
            margin-top: 10px;
            text-align: justify;
        }

        .details-table {
            margin: 10px 0;
            margin-left: 50px;
        }

        .details-table td {
            padding: 5px 0;
        }

        .details-table td:first-child {
            width: 150px;
        }

        .details-table td:nth-child(2) {
            width: 10px;
        }

        .footer {
            margin-top: 40px;
        }

        .signature-section {
            margin-top: 40px;
            position: relative;
            width: 100%;
            height: 150px;
            text-align: left;
        }

        .signature-section img.stamp {
            width: 230px;
            opacity: 1;
            position: relative;
            margin-left: -130px;
            margin-top: -20px;
        }

        .signature-section img.cap {
            width: 150px;
            opacity: 1;
            position: relative;
            margin-left: -80px;
            margin-top: -30px;
            margin-bottom: -10px;
        }

        .signature-section .text {
            position: absolute;
            top: 20px;
            right: 0;
            text-align: left;
        }

        .signature-section .text p {
            margin: 0;
            font-size: 14px;
        }

        .signature-section .text strong {
            font-size: 14px;
            margin-bottom: 200px;
        }

        .footer {
            font-size: 14px;
        }

        .signature-section .tembusan {
            float: left;
            margin-left: 0;
            text-align: left;
        }
    </style>

</head>

<body @if (!isset($is_preview) || !$is_preview) onload="window.print()" @endif>
    <?php
    use Carbon\Carbon;
    
    // Set locale ke Bahasa Indonesia
    Carbon::setLocale('id');
    
    $bulan = Carbon::now()->format('F Y');
    $petaRomawi = [
        'January' => 'I',
        'February' => 'II',
        'March' => 'III',
        'April' => 'IV',
        'May' => 'V',
        'June' => 'VI',
        'July' => 'VII',
        'August' => 'VIII',
        'September' => 'IX',
        'October' => 'X',
        'November' => 'XI',
        'December' => 'XII',
    ];
    $bulanRomawi = $petaRomawi[date('F', strtotime($bulan))];
    ?>

    <div class="page">
        <!-- Kop Surat Section -->
        <div class="kop-surat">
            <!-- Logo Universitas Ibnu Sina -->
            <img src="{{ asset('assets/images/logouis.png') }}" alt="Logo Universitas Ibnu Sina">

            <!-- Informasi Universitas -->
            <div class="text-center">
                <h1>YAYASAN PENDIDIKAN IBNU SINA BATAM (YAPISTA)</h1>
                <h2>UNIVERSITAS IBNU SINA (UIS)</h2>
                <p>Jalan Teuku Umar, Lubuk Baja Kota Batam Indonesia Telp. 0778 425391</p>
                <p>Email: info@uis.ac.id/ibnusina@gmail.com | Website: uis.ac.id</p>
            </div>

            <!-- Garis Pembatas -->
            <hr>
            <hr class="thin">
        </div>

        <!-- Letter Content Section -->
        <table class="letter-header" style="width: 100%; text-align: center; margin-top: 20px;">
            <tr>
                <td colspan="3"
                    style="text-align: center; font-size: 20px; font-weight: bold; text-decoration: underline; margin-bottom: 10px;">
                    SURAT KETERANGAN</td>
            </tr>
            <tr>
                <td class="left" style="text-align: center;">No:
                    {{ str_pad($no_surat, 3, '0', STR_PAD_LEFT) }}/UIS.B1/LL/{{ $bulanRomawi }}/{{ \Carbon\Carbon::now()->format('Y') }}
                </td>
            </tr>
        </table>



        <div class="content">
            <p>
                Yang bertanda tangan di bawah ini:
            </p>
        </div>

        <table class="details-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    {{ $user->name ?? 'Data tidak ditemukan' }}
                </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>Kepala Biro Administrasi Akademik Kemahasiswaan</td>
            </tr>
        </table>
        <div class="content">
            <p>
                Dengan ini menerangkan bahwa:
            </p>
        </div>
        <table class="details-table">
            <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td>{{ $suratAktif->users->name }}</td>
            </tr>
            <tr>
                <td>Tempat/Tgl Lahir</td>
                <td>:</td>
                <td>{{ $suratAktif->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($suratAktif->tgl_lahir)->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td>NPM</td>
                <td>:</td>
                <td>{{ $suratAktif->npm }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $program_studi }}</td>
            </tr>
            <tr>
                <td>Jenjang Pendidikan</td>
                <td>:</td>
                <td>{{ $suratAktif->jenjang_pendidikan }}</td>
            </tr>
        </table>

        <div class="content">
            <p>
                Adalah benar mahasiswa {{ $suratAktif->fakultas }} Universitas Ibnu Sina yang aktif dalam perkuliahan
                dan
                kegiatan akademik pada Semester {{ $suratAktif->status_semester }} Tahun Akademik
                {{ $suratAktif->tahun_akademik }}.
            </p>
            <p>
                Demikian surat keterangan ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.
            </p>
        </div>

        <!-- Signature Section with Stamp -->
        <div class="signature-section">
            <div style="margin-top: 15px; display: flex; justify-content: flex-end;">
                <div style="text-align: left; width: 280px;">
                    <p style="margin: 0;">Batam, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p style="margin: 0;">Universitas Ibnu Sina</p>
                    <p style="margin: 0;">Kepala BAAK</p>

                    <div style="margin-top: 10px; margin-bottom: 5px;">
                        @php
                            $dns2d = new \Milon\Barcode\DNS2D();
                            echo $dns2d->getBarcodeSVG(route('suratAktif.validasi', $suratAktif), 'QRCODE', 2.5, 2.5);
                        @endphp
                    </div>

                    <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                        {{ $pegawai->user->name ?? 'Data tidak ditemukan' }}
                    </p>
                    <p style="margin: 0;">NUP. {{ $pegawai->nup ?? 'Data tidak ditemukan' }}</p>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="footer" style="margin-top: 80px;">
            <p style="margin: 0;">Tembusan:</p>
            <p style="margin-left: 20px; margin-bottom: 2px; margin-top: 0;">- Arsip</p>
        </div>

        <!-- catatan Section -->
        <div class="catatan"
            style="margin-top: 100px; padding-top: 2px; font-size: 10px; font-style: italic; text-align: center;">
            <p style="margin: 2px 0;">Dokumen ini telah ditandatangani secara elektronik yang diterbitkan oleh Biro
                Administrasi Akademik danKemahasiswaan (BAAK)<br>Universitas Ibnu Sina (UIS)</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Array nama bulan dalam bahasa Indonesia
            var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];
            var tanggalSekarang = new Date();
            var tanggal = tanggalSekarang.getDate();
            var namaBulan = bulan[tanggalSekarang.getMonth()];
            var tahun = tanggalSekarang.getFullYear();
            var tanggalIndonesia = `Batam, ${tanggal} ${namaBulan} ${tahun}`;
            document.getElementById("tanggal").textContent = tanggalIndonesia;
        });
    </script>

</body>

</html>
