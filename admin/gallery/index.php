<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'gallery';
$pageTitle = 'Kelola Galeri';

$items = [];
$divisions = [];

try {
    $stmt = $pdo->query("
        SELECT dg.*, d.name as division_name
        FROM division_galleries dg
        JOIN divisions d ON dg.division_id = d.id
        ORDER BY dg.id DESC
    ");
    $items = $stmt->fetchAll();
} catch (PDOException $e) {
    $items = [];
}

try {
    $divisions = $pdo->query("SELECT * FROM divisions WHERE status = 'active' ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $divisions = [];
}

$success = $_GET['success'] ?? '';
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
            <p>Konten Website</p>
            <h1>Galeri Kegiatan Divisi</h1>
        </div>
        <a class="btn btn-add" href="create.php">Tambah Foto</a>
    </header>

    <?php if ($success): ?>
        <div class="alert success"><?= e($success); ?></div>
    <?php endif; ?>

    <section class="admin-table-card">
        <?php if (!empty($items)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Divisi</th>
                        <th>Featured</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <img src="<?= image_url($item['image'], 'default/gallery-default.jpg'); ?>" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td>
                                <strong><?= e($item['title'] ?: '-'); ?></strong><br>
                                <small><?= e(excerpt($item['caption'] ?? '', 80)); ?></small>
                            </td>
                            <td><?= e($item['division_name']); ?></td>
                            <td>
                                <?php if (!empty($item['is_featured'])): ?>
                                    <span class="badge published">Featured</span>
                                <?php else: ?>
                                    <span class="badge draft">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-edit" href="edit.php?id=<?= e($item['id']); ?>">Edit</a>
                                <form method="POST" action="delete.php" onsubmit="return confirm('Hapus foto ini?');">
                                    <input type="hidden" name="id" value="<?= e($item['id']); ?>">
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-table">
                <p>Belum ada foto galeri.</p>
                <small>Silakan tambah foto baru melalui tombol "Tambah Foto" di atas.</small>
            </div>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
