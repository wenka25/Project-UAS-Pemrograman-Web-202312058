<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Product Categories</h2>
            <p class="text-muted small">Manage your product categories</p>
        </div>
        <a href="create.php" class="btn btn-primary rounded-pill px-3 py-2 shadow-sm">
            <i class="fas fa-plus me-2"></i> Add Category
        </a>
    </div>

    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="60" class="ps-4 text-uppercase small text-muted fw-semibold">#</th>
                            <th class="text-uppercase small text-muted fw-semibold">Category</th>
                            <th class="text-uppercase small text-muted fw-semibold">Description</th>
                            <th width="150" class="pe-4 text-end text-uppercase small text-muted fw-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($categories)) : ?>
                            <tr class="border-top">
                                <td class="ps-4 text-muted"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold"><?= htmlspecialchars($row['name']) ?></div>
                                </td>
                                <td>
                                    <div class="text-muted small"><?= htmlspecialchars($row['description']) ?></div>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-outline-primary rounded-start-pill px-3"
                                           title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id'] ?>" 
                                           onclick="return confirm('Are you sure you want to delete this category?')" 
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
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.5rem;
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
        transition: all 0.2s ease;
    }
    .btn-group .btn:hover {
        transform: translateY(-1px);
    }
    .card {
        border: none;
    }
</style>