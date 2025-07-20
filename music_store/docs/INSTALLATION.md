# 🎵 Aplikasi Penjualan Alat Musik - Panduan Instalasi

Panduan ini menjelaskan langkah-langkah instalasi aplikasi **Penjualan Alat Musik** yang dibangun dengan PHP Native & MySQL, menggunakan Laragon sebagai web server lokal. Aplikasi ini mendukung dua peran pengguna: **Admin** dan **Customer**.

---

## 📌 Persyaratan Sistem

Sebelum memulai, pastikan sistem Anda memiliki:

| Komponen       | Keterangan                           |
|----------------|--------------------------------------|
| Laragon        | Disarankan versi terbaru             |
| PHP            | Versi 7.4 atau lebih tinggi          |
| MySQL/MariaDB  | Sudah tersedia dalam Laragon         |
| phpMyAdmin     | Akses melalui `localhost/phpmyadmin` |
| Web browser    | Chrome, Firefox, dll                 |
| Teks editor    | Visual Studio Code (opsional)        |

---

## 📁 Struktur Folder Utama (`src/`)

src/
├── admin/ # Modul admin (produk, pesanan, pembayaran)
├── assets/images/ # Aset gambar produk
├── auth/ # Login, registrasi, logout
├── config/ # Koneksi database dan konfigurasi lainnya
├── customer/ # Modul customer (keranjang, checkout, dll.)
├── includes/ # Komponen UI: header, footer, navbar
├── middleware/ # Middleware untuk otorisasi akses
├── uploads/ # Upload bukti pembayaran atau gambar lainnya
├── generate_password.php # Utility hash password
└── index.php # Halaman utama aplikasi

---

## ⚙️ Langkah Instalasi

---

### 1. Menempatkan Proyek

Letakkan folder `src/` ke dalam direktori Laragon:

> Jika masih bernama `src`, sebaiknya **ubah nama folder ke `music_store`** untuk kemudahan akses.

---

### 2. Setup Database

1. Jalankan Laragon
2. Buka browser dan akses:
3. Buat database baru:
4. Import file SQL:

---

### 3. Konfigurasi Koneksi Database

1. Buka file berikut:
2. music_store/config/database.php
3. Edit konfigurasi sesuai default Laragon:
```php
$host = 'localhost';
$dbname = 'music_store';
$username = 'root';
$password = ''; // kosong (default Laragon)