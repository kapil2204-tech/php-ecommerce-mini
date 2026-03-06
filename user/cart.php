<?php
session_start();
include '../includes/header.php';
?>

<h1 class="page-title">🛒 Your Cart</h1>

<?php
if (empty($_SESSION['cart'])): ?>
    <div class="empty-cart">
        <p>Your cart is empty.</p>
        <a href="/php-ecommerce-mini/index.php" class="btn btn-primary">Continue Shopping</a>
    </div>
<?php else:
    $grand_total = 0;
?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $product_id => $item):
                $subtotal     = $item['price'] * $item['quantity'];
                $grand_total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($subtotal, 2); ?></td>
                <td>
                    <a href="remove_from_cart.php?id=<?php echo $product_id; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Remove this item?')">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total-label"><strong>Grand Total</strong></td>
                <td colspan="2" class="total-amount"><strong>$<?php echo number_format($grand_total, 2); ?></strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="cart-actions">
        <a href="/php-ecommerce-mini/index.php" class="btn btn-secondary">← Continue Shopping</a>
        <a href="clear_cart.php" class="btn btn-danger"
           onclick="return confirm('Clear entire cart?')">Clear Cart</a>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
