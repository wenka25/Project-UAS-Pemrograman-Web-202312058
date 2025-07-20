<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../../config/database.php';

$user_id = $_SESSION['user']['id'];
$recipient_name = $_POST['recipient_name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal_code = $_POST['postal_code'];

$query = "INSERT INTO shipping_addresses (user_id, recipient_name, phone, address, city, province, postal_code)
          VALUES ('$user_id', '$recipient_name', '$phone', '$address', '$city', '$province', '$postal_code')";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}
?>
