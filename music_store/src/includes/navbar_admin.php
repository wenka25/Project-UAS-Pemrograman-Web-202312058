<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>admin/dashboard.php">
            <i class="fas fa-cog me-2 text-primary"></i>Admin<span class="text-primary">Panel</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded" href="<?= BASE_URL ?>admin/dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded" href="<?= BASE_URL ?>admin/categories/index.php">
                        <i class="fas fa-tags me-1"></i> Kategori
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded" href="<?= BASE_URL ?>admin/products/index.php">
                        <i class="fas fa-box-open me-1"></i> Produk
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded" href="<?= BASE_URL ?>admin/orders/index.php">
                        <i class="fas fa-shopping-cart me-1"></i> Pesanan
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 py-2 rounded" href="<?= BASE_URL ?>admin/reports/sales.php">
                        <i class="fas fa-chart-line me-1"></i> Laporan
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown mx-1">
                    <a class="nav-link px-3 py-2 rounded dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        <span class="d-none d-lg-inline">Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
body {
    padding-top: 70px; /* penting agar konten tidak ketutup navbar */
}

.navbar {
    padding: 0.75rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    z-index: 1030; /* pastikan navbar selalu di atas */
}
.nav-link {
    transition: all 0.2s;
}
.nav-link:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}
.dropdown-menu {
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-radius: 0.5rem;
}
.navbar-brand {
    font-size: 1.25rem;
}
</style>
