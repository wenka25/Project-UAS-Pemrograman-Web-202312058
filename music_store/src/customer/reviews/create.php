<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_customer.php';

// Ambil semua produk untuk pilihan
$products = mysqli_query($conn, "SELECT id, name FROM products");
?>

<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-semibold mb-2">Beri Ulasan Produk</h4>
                <p class="text-muted">Bagikan pengalaman Anda tentang produk kami</p>
            </div>

            <form action="store.php" method="POST">
                <div class="mb-4">
                    <label for="product_id" class="form-label fw-medium">Pilih Produk</label>
                    <select name="product_id" class="form-select rounded-pill py-2" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php while ($p = mysqli_fetch_assoc($products)) : ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium">Rating</label>
                    <div class="star-rating mb-2">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
                            <label for="star<?= $i ?>">★</label>
                        <?php endfor; ?>
                    </div>
                    <small class="text-muted">Pilih 1-5 bintang</small>
                </div>

                <div class="mb-4">
                    <label for="comment" class="form-label fw-medium">Komentar</label>
                    <textarea name="comment" class="form-control rounded-3 p-3" rows="4" 
                              placeholder="Bagikan pengalaman Anda menggunakan produk ini..."></textarea>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    font-size: 1.5rem;
    line-height: 1;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #ddd;
    cursor: pointer;
    padding: 0 0.15rem;
}

.star-rating input:checked ~ label,
.star-rating input:hover ~ label {
    color: #ffc107;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}
</style>

<?php include '../../includes/footer.php'; ?>