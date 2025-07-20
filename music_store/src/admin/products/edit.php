<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));
$categories = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];

    // Handle image upload
    if ($_FILES['image']['name']) {
        $filename = $_FILES['image']['name'];
        $tmp      = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../../assets/images/$filename");
    } else {
        $filename = $product['image'];
    }

    $query = "UPDATE products SET 
                name='$name', category_id='$category_id', description='$description',
                price='$price', stock='$stock', image='$filename'
              WHERE id = $id";
    mysqli_query($conn, $query);

    header("Location: index.php");
    exit;
}
?>

<?php include '../../includes/header.php'; include '../../includes/navbar_admin.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Edit Product</h2>
            <p class="text-muted small">Update product details</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <!-- Product Name -->
                    <div class="col-md-12">
                        <label class="form-label fw-medium">Product Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" 
                               class="form-control rounded-2" required>
                    </div>

                    <!-- Category and Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Category</label>
                        <select name="category_id" class="form-select rounded-2" required>
                            <?php while($cat = mysqli_fetch_assoc($categories)) : ?>
                                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                    <?= $cat['name'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Price</label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-2">Rp</span>
                            <input type="number" name="price" value="<?= $product['price'] ?>" 
                                   class="form-control rounded-end-2" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" rows="4" class="form-control rounded-2"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <!-- Stock and Image -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Stock</label>
                        <input type="number" name="stock" value="<?= $product['stock'] ?>" 
                               class="form-control rounded-2" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Product Image</label>
                        <input type="file" name="image" class="form-control rounded-2">
                    </div>

                    <!-- Current Image Preview -->
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <div class="border rounded-2 p-2">
                                <img src="../../assets/images/<?= $product['image'] ?>" 
                                     width="120" 
                                     class="rounded-1"
                                     style="object-fit: cover">
                            </div>
                            <div class="text-muted small">
                                Current product image. Upload new image to replace.
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<style>
    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        padding: 0.5rem 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .card {
        border: none;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
</style>