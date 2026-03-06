<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: /php-ecommerce-mini/login.php');
    exit;
}

require_once '../config/db.php';
include '../includes/header.php';

$success = '';
$error   = '';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product_result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id LIMIT 1");
if (mysqli_num_rows($product_result) === 0) {
    echo '<p class="alert alert-error">Product not found. <a href="products.php">Back</a></p>';
    include '../includes/footer.php';
    exit;
}
$product = mysqli_fetch_assoc($product_result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $price       = trim($_POST['price']);
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $image_path  = $product['image']; // keep existing image by default

    if (empty($name) || empty($price)) {
        $error = 'Product name and price are required.';
    } elseif (!is_numeric($price) || $price < 0) {
        $error = 'Please enter a valid price.';
    } else {

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file      = $_FILES['image'];
            $file_tmp  = $file['tmp_name'];
            $file_size = $file['size'];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file_tmp);
            finfo_close($finfo);

            if ($mime !== 'image/jpeg') {
                $error = 'Only JPG / JPEG images are allowed.';
            } else {
                [$width, $height] = getimagesize($file_tmp);

                if ($width < 300 || $height < 200) {
                    $error = "Image too small. Minimum size is 300 × 200 pixels. Uploaded: {$width}×{$height}.";
                } elseif ($file_size > 5 * 1024 * 1024) {
                    $error = 'Image must be under 5 MB.';
                } else {
                    $uploads_dir = dirname(__DIR__) . '/assets/images/';
                    if (!is_dir($uploads_dir)) {
                        mkdir($uploads_dir, 0755, true);
                    }

                    $filename = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '_', basename($file['name']));
                    $dest     = $uploads_dir . $filename;

                    if (move_uploaded_file($file_tmp, $dest)) {
                        $image_path = '/php-ecommerce-mini/assets/images/' . $filename;
                    } else {
                        $error = 'Failed to save the uploaded image. Check folder permissions.';
                    }
                }
            }
        } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error = 'Upload error code: ' . $_FILES['image']['error'];
        }

        if (empty($error)) {
            $img_esc = mysqli_real_escape_string($conn, $image_path);
            $sql     = "UPDATE products
                        SET name='$name', price='$price', description='$description', image='$img_esc'
                        WHERE id=$id";

            if (mysqli_query($conn, $sql)) {
                $success          = 'Product updated successfully!';
                $product['image'] = $image_path;
            } else {
                $error = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="form-page">
    <h1>Edit Product</h1>
    <a href="/php-ecommerce-mini/admin/products.php" class="btn btn-secondary">← Back to Products</a>

    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

    <form action="edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="product-form">
        <div class="form-group">
            <label for="name">Product Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" required
                   value="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="form-group">
            <label for="price">Price ($) <span class="required">*</span></label>
            <input type="number" id="price" name="price" step="0.01" min="0" required
                   value="<?php echo htmlspecialchars($product['price']); ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Product Image <span class="upload-hint">(JPG only &mdash; min 300&times;200 px, max 5 MB)</span></label>

            <?php if (!empty($product['image'])): ?>
                <div style="margin-bottom:10px;">
                    <small style="color:#888">Current image:</small><br>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                         alt="Current" style="max-width:200px; max-height:140px; border-radius:6px; margin-top:4px; border:1px solid #ddd;">
                </div>
            <?php endif; ?>

            <div class="upload-box" id="upload-box">
                <input type="file" id="image" name="image" accept=".jpg,.jpeg,image/jpeg"
                       onchange="previewImage(this)">
                <div class="upload-placeholder" id="upload-placeholder">
                    <span class="upload-icon">📁</span>
                    <span>Click to replace image (optional)</span>
                    <small>Min 300 × 200 px &bull; Max 5 MB &bull; JPG only</small>
                </div>
                <img id="img-preview" src="" alt="Preview"
                     style="display:none; max-width:100%; max-height:200px; margin-top:10px; border-radius:6px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script>
function previewImage(input) {
    const preview     = document.getElementById('img-preview');
    const placeholder = document.getElementById('upload-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src              = e.target.result;
            preview.style.display    = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../includes/footer.php'; ?>
