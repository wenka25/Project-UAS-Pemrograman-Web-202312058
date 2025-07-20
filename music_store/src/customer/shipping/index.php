<?php
session_start();
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_customer.php';

$user_id = $_SESSION['user']['id'];
$addresses = mysqli_query($conn, "SELECT * FROM shipping_addresses WHERE user_id = '$user_id'");
?>

<div class="container mt-4">
    <h4>Alamat Pengiriman Saya</h4>
    <a href="create.php" class="btn btn-success mb-3">+ Tambah Alamat</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Penerima</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Provinsi</th>
                <th>Kode Pos</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($addresses)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['recipient_name']) ?> (<?= $row['phone'] ?>)</td>
                    <td><?= nl2br(htmlspecialchars($row['address'])) ?></td>
                    <td><?= $row['city'] ?></td>
                    <td><?= $row['province'] ?></td>
                    <td><?= $row['postal_code'] ?></td>
                    <td>
                        <!-- bisa tambahkan fitur edit & delete -->
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin?')" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
