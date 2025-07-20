<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$recipient_name = $_POST['recipient_name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal_code = $_POST['postal_code'];

$query = "INSERT INTO shipping_addresses 
          (user_id, recipient_name, phone, address, city, province, postal_code) 
          VALUES ('$user_id', '$recipient_name', '$phone', '$address', '$city', '$province', '$postal_code')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Alamat berhasil disimpan'); window.location.href='index.php';</script>";
} else {
    echo "Gagal menyimpan alamat: " . mysqli_error($conn);
}
?>
