<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP E-Commerce Mini</title>
    <link rel="stylesheet" href="/php-ecommerce-mini/assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="/php-ecommerce-mini/index.php" class="logo">🛒 ShopMini</a>
        <nav>
            <a href="/php-ecommerce-mini/index.php">Home</a>
            <a href="/php-ecommerce-mini/user/cart.php">Cart
                <?php
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    echo '<span class="cart-count">' . count($_SESSION['cart']) . '</span>';
                }
                ?>
            </a>
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                <a href="/php-ecommerce-mini/admin/dashboard.php">Admin Panel</a>
                <a href="/php-ecommerce-mini/logout.php">Logout</a>
            <?php else: ?>
                <a href="/php-ecommerce-mini/login.php">Admin Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
