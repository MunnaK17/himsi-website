<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

$activeAdmin = 'gallery';
$pageTitle = 'Edit Galeri';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM division_galleries WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die('Data galeri tidak ditemukan.');
}

$divisions = $pdo->query("SELECT * FROM divisions WHERE status = 'active' ORDER BY name ASC")->fetchAll();
$error = $_GET['error'] ?? '';
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
            <p>Galeri</p>
            <h1>Edit Foto Galeri</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <?php if ($error): ?>
        <div class="alert error"><?= e(urldecode($error)); ?></div>
    <?php endif; ?>

    <section class="form-card">
        <form class="admin-form" method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= e($item['id']); ?>">

            <div class="form-group">
                <label for="division_id">Divisi</label>
                <select id="division_id" name="division_id" required>
                    <?php foreach ($divisions as $div): ?>
                        <option value="<?= e($div['id']); ?>" <?= $div['id'] == $item['division_id'] ? 'selected' : ''; ?>>
                            <?= e($div['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Judul Foto</label>
                <input type="text" id="title" name="title" maxlength="200" value="<?= e($item['title'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="image">Ganti Gambar</label>
                <?php if (!empty($item['image'])): ?>
                    <p style="margin: 0 0 10px;">
                        <img src="<?= asset('images/' . $item['image']); ?>" alt="" style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                    </p>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
                <small>Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
            </div>

            <div class="form-group">
                <label for="caption">Caption / Deskripsi</label>
                <textarea id="caption" name="caption" rows="3"><?= e($item['caption'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured" value="1" <?= !empty($item['is_featured']) ? 'checked' : ''; ?>> Tampilkan di utama
                </label>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Update Galeri</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>