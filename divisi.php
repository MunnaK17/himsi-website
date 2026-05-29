<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Divisi';
$activePage = 'divisi';

// Query divisi
$divisions = [];
$allMembers = [];
$membersByDivision = [];

try {
    $divisions = $pdo->query("
        SELECT d.*,
            (SELECT COUNT(*) FROM division_members dm WHERE dm.division_id = d.id) as member_count
        FROM divisions d
        WHERE d.status = 'active'
        ORDER BY d.id ASC
    ")->fetchAll();
} catch (PDOException $e) {
    $divisions = [];
}

try {
    $allMembers = $pdo->query("
        SELECT dm.*, d.name as division_name
        FROM division_members dm
        JOIN divisions d ON dm.division_id = d.id
        WHERE d.status = 'active'
        ORDER BY dm.is_leader DESC, dm.id ASC
    ")->fetchAll();

    foreach ($allMembers as $member) {
        $membersByDivision[$member['division_id']][] = $member;
    }
} catch (PDOException $e) {
    $allMembers = [];
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main>
    <!-- Hero Section -->
    <section class="page-hero-divisi">
        <div class="container">
            <div class="hero-divisi-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Divisi HIMSI
            </div>
            <h1>Divisi HIMSI UBSI</h1>
            <p>Kenali lebih dekat tim kerja HIMSI UBSI. Setiap divisi memiliki peran penting dalam menjalankan program kerja organisasi.</p>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="stats-divisi">
        <div class="container">
            <div class="stats-divisi-grid">
                <div class="stats-divisi-item">
                    <strong><?= count($divisions); ?></strong>
                    <span>Divisi Aktif</span>
                </div>
                <div class="stats-divisi-item">
                    <strong><?= array_sum(array_column($divisions, 'member_count')); ?></strong>
                    <span>Anggota Divisi</span>
                </div>
                <div class="stats-divisi-item">
                    <strong><?= array_sum(array_column($divisions, 'member_count')); ?></strong>
                    <span>Total Orang</span>
                </div>
                <div class="stats-divisi-item">
                    <strong>5+</strong>
                    <span>Tahun Berdiri</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Division Cards -->
    <section class="division-section">
        <div class="container">
            <?php if (!empty($divisions)): ?>
                <?php foreach ($divisions as $div): ?>
                    <?php
                    $members = $membersByDivision[$div['id']] ?? [];
                    $memberCount = $div['member_count'] ?? 0;
                    ?>
                    <article class="division-card-full reveal">
                        <!-- Division Header with Cover Image -->
                        <div class="division-cover-header">
                            <?php if (!empty($div['cover_image'])): ?>
                                <img src="<?= image_url($div['cover_image']); ?>" alt="<?= e($div['name']); ?>" class="cover-image">
                                <div class="cover-overlay"></div>
                            <?php else: ?>
                                <div class="cover-gradient"></div>
                            <?php endif; ?>
                            <div class="cover-content">
                                <div class="cover-left">
                                    <div class="division-emblem">
                                        <?php
                                        $parts = preg_split('/\s+/', trim($div['name']));
                                        $initials = strtoupper(substr($parts[0] ?? 'D', 0, 1));
                                        if (!empty($parts[1])) {
                                            $initials .= strtoupper(substr($parts[1], 0, 1));
                                        }
                                        echo e($initials);
                                        ?>
                                    </div>
                                </div>
                                <div class="cover-right">
                                    <h2><?= e($div['name']); ?></h2>
                                    <?php if (!empty($div['tagline'])): ?>
                                        <p class="tagline-text"><?= e($div['tagline']); ?></p>
                                    <?php endif; ?>
                                    <div class="member-badge">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                        <span><?= (int) $memberCount; ?> Anggota</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Division Info Body -->
                        <div class="division-body">
                            <div class="division-desc-section">
                                <?php if (!empty($div['description'])): ?>
                                    <div class="desc-block">
                                        <h4>Tentang Divisi</h4>
                                        <p><?= nl2br(e($div['description'])); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($div['focus'])): ?>
                                    <div class="desc-block">
                                        <h4>Fokus Kerja</h4>
                                        <p><?= nl2br(e($div['focus'])); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Members Layout -->
                            <div class="division-members-layout">
                                <?php
                                $koordinator = null;
                                $staffs = [];
                                foreach ($members as $m) {
                                    if (!empty($m['is_leader'])) {
                                        $koordinator = $m;
                                    } else {
                                        $staffs[] = $m;
                                    }
                                }
                                ?>

                                <!-- Coordinator Card -->
                                <?php if ($koordinator): ?>
                                    <div class="koordinator-panel">
                                        <div class="koordinator-card">
                                            <div class="koordinator-foto">
                                                <?php if (!empty($koordinator['photo'])): ?>
                                                    <img src="<?= image_url($koordinator['photo']); ?>" alt="<?= e($koordinator['name']); ?>">
                                                <?php else: ?>
                                                    <div class="koordinator-avatar">
                                                        <?php
                                                        $nameParts = explode(' ', $koordinator['name']);
                                                        echo e(strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : '')));
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="koordinator-info">
                                                <span class="koord-label">KOORDINATOR</span>
                                                <h3><?= e($koordinator['name']); ?></h3>
                                                <p><?= e($koordinator['position'] ?: 'Divisi'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Staff Grid -->
                                <?php if (!empty($staffs)): ?>
                                    <div class="staff-panel">
                                        <h4 class="staff-title">ANGGOTA</h4>
                                        <div class="staff-grid">
                                            <?php foreach ($staffs as $staff): ?>
                                                <div class="staff-card">
                                                    <div class="staff-foto">
                                                        <?php if (!empty($staff['photo'])): ?>
                                                            <img src="<?= image_url($staff['photo']); ?>" alt="<?= e($staff['name']); ?>">
                                                        <?php else: ?>
                                                            <div class="staff-avatar">
                                                                <?php
                                                                $nameParts = explode(' ', $staff['name']);
                                                                echo e(strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : '')));
                                                                ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="staff-info">
                                                        <strong><?= e($staff['name']); ?></strong>
                                                        <small><?= e($staff['position'] ?: 'Staff'); ?></small>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php elseif (empty($koordinator)): ?>
                                    <div class="no-members-msg">
                                        <p>Tim akan segera ditambahkan</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state-modern">
                    <h2>Data divisi belum tersedia</h2>
                    <p>Informasi divisi HIMSI UBSI akan ditampilkan di halaman ini setelah admin menambahkan datanya.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-divisi">
        <div class="container">
            <div class="cta-content-modern reveal">
                <div class="cta-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <h2>Bergabung dengan HIMSI UBSI?</h2>
                <p>Tiap semester kami membuka kesempatan untuk mahasiswa Sistem Informasi yang ingin berkembang dalam organisasi dan teknologi.</p>
                <a href="<?= url('open-recruitment'); ?>" class="btn-cta-primary">
                    Lihat Open Recruitment
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                </a>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>