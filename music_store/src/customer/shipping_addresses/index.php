<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_customer.php';

$user_id = $_SESSION['user']['id'];
$query = "SELECT * FROM shipping_addresses WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Alamat Pengiriman Saya</h4>
        <a href="create.php" class="btn btn-primary rounded-pill">
            <i class="fas fa-plus me-1"></i> Tambah Alamat
        </a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-semibold mb-0">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <?= htmlspecialchars($row['recipient_name']) ?>
                            </h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary rounded-circle" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="edit.php?id=<?= $row['id'] ?>">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" 
                                           href="delete.php?id=<?= $row['id'] ?>" 
                                           onclick="return confirm('Hapus alamat ini?')">
                                            <i class="fas fa-trash-alt me-2"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <?= htmlspecialchars($row['phone']) ?>
                        </div>
                        
                        <div class="mb-2">
                            <i class="fas fa-home text-muted me-2"></i>
                            <?= htmlspecialchars($row['address']) ?>
                        </div>
                        
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-city me-1"></i>
                                <?= htmlspecialchars($row['city']) ?>
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-map me-1"></i>
                                <?= htmlspecialchars($row['province']) ?>
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-mail-bulk me-1"></i>
                                <?= htmlspecialchars($row['postal_code']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-map-marked-alt text-muted" style="font-size: 3rem;"></i>
            </div>
            <h5 class="fw-semibold">Belum Ada Alamat</h5>
            <p class="text-muted mb-4">Tambahkan alamat pengiriman untuk mempermudah belanja Anda</p>
            <a href="create.php" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> Tambah Alamat
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>