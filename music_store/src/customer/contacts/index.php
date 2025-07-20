<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar_customer.php'; ?>

<style>
    .contact-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
    }
    .form-control:focus {
        border-color: #4a6bff;
        box-shadow: 0 0 0 3px rgba(74,107,255,0.1);
    }
    .form-label {
        font-weight: 500;
        color: #444;
        margin-bottom: 8px;
    }
    .contact-icon {
        font-size: 1.2rem;
        margin-right: 8px;
        color: #4a6bff;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0">Hubungi Kami</h4>
                <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            
            <div class="card contact-card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">📬 Kirim Pesan</h4>
                        <p class="text-muted">Tim kami akan segera merespons pesan Anda</p>
                    </div>
                    
                    <form action="submit.php" method="POST">
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="fas fa-user contact-icon"></i>Nama Lengkap
                            </label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope contact-icon"></i>Alamat Email
                            </label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="subject" class="form-label">
                                <i class="fas fa-tag contact-icon"></i>Subjek
                            </label>
                            <input type="text" name="subject" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment contact-icon"></i>Pesan
                            </label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill py-2">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>