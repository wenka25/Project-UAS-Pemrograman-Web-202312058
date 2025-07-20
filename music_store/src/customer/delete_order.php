<?php
session_start();
require_once '../config/database.php';

// Validasi user
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Validasi parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID pesanan tidak valid";
    header("Location: orders.php");
    exit;
}

$order_id = (int)$_GET['id'];

// Mulai transaksi
mysqli_begin_transaction($conn);

try {
    // Pastikan pesanan milik user dan status bisa dihapus (completed atau cancelled)
    $check = mysqli_query($conn, 
        "SELECT * FROM orders 
         WHERE id = $order_id 
         AND user_id = $user_id 
         AND status IN ('completed', 'cancelled')");
    
    if (mysqli_num_rows($check) === 0) {
        throw new Exception("Pesanan tidak ditemukan atau belum dapat dihapus");
    }

    // Hapus order_items terlebih dahulu (jika ada constraint foreign key)
    $delete_items = mysqli_query($conn, "DELETE FROM order_items WHERE order_id = $order_id");
    if (!$delete_items) {
        throw new Exception("Gagal menghapus item pesanan");
    }

    // Hapus order
    $delete_order = mysqli_query($conn, "DELETE FROM orders WHERE id = $order_id");
    if (!$delete_order) {
        throw new Exception("Gagal menghapus pesanan");
    }

    // Commit transaksi jika semua berhasil
    mysqli_commit($conn);
    $_SESSION['success'] = "Riwayat pesanan berhasil dihapus";
    
} catch (Exception $e) {
    // Rollback jika ada error
    mysqli_rollback($conn);
    $_SESSION['error'] = $e->getMessage();
    
    // Log error untuk debugging
    error_log("Error deleting order: " . $e->getMessage());
}

header("Location: orders.php");
exit;
?>