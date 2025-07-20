<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$product_id = $_POST['product_id'] ?? null;

// Cek jika sudah ada
$cek = mysqli_query($conn, "SELECT * FROM wishlists WHERE user_id = $user_id AND product_id = $product_id");
if (mysqli_num_rows($cek) === 0 && $product_id) {
    mysqli_query($conn, "INSERT INTO wishlists (user_id, product_id) VALUES ($user_id, $product_id)");
}

header('Location: index.php');
