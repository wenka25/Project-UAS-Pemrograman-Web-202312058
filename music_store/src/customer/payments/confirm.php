<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

if (!isset($_GET['order_id'])) {
    echo "<div class='container py-5 text-center'><h5 class='fw-medium'>Order ID tidak ditemukan</h5></div>";
    exit;
}

$order_id = (int)$_GET['order_id'];

$result = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id");
if (mysqli_num_rows($result) == 0) {
    echo "<div class='container py-5 text-center'><h5 class='fw-medium'>Order tidak valid atau bukan milik Anda</h5></div>";
    exit;
}

$order = mysqli_fetch_assoc($result);
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar_customer.php'; ?>

<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-semibold mb-2">Konfirmasi Pembayaran</h4>
                <p class="text-muted">Lengkapi detail pembayaran Anda</p>
            </div>

            <!-- Informasi Rekening Penjual -->
            <div class="alert alert-info mb-4">
                <h6 class="mb-2"><i class="fas fa-university me-2"></i>Transfer ke Rekening Berikut:</h6>
                <ul class="mb-0 ps-3">
                    <li><strong>Bank BCA</strong> - 1234567890 a.n. <strong>PT Music Store</strong></li>
                    <li><strong>Bank Mandiri</strong> - 0987654321 a.n. <strong>PT Music Store</strong></li>
                </ul>
            </div>

            <!-- Form Konfirmasi -->
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="order_id" value="<?= $order_id ?>">

                <div class="mb-4">
                    <label for="bank_name" class="form-label fw-medium">Bank Tujuan</label>
                    <input type="text" name="bank_name" class="form-control rounded-2 py-2 px-3" 
                           placeholder="Contoh: BCA, Mandiri, BRI" required>
                </div>

                <div class="mb-4">
                    <label for="sender_name" class="form-label fw-medium">Nama Pengirim</label>
                    <input type="text" name="sender_name" class="form-control rounded-2 py-2 px-3" 
                           placeholder="Nama sesuai rekening pengirim" required>
                </div>

                <div class="mb-4">
                    <label for="proof" class="form-label fw-medium">Bukti Transfer</label>
                    <input type="file" name="proof" class="form-control rounded-2 py-2" 
                           accept="image/*" required>
                    <small class="text-muted">Format: JPG, PNG (maks. 2MB)</small>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pembayaran
                    </button>
                    <a href="../payments/index.php" class="btn btn-outline-secondary rounded-pill py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
