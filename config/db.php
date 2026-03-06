<?php
$host     = 'localhost';
$username = 'root';
$password = '';  // Laragon default

$conn = mysqli_connect($host, $username, $password);

if (!$conn) {
    die('<p style="color:red;text-align:center;margin-top:50px;font-family:sans-serif;">
         ❌ Cannot connect to MySQL: ' . mysqli_connect_error() . '
         <br><small>Make sure Laragon is running and MySQL is started.</small>
         </p>');
}

$create_db = "CREATE DATABASE IF NOT EXISTS `ecommerce_mini` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!mysqli_query($conn, $create_db)) {
    die('<p style="color:red;text-align:center;margin-top:50px;font-family:sans-serif;">
         ❌ Could not create database: ' . mysqli_error($conn) . '</p>');
}

mysqli_select_db($conn, 'ecommerce_mini');

mysqli_query($conn, "
    CREATE TABLE IF NOT EXISTS `users` (
        id       INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50)  NOT NULL,
        password VARCHAR(255) NOT NULL,
        role     VARCHAR(20)  NOT NULL DEFAULT 'admin'
    ) ENGINE=InnoDB;
");

$check = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM users");
$row   = mysqli_fetch_assoc($check);
if ($row['cnt'] == 0) {
    mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin')");
}

mysqli_query($conn, "
    CREATE TABLE IF NOT EXISTS `products` (
        id          INT AUTO_INCREMENT PRIMARY KEY,
        name        VARCHAR(100)  NOT NULL,
        price       DECIMAL(10,2) NOT NULL,
        description TEXT,
        image       VARCHAR(255),
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;
");

$check2 = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM products");
$row2   = mysqli_fetch_assoc($check2);
if ($row2['cnt'] == 0) {
    mysqli_query($conn, "
        INSERT INTO products (name, price, description, image) VALUES
        ('Wireless Headphones', 29.99, 'High quality wireless headphones with noise cancellation.', '/php-ecommerce-mini/assets/images/headphones.webp'),
        ('Mechanical Keyboard',  49.99, 'Compact mechanical keyboard with RGB backlight.',          '/php-ecommerce-mini/assets/images/keyboard.webp'),
        ('USB-C Hub',            19.99, 'Multi-port USB-C hub with HDMI, USB 3.0, and SD card.',    '/php-ecommerce-mini/assets/images/usbc_hub.webp'),
        ('Webcam HD 1080p',      34.99, 'Full HD webcam ideal for video calls and streaming.',       '/php-ecommerce-mini/assets/images/webcam.webp')
    ");
}
?>
