<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

$orders = mysqli_query($conn, "
    SELECT o.*, u.name AS customer_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.order_date DESC
");
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Order Management</h2>
            <p class="text-muted small">View and manage customer orders</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary rounded-pill px-3 dropdown-toggle" 
                        type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">All Orders</a></li>
                    <li><a class="dropdown-item" href="#">Completed</a></li>
                    <li><a class="dropdown-item" href="#">Processing</a></li>
                    <li><a class="dropdown-item" href="#">Cancelled</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 text-uppercase small text-muted fw-semibold">Date</th>
                            <th class="text-uppercase small text-muted fw-semibold">Customer</th>
                            <th class="text-uppercase small text-muted fw-semibold">Status</th>
                            <th class="text-uppercase small text-muted fw-semibold">Amount</th>
                            <th class="pe-4 text-end text-uppercase small text-muted fw-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($orders)) : ?>
                        <tr class="border-top">
                            <td class="ps-4">
                                <div class="fw-medium"><?= date('d M Y', strtotime($row['order_date'])) ?></div>
                                <div class="text-muted small"><?= date('H:i', strtotime($row['order_date'])) ?></div>
                            </td>
                            <td class="fw-semibold"><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td>
                                <span class="badge rounded-pill py-2 px-3 
                                    <?= 
                                        $row['status'] == 'completed' ? 'bg-success bg-opacity-10 text-success' : 
                                        ($row['status'] == 'processing' ? 'bg-primary bg-opacity-10 text-primary' : 
                                        ($row['status'] == 'cancelled' ? 'bg-danger bg-opacity-10 text-danger' : 'bg-secondary bg-opacity-10 text-secondary')) 
                                    ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td class="fw-semibold">Rp<?= number_format($row['total']) ?></td>
                            <td class="pe-4 text-end">
                                <a href="edit.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                   title="Edit Order">
                                   <i class="fas fa-pencil-alt me-1"></i> Edit
                                </a>
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
    .badge {
        font-weight: 500;
    }
    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .card {
        border: none;
    }
</style>