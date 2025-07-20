<?php
include '../middleware/auth_customer.php';
require_once '../config/database.php';

// Handle POST from product page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];
    $qty = (int) ($_POST['qty'] ?? 1);

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => $qty,
                'image' => $product['image']
            ];
        } else {
            $_SESSION['cart'][$product_id]['qty'] += $qty;
        }
    }

    header("Location: cart.php");
    exit;
}

include '../includes/header.php';
include '../includes/navbar_customer.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<style>
    .cart-table {
        --bs-table-bg: transparent;
    }
    .cart-table thead th {
        border-bottom: 1px solid #eee;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .cart-item-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        background: #f9f9f9;
        border-radius: 8px;
        padding: 10px;
    }
    .qty-badge {
        background: #f8f9fa;
        font-weight: 500;
        min-width: 40px;
    }
    .empty-cart-icon {
        font-size: 5rem;
        color: #e9ecef;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="fw-semibold mb-0 text-center">Keranjang Belanja</h4>
        <span class="badge bg-primary rounded-pill px-3 py-2">
            <?= count($cart) ?> Item
        </span>
    </div>

    <?php if (!empty($cart)): ?>
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table cart-table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php foreach ($cart as $item): 
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="../assets/images/<?= $item['image'] ?? 'default.jpg' ?>" 
                                         class="cart-item-img" 
                                         alt="<?= htmlspecialchars($item['name']) ?>">
                                    <span class="fw-medium"><?= htmlspecialchars($item['name']) ?></span>
                                </div>
                            </td>
                            <td class="text-end align-middle">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="text-center align-middle">
                                <span class="badge qty-badge rounded-pill py-2">
                                    <?= $item['qty'] ?>
                                </span>
                            </td>
                            <td class="text-end align-middle fw-bold">Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                            <td class="text-end align-middle">
                                <a href="remove_from_cart.php?id=<?= $item['id'] ?>" 
                                   class="btn btn-sm btn-link text-danger"
                                   onclick="return confirm('Hapus produk ini dari keranjang?')">
                                   <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Total Belanja:</h5>
                    <h4 class="fw-bold text-primary mb-0">Rp<?= number_format($total, 0, ',', '.') ?></h4>
                </div>
                <a href="checkout.php" 
                   class="btn btn-primary rounded-pill py-3 w-100 <?= $total == 0 ? 'disabled' : '' ?>">
                   <i class="fas fa-credit-card me-2"></i> Lanjut ke Pembayaran
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart empty-cart-icon"></i>
            </div>
            <h5 class="fw-semibold mb-3">Keranjang Belanja Kosong</h5>
            <p class="text-muted mb-4">Tambahkan produk ke keranjang untuk mulai berbelanja</p>
            <a href="../customer/all_product.php" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fas fa-store me-2"></i> Jelajahi Produk
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>