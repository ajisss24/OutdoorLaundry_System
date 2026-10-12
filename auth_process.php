<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') header("Location: dashboard_admin.php");
            else if ($user['role'] == 'kurir') header("Location: dashboard_kurir.php");
            else header("Location: dashboard_customer.php");
            exit;
        } else {
            header("Location: login.php?error=1");
            exit;
        }
    } 
    
    else if ($action == 'register') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, phone, address) VALUES (?, ?, ?, 'customer', ?, ?)");
            $stmt->execute([$name, $email, $password, $phone, $address]);
            
            // Auto login after register
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['name'] = $name;
            $_SESSION['role'] = 'customer';
            
            header("Location: dashboard_customer.php");
            exit;
        } catch (PDOException $e) {
            header("Location: register.php?error=1");
            exit;
        }
    }
}
?>
