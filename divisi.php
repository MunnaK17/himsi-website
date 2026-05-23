<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Divisi';
$activePage = 'divisi';

// Hanya tampilkan divisi aktif. Fallback aman jika kolom status belum di-migrasi.
try {
    $stmt = $pdo->query("SELECT * FROM divisions WHERE status = 'active' ORDER BY id ASC");
    $divisions = $stmt->fetchAll();
} catch (PDOException $e) {
    $divisions = $pdo->query("SELECT * FROM divisions ORDER BY id ASC")->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main>
    <section class="page-hero">
        <div class="container">
            <span class="section-badge">DIVISI HIMSI</span>
            <h1>Divisi HIMSI UBSI</h1>
            <p>Ruang kerja organisasi untuk menjalankan program, publikasi, pengembangan SDM, kewirausahaan, dan kolaborasi teknologi.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if ($divisions): ?>
                <div class="division-grid">
                    <?php foreach ($divisions as $division): ?>
                        <?php
                            $iconText = trim((string) ($division['icon'] ?? ''));
                            if ($iconText === '') {
                                $parts = preg_split('/\s+/', trim((string) $division['name']));
                                $iconText = strtoupper(substr($parts[0] ?? 'D', 0, 1));
                                if (!empty($parts[1])) {
                                    $iconText .= strtoupper(substr($parts[1], 0, 1));
                                }
                            }
                        ?>
                        <article class="division-card">
                            <div class="division-icon"><?= e($iconText); ?></div>
                            <h3><?= e($division['name']); ?></h3>
                            <p class="division-desc"><?= nl2br(e($division['description'])); ?></p>

                            <?php if (!empty($division['focus'])): ?>
                                <div class="division-focus">
                                    <strong>Fokus Kerja</strong>
                                    <p><?= nl2br(e($division['focus'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h2>Data divisi belum tersedia.</h2>
                    <p>Informasi divisi HIMSI UBSI akan ditampilkan di halaman ini setelah admin menambahkan datanya.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
