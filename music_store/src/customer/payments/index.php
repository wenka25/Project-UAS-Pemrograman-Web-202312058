<?php
include '../../middleware/auth_customer.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_customer.php';

$user_id = $_SESSION['user']['id'];

$query = "
SELECT o.*, p.status AS payment_status 
FROM orders o 
LEFT JOIN payments p ON p.order_id = o.id
WHERE o.user_id = $user_id AND o.status IN ('pending', 'paid')
ORDER BY o.order_date DESC";

$orders = mysqli_query($conn, $query);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Tombol Kembali -->
        <div>
            <button onclick="history.back()" class="btn btn-sm btn-outline-secondary rounded-pill me-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </button>
        </div>

        <!-- Judul Halaman -->
        <h4 class="fw-semibold mb-0">Konfirmasi Pembayaran</h4>

        <!-- Tanggal Hari Ini -->
        <div class="text-muted small">
            <i class="fas fa-calendar-alt me-1"></i>
            <?= date('d M Y') ?>
        </div>
    </div>


    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="180">Tanggal Pesanan</th>
                            <th width="150">Total</th>
                            <th width="150">Status Pesanan</th>
                            <th width="150">Status Pembayaran</th>
                            <th width="120" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($orders)) : ?>
                        <tr>
                            <td>
                                <span class="d-block fw-medium"><?= date('d M Y', strtotime($row['order_date'])) ?></span>
                                <small class="text-muted"><?= date('H:i', strtotime($row['order_date'])) ?></small>
                            </td>
                            <td class="fw-bold">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge rounded-pill 
                                    <?= $row['status'] == 'paid' ? 'bg-success-light text-success' : 'bg-warning-light text-warning' ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill 
                                    <?= 
                                        empty($row['payment_status']) ? 'bg-secondary' : 
                                        ($row['payment_status'] == 'confirmed' ? 'bg-success-light text-success' : 'bg-info-light text-info')
                                    ?>">
                                    <?= empty($row['payment_status']) ? 'Belum Ada' : ucfirst($row['payment_status']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="confirm.php?order_id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-primary rounded-pill px-3">
                                   <i class="fas fa-check-circle me-1"></i> Konfirmasi
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
.bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
.bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
</style>

<?php include '../../includes/footer.php'; ?>