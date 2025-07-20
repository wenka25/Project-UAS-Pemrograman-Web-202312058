<?php
require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/navbar_admin.php';

// Ambil semua pesan kontak dan join ke tabel users
$query = "SELECT c.*, u.name, u.email 
          FROM contacts c 
          JOIN users u ON c.user_id = u.id 
          ORDER BY c.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Daftar Pesan Kontak</h4>
        <div class="d-flex">
            <button class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            <button class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash-alt me-1"></i> Hapus Lama
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="180">Pengirim</th>
                            <th width="200">Subjek</th>
                            <th>Pesan</th>
                            <th width="150">Tanggal</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold"><?= htmlspecialchars($row['name']) ?></span>
                                    <small class="text-muted"><?= htmlspecialchars($row['email']) ?></small>
                                </div>
                            </td>
                            <td class="fw-medium text-truncate" style="max-width: 200px;">
                                <?= htmlspecialchars($row['subject']) ?>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;" 
                                     data-bs-toggle="tooltip" 
                                     title="<?= htmlspecialchars($row['message']) ?>">
                                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?= date('d M Y', strtotime($row['created_at'])) ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary rounded-circle"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#messageModal<?= $row['id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for message details -->
                        <div class="modal fade" id="messageModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pesan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <h6 class="fw-semibold"><?= htmlspecialchars($row['subject']) ?></h6>
                                            <small class="text-muted">
                                                Dari: <?= htmlspecialchars($row['name']) ?> &lt;<?= htmlspecialchars($row['email']) ?>&gt;
                                            </small>
                                        </div>
                                        <div class="border-top pt-3">
                                            <p class="mb-0"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <a href="mailto:<?= htmlspecialchars($row['email']) ?>" 
                                           class="btn btn-sm btn-primary">
                                           <i class="fas fa-reply me-1"></i> Balas
                                        </a>
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