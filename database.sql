-- Table creation & reset

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS tracking_logs;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS gears;
DROP TABLE IF EXISTS treatments;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin', 'kurir') DEFAULT 'customer',
    kurir_status ENUM('active', 'inactive') DEFAULT 'active',
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Treatments Table (Admin manages services here)
CREATE TABLE IF NOT EXISTS treatments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type ENUM('Base', 'Condition', 'Material') NOT NULL,
    price INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gears Table
CREATE TABLE IF NOT EXISTS gears (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    is_gore_tex BOOLEAN DEFAULT FALSE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bookings Table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    gear_id INT NOT NULL,
    conditions JSON NOT NULL,
    price INT NOT NULL,
    pickup_date DATE,
    pickup_time VARCHAR(50),
    quantity INT DEFAULT 1,
    payment_method VARCHAR(50) DEFAULT 'Transfer Bank',
    promo_code VARCHAR(50) DEFAULT NULL,
    payment_status ENUM('Unpaid', 'Paid', 'Failed') DEFAULT 'Unpaid',
    kurir_id INT NULL,
    status VARCHAR(100) DEFAULT 'Pending',
    pickup_address TEXT NOT NULL,
    delivery_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (gear_id) REFERENCES gears(id) ON DELETE CASCADE,
    FOREIGN KEY (kurir_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Tracking Logs Table
CREATE TABLE IF NOT EXISTS tracking_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    status VARCHAR(100) NOT NULL,
    description TEXT,
    photo_proof VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

-- Dummy Data for Users (Password: 123456 -> hashed with bcrypt)
INSERT INTO users (name, email, password, role, phone, address) VALUES
('Admin Utama', 'admin@laundry.com', '$2y$10$KtDnRS/KA30hDpdk7lY20e3tlKbjeid1gk1uL.q1sWoJLJko8a8Py', 'admin', '081234567890', 'Kantor Pusat'),
('Kurir Budi', 'budi@laundry.com', '$2y$10$KtDnRS/KA30hDpdk7lY20e3tlKbjeid1gk1uL.q1sWoJLJko8a8Py', 'kurir', '081234567891', 'Jl. Kurir No 1'),
('Customer Test', 'test@gmail.com', '$2y$10$KtDnRS/KA30hDpdk7lY20e3tlKbjeid1gk1uL.q1sWoJLJko8a8Py', 'customer', '081234567892', 'Jl. Customer No 1'),
('Aziz Dhisa', 'azizdhisa18@gmail.com', '$2y$10$KtDnRS/KA30hDpdk7lY20e3tlKbjeid1gk1uL.q1sWoJLJko8a8Py', 'customer', '081234567899', 'Jl. Customer Aziz Dhisa No. 1');

-- Password Resets Table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_token (token)
);

-- Dummy Data for Treatments
INSERT INTO treatments (name, type, price) VALUES
('Standard Wash', 'Base', 50000),
('Deodorizing Treatment', 'Condition', 10000),
('Deep Mud Scrub', 'Condition', 15000),
('Anti-Fungal Wash', 'Condition', 20000),
('Quick Dry System', 'Condition', 10000),
('Gore-Tex Re-coating', 'Material', 25000);