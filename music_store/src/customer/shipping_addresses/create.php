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
    <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="fas fa-map-marker-alt text-primary mb-3" style="font-size: 2rem;"></i>
                <h4 class="fw-semibold mb-2">Tambah Alamat Pengiriman</h4>
                <p class="text-muted">Lengkapi detail alamat pengiriman Anda</p>
            </div>

            <form action="store.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nama Penerima</label>
                        <input type="text" name="recipient_name" class="form-control rounded-2 py-2 px-3" 
                               placeholder="Nama lengkap penerima" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">No. Telepon</label>
                        <input type="text" name="phone" class="form-control rounded-2 py-2 px-3" 
                               placeholder="Nomor yang bisa dihubungi">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium">Alamat Lengkap</label>
                        <textarea name="address" class="form-control rounded-2 p-3" rows="3"
                                  placeholder="Jl. Nama Jalan No. 123, Gedung/Apartemen (opsional)" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Kota</label>
                        <input type="text" name="city" class="form-control rounded-2 py-2 px-3" 
                               placeholder="Nama kota">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Provinsi</label>
                        <input type="text" name="province" class="form-control rounded-2 py-2 px-3" 
                               placeholder="Nama provinsi">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Kode Pos</label>
                        <input type="text" name="postal_code" class="form-control rounded-2 py-2 px-3" 
                               placeholder="5 digit kode pos">
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">
                        <i class="fas fa-save me-2"></i> Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>