<?php
require_once '../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validasi
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "Semua field harus diisi.";
    }

    if ($password !== $confirm) {
        $errors[] = "Konfirmasi password tidak cocok.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password minimal 8 karakter.";
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }

    // Cek email sudah terdaftar menggunakan prepared statement
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors[] = "Email sudah terdaftar.";
    }
    $stmt->close();

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        $stmt->bind_param("sss", $name, $email, $hashed);
        
        if ($stmt->execute()) {
            header("Location: login.php?success=1");
            exit;
        } else {
            $errors[] = "Terjadi kesalahan. Silakan coba lagi.";
        }
        $stmt->close();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#0d6efd" class="bi bi-person-plus mb-3" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <h3 class="fw-bold mb-2">Buat Akun Baru</h3>
                        <p class="text-muted">Isi form berikut untuk mendaftar</p>
                    </div>

                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $err) : ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                            <div class="invalid-feedback">Harap isi nama lengkap</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            <div class="invalid-feedback">Harap isi email yang valid</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required minlength="8">
                            <div class="invalid-feedback">Password minimal 8 karakter</div>
                            <div class="form-text">Minimal 8 karakter</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">Harap konfirmasi password</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Daftar</button>
                        
                        <div class="text-center">
                            <p class="text-muted">Sudah punya akun? <a href="login.php" class="text-decoration-none">Masuk disini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side validation
(function () {
    'use strict'
    
    const forms = document.querySelectorAll('.needs-validation')
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            // Check password match
            const password = document.getElementById('password')
            const confirmPassword = document.getElementById('confirm_password')
            
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords don't match")
                confirmPassword.classList.add('is-invalid')
            } else {
                confirmPassword.setCustomValidity('')
                confirmPassword.classList.remove('is-invalid')
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php include '../includes/footer.php'; ?>