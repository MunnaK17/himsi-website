<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Program Kerja';
$activePage = 'program';

// Hanya tampilkan program aktif. Fallback aman jika kolom status belum di-migrasi.
try {
    $stmt = $pdo->query("SELECT * FROM programs WHERE status = 'active' ORDER BY event_date DESC, created_at DESC");
    $programs = $stmt->fetchAll();
} catch (PDOException $e) {
    $programs = $pdo->query("SELECT * FROM programs ORDER BY event_date DESC, created_at DESC")->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main>
    <section class="page-hero">
        <div class="container">
            <span class="section-badge">PROGRAM KERJA</span>
            <h1>Program dan Dokumentasi Kegiatan</h1>
            <p>Kumpulan kegiatan unggulan, workshop, kompetisi, dan pengabdian masyarakat HIMSI UBSI.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if ($programs): ?>
                <div class="program-public-grid">
                    <?php foreach ($programs as $program): ?>
                        <article class="program-public-card">
                            <div class="program-public-image">
                                <img src="<?= e(image_url($program['image'], 'default/program-workshop.svg')); ?>" alt="<?= e($program['title']); ?>">
                            </div>
                            <div class="program-public-body">
                                <span class="program-date"><?= e(format_tanggal($program['event_date'])); ?></span>
                                <h3><?= e($program['title']); ?></h3>
                                <p><?= e(excerpt($program['description'], 160)); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h2>Belum ada program kerja yang dipublikasikan.</h2>
                    <p>Daftar program kerja HIMSI UBSI akan ditampilkan di halaman ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
