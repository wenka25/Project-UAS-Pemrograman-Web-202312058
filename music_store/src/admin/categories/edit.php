<?php
include '../../middleware/auth_admin.php';
require_once '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "UPDATE categories SET name='$name', description='$desc' WHERE id = $id";
    mysqli_query($conn, $query);

    header("Location: index.php");
    exit;
}
?>

<?php include '../../includes/header.php'; include '../../includes/navbar_admin.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Edit Category</h2>
            <p class="text-muted small">Update category details</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Categories
        </a>
    </div>

    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-4">
            <form method="POST">
                <div class="row g-3">
                    <!-- Category Name -->
                    <div class="col-md-12">
                        <label class="form-label fw-medium">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" 
                               class="form-control rounded-2" required>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" rows="3" class="form-control rounded-2"><?= htmlspecialchars($data['description']) ?></textarea>
                    </div>

                    <!-- Form Actions -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Save Changes
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
    [required] ~ label:after {
        content: ' *';
        color: #dc3545;
    }
    .btn {
        transition: all 0.2s ease;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
</style>