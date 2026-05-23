<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';

if (!$slug) {
    header('Location: press-release.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM press_releases WHERE slug = ? AND status = 'published' LIMIT 1");
$stmt->execute([$slug]);
$article = $stmt->fetch();

if (!$article) {
    http_response_code(404);
    die('Artikel tidak ditemukan atau belum dipublikasikan.');
}

$pageTitle = $article['title'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/includes/header.php'; ?>
</head>
<body>

<?php include __DIR__ . '/includes/navbar.php'; ?>

<main>
    <section class="article-detail-hero">
        <div class="container narrow">
            <span class="section-badge"><?= e($article['category']); ?></span>
            <h1><?= e($article['title']); ?></h1>
            <p><?= e(format_tanggal($article['published_at'])); ?> • <?= e($article['author']); ?></p>
        </div>
    </section>

    <section class="section">
        <div class="container narrow">
            <div class="detail-cover">
                <?php if (!empty($article['image'])): ?>
                    <img src="<?= url('assets/images/uploads/' . $article['image']); ?>" alt="<?= e($article['title']); ?>">
                <?php else: ?>
                    <img src="<?= url('assets/images/default/default-news.jpg'); ?>" alt="<?= e($article['title']); ?>">
                <?php endif; ?>
            </div>

            <article class="article-detail-content">
                <p class="lead"><?= e($article['excerpt']); ?></p>
                <?= nl2br(e($article['content'])); ?>
            </article>

            <div class="detail-actions">
                <a class="btn-secondary" href="<?= url('press-release.php'); ?>">← Kembali ke Press Release</a>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>