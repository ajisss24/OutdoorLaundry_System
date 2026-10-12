<?php
// Template Konfigurasi Koneksi Database
// Salin file ini menjadi 'config.php' lalu sesuaikan dengan pengaturan MySQL Anda.

date_default_timezone_set('Asia/Jakarta');

$host     = 'localhost';
$dbname   = 'laundry_outdoor';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
