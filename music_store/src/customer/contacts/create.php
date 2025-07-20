<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}
include '../../includes/header.php';
include '../../includes/navbar_customer.php';
?>

<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="fas fa-headset text-primary mb-3" style="font-size: 2.5rem;"></i>
                <h4 class="fw-semibold mb-2">Hubungi Admin</h4>
                <p class="text-muted">Kami siap membantu Anda</p>
            </div>

            <form action="store.php" method="POST">
                <div class="mb-4">
                    <label for="subject" class="form-label fw-medium">Subjek</label>
                    <input type="text" name="subject" class="form-control rounded-3 py-2 px-3" 
                           placeholder="Masukkan subjek pesan" required>
                </div>

                <div class="mb-4">
                    <label for="message" class="form-label fw-medium">Pesan Anda</label>
                    <textarea name="message" class="form-control rounded-3 p-3" rows="5"
                              placeholder="Tulis pesan Anda secara detail..." required></textarea>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>