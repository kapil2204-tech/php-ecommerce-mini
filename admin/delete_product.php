<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: /php-ecommerce-mini/login.php');
    exit;
}

require_once '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "DELETE FROM products WHERE id = $id";
    mysqli_query($conn, $sql);
}

header('Location: /php-ecommerce-mini/admin/products.php');
exit;
?>
