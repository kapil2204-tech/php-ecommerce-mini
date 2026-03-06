<?php
session_start();
$_SESSION['cart'] = [];
header('Location: /php-ecommerce-mini/user/cart.php');
exit;
?>
