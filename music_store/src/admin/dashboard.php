<?php
include '../middleware/auth_admin.php';
require_once '../config/database.php';
include '../includes/header.php';
include '../includes/navbar_admin.php';

// Query ringkasan data
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'customer'"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$total_payments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM payments WHERE status = 'verified'"))['total'];
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-dark mb-0">Dashboard Overview</h2>
        <div class="text-muted"><?= date('l, d F Y') ?></div>
    </div>

    <div class="row g-4">
        <!-- Customer Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-3 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold small">Customers</h6>
                            <h3 class="mb-0 fw-bold"><?= $total_users ?></h3>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-circle">
                            <i class="fas fa-users fa-lg text-blue-500"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-semibold">Total registered</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-3 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold small">Products</h6>
                            <h3 class="mb-0 fw-bold"><?= $total_products ?></h3>
                        </div>
                        <div class="bg-green-50 p-3 rounded-circle">
                            <i class="fas fa-boxes fa-lg text-green-500"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-semibold">Available products</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-3 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold small">Orders</h6>
                            <h3 class="mb-0 fw-bold"><?= $total_orders ?></h3>
                        </div>
                        <div class="bg-orange-50 p-3 rounded-circle">
                            <i class="fas fa-shopping-cart fa-lg text-orange-500"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-semibold">Total orders</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-3 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold small">Payments</h6>
                            <h3 class="mb-0 fw-bold"><?= $total_payments ?></h3>
                        </div>
                        <div class="bg-teal-50 p-3 rounded-circle">
                            <i class="fas fa-check-circle fa-lg text-teal-500"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-semibold">Verified payments</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional dashboard sections can be added here -->
    <div class="row mt-4 g-4">
        <div class="col-lg-8">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Recent Activity</h5>
                    <!-- Activity content would go here -->
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <p>Activity chart will be displayed here</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="products/index.php" class="btn btn-outline-primary text-start py-2">
                            <i class="fas fa-plus me-2"></i> Add New Product
                        </a>
                        <a href="orders/" class="btn btn-outline-success text-start py-2">
                            <i class="fas fa-list me-2"></i> View Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

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
        transition: all 0.3s ease;
    }
    .bg-blue-50 { background-color: rgba(59, 130, 246, 0.1); }
    .bg-green-50 { background-color: rgba(16, 185, 129, 0.1); }
    .bg-orange-50 { background-color: rgba(249, 115, 22, 0.1); }
    .bg-teal-50 { background-color: rgba(20, 184, 166, 0.1); }
    .text-blue-500 { color: #3b82f6; }
    .text-green-500 { color: #10b981; }
    .text-orange-500 { color: #f97316; }
    .text-teal-500 { color: #14b8a6; }
</style>