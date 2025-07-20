<?php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

if ($name && $email && $subject && $message) {
    $query = "INSERT INTO contacts (name, email, subject, message)
              VALUES ('$name', '$email', '$subject', '$message')";
    $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='index.php';</script>";
        } else {
            echo "Gagal menyimpan pesan.";
        }
    } else {
        echo "Harap lengkapi semua data yang wajib diisi.";
    }
} else {
    echo "Akses tidak sah.";
}
?>
