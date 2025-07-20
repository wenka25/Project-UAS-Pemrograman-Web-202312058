<?php
define('BASE_URL', 'http://localhost/music_store/');

// config/database.php

$host     = 'localhost';
$username = 'root';
$password = 'wenka123'; // Ganti sesuai dengan password database Anda
$database = 'music_store';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
