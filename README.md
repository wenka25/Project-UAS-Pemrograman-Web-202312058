## 🎵 Doremigo Music – Aplikasi Penjualan Alat Musik (PHP Native)

**Doremigo Music** adalah aplikasi web e-commerce berbasis **PHP Native** dan **MySQL** yang dibuat untuk memenuhi tugas akhir mata kuliah Pemrograman Web. Aplikasi ini dirancang untuk memudahkan proses penjualan alat musik secara online, dengan memisahkan peran pengguna menjadi dua: **Admin** (penjual) dan **Customer** (pembeli).

---

## 🚀 Tujuan dan Manfaat

* Membantu pengguna dalam membeli alat musik secara online.
* Memberikan sistem pengelolaan produk, transaksi, dan pelaporan bagi admin.
* Memberikan pengalaman pembelajaran dalam membangun aplikasi web PHP Native dari sisi backend dan frontend.

---

## 💡 Fitur Utama

### Untuk Customer:

* Registrasi dan login
* Menjelajah dan mencari produk
* Wishlist (daftar keinginan)
* Checkout dan pengelolaan alamat pengiriman
* Upload bukti pembayaran
* Memberi review dan rating produk

### Untuk Admin:

* Login ke dashboard admin
* CRUD Produk dan Kategori
* Manajemen Pesanan
* Verifikasi Pembayaran
* Laporan Penjualan

---

## 📂 Teknologi yang Digunakan

* PHP Native (tanpa framework)
* MySQL
* HTML, CSS, Bootstrap
* Apache (Laragon/XAMPP)

---

## 📁 Struktur Repositori

```
src/
├── admin/                # Halaman admin (produk, pesanan, laporan)
├── assets/images/        # Gambar produk dan ikon
├── auth/                 # Login, registrasi, logout
├── config/               # Koneksi database
├── customer/             # Halaman customer (produk, checkout, wishlist)
├── includes/             # Header, footer, navbar
├── middleware/           # Proteksi auth per role
├── uploads/              # File bukti pembayaran
├── generate_password.php # Tool hash password
└── index.php             # Beranda utama
```

---

## 🔧 Instalasi dan Konfigurasi

* Persyaratan: PHP >= 7.4, MySQL, Apache, Laragon/XAMPP
* Clone repositori ke folder `www` atau `htdocs`
* Import database `music_store.sql`
* Konfigurasi file `config/database.php`
* Akses aplikasi melalui `http://localhost/music_store`

Detail instalasi lengkap ada di: [`docs/INSTALLATION.md`](/music_store/docs/INSTALLATION.md)

---

## 📊 Struktur Database

Database terdiri dari tabel:

* `users`, `products`, `categories`
* `orders`, `order_items`, `payments`
* `shipping_addresses`, `reviews`, `wishlists`, `contacts`

Lihat penjelasan dan ERD di: [`docs/DATABASE.md`](/music_store/docs/DATABASE.md)

---

## 🌐 Panduan Penggunaan

Panduan penggunaan aplikasi oleh customer dan admin ada di:
[`docs/USAGE.md`](/music_store/docs/USAGE.md)

---

## 🔐 Keamanan

* Password menggunakan bcrypt hashing
* Middleware untuk proteksi akses per role
* Validasi input dan upload file

---

## 🙋 Kontak

**Wenka**
📧 [wenkasalinding04@gmail.com](mailto:wenkasalinding04@gmail.com)

## 📺 Link Youtube
Video Penjelasan tentang web: [Link Youtube](https://youtu.be/BtbPgo681Wo)

---

### 🌐 Hosting
Web Doremigo Music: [doremigomusic.rf.gd](https://doremigomusic.rf.gd/)