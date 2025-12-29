<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Layanan Akademik</title>
    <style>
        body {
            /* font-family: Arial, sans-serif;
            margin: 20px; */
            /* font-family: Arial, sans-serif; */
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.2;
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
            margin-top: 20px;
            text-align: justify;
        }

        .row {
            display: flex;
            justify-content: flex-start;
            margin: 5px 0;
        }

        .col {
            margin-right: 10px;
        }

        .row p {
            margin: 0;
        }

        .details-table {
            margin: 20px 0;
            margin-left: 15px;
        }

        .details-table td {
            font-size: 12px;
            line-height: 1.5;
            padding: 3px 5px;
            text-align: left;
        }

        .details-table td:first-child {
            width: 200px;
        }

        .details-table td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        .details-table td:last-child {
            padding-left: 5px;
        }


        .footer {
            margin-top: 40px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-top: 40px;
            height: 150px;
        }

        .signature-item {
            width: 30%;
            text-align: center;
        }

        .signature-item.center {
            width: 35%;
            text-align: center;
            flex-grow: 1;
        }

        .signature-item p {
            margin-top: 5px;
            font-size: 12px;
        }

        .signature-item strong {
            margin-top: 10px;
            font-size: 12px;
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

<body onload="window.print()">
    <?php
    use Carbon\Carbon;
    
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

    <!-- Kop Surat Section -->
    <div class="kop-surat">
        <!-- Logo Universitas Ibnu Sina -->
        <img src="{{ asset('dashboard/assets/images/logouis.png') }}" alt="Logo Universitas Ibnu Sina">

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
    <table class="letter-header" style="width: 100%; text-align: center; margin-top: -20px;">
        <tr>
            <td colspan="3" style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                FORMULIR LAYANAN AKADEMIK</td>
        </tr>
    </table>

    <div class="row">
        <div class="col">
            <p>Fakultas</p>
        </div>
        <div class="col">
            <p style="margin-left: 185px;">:</p>
        </div>
        <div class="col">
            <p>{{ $fakultas }}</p>
        </div>
    </div>


    <div class="content">
        <p style="font-size: 12px; line-height: 0.5;">
            Yang bertanda tangan di bawah ini:
        </p>
    </div>

    <table class="details-table">
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">NAMA</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5; margin-left: -20px;">
                {{ $suratAkademik->user->name }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">NPM</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->npm }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">Semester</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->semester }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">Prodi</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->programStudi->program_studi }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">Sudah/Belum Pernah Cuti</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->status_cuti }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">Alamat/No. Telp/HP</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->alamat }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">Mengajukan Permohonan</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->permohonan }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; line-height: 1.5;">Alasan Cuti Akademik</td>
            <td style="font-size: 12px; line-height: 1.5;">:</td>
            <td style="font-size: 12px; line-height: 1.5;">
                {{ $suratAkademik->alasan_cuti }}
            </td>
        </tr>
    </table>

    <div class="content">
        <p style="font-size: 12px; line-height: 1.5;">
            Sebagai bahan pertimbangan bersama ini kami lampirkan:
        </p>
        <ol style="font-size: 12px; line-height: 1.5; margin-top: -10px;">
            <li>Surat Pernyataan Mahasiswa Cuti/Pindah Prodi/Pindah Kelas</li>
            <li>KHS Terakhir</li>
            <li>Surat Keterangan lain yang relevan (Surat Keterangan Sakit, Surat Keterangan Bekerja dll)</li>
        </ol>
        <p style="font-size: 12px; line-height: 1.5;">
            Atas perhatian saudara kami ucapkan terima kasih.
        </p>
    </div>

    <!-- Signature Section with multiple signatures -->
    <div class="signature-section">
        <!-- Signature 1: Pembimbing Akademik -->
        <div class="signature-item" style="margin-top: -60px;">
            <p>Mengetahui/Menyetujui</p>
            <p style="margin-top: -10px;">Pembimbing Akademik</p>
            <p style="margin-top: 70px;">(.......................................)</p>
        </div>

        <!-- Signature 2: Hormat Saya -->
        <div class="signature-item" style="margin-top: -60px;">
            <p>Batam, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p style="margin-top: -10px;">Hormat Saya</p>
            <p style="margin-top: 70px;">{{ $suratAkademik->user->name }}</p>
        </div>
    </div>

    <!-- Signature Section with "Ka. Prodi" centered -->
    <div class="signature-section" style="margin-top: -85px;">
        <!-- Signature 3: Ka. Prodi (Centered) -->
        <div class="signature-item center">
            <p>Ketua Prodi</p>
            <p style="margin-top: 70px;">(.......................................)</p>
        </div>
    </div>

    <!-- Signature Section with "Ka. BAAK" and "Ka. BAUK" -->
    <div class="signature-section">
        <!-- Signature 4: Ka. BAAK -->
        <div class="signature-item" style="margin-top: -130px;">
            <p>Ka. BAAK</p>
            <p style="margin-top: 90px; text-decoration: underline; font-weight: bold;">Leni Utami,MKM</p>
            <p style="margin-top: -12px;">NIDN. 1001057904</p>
        </div>

        <!-- Signature 5: Ka. BAUK -->
        <div class="signature-item" style="margin-top: -130px;">
            <p>Ka. BAUK</p>
            <p style="margin-top: 90px; margin-left: -10px; text-decoration: underline; font-weight: bold;">Andi
                Hidayatul Fadila, SE., M.Si.AK</p>
            <p style="margin-top: -12px;">NIDN. 1011088401</p>
        </div>
    </div>

    <!-- Footer Section -->
    {{-- <div class="footer" style="margin-top: 90px;">
        <p>Tembusan:</p>
        <p style="margin-left: 25px; margin-bottom: 30px; margin-top: -10px;">- Arsip</p>
    </div> --}}

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
