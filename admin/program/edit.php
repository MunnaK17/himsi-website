<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'program';
$pageTitle = 'Edit Program Kerja';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die('Data program tidak ditemukan.');
}

$img = $item['image'] ?? '';
$isUpload = $img && str_starts_with($img, 'uploads/');
$previewUrl = '';

if ($isUpload) {
    $previewUrl = asset('images/' . $img);
} elseif ($img) {
    $previewUrl = asset('images/default/' . $img);
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
            <p>Program Kerja</p>
            <h1>Edit Program</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <section class="form-card">
        <form class="admin-form" method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= e($item['id']); ?>">
            <input type="hidden" name="old_image" value="<?= e($item['image']); ?>">

            <div class="form-group">
                <label for="title">Nama Program</label>
                <input type="text" id="title" name="title" value="<?= e($item['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Program</label>
                <textarea id="description" name="description" rows="5" required><?= e($item['description']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="event_date">Tanggal Kegiatan</label>
                    <input type="date" id="event_date" name="event_date" value="<?= e($item['event_date']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="active" <?= ($item['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?= ($item['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>
                <?php if ($previewUrl): ?>
                    <img class="image-preview" src="<?= e($previewUrl); ?>" alt="<?= e($item['title']); ?>">
                <?php else: ?>
                    <small>Belum ada gambar.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image">Ganti Gambar</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
                <small>Kosongkan jika tidak ingin mengganti. Format JPG, PNG, WEBP. Maksimal 2MB.</small>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Update Program</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>
