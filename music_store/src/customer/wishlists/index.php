<?php
session_start();
require_once '../../config/database.php';
include '../../includes/header.php';

// Redirect if not logged in as customer
if (!isset($_SESSION['user'])) {
    header('Location: ../../auth/login.php?redirect=wishlist');
    exit;
}

if ($_SESSION['user']['role'] !== 'customer') {
    header('Location: ../../index.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Get wishlist items with product details
$stmt = $conn->prepare("
    SELECT w.id AS wishlist_id, p.*, 
           (SELECT COUNT(*) FROM wishlists WHERE product_id = p.id) AS total_wishlists
    FROM wishlists w 
    JOIN products p ON w.product_id = p.id 
    WHERE w.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$wishlist_count = $result->num_rows;
?>

<!-- Navigation -->
<?php include '../../includes/navbar_customer.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">My Wishlist</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 me-3">
                <i class="fas fa-heart me-1"></i> <?= $wishlist_count ?> items
            </span>
            <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary rounded-pill me-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <?php if ($wishlist_count > 0): ?>
        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift">
                        <div class="position-relative">
                            <!-- Product Image -->
                            <img src="../../assets/images/<?= htmlspecialchars($row['image']) ?>" 
                                class="card-img-top rounded-top-3" 
                                style="height: 220px; object-fit: contain; background-color: #f8f9fa;"
                                alt="<?= htmlspecialchars($row['name']) ?>">
                            
                            <!-- Remove Button -->
                            <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-sm"
                                    onclick="confirmRemove(<?= $row['wishlist_id'] ?>)">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <!-- Popularity Badge -->
                            <?php if ($row['total_wishlists'] > 5): ?>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark rounded-pill">
                                    <i class="fas fa-fire me-1"></i> Popular
                                </span>
                            <?php endif; ?>
                            
                            <!-- Stock Status -->
                            <span class="position-absolute bottom-0 start-0 m-2 badge <?= $row['stock'] > 0 ? 'bg-success' : 'bg-secondary' ?> rounded-pill">
                                <?= $row['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Product Info -->
                            <h5 class="card-title fw-semibold mb-2"><?= htmlspecialchars($row['name']) ?></h5>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-primary fw-bold fs-4">
                                    Rp<?= number_format($row['price'], 0, ',', '.') ?>
                                </span>
                                <span class="text-muted small">
                                    <i class="fas fa-heart text-danger me-1"></i> <?= $row['total_wishlists'] ?>
                                </span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-2 mt-auto">
                                <a href="../../customer/product_detail.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-outline-primary rounded-pill">
                                   <i class="fas fa-eye me-1"></i> View Details
                                </a>
                                <form action="../cart.php" method="POST" class="d-grid">
                                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-primary rounded-pill" 
                                            <?= $row['stock'] <= 0 ? 'disabled' : '' ?>>
                                        <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <!-- Empty Wishlist State -->
        <div class="text-center py-5 my-5">
            <div class="mb-4">
                <i class="fas fa-heart text-danger" style="font-size: 4rem; opacity: 0.2;"></i>
            </div>
            <h4 class="fw-semibold mb-2">Your Wishlist is Empty</h4>
            <p class="text-muted mb-4">Save your favorite items here for easy access later</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="../all_product.php" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-shopping-bag me-1"></i> Start Shopping
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>

<script>
function confirmRemove(wishlistId) {
    Swal.fire({
        title: 'Remove from Wishlist?',
        text: "Are you sure you want to remove this item?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'remove.php?id=' + wishlistId;
        }
    });
}
</script>

<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card {
        border: none;
    }
    .card-img-top {
        padding: 1.5rem;
    }
    .breadcrumb {
        font-size: 0.875rem;
    }
    .breadcrumb-item a {
        text-decoration: none;
        color: #6c757d;
    }
</style>