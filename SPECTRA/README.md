# SPECTRA (System for Project, Earnings, & Comprehensive Task Reporting Analysis)

**SPECTRA** adalah platform internal resmi PT. SatSet MerahPutih Indonesia (sebelumnya bernama SATSET Intelligence System). Sistem ini dirancang untuk mengatur *workflow* dari hulu ke hilir, mulai dari absensi pekerja lapangan (Korlap), pelaporan progres proyek harian, manajemen closing deal proyek, perhitungan bagi hasil otomatis (Skema 5:3:1:1), hingga pelaporan keuangan terpadu bagi level Direksi.

## 🌟 Fitur Utama (Hilir ke Hulu)

1. **Korlap (Koordinator Lapangan)**
   - Absensi lapangan harian berbasis **Auto-GPS Tracking**.
   - Input laporan progres harian (Deskripsi + Upload Foto).
   - Pantau Rekapitulasi Gaji dan Bagi Hasil yang diterima.

2. **Manager Area**
   - Registrasi *Closing Deal* / Proyek Baru beserta nilai kontrak.
   - Papan monitoring aktivitas Korlap dan Pekerja (Absensi & Laporan).
   - Papan **Kalkulator & Approval Skema 5:3:1:1** otomatis untuk setiap nilai kontrak yang berhasil diamankan.

3. **Finance (Keuangan)**
   - Menerima antrian pembayaran gaji dan bagi hasil yang telah disetujui Manager Area.
   - Tombol "Realisasi Bayar" untuk memproses pencairan.
   - Papan input **Biaya Operasional (Expenses)** untuk proyek.

4. **Direksi & General Manager**
   - **Dashboard Laba/Rugi Konsolidasi:** Melihat margin EBITDA bersih dari total pemasukan kontrak vs pengeluaran riil (Gaji + Operasional).
   - Ekspor laporan formal berformat PDF (`dompdf`).
   - Sistem peringkat kompetitif (Gamifikasi) per wilayah/area.

---

## 🛠️ Prasyarat (Requirements)

Pastikan server atau lokal mesin Anda memiliki spesifikasi berikut sebelum instalasi:
- **PHP** >= 8.2
- **Composer** (untuk PHP dependencies)
- **Node.js & NPM** (untuk kompilasi aset Frontend/Tailwind)
- **MySQL / MariaDB** (untuk Database)
- Ekstensi PHP: `pdo_mysql`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`, `zip`.

---

## 🚀 Panduan Instalasi Langkah-demi-Langkah

### 1. Clone / Siapkan Repositori
Masuk ke direktori `htdocs` (XAMPP) atau direktori root server Anda, lalu ekstrak / paste folder `SPECTRA` ini. Buka terminal/command prompt di dalam folder `SPECTRA`.

### 2. Instalasi Dependensi PHP & Frontend
Jalankan perintah berikut secara berurutan untuk menginstal semua *library* dan *packages*:

```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Environment & Database
1. Buat database baru di MySQL (misal melalui phpMyAdmin), berikan nama `db_spectra` (atau nama lain yang Anda inginkan).
2. Salin file konfigurasi bawaan Laravel:
   - Di Windows: `copy .env.example .env`
   - Di Mac/Linux: `cp .env.example .env`
3. Buka file `.env` yang baru saja dibuat. Ubah pengaturan database agar terhubung dengan database yang Anda buat di langkah pertama:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_spectra
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 4. Generate Application Key
Jalankan perintah ini untuk mengamankan sesi aplikasi Anda:
```bash
php artisan key:generate
```

### 5. Migrasi & Seeding Database (Penting!)
Agar tabel-tabel di database tercipta dan data *dummy* awal (seperti akun super-admin / contoh role) terisi, jalankan:
```bash
php artisan migrate:fresh --seed
```

### 6. Link Storage (Untuk Upload Foto & File)
Karena fitur Laporan dan Absensi Korlap menggunakan fitur *upload* foto, serta menu Legalitas menggunakan *upload* PDF, wajib lakukan *symlink* folder storage agar file bisa diakses melalui browser:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal
Setelah instalasi selesai, nyalakan aplikasi menggunakan:
```bash
php artisan serve
```
Aplikasi SPECTRA sekarang dapat diakses melalui browser pada alamat: **http://127.0.0.1:8000**

---

## 🎭 Daftar Role untuk Testing (Berdasarkan Seeder)

Jika Anda ingin mencoba fitur aplikasi sesuai *role*, biasanya seeder telah membuatkan akun dengan format umum. Anda bisa mengecek file `database/seeders/DatabaseSeeder.php` untuk melihat *email* dan *password* yang digunakan. 
*(Secara umum password default yang digenerate adalah `password`).*

---

## 🏗️ Stack Teknologi
- **Backend:** Laravel 11.x
- **Frontend / Styling:** Tailwind CSS 3.x, Vanilla CSS (Custom Utilities)
- **Javascript Logic:** Alpine.js (Lightweight interactivity & Mobile Nav)
- **Ikonografi:** FontAwesome 6 (Free)
- **PDF Generator:** `barryvdh/laravel-dompdf`

---

## 🔒 Catatan Keamanan Tambahan
- Pastikan pada environment *Production*, variabel `APP_DEBUG` di file `.env` bernilai `false`.
- Aplikasi ini mencatat *timezone* di `.env`. Pastikan `APP_TIMEZONE` diset sesuai wilayah server operasional (misalnya `Asia/Jakarta`).

---
**Hak Cipta © 2026 PT. SatSet MerahPutih Indonesia.** All rights reserved.
