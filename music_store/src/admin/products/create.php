<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';

$categories = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];
    $created_by  = $_SESSION['user']['id'];

    // Upload gambar
    $filename = $_FILES['image']['name'];
    $tmp      = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../../assets/images/$filename");

    $query = "INSERT INTO products (name, category_id, description, price, stock, image, created_by)
              VALUES ('$name', '$category_id', '$description', '$price', '$stock', '$filename', '$created_by')";
    mysqli_query($conn, $query);

    header("Location: index.php");
    exit;
}
?>

<?php include '../../includes/header.php'; include '../../includes/navbar_admin.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Add New Product</h2>
            <p class="text-muted small">Fill in the details to create a new product</p>
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
                        <label class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-2" required>
                    </div>

                    <!-- Category and Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select rounded-2" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php while($cat = mysqli_fetch_assoc($categories)) : ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-2">Rp</span>
                            <input type="number" name="price" class="form-control rounded-end-2" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" rows="4" class="form-control rounded-2"></textarea>
                    </div>

                    <!-- Stock and Image -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control rounded-2" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Product Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control rounded-2" required>
                        <div class="form-text">Recommended size: 500x500 pixels</div>
                    </div>

                    <!-- Form Actions -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-plus me-1"></i> Add Product
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
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
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
    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
    [required] ~ label:after {
        content: ' *';
        color: #dc3545;
    }
</style>