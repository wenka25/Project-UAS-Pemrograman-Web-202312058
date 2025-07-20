<?php
session_start();
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_customer.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>

<div class="container mt-4">
    <h4>Tambah Alamat Pengiriman</h4>
    <form action="store.php" method="POST">
        <div class="mb-3">
            <label>Nama Penerima</label>
            <input type="text" name="recipient_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Kota</label>
            <input type="text" name="city" class="form-control">
        </div>
        <div class="mb-3">
            <label>Provinsi</label>
            <input type="text" name="province" class="form-control">
        </div>
        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="postal_code" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Alamat</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
