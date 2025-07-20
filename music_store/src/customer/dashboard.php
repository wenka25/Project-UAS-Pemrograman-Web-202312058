<?php
include '../middleware/auth_customer.php';
require_once '../config/database.php';

$user_id = $_SESSION['user']['id'];

// Get order and payment counts
$orders = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE user_id = $user_id");
$order_total = mysqli_fetch_assoc($orders)['total'];

$payments = mysqli_query($conn, "SELECT COUNT(*) as total FROM payments WHERE order_id IN (SELECT id FROM orders WHERE user_id = $user_id)");
$payment_total = mysqli_fetch_assoc($payments)['total'];

// Get featured products
$products = mysqli_query($conn, "SELECT * FROM products LIMIT 4");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar_customer.php'; ?>

<style>
    .stat-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .product-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .product-image {
        height: 160px;
        object-fit: contain;
        background: #f9f9f9;
        padding: 20px;
    }
    .new-badge {
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
</style>

<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?></h4>
            <div class="text-muted small">
                <i class="fas fa-calendar-alt me-1"></i>
                <?= date('d M Y') ?>
            </div>
        </div>
        <div>
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <a href="<?= BASE_URL ?>customer/orders.php" class="text-decoration-none text-dark">
                <div class="card stat-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Pesanan</h6>
                                <h2 class="fw-bold mb-0"><?= $order_total ?></h2>
                                <small class="text-muted">Pesanan yang pernah Anda buat</small>
                            </div>
                            <div class="stat-icon bg-primary-light">
                                <i class="fas fa-shopping-bag text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="<?= BASE_URL ?>customer/payments/index.php" class="text-decoration-none text-dark">
                <div class="card stat-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Pembayaran</h6>
                                <h2 class="fw-bold mb-0"><?= $payment_total ?></h2>
                                <small class="text-muted">Pembayaran dikonfirmasi</small>
                            </div>
                            <div class="stat-icon bg-success-light">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Produk Pilihan</h4>
        <a href="<?= BASE_URL ?>customer/all_product.php" class="btn btn-sm btn-outline-primary rounded-pill">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-4">
        <?php while ($product = mysqli_fetch_assoc($products)) : ?>
        <div class="col-md-3">
            <div class="card product-card h-100">
                <div class="position-relative">
                    <img src="../assets/images/<?= htmlspecialchars($product['image']) ?>" 
                         class="product-image w-100" 
                         alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary new-badge">BARU</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-1"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text fw-bold text-primary mb-2">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                    <a href="<?= BASE_URL ?>customer/product_detail.php?id=<?= $product['id'] ?>" 
                       class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<style>
.bg-primary-light {
    background-color: rgba(13, 110, 253, 0.1);
}
.bg-success-light {
    background-color: rgba(25, 135, 84, 0.1);
}
</style>

<?php include '../includes/footer.php'; ?>