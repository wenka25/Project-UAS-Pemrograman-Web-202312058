<?php
session_start();
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_customer.php';

$id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

$query = "SELECT * FROM shipping_addresses WHERE id = $id AND user_id = $user_id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h4>Edit Alamat Pengiriman</h4>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="mb-3">
            <label>Nama Penerima</label>
            <input type="text" name="recipient_name" value="<?= $data['recipient_name'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="phone" value="<?= $data['phone'] ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control" required><?= $data['address'] ?></textarea>
        </div>
        <div class="mb-3">
            <label>Kota</label>
            <input type="text" name="city" value="<?= $data['city'] ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Provinsi</label>
            <input type="text" name="province" value="<?= $data['province'] ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="postal_code" value="<?= $data['postal_code'] ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
