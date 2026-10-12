<?php
require 'config.php';
$stmt = $pdo->query("SELECT id, status, kurir_id FROM bookings");
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res);
