<?php
session_start();
require_once '../../config/database.php';

$id = $_POST['id'];
$user_id = $_SESSION['user']['id'];

$recipient_name = $_POST['recipient_name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal_code = $_POST['postal_code'];

$query = "UPDATE shipping_addresses SET 
            recipient_name = '$recipient_name',
            phone = '$phone',
            address = '$address',
            city = '$city',
            province = '$province',
            postal_code = '$postal_code'
          WHERE id = $id AND user_id = $user_id";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Gagal update: " . mysqli_error($conn);
}
?>
