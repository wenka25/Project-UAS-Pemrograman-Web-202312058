<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../../config/database.php';

$user_id = $_SESSION['user']['id'];
$subject = htmlspecialchars(trim($_POST['subject']));
$message = htmlspecialchars(trim($_POST['message']));

if ($subject && $message) {
    // Pastikan hanya menyimpan ke kolom yang valid
    $query = "INSERT INTO contacts (user_id, subject, message, created_at) 
              VALUES ('$user_id', '$subject', '$message', NOW())";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='create.php';</script>";
    } else {
        echo "Gagal menyimpan pesan.";
    }
} else {
    echo "Data tidak lengkap.";
}
?>
