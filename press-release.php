<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Press Release';

$stmt = $pdo->prepare("SELECT * FROM press_releases WHERE status = 'published' ORDER BY published_at DESC");
$stmt->execute();
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/includes/header.php'; ?>
</head>
<body>

<?php include __DIR__ . '/includes/navbar.php'; ?>

<main>
    <section class="page-hero">
        <div class="container">
            <span class="section-badge">PRESS RELEASE</span>
            <h1>Berita Resmi HIMSI</h1>
            <p>Publikasi kegiatan, informasi organisasi, dan dokumentasi resmi Himpunan Mahasiswa Sistem Informasi UBSI.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if ($articles): ?>
                <div class="article-grid">
                    <?php foreach ($articles as $article): ?>
                        <article class="article-card">
                            <div class="article-image">
                                <?php if (!empty($article['image'])): ?>
                                    <img src="<?= url('assets/images/uploads/' . $article['image']); ?>" alt="<?= e($article['title']); ?>">
                                <?php else: ?>
                                    <img src="<?= url('assets/images/default/default-news.jpg'); ?>" alt="<?= e($article['title']); ?>">
                                <?php endif; ?>

                                <span class="article-category"><?= e($article['category']); ?></span>
                            </div>

                            <div class="article-content">
                                <div class="article-meta">
                                    <?= e(format_tanggal($article['published_at'])); ?> • <?= e($article['author']); ?>
                                </div>

                                <h2><?= e($article['title']); ?></h2>
                                <p><?= e(excerpt($article['excerpt'], 130)); ?></p>

                                <a class="article-link" href="<?= url('detail-press-release.php?slug=' . $article['slug']); ?>">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h2>Belum ada press release.</h2>
                    <p>Berita resmi HIMSI akan ditampilkan di halaman ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>