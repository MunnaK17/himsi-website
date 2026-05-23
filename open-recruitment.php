<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Open Recruitment';

$stmt = $pdo->prepare("SELECT * FROM open_recruitments WHERE status = 'active' ORDER BY updated_at DESC LIMIT 1");
$stmt->execute();
$recruitment = $stmt->fetch();

$posterUrl = '';

if ($recruitment && !empty($recruitment['poster'])) {
    $posterFile = $recruitment['poster'];
    $posterPath = __DIR__ . '/assets/images/uploads/' . $posterFile;

    if (file_exists($posterPath)) {
        $posterUrl = url('assets/images/uploads/' . $posterFile);
    }
}
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
            <span class="section-badge">OPEN RECRUITMENT</span>
            <h1>Open Recruitment HIMSI UBSI</h1>
            <p>Informasi resmi mengenai jadwal, persyaratan, tahapan seleksi, dan divisi yang dibuka.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if ($recruitment): ?>
                <div class="or-grid">
                    <div class="or-content">
                        <span class="section-badge">INFORMASI REKRUTMEN</span>
                        <h2><?= e($recruitment['title']); ?></h2>
                        <p><?= nl2br(e($recruitment['description'])); ?></p>

                        <div class="or-info-card">
                            <h3>Jadwal Open Recruitment</h3>
                            <p><?= nl2br(e($recruitment['schedule'])); ?></p>
                        </div>

                        <div class="or-info-card">
                            <h3>Syarat Pendaftaran</h3>
                            <p><?= nl2br(e($recruitment['requirements'])); ?></p>
                        </div>

                        <div class="or-info-card">
                            <h3>Tahapan Seleksi</h3>
                            <p><?= nl2br(e($recruitment['selection_steps'])); ?></p>
                        </div>

                        <div class="or-info-card">
                            <h3>Divisi yang Dibuka</h3>
                            <p><?= nl2br(e($recruitment['divisions'])); ?></p>
                        </div>

                        <div class="notice-box">
                            <strong>Catatan:</strong> Website ini hanya menampilkan informasi open recruitment. Pendaftaran online tidak tersedia melalui website.
                        </div>
                    </div>

                    <div class="or-poster">
                        <?php if ($posterUrl): ?>
                            <img src="<?= e($posterUrl); ?>" alt="<?= e($recruitment['title']); ?>">
                        <?php else: ?>
                            <div class="poster-placeholder">
                                <h3>Poster Open Recruitment</h3>
                                <p>Poster belum tersedia atau file gambar tidak ditemukan.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h2>Open recruitment belum dibuka.</h2>
                    <p>Informasi recruitment akan ditampilkan ketika periode pendaftaran telah diumumkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>