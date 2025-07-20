<?php
include '../middleware/auth_customer.php';
require_once '../config/database.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if ($query !== '') {
    $search = mysqli_real_escape_string($conn, $query);
    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.name LIKE '%$search%' OR c.name LIKE '%$search%'
            ORDER BY p.created_at DESC";
    $results = mysqli_query($conn, $sql);
}

include '../includes/header.php';
include '../includes/navbar_customer.php';
?>

<style>
    .product-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #ffffff;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .product-image {
        height: 200px;
        object-fit: contain;
        background: #f9f9f9;
        padding: 20px;
    }
    .category-badge {
        background: rgba(0,0,0,0.05);
        color: #555;
        font-weight: 500;
    }
    .action-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .price-text {
        color: #4a6bff;
        font-weight: 600;
    }
    .search-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
</style>

<div class="container py-4">
    <div class="search-header">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="fw-semibold mb-0">Search Results</h4>
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
        <p class="text-muted mb-0">Showing results for: <strong>"<?= htmlspecialchars($query) ?>"</strong></p>
    </div>

    <?php if ($results && mysqli_num_rows($results) > 0): ?>
        <div class="row g-4">
            <?php while ($product = mysqli_fetch_assoc($results)) : ?>
                <div class="col-md-4">
                    <div class="card h-100 product-card">
                        <img src="../assets/images/<?= htmlspecialchars($product['image']) ?>" 
                             class="product-image w-100" 
                             alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge category-badge mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                                <h5 class="card-title fw-semibold mb-1"><?= htmlspecialchars($product['name']) ?></h5>
                            </div>
                            <div class="mt-auto">
                                <p class="price-text mb-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <!-- Detail Button -->
                                    <a href="product_detail.php?id=<?= $product['id'] ?>" 
                                       class="btn btn-sm btn-outline-dark action-btn rounded-circle"
                                       data-bs-toggle="tooltip" title="Detail">
                                       <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Cart Form -->
                                    <form action="cart.php" method="POST" class="flex-grow-1">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill w-100 py-2">
                                            <i class="fas fa-shopping-cart me-1"></i> Add
                                        </button>
                                    </form>

                                    <!-- Wishlist Button -->
                                    <form action="../customer/wishlists/add.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary action-btn rounded-circle"
                                                data-bs-toggle="tooltip" title="Wishlist">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Review Button -->
                                <a href="./reviews/create.php?product_id=<?= $product['id'] ?>" 
                                   class="btn btn-sm btn-link text-muted w-100 mt-2 px-0">
                                    <i class="far fa-star me-1"></i> Rate this product
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-search fa-3x text-muted"></i>
            </div>
            <h4 class="fw-light mb-3">No products found</h4>
            <p class="text-muted mb-4">Try different keywords or browse our product collection</p>
            <a href="<?= BASE_URL ?>customer/dashboard.php" class="btn btn-primary px-4 rounded-pill">
                Back to Home
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltips.map(el => new bootstrap.Tooltip(el))
});
</script>