<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: /php-ecommerce-mini/login.php');
    exit;
}

require_once '../config/db.php';
include '../includes/header.php';

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
?>

<div class="admin-products">
    <div class="admin-header">
        <h1>All Products</h1>
        <a href="/php-ecommerce-mini/admin/add_product.php" class="btn btn-primary">+ Add New Product</a>
    </div>

    <?php if (mysqli_num_rows($result) === 0): ?>
        <p class="no-products">No products found. <a href="add_product.php">Add one now</a>.</p>
    <?php else: ?>
        <table class="product-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                 alt="product" class="table-img">
                        <?php else: ?>
                            <span class="no-img">No image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td class="desc-cell"><?php echo htmlspecialchars(substr($product['description'], 0, 60)) . '...'; ?></td>
                    <td class="action-btns">
                        <a href="/php-ecommerce-mini/admin/edit_product.php?id=<?php echo $product['id']; ?>"
                           class="btn btn-secondary btn-sm">Edit</a>
                        <a href="/php-ecommerce-mini/admin/delete_product.php?id=<?php echo $product['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
