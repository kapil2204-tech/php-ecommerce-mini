<?php
session_start();
session_destroy();
header('Location: /php-ecommerce-mini/index.php');
exit;
?>
