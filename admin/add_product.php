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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $price       = trim($_POST['price']);
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $image_path  = '';

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
            $sql     = "INSERT INTO products (name, price, description, image)
                        VALUES ('$name', '$price', '$description', '$img_esc')";

            if (mysqli_query($conn, $sql)) {
                $success = 'Product added successfully!';
            } else {
                $error = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="form-page">
    <h1>Add New Product</h1>
    <a href="/php-ecommerce-mini/admin/products.php" class="btn btn-secondary">← Back to Products</a>

    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

    <!-- enctype required for file uploads -->
    <form action="add_product.php" method="POST" enctype="multipart/form-data" class="product-form">
        <div class="form-group">
            <label for="name">Product Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" required placeholder="e.g. Wireless Mouse"
                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="price">Price ($) <span class="required">*</span></label>
            <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="e.g. 19.99"
                   value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"
                      placeholder="Short product description..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Product Image <span class="upload-hint">(JPG only &mdash; min 300&times;200 px, max 5 MB)</span></label>
            <div class="upload-box" id="upload-box">
                <input type="file" id="image" name="image" accept=".jpg,.jpeg,image/jpeg"
                       onchange="previewImage(this)">
                <div class="upload-placeholder" id="upload-placeholder">
                    <span class="upload-icon">📁</span>
                    <span>Click to choose a JPG image</span>
                    <small>Min 300 × 200 px &bull; Max 5 MB</small>
                </div>
                <img id="img-preview" src="" alt="Preview" style="display:none; max-width:100%; max-height:200px; margin-top:10px; border-radius:6px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
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
