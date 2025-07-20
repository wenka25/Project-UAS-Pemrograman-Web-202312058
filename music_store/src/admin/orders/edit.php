<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';

$id = $_GET['id'];

// Tangani update status SEBELUM HTML / include file lain
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $id);

    if ($stmt->execute()) {
        header("Location: index.php?status=updated");
        exit;
    } else {
        $error = "Gagal memperbarui status.";
    }
}

// Lanjutkan ambil data setelah POST
$order = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT o.*, u.name AS customer 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = $id
"));

if (!$order) {
    echo "<div class='container py-5 text-center'><h5 class='fw-medium'>Pesanan tidak ditemukan</h5></div>";
    exit;
}

// Baru include komponen visual
include '../../includes/header.php';
include '../../includes/navbar_admin.php';
?>


<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-semibold mb-2">Ubah Status Pesanan</h4>
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <span class="badge bg-light text-dark rounded-pill px-3 py-1">
                        <i class="fas fa-user me-1"></i> <?= htmlspecialchars($order['customer']) ?>
                    </span>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-1">
                        <i class="fas fa-calendar me-1"></i> <?= date('d M Y', strtotime($order['order_date'])) ?>
                    </span>
                </div>
            </div>

            <div class="alert alert-info rounded-3 mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>Status saat ini: <strong><?= ucfirst($order['status']) ?></strong></span>
                </div>
            </div>

            <form method="POST">
                <div class="mb-4">
                    <label for="status" class="form-label fw-medium mb-2">Pilih Status Baru</label>
                    <select name="status" id="status" class="form-select rounded-2 py-2" required>
                        <?php 
                        $statuses = [
                            'pending' => 'Pending', 
                            'paid' => 'Paid', 
                            'shipped' => 'Shipped', 
                            'completed' => 'Completed', 
                            'cancelled' => 'Cancelled'
                        ];
                        foreach ($statuses as $value => $label):
                        ?>
                            <option value="<?= $value ?>" <?= $value == $order['status'] ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">
                        <i class="fas fa-sync-alt me-2"></i> Update Status
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary rounded-pill py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>