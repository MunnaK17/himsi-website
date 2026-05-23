<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'open-recruitment';
$pageTitle = 'Kelola Open Recruitment';

$stmt = $pdo->query("SELECT * FROM open_recruitments ORDER BY id DESC");
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
            <h1>Open Recruitment</h1>
        </div>
    </header>

    <?php if ($success): ?>
        <div class="alert success"><?= e($success); ?></div>
    <?php endif; ?>

    <section class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Poster</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e($item['title']); ?></strong><br>
                                <small><?= e(excerpt($item['description'], 90)); ?></small>
                            </td>
                            <td><?= nl2br(e($item['schedule'])); ?></td>
                            <td>
                                <span class="badge <?= $item['status'] === 'active' ? 'published' : 'draft'; ?>">
                                    <?= e($item['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $posterPath = !empty($item['poster']) ? __DIR__ . '/../../assets/images/uploads/' . $item['poster'] : '';
                                ?>
                                <?php if ($posterPath && file_exists($posterPath)): ?>
                                    <img class="table-thumb" src="<?= url('assets/images/uploads/' . $item['poster']); ?>" alt="<?= e($item['title']); ?>">
                                <?php else: ?>
                                    <small>Tidak ada poster</small>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-view" href="<?= url('open-recruitment.php'); ?>" target="_blank">Lihat</a>
                                <a class="btn btn-edit" href="edit.php?id=<?= e($item['id']); ?>">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-table">Belum ada data open recruitment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>