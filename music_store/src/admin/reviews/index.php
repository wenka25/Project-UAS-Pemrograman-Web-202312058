<?php
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

$query = "SELECT r.*, u.name AS user_name, p.name AS product_name 
          FROM reviews r 
          JOIN users u ON r.user_id = u.id 
          JOIN products p ON r.product_id = p.id 
          ORDER BY r.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Ulasan Produk</h4>
        <div class="d-flex">
            <button class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            <button class="btn btn-sm btn-outline-primary">
                <i class="fas fa-download me-1"></i> Export
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="150">Waktu</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th width="120">Rating</th>
                            <th>Komentar</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td>
                                <small class="text-muted">
                                    <?= date('d M Y H:i', strtotime($r['created_at'])) ?>
                                </small>
                            </td>
                            <td class="fw-semibold"><?= htmlspecialchars($r['user_name']) ?></td>
                            <td>
                                <span class="d-block"><?= htmlspecialchars($r['product_name']) ?></span>
                            </td>
                            <td>
                                <div class="star-rating" style="--rating: <?= $r['rating'] ?>;">
                                    <div class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star <?= $i <= $r['rating'] ? 'filled' : '' ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;" 
                                     data-bs-toggle="tooltip" 
                                     title="<?= htmlspecialchars($r['comment']) ?>">
                                    <?= nl2br(htmlspecialchars($r['comment'])) ?>
                                </div>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-secondary rounded-circle p-1"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#reviewModal<?= $r['id'] ?>">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for review details -->
                        <div class="modal fade" id="reviewModal<?= $r['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Ulasan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold"><?= htmlspecialchars($r['product_name']) ?></h6>
                                            <small class="text-muted">
                                                Oleh: <?= htmlspecialchars($r['user_name']) ?>
                                            </small>
                                            <div class="star-rating mt-2" style="--rating: <?= $r['rating'] ?>;">
                                                <div class="stars">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <span class="star <?= $i <= $r['rating'] ? 'filled' : '' ?>">★</span>
                                                    <?php endfor; ?>
                                                </div>
                                                <span class="ms-2 fw-medium"><?= $r['rating'] ?>/5</span>
                                            </div>
                                        </div>
                                        <div class="border-top pt-3">
                                            <p class="mb-0"><?= nl2br(htmlspecialchars($r['comment'])) ?></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.star-rating {
    --star-size: 18px;
    --star-color: #ddd;
    --star-background: #fc0;
    display: flex;
    align-items: center;
}

.star-rating .stars {
    position: relative;
    display: inline-block;
    font-size: var(--star-size);
    color: var(--star-color);
}

.star-rating .stars .star {
    display: inline-block;
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}

.star-rating .stars .star.filled {
    color: var(--star-background);
}
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include '../../includes/footer.php'; ?>