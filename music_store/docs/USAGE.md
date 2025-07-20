# 📘 PANDUAN PENGGUNAAN APLIKASI

Dokumen ini menjelaskan cara menggunakan fitur-fitur utama dalam aplikasi penjualan alat musik, baik sebagai **Customer (Pembeli)** maupun **Admin (Penjual)**.

---

## 🔐 1. Autentikasi Pengguna

### 🔸 Registrasi Customer
1. Akses halaman: `/auth/register.php`
2. Isi nama, email, password
3. Setelah berhasil, akan diarahkan ke halaman login

### 🔸 Login
- Halaman login: `/auth/login.php`
- User login dibedakan berdasarkan peran (admin atau customer)

### 🔸 Logout
- Link logout terdapat di navbar, atau akses `/auth/logout.php`

---

## 🧑‍💼 2. Modul Customer

### 🛍️ Menjelajah Produk
- Halaman utama: `/index.php` atau `/customer/all_product.php`
- Tampilkan semua produk dengan gambar, nama, harga
- Tersedia fitur pencarian dan filter kategori

### ❤️ Wishlist
- Klik tombol "❤️ Tambah ke Wishlist"
- Wishlist disimpan di `/customer/wishlist/index.php`
- Bisa dihapus kapan saja oleh user

### ⭐ Ulasan Produk
- Setelah melakukan pembelian, customer bisa memberikan ulasan
- Form ulasan: `/customer/reviews.php`
- Ulasan ditampilkan di halaman detail produk

### 📦 Checkout
1. Tambahkan produk ke keranjang (opsional)
2. Isi alamat pengiriman (bisa dipilih jika sudah pernah menambahkan)
3. Sistem akan membuat pesanan dengan status `pending`
4. Redirect ke halaman upload bukti pembayaran

### 💳 Pembayaran
- Halaman upload bukti: `/customer/payments/index.php`
- Input metode pembayaran, tanggal bayar, dan upload bukti (jika ada)
- Admin akan memverifikasi pembayaran melalui panel admin

---

## 🛠️ 3. Modul Admin

### 🔐 Login Admin
- Login dengan akun admin yang telah ditentukan
- Otomatis diarahkan ke `/admin/dashboard.php`

### 📦 Manajemen Produk
- Tambah, edit, hapus produk via:
  `/admin/products/index.php`
- Tambah kategori produk juga bisa di halaman:
  `/admin/categories/index.php`

### 📋 Manajemen Pesanan
- Daftar pesanan: `/admin/orders/index.php`
- Admin bisa ubah status pesanan menjadi:
  - `pending`, `paid`, `shipped`, `completed`, `cancelled`

### 💸 Konfirmasi Pembayaran
- Lihat daftar pembayaran masuk
- Validasi bukti pembayaran dan update status pesanan

### 📊 Laporan
- Menampilkan laporan penjualan, jumlah pesanan, dan pendapatan
- Laporan tersedia di halaman: `/admin/reports/sales_detail.php` (jika diaktifkan)

---

## 🧭 4. Navigasi Umum

### Navigasi Customer:
- **Beranda:** `/index.php`
- **Produk:** `/customer/all_product.php`
- **Keranjang / Checkout:** `/customer/cart.php`
- **Wishlist:** `/customer/wishlist/index.php`
- **Akun & Logout:** `/auth/logout.php`

### Navigasi Admin:
- **Dashboard:** `/admin/dashboard.php`
- **Produk:** `/admin/products/index.php`
- **Pesanan:** `/admin/orders/index.php`
- **Pembayaran:** `/admin/payments/index.php`
- **Kategori:** `/admin/categories/index.php`
- **Logout:** `/auth/logout.php`

---

## 🧪 Akun Default (Opsional)

Jika kamu ingin langsung mencoba aplikasi, berikut akun dummy:

### 🔹 Admin
- **Email:** admin@example.com
- **Password:** 12345678

### 🔹 Customer
- **Email:** user@example.com
- **Password:** 12345678

> ⚠️ Jangan gunakan akun default di lingkungan produksi.

---

## ❓ FAQ

### Q: Saya tidak bisa login meski email & password benar?
- Cek apakah password di-hash. Gunakan `generate_password.php` untuk membuat hash.

---

