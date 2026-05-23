<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'divisi';
$pageTitle = 'Kelola Divisi';

$stmt = $pdo->query("SELECT * FROM divisions ORDER BY id ASC");
$items = $stmt->fetchAll();

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
            <h1>Divisi</h1>
        </div>

        <a class="btn btn-add" href="create.php">Tambah Divisi</a>
    </header>

    <?php if ($success): ?>
        <div class="alert success"><?= e($success); ?></div>
    <?php endif; ?>

    <section class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama Divisi</th>
                    <th>Fokus Kerja</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e($item['name']); ?></strong><br>
                                <small><?= e(excerpt($item['description'] ?? '', 100)); ?></small>
                            </td>
                            <td><small><?= e(excerpt($item['focus'] ?? '-', 90)); ?></small></td>
                            <td>
                                <span class="badge <?= ($item['status'] ?? 'active') === 'active' ? 'published' : 'draft'; ?>">
                                    <?= e($item['status'] ?? 'active'); ?>
                                </span>
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-view" href="<?= url('divisi.php'); ?>" target="_blank">Lihat</a>
                                <a class="btn btn-edit" href="edit.php?id=<?= e($item['id']); ?>">Edit</a>
                                <form method="POST" action="delete.php" onsubmit="return confirm('Hapus divisi ini?');">
                                    <input type="hidden" name="id" value="<?= e($item['id']); ?>">
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="empty-table">Belum ada data divisi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
