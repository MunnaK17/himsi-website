<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Beranda';
$activePage = 'beranda';

$pressStmt = $pdo->query("SELECT * FROM press_releases WHERE status = 'published' ORDER BY published_at DESC, created_at DESC LIMIT 3");
$pressReleases = $pressStmt->fetchAll();

try {
    $programStmt = $pdo->query("SELECT * FROM programs WHERE status = 'active' ORDER BY event_date DESC, created_at DESC LIMIT 4");
    $programs = $programStmt->fetchAll();
} catch (PDOException $e) {
    $programs = $pdo->query("SELECT * FROM programs ORDER BY event_date DESC, created_at DESC LIMIT 4")->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main>
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container hero-content reveal">
            <p class="eyebrow light">HIMSI UBSI</p>
            <h1>Himpunan Mahasiswa Sistem Informasi Universitas Bina Sarana Informatika</h1>
            <p>Menjadi wadah aspirasi, kolaborasi, dan pengembangan diri bagi mahasiswa Sistem Informasi UBSI menuju masa depan teknologi yang inovatif.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= url('open-recruitment'); ?>">Gabung Kami</a>
                <a class="btn btn-outline-light" href="<?= url('program'); ?>">Jelajahi Program</a>
            </div>
        </div>
    </section>

    <section class="section about-section">
        <div class="container two-column">
            <div class="reveal">
                <span class="badge dark">Tentang Kami</span>
                <h2>Membangun Ekosistem Digital yang Kolaboratif</h2>
                <p>HIMSI Universitas Bina Sarana Informatika adalah organisasi kemahasiswaan yang berfokus pada pengembangan kompetensi akademik dan non-akademik di bidang teknologi informasi.</p>
                <p>Dengan semangat inovasi, kami menyelenggarakan berbagai kegiatan mulai dari workshop teknis, kompetisi tingkat nasional, hingga pengabdian masyarakat berbasis teknologi.</p>
                <a class="link-arrow" href="<?= url('profil'); ?>">Profil Selengkapnya →</a>
            </div>
            <div class="image-card reveal">
                <img src="<?= asset('images/default/1.jpg'); ?>" alt="Mahasiswa berkolaborasi di laboratorium komputer">
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="container stats-grid">
            <div><strong>15+</strong><span>Program Kerja</span></div>
            <div><strong>2500+</strong><span>Alumni Aktif</span></div>
            <div><strong>450+</strong><span>Anggota Aktif</span></div>
            <div><strong>50+</strong><span>Penghargaan</span></div>
        </div>
    </section>

    <section class="section muted-section">
        <div class="container">
            <div class="section-heading split reveal">
                <div>
                    <span class="badge yellow">Program Kerja</span>
                    <h2>Inovasi Melalui Program Unggulan</h2>
                </div>
                <a class="btn btn-dark" href="<?= url('program'); ?>">Lihat Semua Program</a>
            </div>

            <div class="program-grid">
                <?php foreach ($programs as $index => $program): ?>
                    <article class="program-card <?= $index === 0 ? 'featured' : ''; ?> reveal">
                        <img src="<?= image_url($program['image'], 'default/program-workshop.svg'); ?>" alt="<?= e($program['title']); ?>">
                        <div class="program-content">
                            <h3><?= e($program['title']); ?></h3>
                            <p><?= e($program['description']); ?></p>
                            <span><?= format_tanggal($program['event_date']); ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-heading center reveal">
                <h2>Workshop & Berita Terbaru</h2>
                <p>Update terkini mengenai kegiatan akademis dan event mendatang di lingkungan HIMSI UBSI.</p>
            </div>

            <div class="card-grid">
                <?php foreach ($pressReleases as $item): ?>
                    <article class="press-card reveal">
                        <img src="<?= image_url($item['image']); ?>" alt="<?= e($item['title']); ?>">
                        <div class="press-body">
                            <span class="category"><?= e($item['category']); ?></span>
                            <small><?= format_tanggal($item['published_at']); ?></small>
                            <h3><?= e($item['title']); ?></h3>
                            <p><?= e($item['excerpt']); ?></p>
                            <a href="<?= url('detail-press-release?slug=' . e($item['slug'])); ?>">Baca Detail →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section contact-preview">
        <div class="container two-column">
            <div class="reveal">
                <span class="badge dark">Kontak</span>
                <h2>Hubungi Kami</h2>
                <p>Punya pertanyaan atau ingin berkolaborasi? Kami siap menyambut Anda di Sekretariat HIMSI UBSI.</p>
                <div class="contact-list">
                    <div><strong>Telepon</strong><span>+62 21 8000 000</span></div>
                    <div><strong>Email</strong><span>himsi@bsi.ac.id</span></div>
                    <div><strong>Alamat</strong><span>Jl. Kemanggisan Utama Raya, RT.3/RW.2, Slipi, Kec. Palmerah, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11480</span></div>
                </div>
            </div>
            <div class="map-card reveal">
                <div class="map-frame">
                    <iframe
                        src="https://www.google.com/maps?q=Universitas+Bina+Sarana+Informatika+Kampus+Slipi&output=embed"
                        width="100%"
                        height="320"
                        style="border:0;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        title="Lokasi HIMSI UBSI di Google Maps">
                    </iframe>
                </div>
                <a class="map-link" href="https://www.google.com/maps/search/?api=1&query=Universitas+Bina+Sarana+Informatika+Kampus+Slipi" target="_blank" rel="noopener">Buka di Google Maps →</a>
                <div class="office-hour"><span>Jam Operasional</span><strong>09:00 - 17:00</strong></div>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
