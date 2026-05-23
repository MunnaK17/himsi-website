<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'open-recruitment';
$pageTitle = 'Edit Open Recruitment';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM open_recruitments WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die('Data tidak ditemukan.');
}

$posterUrl = '';
$posterPath = '';

if (!empty($item['poster'])) {
    $posterPath = __DIR__ . '/../../assets/images/uploads/' . $item['poster'];

    if (file_exists($posterPath)) {
        $posterUrl = url('assets/images/uploads/' . $item['poster']);
    }
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
            <p>Open Recruitment</p>
            <h1>Edit Informasi</h1>
        </div>

        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <section class="form-card">
        <form class="admin-form" method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= e($item['id']); ?>">
            <input type="hidden" name="old_poster" value="<?= e($item['poster']); ?>">

            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" id="title" name="title" value="<?= e($item['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="5" required><?= e($item['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="schedule">Jadwal</label>
                <textarea id="schedule" name="schedule" rows="4" required><?= e($item['schedule']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="requirements">Syarat</label>
                <textarea id="requirements" name="requirements" rows="5" required><?= e($item['requirements']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="selection_steps">Tahapan Seleksi</label>
                <textarea id="selection_steps" name="selection_steps" rows="5" required><?= e($item['selection_steps']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="divisions">Divisi Dibuka</label>
                <textarea id="divisions" name="divisions" rows="5" required><?= e($item['divisions']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Poster Saat Ini</label>

                <?php if ($posterUrl): ?>
                    <img class="image-preview" src="<?= e($posterUrl); ?>" alt="<?= e($item['title']); ?>">
                <?php else: ?>
                    <small>Poster belum tersedia atau file tidak ditemukan.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="poster">Ganti Poster</label>
                <input type="file" id="poster" name="poster" accept="image/jpeg,image/png,image/webp">
                <small>Kosongkan jika tidak ingin mengganti poster. Format JPG, PNG, WEBP. Maksimal 2MB.</small>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="active" <?= $item['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?= $item['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Update Open Recruitment</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>