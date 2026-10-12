<?php
require 'config.php';

echo "=== USERS ===\n";
$stmt = $pdo->query("SELECT id, name, email, role FROM users");
while ($row = $stmt->fetch()) {
    print_r($row);
}

echo "\n=== TREATMENTS ===\n";
$stmt = $pdo->query("SELECT id, name, price FROM treatments");
while ($row = $stmt->fetch()) {
    print_r($row);
}

echo "\n=== BOOKINGS ===\n";
$stmt = $pdo->query("SELECT id, user_id, price, status FROM bookings");
while ($row = $stmt->fetch()) {
    print_r($row);
}
?>
