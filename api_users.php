<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_kurir') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash('123456', PASSWORD_DEFAULT); // Default password

    // Cek apakah email sudah ada
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, phone, address) VALUES (?, ?, ?, 'kurir', ?, ?)");
        $stmt->execute([$name, $email, $password, $phone, $address]);
    }

    header("Location: dashboard_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_kurir_status') {
    $user_id = $_POST['user_id'];
    $status = $_POST['kurir_status'];

    $stmt = $pdo->prepare("UPDATE users SET kurir_status = ? WHERE id = ?");
    $stmt->execute([$status, $user_id]);

    header("Location: dashboard_admin.php");
    exit;
}
?>
