<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $user_id = $_SESSION['user_id'];
    
    // Verify user exists to avoid Integrity Constraint Violation (e.g. after DB reset)
    $checkUser = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $checkUser->execute([$user_id]);
    if (!$checkUser->fetch()) {
        session_destroy();
        header("Location: login.php?error=session_invalid");
        exit;
    }

    $name = $_POST['name'];
    $type = $_POST['type'];
    $is_gore_tex = isset($_POST['is_gore_tex']) ? 1 : 0;
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("INSERT INTO gears (user_id, name, type, is_gore_tex, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $type, $is_gore_tex, $notes]);

    header("Location: dashboard_customer.php");
    exit;
}
?>
