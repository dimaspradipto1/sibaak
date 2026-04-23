# Mybaak - Sistem Informasi & Arsip Akademik

<p align="center">
    <img src="public/assets/images/logouis.png" width="180" alt="UIS Logo">
</p>

Mybaak adalah platform manajemen informasi dan pengarsipan akademik modern yang dirancang untuk efisiensi administrasi di lingkungan institusi pendidikan. Sistem ini menggabungkan kemudahan akses data dengan teknologi pencarian cerdas.

---

## 🚀 Fitur Unggulan

### 🔍 Semantic Search (Google-Style)
Mesin pencari arsip cerdas dengan antarmuka yang familiar seperti Google. Memungkinkan pengguna menemukan dokumen akademik, SK, dan LPJ dengan cepat menggunakan algoritma pencarian yang efisien.

### 📰 Portal Artikel & Informasi
Modul manajemen konten yang memungkinkan admin mempublikasikan berita, pengumuman, dan materi tutorial dengan tampilan yang profesional dan responsif.
- **Rich Text Editor**: Penulisan artikel yang fleksibel.
- **Media Support**: Dukungan gambar sampul dan embed video YouTube.
- **Categorized Content**: Pengelompokan informasi berdasarkan tipe.

### 🎓 Layanan Mahasiswa Digital
Digitalisasi layanan administratif mahasiswa untuk mempercepat proses birokrasi:
- **Surat Keterangan Aktif**: Pengajuan dan verifikasi surat aktif secara online.
- **Surat Layanan Akademik**: Manajemen berbagai jenis surat akademik lainnya.

### 📂 Manajemen Arsip Terstruktur
Penyimpanan dokumen penting dalam kategori yang rapi:
- **Arsip Utama**, **SK Kepanitiaan**, **LPJ Kepanitiaan**.
- **Kurikulum Prodi**, **Pedoman**, **SOP Akademik**, dan **Wasdalbin**.

### 🛡️ Advanced Role-Based Access Control (RBAC)
Sistem keamanan tingkat tinggi dengan matriks hak akses yang mendetail:
- Konfigurasi izin akses (View, Add, Edit, Delete) per modul.
- Manajemen peran pengguna (Admin, Pegawai, Dosen, Mahasiswa).

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10 (PHP Framework)
- **Frontend**: Blade Templating, Bootstrap 4, Premium Custom CSS
- **Database**: MySQL / MariaDB
- **DataTables**: Server-side processing untuk manajemen data besar
- **Security**: Laravel Gates & Spatie Permission inspired logic

---

## ⚙️ Instalasi & Persiapan

1. **Clone repositori**
   ```bash
   git clone https://github.com/username/mybaak.git
   ```

2. **Instal dependensi**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin `.env.example` menjadi `.env` dan sesuaikan database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Seeding**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

---

## 🎨 Desain & Antarmuka
Mybaak mengedepankan estetika **Premium & Modern** dengan:
- **Responsive Layout**: Optimal di desktop, tablet, maupun mobile.
- **Rounded UI**: Konsistensi elemen rounded/pill-shaped untuk kesan modern.
- **Boxed Dashboard**: Layout dashboard yang rapi dan terorganisir.

---

## 📄 Lisensi
Sistem ini bersifat Open-Source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).

---
<p align="center">Dikembangkan dengan ❤️ untuk Institusi Pendidikan yang Lebih Digital.</p>
