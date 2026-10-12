<?php
/**
 * Database Migration Script: Create password_resets Table
 * 
 * Script ini digunakan untuk membuat tabel `password_resets` 
 * jika belum ada di database `laundry_outdoor`.
 * 
 * Cara menjalankan:
 * 1. Via Terminal : php migrate_reset_password.php
 * 2. Via Browser  : http://localhost:8000/migrate_reset_password.php
 */

require_once 'config.php';

echo "<pre style='font-family: monospace; font-size: 14px; padding: 20px; background: #1e293b; color: #f8fafc; border-radius: 8px;'>";
echo "=== OUTDOOR LAUNDRY - DATABASE MIGRATION ===\n\n";

try {
    $sql = "CREATE TABLE IF NOT EXISTS password_resets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        expires_at DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_token (token)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    
    echo "✅ [BERHASIL] Tabel 'password_resets' siap digunakan!\n";
    echo "ℹ️  Struktur tabel:\n";
    echo "    - id         : INT (Primary Key, Auto Increment)\n";
    echo "    - email      : VARCHAR(255) (Indexed)\n";
    echo "    - token      : VARCHAR(255) (Indexed)\n";
    echo "    - expires_at : DATETIME\n";
    echo "    - created_at : TIMESTAMP\n\n";
    echo "Status: Siap melayani fitur Reset Password.\n";

} catch (PDOException $e) {
    echo "❌ [GAGAL] Error saat migrasi: " . $e->getMessage() . "\n";
}

echo "\n============================================\n";
echo "</pre>";
