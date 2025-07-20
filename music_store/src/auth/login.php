<?php
session_start();
require_once '../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' LIMIT 1");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role']
        ];

        if ($user['role'] === 'customer') {
            $_SESSION['customer_name'] = $user['name'];
        }

        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../customer/dashboard.php");
        }
        exit;
    } else {
        $errors[] = "Email atau password salah.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#0d6efd" class="bi bi-person-circle mb-3" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        <h3 class="fw-bold mb-2">Selamat Datang</h3>
                        <p class="text-muted">Masuk untuk melanjutkan ke akun Anda</p>
                    </div>

                    <?php if (!empty($_GET['success'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Registrasi berhasil! Silakan login.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php foreach ($errors as $err) : ?>
                                <div><?= htmlspecialchars($err) ?></div>
                            <?php endforeach; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Sign In</button>
                        <div class="text-center">
                            <p class="text-muted">Don't have an account? <a href="register.php" class="text-decoration-none">Sign up</a></p>
                        </div>
                    </form>

                    <!-- ✅ Tombol Kembali ke Beranda -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <a href="../index.php" class="text-decoration-none small">
                            <i class="fas fa-arrow-left me-1"></i> Return to Homepage
                        </a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
