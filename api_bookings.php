<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $user_id = $_SESSION['user_id'];

    // Verify user exists
    $checkUser = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $checkUser->execute([$user_id]);
    if (!$checkUser->fetch()) {
        session_destroy();
        header("Location: login.php?error=session_invalid");
        exit;
    }

    $gear_id = $_POST['gear_id'];
    $conditions = isset($_POST['conditions']) ? json_encode($_POST['conditions']) : '[]';
    $price = $_POST['price']; 
    $pickup_address = $_POST['pickup_address'];
    $delivery_address = $_POST['delivery_address'];
    
    // New fields
    $pickup_date = $_POST['pickup_date'] ?? date('Y-m-d');
    $quantity = $_POST['quantity'] ?? 1;
    $payment_method = $_POST['payment_method'] ?? 'Transfer Bank';
    $promo_code = $_POST['promo_code'] ?? '';
    $pickup_time = $_POST['pickup_time'] ?? '';

    // Simple Promo Code Logic (10% off if 'OUTDOOR10')
    if (strtoupper($promo_code) === 'OUTDOOR10') {
        $price = $price - ($price * 0.10);
    }

    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, gear_id, conditions, price, pickup_address, delivery_address, pickup_date, pickup_time, quantity, payment_method, promo_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $gear_id, $conditions, $price, $pickup_address, $delivery_address, $pickup_date, $pickup_time, $quantity, $payment_method, $promo_code]);

    // Initial Tracking Log
    $booking_id = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO tracking_logs (booking_id, status, description) VALUES (?, 'Pending', 'Pesanan dibuat dan menunggu validasi')");
    $stmt->execute([$booking_id]);

    header("Location: dashboard_customer.php");
    exit;
}
?>
