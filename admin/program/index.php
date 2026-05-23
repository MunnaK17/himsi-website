<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'program';
$pageTitle = 'Kelola Program Kerja';

$stmt = $pdo->query("SELECT * FROM programs ORDER BY event_date DESC, created_at DESC");
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
            <h1>Program Kerja</h1>
        </div>
        <a class="btn btn-add" href="create.php">Tambah Program</a>
    </header>

    <?php if ($success): ?>
        <div class="alert success"><?= e($success); ?></div>
    <?php endif; ?>

    <section class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Program</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e($item['title']); ?></strong><br>
                                <small><?= e(excerpt($item['description'] ?? '', 100)); ?></small>
                            </td>
                            <td><?= e(format_tanggal($item['event_date'])); ?></td>
                            <td>
                                <span class="badge <?= ($item['status'] ?? 'active') === 'active' ? 'published' : 'draft'; ?>">
                                    <?= e($item['status'] ?? 'active'); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $img = $item['image'] ?? '';
                                $isUpload = $img && str_starts_with($img, 'uploads/');
                                $imgFile = $isUpload ? __DIR__ . '/../../assets/images/' . $img : '';
                                ?>
                                <?php if ($isUpload && file_exists($imgFile)): ?>
                                    <img class="table-thumb" src="<?= e(asset('images/' . $img)); ?>" alt="<?= e($item['title']); ?>">
                                <?php elseif ($img): ?>
                                    <img class="table-thumb" src="<?= e(asset('images/default/' . $img)); ?>" alt="<?= e($item['title']); ?>">
                                <?php else: ?>
                                    <small>Tidak ada gambar</small>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-view" href="<?= url('program.php'); ?>" target="_blank">Lihat</a>
                                <a class="btn btn-edit" href="edit.php?id=<?= e($item['id']); ?>">Edit</a>
                                <form method="POST" action="delete.php" onsubmit="return confirm('Hapus program ini? File gambarnya juga akan dihapus.');">
                                    <input type="hidden" name="id" value="<?= e($item['id']); ?>">
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-table">Belum ada data program kerja.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
