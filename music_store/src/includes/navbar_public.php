<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <i class="fas fa-music me-2 text-primary"></i>Doremigo<span class="text-primary">Music</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarPublic">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item me-3">
          <a href="auth/login.php" class="nav-link px-3 py-2 rounded text-dark">
            <i class="fas fa-sign-in-alt d-lg-none me-2"></i>Masuk
          </a>
        </li>
        <li class="nav-item">
          <a href="auth/register.php" class="btn btn-primary rounded-pill px-3 py-2">
            <i class="fas fa-user-plus me-1"></i>Daftar
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
body {
  padding-top: 70px; /* Sesuaikan jika navbar lebih tinggi */
}
.navbar {
  padding: 1rem 0;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  z-index: 1030;
}
.navbar-brand {
  font-size: 1.5rem;
}
.nav-link {
  transition: all 0.2s;
}
.nav-link:hover {
  color: var(--bs-primary) !important;
}
</style>
