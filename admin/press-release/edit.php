<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'press-release';
$pageTitle = 'Edit Press Release';

$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM press_releases WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die('Data press release tidak ditemukan.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/../includes/head.php'; ?>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<main class="admin-main">
    <header class="admin-header">
        <div>
            <p>Press Release</p>
            <h1>Edit Artikel</h1>
        </div>

        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <section class="form-card">
        <form class="admin-form" method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= e($item['id']); ?>">
            <input type="hidden" name="old_image" value="<?= e($item['image']); ?>">

            <div class="form-group">
                <label for="title">Judul Artikel</label>
                <input type="text" id="title" name="title" value="<?= e($item['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <input type="text" id="category" name="category" value="<?= e($item['category']); ?>" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Ringkasan</label>
                <textarea id="excerpt" name="excerpt" rows="3" required><?= e($item['excerpt']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="content">Isi Artikel</label>
                <textarea id="content" name="content" rows="10" required><?= e($item['content']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>
                <?php if (!empty($item['image'])): ?>
                    <img class="image-preview" src="<?= url('assets/images/uploads/' . $item['image']); ?>" alt="<?= e($item['title']); ?>">
                <?php else: ?>
                    <small>Belum ada gambar.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image">Ganti Gambar</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
                <small>Kosongkan jika tidak ingin mengganti gambar.</small>
            </div>

            <div class="form-group">
                <label for="author">Penulis</label>
                <input type="text" id="author" name="author" value="<?= e($item['author']); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="published_at">Tanggal Publish</label>
                    <input type="date" id="published_at" name="published_at" value="<?= e($item['published_at']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published" <?= $item['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?= $item['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Update Artikel</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>