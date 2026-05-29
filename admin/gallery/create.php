<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

$activeAdmin = 'gallery';
$pageTitle = 'Tambah Galeri';

$divisions = [];
try {
    $divisions = $pdo->query("SELECT * FROM divisions WHERE status = 'active' ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $divisions = [];
}

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
            <h1>Tambah Foto Galeri</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <?php if ($error): ?>
        <div class="alert error"><?= e(urldecode($error)); ?></div>
    <?php endif; ?>

    <section class="form-card">
        <form class="admin-form" method="POST" action="store.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="division_id">Divisi</label>
                <?php if (!empty($divisions)): ?>
                    <select id="division_id" name="division_id" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisions as $div): ?>
                            <option value="<?= e($div['id']); ?>"><?= e($div['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <p class="error-text">Belum ada divisi. Silakan tambah divisi terlebih dahulu.</p>
                    <a class="btn btn-edit" href="<?= url('admin/divisi/create.php'); ?>">Tambah Divisi</a>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="title">Judul Foto</label>
                <input type="text" id="title" name="title" maxlength="200" placeholder="Contoh: Workshop Content Writing">
            </div>

            <div class="form-group">
                <label for="image">Upload Gambar</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" required>
                <small>Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
            </div>

            <div class="form-group">
                <label for="caption">Caption / Deskripsi</label>
                <textarea id="caption" name="caption" rows="3" placeholder="Deskripsi singkat tentang foto ini..."></textarea>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured" value="1"> Tampilkan di utama
                </label>
            </div>

            <?php if (!empty($divisions)): ?>
                <div class="form-actions">
                    <button class="btn btn-add" type="submit">Simpan Galeri</button>
                    <a class="btn btn-edit" href="index.php">Batal</a>
                </div>
            <?php else: ?>
                <div class="form-actions">
                    <a class="btn btn-edit" href="index.php">Kembali</a>
                </div>
            <?php endif; ?>
        </form>
    </section>
</main>

</body>
</html>
