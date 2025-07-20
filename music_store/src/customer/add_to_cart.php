<?php
session_start();
require_once '../config/database.php';

$product_id = $_GET['id'];
$qty = isset($_GET['qty']) ? intval($_GET['qty']) : 1;

$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id"));

if ($product) {
    $_SESSION['cart'][$product_id] = [
        'id'    => $product['id'],
        'name'  => $product['name'],
        'price' => $product['price'],
        'qty'   => isset($_SESSION['cart'][$product_id]) 
                    ? $_SESSION['cart'][$product_id]['qty'] + $qty 
                    : $qty
    ];
}

header("Location: cart.php");
exit;
