<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../../config/database.php';

$user_id = $_SESSION['user']['id'];
$product_id = intval($_POST['product_id']);
$rating = intval($_POST['rating']);
$comment = htmlspecialchars(trim($_POST['comment']));

if ($product_id && $rating >= 1 && $rating <= 5) {
    $query = "INSERT INTO reviews (user_id, product_id, rating, comment) 
              VALUES ('$user_id', '$product_id', '$rating', '$comment')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Ulasan berhasil dikirim!'); window.location.href='create.php';</script>";
    } else {
        echo "Gagal menyimpan ulasan.";
    }
} else {
    echo "Data tidak lengkap atau rating tidak valid.";
}
