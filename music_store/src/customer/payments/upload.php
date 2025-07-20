<?php
session_start();
require_once '../../config/database.php';

// Cek apakah user login
if (!isset($_SESSION['user'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

// Proses hanya jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $order_id     = $_POST['order_id'] ?? null;
    $bank_name    = $_POST['bank_name'] ?? null;
    $sender_name  = $_POST['sender_name'] ?? null;
    $payment_date = date('Y-m-d H:i:s');

    // Validasi input
    if (!$order_id || !$bank_name || !$sender_name || !isset($_FILES['proof'])) {
        echo "Semua field wajib diisi.";
        exit;
    }

    // Validasi dan upload file
    $proof_name = $_FILES['proof']['name'];
    $tmp_name   = $_FILES['proof']['tmp_name'];
    $file_ext   = strtolower(pathinfo($proof_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if (!in_array($file_ext, $allowed_ext)) {
        echo "Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
        exit;
    }

    if ($_FILES['proof']['size'] > 2 * 1024 * 1024) {
        echo "Ukuran file maksimal 2MB.";
        exit;
    }

    // Buat folder jika belum ada
    $upload_dir = '../../uploads/payments/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Simpan file dengan nama unik
    $filename = time() . '_' . uniqid() . '.' . $file_ext;
    $filepath = $upload_dir . $filename;

    if (move_uploaded_file($tmp_name, $filepath)) {
        // Simpan ke tabel payments
        $insert = mysqli_query($conn, "INSERT INTO payments (order_id, payment_date, bank_name, sender_name, proof)
                                       VALUES ('$order_id', '$payment_date', '$bank_name', '$sender_name', '$filename')");

        // Update order: status + simpan bukti pembayaran
        if ($insert) {
            $update = mysqli_query($conn, "UPDATE orders SET status = 'paid', payment_proof = '$filename' WHERE id = '$order_id'");

            if ($update) {
                header("Location: index.php?success=1");
                exit;
            } else {
                echo "Upload berhasil, tapi gagal update status pesanan.";
            }
        } else {
            echo "Gagal menyimpan data pembayaran: " . mysqli_error($conn);
        }
    } else {
        echo "Upload gagal. File tidak bisa dipindahkan.";
    }
} else {
    echo "Akses tidak diizinkan.";
}
