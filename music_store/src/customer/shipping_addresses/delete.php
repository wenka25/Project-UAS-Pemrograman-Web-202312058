<?php
session_start();
require_once '../../config/database.php';

$id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

$query = "DELETE FROM shipping_addresses WHERE id = $id AND user_id = $user_id";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
