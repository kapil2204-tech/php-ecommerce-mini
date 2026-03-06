<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: /php-ecommerce-mini/login.php');
    exit;
}

include '../includes/header.php';
?>

<div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>! 👋</h1>
    <p>Manage your products from this admin panel.</p>

    <div class="dashboard-cards">
        <a href="/php-ecommerce-mini/admin/add_product.php" class="dash-card">
            <span class="dash-icon">➕</span>
            <h3>Add Product</h3>
            <p>Create a new product listing</p>
        </a>
        <a href="/php-ecommerce-mini/admin/products.php" class="dash-card">
            <span class="dash-icon">📦</span>
            <h3>View Products</h3>
            <p>Browse and manage all products</p>
        </a>
        <a href="/php-ecommerce-mini/logout.php" class="dash-card dash-card-danger">
            <span class="dash-icon">🚪</span>
            <h3>Logout</h3>
            <p>End your admin session</p>
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
