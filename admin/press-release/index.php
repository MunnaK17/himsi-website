<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'press-release';
$pageTitle = 'Kelola Press Release';

$stmt = $pdo->query("SELECT * FROM press_releases ORDER BY created_at DESC");
$items = $stmt->fetchAll();

$success = $_GET['success'] ?? '';
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
            <p>Konten Website</p>
            <h1>Press Release</h1>
        </div>

        <a class="btn btn-add" href="create.php">Tambah Press Release</a>
    </header>

    <?php if ($success): ?>
        <div class="alert success">
            <?= e($success); ?>
        </div>
    <?php endif; ?>

    <section class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($items): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e($item['title']); ?></strong><br>
                                <small><?= e($item['slug']); ?></small>
                            </td>

                            <td><?= e($item['category']); ?></td>

                            <td>
                                <span class="badge <?= $item['status'] === 'published' ? 'published' : 'draft'; ?>">
                                    <?= e($item['status']); ?>
                                </span>
                            </td>

                            <td><?= e(format_tanggal($item['published_at'])); ?></td>

                            <td class="table-actions">
                                <a 
                                    class="btn btn-view" 
                                    href="<?= url('detail-press-release.php?slug=' . $item['slug']); ?>" 
                                    target="_blank"
                                >
                                    Lihat
                                </a>

                                <a 
                                    class="btn btn-edit" 
                                    href="edit.php?id=<?= e($item['id']); ?>"
                                >
                                    Edit
                                </a>

                                <form 
                                    method="POST" 
                                    action="delete.php" 
                                    onsubmit="return confirm('Hapus press release ini?');"
                                >
                                    <input type="hidden" name="id" value="<?= e($item['id']); ?>">
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-table">
                            Belum ada press release.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>