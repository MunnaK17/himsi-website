<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'members';
$pageTitle = 'Kelola Anggota Divisi';

$items = [];
$divisions = [];

try {
    $stmt = $pdo->query("
        SELECT dm.*, d.name as division_name
        FROM division_members dm
        JOIN divisions d ON dm.division_id = d.id
        ORDER BY dm.is_leader DESC, dm.id ASC
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
            <h1>Anggota Divisi</h1>
        </div>
        <a class="btn btn-add" href="create.php">Tambah Anggota</a>
    </header>

    <?php if ($success): ?>
        <div class="alert success"><?= e($success); ?></div>
    <?php endif; ?>

    <section class="admin-table-card">
        <?php if (!empty($items)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['photo'])): ?>
                                    <img src="<?= image_url($item['photo']); ?>" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <div style="width: 40px; height: 40px; background: var(--color-primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                                        <?= e(substr($item['name'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= e($item['name']); ?></strong></td>
                            <td><?= e($item['position'] ?: '-'); ?></td>
                            <td><?= e($item['division_name']); ?></td>
                            <td>
                                <?php if (!empty($item['is_leader'])): ?>
                                    <span class="badge published">Koordinator</span>
                                <?php else: ?>
                                    <span class="badge draft">Staff</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-edit" href="edit.php?id=<?= e($item['id']); ?>">Edit</a>
                                <form method="POST" action="delete.php" onsubmit="return confirm('Hapus anggota ini?');">
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
                <p>Belum ada data anggota.</p>
                <small>Silakan tambah anggota baru melalui tombol "Tambah Anggota" di atas.</small>
            </div>
        <?php endif; ?>
    </section>
</main>

</body>
</html>