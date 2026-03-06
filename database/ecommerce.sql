-- ============================================================
-- ecommerce.sql
-- Database setup for PHP E-Commerce Mini Project
-- Run this in phpMyAdmin or MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS ecommerce_mini;
USE ecommerce_mini;

-- ----------------------------
-- Table: users
-- ----------------------------
CREATE TABLE IF NOT EXISTS users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL,
    password VARCHAR(255) NOT NULL,
    role     VARCHAR(20)  NOT NULL DEFAULT 'admin'
);

-- Default admin user (password stored as plain text for academic demo)
INSERT INTO users (username, password, role) VALUES
('admin', 'admin123', 'admin');

-- ----------------------------
-- Table: products
-- ----------------------------
CREATE TABLE IF NOT EXISTS products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)   NOT NULL,
    price       DECIMAL(10,2)  NOT NULL,
    description TEXT,
    image       VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample products
INSERT INTO products (name, price, description, image) VALUES
('Wireless Headphones', 29.99, 'High quality wireless headphones with noise cancellation.', 'https://via.placeholder.com/300x200?text=Headphones'),
('Mechanical Keyboard', 49.99, 'Compact mechanical keyboard with RGB backlight.', 'https://via.placeholder.com/300x200?text=Keyboard'),
('USB-C Hub',          19.99, 'Multi-port USB-C hub with HDMI, USB 3.0, and SD card.', 'https://via.placeholder.com/300x200?text=USB-C+Hub'),
('Webcam HD 1080p',    34.99, 'Full HD webcam ideal for video calls and streaming.',   'https://via.placeholder.com/300x200?text=Webcam');
