<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

// Get all orders with customer information
$query = "
    SELECT o.*, u.name AS customer_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.order_date DESC
";
$orders = mysqli_query($conn, $query);

// Calculate summary statistics
$summaryQuery = "
    SELECT 
        COUNT(*) as total_orders,
        SUM(total) as total_revenue,
        SUM(CASE WHEN status = 'completed' THEN total ELSE 0 END) as completed_revenue,
        AVG(total) as avg_order_value
    FROM orders
";
$summary = mysqli_fetch_assoc(mysqli_query($conn, $summaryQuery));
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Sales Dashboard</h2>
            <p class="text-muted small">Comprehensive overview of all orders and sales performance</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary rounded-pill dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-calendar me-1"></i> Filter Period
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Week</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                    <li><a class="dropdown-item" href="#">Custom Range</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Orders</h6>
                            <h3 class="mb-0 fw-bold"><?= number_format($summary['total_orders']) ?></h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0 fw-bold">Rp<?= number_format($summary['total_revenue'], 0, ',', '.') ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-chart-line text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Completed Revenue</h6>
                            <h3 class="mb-0 fw-bold">Rp<?= number_format($summary['completed_revenue'], 0, ',', '.') ?></h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-check-circle text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Avg. Order Value</h6>
                            <h3 class="mb-0 fw-bold">Rp<?= number_format($summary['avg_order_value'], 0, ',', '.') ?></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-dollar-sign text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50" class="ps-4">#</th>
                            <th width="180">Order Date</th>
                            <th>Customer</th>
                            <th width="140">Status</th>
                            <th width="160">Total Amount</th>
                            <th width="120" class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($orders)) : ?>
                        <tr class="border-top">
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td>
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
                            <td class="fw-bold">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td class="text-center pe-4">
                                <a href="sales_detail.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                   title="View Details">
                                   <i class="fas fa-eye me-1"></i> View
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
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
        padding: 1rem 0.5rem;
    }
    .card {
        border: none;
    }
    .badge {
        font-weight: 500;
    }
    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>