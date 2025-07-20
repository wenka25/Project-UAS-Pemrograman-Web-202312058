<?php
include '../middleware/auth_customer.php';
require_once '../config/database.php';

$user_id = $_SESSION['user']['id'];
$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($cart)) {
        $_SESSION['error'] = "Keranjang belanja kosong";
        header("Location: cart.php");
        exit;
    }

    $shipping_address_id = $_POST['shipping_address_id'] ?? null;
    if (!$shipping_address_id) {
        $_SESSION['error'] = "Alamat pengiriman belum dipilih";
        header("Location: checkout.php");
        exit;
    }

    // Calculate total
    $total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert order
        $insert_order = "INSERT INTO orders (user_id, shipping_address_id, order_date, status, total)
                         VALUES (?, ?, NOW(), 'pending', ?)";
        $stmt = mysqli_prepare($conn, $insert_order);
        mysqli_stmt_bind_param($stmt, "iid", $user_id, $shipping_address_id, $total);
        mysqli_stmt_execute($stmt);
        $order_id = mysqli_insert_id($conn);

        // Insert order items
        $insert_items = "INSERT INTO order_items (order_id, product_id, quantity, price)
                         VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_items);
        
        foreach ($cart as $item) {
            mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item['id'], $item['qty'], $item['price']);
            mysqli_stmt_execute($stmt);
        }

        // Commit transaction
        mysqli_commit($conn);
        
        // Clear cart
        unset($_SESSION['cart']);
        $_SESSION['success'] = "Pesanan berhasil dibuat!";
        header("Location: orders.php");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error'] = "Terjadi kesalahan saat memproses pesanan";
        header("Location: checkout.php");
        exit;
    }
}

// Get shipping addresses
$addresses = mysqli_query($conn, "SELECT * FROM shipping_addresses WHERE user_id = $user_id");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar_customer.php'; ?>

<style>
    .checkout-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        max-width: 700px;
    }
    .checkout-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 1rem;
    }
    .address-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
    }
    .address-select:focus {
        border-color: #6c5ce7;
        box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.15);
    }
    .add-address-link {
        color: #6c5ce7;
        font-size: 0.9rem;
    }
</style>

<div class="container py-4">
    <div class="card checkout-card border-0 mx-auto">
        <div class="card-body p-4 p-md-5">
            <!-- Header -->
            <div class="checkout-header text-center mb-4">
                <h4 class="fw-semibold mb-3">Checkout</h4>
                <div class="d-flex justify-content-center">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Total: Rp<?= number_format(array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart)), 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <!-- Notifications -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger rounded-3 mb-4">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Address Selection -->
            <?php if (mysqli_num_rows($addresses) === 0): ?>
                <div class="alert alert-light text-center rounded-3 border mb-4">
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt text-muted" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-medium mb-2">Belum ada alamat pengiriman</h5>
                    <p class="text-muted mb-3">Tambahkan alamat pengiriman untuk melanjutkan checkout</p>
                    <a href="shipping_addresses/create.php" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-plus me-2"></i> Tambah Alamat
                    </a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-medium mb-3 d-block">Alamat Pengiriman</label>
                        <select name="shipping_address_id" class="form-select address-select" required>
                            <option value="">-- Pilih Alamat --</option>
                            <?php while ($addr = mysqli_fetch_assoc($addresses)) : ?>
                                <option value="<?= $addr['id'] ?>">
                                    <?= htmlspecialchars($addr['recipient_name']) ?> - 
                                    <?= htmlspecialchars($addr['address']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <div class="text-end mt-3">
                            <a href="shipping_addresses/create.php" class="add-address-link text-decoration-none">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Alamat Baru
                            </a>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-3 mt-5">
                        <button type="submit" class="btn btn-primary rounded-pill py-3 fw-medium">
                            <i class="fas fa-check-circle me-2"></i> Konfirmasi Pesanan
                        </button>
                        <a href="cart.php" class="btn btn-outline-secondary rounded-pill py-3">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>