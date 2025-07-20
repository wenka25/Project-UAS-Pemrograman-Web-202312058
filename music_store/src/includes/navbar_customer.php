<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../config/database.php';
    session_start(); // Pastikan session aktif
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>customer/dashboard.php">
      <i class="fas fa-music me-2 text-primary"></i>Doremigo<span class="text-primary">Music</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="d-flex flex-column flex-lg-row w-100 align-items-lg-center">

        <!-- Search Bar -->
        <form class="d-flex my-2 my-lg-0 me-lg-3 flex-grow-1" action="<?= BASE_URL ?>customer/search.php" method="GET">
          <div class="input-group search-container">
            <input class="form-control border-end-0 ps-3" type="search" name="q" placeholder="Cari produk..." aria-label="Search" required>
            <button class="btn btn-outline-secondary border-start-0 bg-transparent" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>

        <!-- Navigation Items -->
        <ul class="navbar-nav ms-lg-auto d-flex flex-row">
          <li class="nav-item mx-lg-1">
            <a class="nav-link px-3 py-2 position-relative" href="<?= BASE_URL ?>customer/contacts/index.php">
              <i class="far fa-comment-dots"></i>
              <span class="d-none d-lg-inline ms-2">Kontak</span>
            </a>
          </li>

          <li class="nav-item mx-lg-1">
            <a class="nav-link px-3 py-2 position-relative" href="<?= BASE_URL ?>customer/wishlists/index.php">
              <i class="far fa-heart"></i>
              <span class="d-none d-lg-inline ms-2">Wishlist</span>
            </a>
          </li>

          <li class="nav-item mx-lg-1">
            <a class="nav-link px-3 py-2 position-relative" href="<?= BASE_URL ?>customer/cart.php">
              <i class="fas fa-shopping-bag"></i>
              <span class="d-none d-lg-inline ms-2">Keranjang</span>
            </a>
          </li>

          <li class="nav-item dropdown mx-lg-1">
            <a class="nav-link px-3 py-2 rounded-circle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" style="width: 40px; height: 40px;">
              <i class="fas fa-user-circle"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2">
              <li><h6 class="dropdown-header">Halo, <?= isset($_SESSION['customer_name']) ? htmlspecialchars($_SESSION['customer_name']) : 'Pelanggan' ?></h6></li>
              <li><hr class="dropdown-divider my-1"></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>customer/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>customer/orders.php"><i class="fas fa-clipboard-list me-2"></i>Pesanan</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>customer/payments/index.php"><i class="fas fa-credit-card me-2"></i>Pembayaran</a></li>
              <li><hr class="dropdown-divider my-1"></li>
              <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<style>
body {
  padding-top: 72px; /* sedikit lebih kecil dari sebelumnya */
}

.navbar {
  padding: 0.75rem 0;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  backdrop-filter: blur(8px);
  background-color: rgba(255,255,255,0.85);
}

.navbar-brand {
  font-size: 1.25rem;
  letter-spacing: 0.5px;
}

.nav-link {
  color: #333;
  font-weight: 500;
  transition: all 0.2s ease;
  border-radius: 20px;
}

.nav-link:hover {
  color: var(--bs-primary);
  background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.nav-link i {
  font-size: 1.1rem;
}

.dropdown-menu {
  border: none;
  box-shadow: 0 5px 25px rgba(0,0,0,0.08);
  border-radius: 12px;
  padding: 0.5rem 0;
  margin-top: 8px !important;
}

.dropdown-item {
  padding: 0.5rem 1.25rem;
  border-radius: 6px;
  margin: 0 0.25rem;
  font-size: 0.9rem;
}

.dropdown-item:hover {
  background-color: rgba(var(--bs-primary-rgb), 0.08);
}

.dropdown-header {
  font-size: 0.8rem;
  font-weight: 600;
  color: #6c757d;
  padding: 0.25rem 1.25rem;
}

.search-container {
  max-width: 400px;
}

.search-container .form-control {
  border-radius: 20px 0 0 20px !important;
  padding: 0.5rem 1rem;
  border-color: #ddd;
}

.search-container .btn {
  border-radius: 0 20px 20px 0 !important;
  padding: 0 1rem;
  border-color: #ddd;
}

.search-container .btn:hover {
  background-color: rgba(var(--bs-primary-rgb), 0.1);
}

@media (max-width: 991.98px) {
  .search-container {
    max-width: 100%;
  }
}
</style>