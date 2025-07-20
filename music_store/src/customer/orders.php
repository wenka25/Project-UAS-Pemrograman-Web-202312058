<?php
include '../middleware/auth_customer.php';
require_once '../config/database.php';

$user_id = $_SESSION['user']['id'];
$orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");

include '../includes/header.php';
include '../includes/navbar_customer.php';
?>

<style>
    .order-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .order-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .status-badge {
        padding: 6px 12px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    .order-date {
        font-weight: 500;
        color: #333;
    }
    .order-time {
        font-size: 0.85rem;
    }
    .empty-state {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Tombol Kembali -->
        <div>
            <button onclick="history.back()" class="btn btn-sm btn-outline-secondary rounded-pill me-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </button>
        </div>

        <!-- Judul Halaman -->
        <h4 class="fw-semibold mb-0">Riwayat Pesanan</h4>

        <!-- Tanggal Hari Ini -->
        <div class="text-muted small">
            <i class="fas fa-calendar-alt me-1"></i>
            <?= date('d M Y') ?>
        </div>
    </div>

    <!-- Notifications -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- List Order -->
    <?php if (mysqli_num_rows($orders) > 0): ?>
        <div class="row g-3">
            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card order-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="order-date"><?= date('d M Y', strtotime($order['order_date'])) ?></span>
                                    <span class="order-time text-muted d-block"><?= date('H:i', strtotime($order['order_date'])) ?></span>
                                </div>
                                <span class="status-badge rounded-pill 
                                    <?= 
                                        $order['status'] == 'completed' ? 'bg-success-light text-success' : 
                                        ($order['status'] == 'processing' ? 'bg-primary-light text-primary' : 
                                        ($order['status'] == 'cancelled' ? 'bg-danger-light text-danger' : 'bg-secondary text-white'))
                                    ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                            
                            <h5 class="fw-bold mb-3">Rp<?= number_format($order['total'], 0, ',', '.') ?></h5>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if ($order['status'] === 'completed' || $order['status'] === 'cancelled'): ?>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="if(confirm('Yakin ingin menghapus pesanan ini?')) { window.location.href='delete_order.php?id=<?= $order['id'] ?>' }">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted small">Tersimpan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-3">
            <div class="empty-state text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-box-open text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-semibold mb-2">Belum ada riwayat pesanan</h5>
                <p class="text-muted mb-4">Pesanan yang Anda buat akan muncul di sini</p>
                <a href="../customer/all_product.php" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
.bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
.bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
</style>

<?php include '../includes/footer.php'; ?>