<?php
session_start();
require_once '../../config/database.php';

$id = $_GET['id'];
$action = $_GET['action']; // verify / reject

if (!in_array($action, ['verify', 'reject'])) {
    die("Aksi tidak valid.");
}

// Ubah status di tabel payments
$status = $action == 'verify' ? 'verified' : 'rejected';
mysqli_query($conn, "UPDATE payments SET status = '$status' WHERE id = $id");

// Jika diverifikasi, juga update status pesanan ke 'paid'
if ($action == 'verify') {
    // Cari order ID
    $result = mysqli_query($conn, "SELECT order_id FROM payments WHERE id = $id");
    $payment = mysqli_fetch_assoc($result);
    $order_id = $payment['order_id'];

    mysqli_query($conn, "UPDATE orders SET status = 'paid' WHERE id = $order_id");
}

header("Location: index.php");
exit;
