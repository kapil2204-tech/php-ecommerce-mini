<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id    = (int)$_POST['product_id'];
    $product_name  = htmlspecialchars(trim($_POST['product_name']));
    $product_price = (float)$_POST['product_price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name'     => $product_name,
            'price'    => $product_price,
            'quantity' => 1
        ];
    }
}

header('Location: /php-ecommerce-mini/index.php');
exit;
?>
