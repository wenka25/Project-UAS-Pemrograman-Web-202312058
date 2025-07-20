<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

$order_id = $_GET['id'];

// Ambil data pesanan
$order = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT o.*, u.name AS customer 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = $order_id
"));

// Ambil item pesanan
$items = mysqli_query($conn, "
    SELECT oi.*, p.name 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = $order_id
");
?>

<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0">Detail Transaksi</h4>
                <a href="sales.php" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- Bukti Pembayaran Section -->
            <div class="mb-4">
                <h5 class="fw-medium mb-3">Bukti Pembayaran</h5>
                <?php if (!empty($order['payment_proof'])): ?>
                    <div class="border rounded-3 p-3 d-inline-block">
                        <img src="<?= BASE_URL . 'uploads/payments/' . $order['payment_proof'] ?>" 
                             class="img-fluid rounded-2" 
                             style="max-height: 300px;"
                             alt="Bukti Pembayaran">
                        <div class="mt-2">
                            <a href="<?= BASE_URL . 'uploads/payments/' . $order['payment_proof'] ?>" 
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                               <i class="fas fa-expand me-1"></i> Lihat Full Size
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning rounded-3 d-inline-block">
                        <i class="fas fa-exclamation-circle me-1"></i> Belum ada bukti pembayaran
                    </div>
                <?php endif; ?>
            </div>

            <!-- Order Info -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="text-muted mb-2">Customer</h6>
                        <p class="fw-medium mb-0"><?= htmlspecialchars($order['customer']) ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="text-muted mb-2">Tanggal</h6>
                        <p class="fw-medium mb-0"><?= date('d M Y H:i', strtotime($order['order_date'])) ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="text-muted mb-2">Status</h6>
                        <p class="fw-medium mb-0">
                            <span class="badge rounded-pill 
                                <?= $order['status'] === 'completed' ? 'bg-success' : 
                                   ($order['status'] === 'processing' ? 'bg-primary' : 'bg-secondary') ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; while ($item = mysqli_fetch_assoc($items)) : 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td class="text-end">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="text-end"><?= $item['quantity'] ?></td>
                            <td class="text-end fw-medium">Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr class="border-top">
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-end fw-bold text-primary">Rp<?= number_format($total, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>