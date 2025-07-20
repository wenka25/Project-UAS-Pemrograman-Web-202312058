customer/wishlists/remove.php<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

mysqli_query($conn, "DELETE FROM wishlists WHERE id = $id");

header("Location: index.php");
exit;
