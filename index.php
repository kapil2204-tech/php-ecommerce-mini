<?php
session_start();
require_once 'config/db.php';
include 'includes/header.php';

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
?>

<h1 class="page-title">Our Products</h1>

<?php if (mysqli_num_rows($result) === 0): ?>
    <p class="no-products">No products available yet. <a href="admin/add_product.php">Add one</a>.</p>
<?php else: ?>
    <div class="product-grid">
        <?php while ($product = mysqli_fetch_assoc($result)): ?>
            <div class="product-card">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php endif; ?>
                <div class="product-info">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                    <form action="user/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id"    value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_name"  value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
