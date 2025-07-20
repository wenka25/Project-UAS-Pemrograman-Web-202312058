<?php
require_once '../config/database.php';
include '../includes/header.php';
include '../includes/navbar_customer.php';

if (!isset($_GET['id'])) {
    echo "<div class='container py-5 text-center'><h5 class='fw-medium'>Produk tidak ditemukan</h5></div>";
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<div class='container py-5 text-center'><h5 class='fw-medium'>Produk tidak ditemukan</h5></div>";
    exit;
}
?>

<div class="container py-4">

    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="all_product.php" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Produk
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="bg-light rounded-3 p-4 d-flex justify-content-center align-items-center" style="min-height: 400px;">
                <img src="../assets/images/<?= htmlspecialchars($product['image']) ?>" 
                     class="img-fluid" 
                     style="max-height: 400px; object-fit: contain;"
                     alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="d-flex flex-column h-100">
                <div class="mb-3">
                    <h2 class="fw-semibold mb-2"><?= htmlspecialchars($product['name']) ?></h2>
                    <h3 class="text-primary fw-bold">Rp <?= number_format($product['price'], 0, ',', '.') ?></h3>
                </div>
                
                <div class="mb-4">
                    <h5 class="fw-medium mb-2">Deskripsi Produk</h5>
                    <div class="text-muted lh-lg" style="text-align: justify;">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>
                </div>
                
                <div class="mt-auto">
                    <form action="cart.php" method="POST" class="mb-2">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        
                        <div class="d-flex align-items-center mb-3">
                            <label for="qty" class="fw-medium me-3">Jumlah:</label>
                            <input type="number" name="qty" id="qty" value="1" min="1" 
                                   class="form-control rounded-pill" style="width: 80px;">
                        </div>
                        
                        <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 mb-2">
                            <i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang
                        </button>
                    </form>

                    <form action="../customer/wishlists/add.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
                            <i class="fas fa-heart me-2"></i> Tambah ke Wishlist
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
