<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/auth.php';
require_admin();

$activeAdmin = 'dashboard';
$pageTitle = 'Dashboard Admin HIMSI';
$totalPress = $pdo->query('SELECT COUNT(*) AS total FROM press_releases')->fetch()['total'];
$totalPublished = $pdo->query("SELECT COUNT(*) AS total FROM press_releases WHERE status = 'published'")->fetch()['total'];
$totalPrograms = $pdo->query('SELECT COUNT(*) AS total FROM programs')->fetch()['total'];
$totalDivisions = $pdo->query('SELECT COUNT(*) AS total FROM divisions')->fetch()['total'];
$totalOprec = $pdo->query('SELECT COUNT(*) AS total FROM open_recruitments')->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head><?php include __DIR__ . '/includes/head.php'; ?></head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="admin-main">
        <header class="admin-header">
            <div>
                <p>Selamat datang,</p>
                <h1><?= e($_SESSION['admin_name']); ?></h1>
            </div>
            <a class="btn-admin" href="<?= url('index.php'); ?>" target="_blank">Preview Website</a>
        </header>
        <section class="dashboard-grid">
            <article class="stat-card"><span>Total Press Release</span><strong><?= e($totalPress); ?></strong></article>
            <article class="stat-card"><span>Dipublikasikan</span><strong><?= e($totalPublished); ?></strong></article>
            <article class="stat-card"><span>Program Kerja</span><strong><?= e($totalPrograms); ?></strong></article>
            <article class="stat-card"><span>Divisi</span><strong><?= e($totalDivisions); ?></strong></article>
            <article class="stat-card"><span>Open Recruitment</span><strong><?= e($totalOprec); ?></strong></article>
        </section>
        <section class="admin-panel-note">
            <h2>Panel admin siap digunakan</h2>
            <p>Kelola Press Release, Program Kerja, Divisi, dan Open Recruitment lewat menu di sidebar. Semua perubahan langsung tampil di halaman publik (kecuali yang berstatus draft / inactive).</p>
        </section>
    </main>
</body>
</html>
