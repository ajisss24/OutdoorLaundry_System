<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'create') {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];

        $stmt = $pdo->prepare("INSERT INTO treatments (name, type, price) VALUES (?, ?, ?)");
        $stmt->execute([$name, $type, $price]);
    } 
    elseif ($action == 'update_price') {
        $id = $_POST['treatment_id'];
        $price = $_POST['price'];

        $stmt = $pdo->prepare("UPDATE treatments SET price = ? WHERE id = ?");
        $stmt->execute([$price, $id]);
    } 
    elseif ($action == 'delete') {
        $id = $_POST['treatment_id'];

        $stmt = $pdo->prepare("DELETE FROM treatments WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: dashboard_admin.php");
    exit;
}
?>
