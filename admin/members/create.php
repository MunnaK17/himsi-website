<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

$activeAdmin = 'members';
$pageTitle = 'Tambah Anggota';

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
            <p>Anggota</p>
            <h1>Tambah Anggota</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <?php if ($error): ?>
        <div class="alert error"><?= e(urldecode($error)); ?></div>
    <?php endif; ?>

    <section class="form-card">
        <?php if (empty($divisions)): ?>
            <div class="empty-table">
                <p>Belum ada divisi.</p>
                <small>Silakan tambah divisi terlebih dahulu.</small>
                <div style="margin-top: 16px;">
                    <a class="btn btn-edit" href="<?= url('admin/divisi/create.php'); ?>">Tambah Divisi</a>
                </div>
            </div>
        <?php else: ?>
            <form class="admin-form" method="POST" action="store.php" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required placeholder="Contoh: Ahmad Fauzi Rahman">
                    </div>

                    <div class="form-group">
                        <label for="position">Jabatan</label>
                        <input type="text" id="position" name="position" placeholder="Contoh: Staff Publikasi">
                    </div>
                </div>

                <div class="form-group">
                    <label for="division_id">Divisi</label>
                    <select id="division_id" name="division_id" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisions as $div): ?>
                            <option value="<?= e($div['id']); ?>"><?= e($div['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="photo">Upload Foto</label>
                    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp">
                    <small>Format: JPG, PNG, WEBP. Maksimal 2MB. Kosongkan untuk avatar otomatis.</small>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_leader" value="1"> Koordinator Divisi
                    </label>
                    <small>Centang jika orang ini koordinator divisi.</small>
                </div>

                <div class="form-actions">
                    <button class="btn btn-add" type="submit">Simpan Anggota</button>
                    <a class="btn btn-edit" href="index.php">Batal</a>
                </div>
            </form>
        <?php endif; ?>
    </section>
</main>

</body>
</html>