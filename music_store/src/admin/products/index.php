<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

$query = "
    SELECT 
        p.*, 
        c.name AS category,
        (SELECT COUNT(*) FROM wishlists w WHERE w.product_id = p.id) AS total_wishlist
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.id DESC
";
$result = mysqli_query($conn, $query);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-0">Product Management</h2>
            <p class="text-muted small mb-0">Manage your product inventory</p>
        </div>
        <a href="create.php" class="btn btn-primary rounded-pill px-3 py-2 shadow-sm">
            <i class="fas fa-plus me-2"></i> Add Product
        </a>
    </div>

    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50" class="ps-4">#</th>
                            <th width="80">Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th width="120">Price</th>
                            <th width="100">Stock</th>
                            <th width="100">Wishlist</th>
                            <th width="120" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr class="border-top">
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td>
                                <img src="../../assets/images/<?= $row['image'] ?>" 
                                     class="rounded-2" 
                                     width="60" 
                                     height="60" 
                                     style="object-fit: cover; border: 1px solid #eee">
                            </td>
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($row['name']) ?></div>
                                <div class="text-muted small">ID: <?= $row['id'] ?></div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= htmlspecialchars($row['category']) ?></span>
                            </td>
                            <td class="fw-semibold">Rp<?= number_format($row['price']) ?></td>
                            <td>
                                <span class="badge rounded-pill <?= $row['stock'] > 0 ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' ?>">
                                    <?= $row['stock'] ?> <?= $row['stock'] > 0 ? 'available' : 'sold out' ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-heart text-danger me-2"></i>
                                    <span class="fw-medium"><?= $row['total_wishlist'] ?></span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="edit.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary rounded-start-pill px-3"
                                       title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" 
                                       onclick="return confirm('Are you sure you want to delete this product?')" 
                                       class="btn btn-sm btn-outline-danger rounded-end-pill px-3"
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<style>
    .table {
        --bs-table-hover-bg: rgba(0, 0, 0, 0.02);
    }
    .table th {
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
        padding: 1rem 0.5rem;
    }
    .table tr:first-child {
        border-top: none;
    }
    .btn-group .btn {
        border-width: 1px;
    }
    .badge.bg-light {
        background-color: rgba(0, 0, 0, 0.05) !important;
    }
</style>