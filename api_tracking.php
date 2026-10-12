<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'kurir')) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? 'update_status';
    $booking_id = $_POST['booking_id'];

    if ($action == 'validate_payment' && $_SESSION['role'] == 'admin') {
        $stmt = $pdo->prepare("UPDATE bookings SET payment_status = 'Paid' WHERE id = ?");
        $stmt->execute([$booking_id]);
        
        $stmt = $pdo->prepare("INSERT INTO tracking_logs (booking_id, status, description) VALUES (?, 'Payment Validated', 'Pembayaran telah divalidasi oleh admin')");
        $stmt->execute([$booking_id]);
    }
    elseif ($action == 'assign_kurir' && $_SESSION['role'] == 'admin') {
        $kurir_id = $_POST['kurir_id'];
        $stmt = $pdo->prepare("UPDATE bookings SET kurir_id = ? WHERE id = ?");
        $stmt->execute([$kurir_id, $booking_id]);
        
        // Fetch kurir name for log
        $stmt_k = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $stmt_k->execute([$kurir_id]);
        $kurir_name = $stmt_k->fetchColumn();

        $desc = 'Order di-assign ke kurir: ' . $kurir_name;
        $stmt = $pdo->prepare("INSERT INTO tracking_logs (booking_id, status, description) VALUES (?, 'Assigned to Kurir', ?)");
        $stmt->execute([$booking_id, $desc]);
    }
    elseif ($action == 'update_status') {
        $status = $_POST['status'];

        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $booking_id]);

        $desc = "Status diupdate menjadi " . $status;
        $photo_proof = null;

        // Handle Photo Upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['photo']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_filename = uniqid('proof_') . '.' . $ext;
                $destination = 'uploads/' . $new_filename;
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    $photo_proof = $destination;
                }
            }
        }

        $stmt = $pdo->prepare("INSERT INTO tracking_logs (booking_id, status, description, photo_proof) VALUES (?, ?, ?, ?)");
        $stmt->execute([$booking_id, $status, $desc, $photo_proof]);
    }

    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_kurir.php");
    }
    exit;
}
?>
