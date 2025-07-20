<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

$payments = mysqli_query($conn, "
SELECT p.*, o.order_date, u.name AS customer
FROM payments p
JOIN orders o ON p.order_id = o.id
JOIN users u ON o.user_id = u.id
ORDER BY p.payment_date DESC
");
?>

<div class="container mt-4">
    <h4>Verifikasi Pembayaran</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal Bayar</th>
                <th>Customer</th>
                <th>Bank</th>
                <th>Pengirim</th>
                <th>Bukti</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_assoc($payments)) : ?>
            <tr>
                <td><?= $p['payment_date'] ?></td>
                <td><?= htmlspecialchars($p['customer']) ?></td>
                <td><?= htmlspecialchars($p['bank_name']) ?></td>
                <td><?= htmlspecialchars($p['sender_name']) ?></td>
                <td>
                    <a href="../../uploads/payments/<?= $p['proof'] ?>" target="_blank">Lihat Bukti</a>
                </td>
                <td>
                    <?= ucfirst($p['status']) ?>
                </td>
                <td>
                    <?php if ($p['status'] == 'pending'): ?>
                        <a href="verify.php?id=<?= $p['id'] ?>&action=verify" class="btn btn-success btn-sm">Verifikasi</a>
                        <a href="verify.php?id=<?= $p['id'] ?>&action=reject" class="btn btn-danger btn-sm">Tolak</a>
                    <?php else: ?>
                        <span class="text-muted">Sudah <?= $p['status'] ?></span>
                    <?php endif ?>
                </td>
            </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
