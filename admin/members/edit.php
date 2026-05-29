<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

$activeAdmin = 'members';
$pageTitle = 'Edit Anggota';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM division_members WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die('Data anggota tidak ditemukan.');
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
            <p>Anggota</p>
            <h1>Edit Anggota</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <?php if ($error): ?>
        <div class="alert error"><?= e(urldecode($error)); ?></div>
    <?php endif; ?>

    <section class="form-card">
        <form class="admin-form" method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= e($item['id']); ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="<?= e($item['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="position">Jabatan</label>
                    <input type="text" id="position" name="position" value="<?= e($item['position'] ?? ''); ?>">
                </div>
            </div>

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
                <label for="photo">Ganti Foto</label>
                <?php if (!empty($item['photo'])): ?>
                    <p style="margin: 0 0 10px;">
                        <img src="<?= image_url($item['photo']); ?>" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #e5e7eb;">
                    </p>
                <?php endif; ?>
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp">
                <small>Kosongkan jika tidak ingin mengubah foto.</small>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_leader" value="1" <?= !empty($item['is_leader']) ? 'checked' : ''; ?>> Koordinator Divisi
                </label>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Update Anggota</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>