<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

$activeAdmin = 'divisi';
$pageTitle = 'Edit Divisi';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM divisions WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die('Data divisi tidak ditemukan.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/../includes/head.php'; ?>
</head>
<body>

<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<main class="admin-main">
    <header class="admin-header">
        <div>
            <p>Divisi</p>
            <h1>Edit Divisi</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <section class="form-card">
        <form class="admin-form" method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= e($item['id']); ?>">

            <div class="form-group">
                <label for="name">Nama Divisi</label>
                <input type="text" id="name" name="name" value="<?= e($item['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Divisi</label>
                <textarea id="description" name="description" rows="4" required><?= e($item['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="focus">Fokus Kerja</label>
                <textarea id="focus" name="focus" rows="3"><?= e($item['focus'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="tagline">Tagline Divisi</label>
                <input type="text" id="tagline" name="tagline" maxlength="255" value="<?= e($item['tagline'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <?php if (!empty($item['cover_image'])): ?>
                    <p style="margin: 0 0 10px;">
                        <img src="<?= image_url($item['cover_image']); ?>" alt="" style="width: 200px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb;">
                    </p>
                <?php endif; ?>
                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp">
                <small>Upload cover image baru. Kosongkan jika tidak ingin mengubah.</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="icon">Inisial / Ikon (maks 3 huruf)</label>
                    <input type="text" id="icon" name="icon" maxlength="3" value="<?= e($item['icon'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="active" <?= ($item['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?= ($item['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Update Divisi</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>