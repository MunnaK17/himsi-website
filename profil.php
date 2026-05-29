<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Profil HIMSI';

// Query data untuk struktur organisasi
$structureData = [];

try {
    // Ambil semua member dengan division info
    $members = $pdo->query("
        SELECT dm.*, d.name as division_name, d.tagline as division_tagline
        FROM division_members dm
        JOIN divisions d ON dm.division_id = d.id
        WHERE d.status = 'active'
        ORDER BY dm.is_leader DESC, dm.id ASC
    ")->fetchAll();

    // Group by division
    $membersByDivision = [];
    foreach ($members as $m) {
        $membersByDivision[$m['division_id']][] = $m;
    }

    // Ambil divisi untuk struktur
    $divisions = $pdo->query("SELECT * FROM divisions WHERE status = 'active' ORDER BY id ASC")->fetchAll();
} catch (PDOException $e) {
    $members = [];
    $divisions = [];
    $membersByDivision = [];
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main>
    <!-- Hero Section -->
    <section class="page-hero-profil">
        <div class="container">
            <span class="section-badge">PROFIL HIMSI</span>
            <h1>Mengenal HIMSI UBSI</h1>
            <p>Himpunan Mahasiswa Sistem Informasi sebagai wadah aspirasi, pengembangan diri, dan kolaborasi mahasiswa Sistem Informasi UBSI.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="container profile-grid">
            <div>
                <span class="section-badge">SEJARAH</span>
                <h2>Sejarah Organisasi</h2>
                <p>HIMSI Universitas Bina Sarana Informatika merupakan organisasi kemahasiswaan yang dibentuk sebagai wadah pengembangan potensi mahasiswa Sistem Informasi dalam bidang akademik, teknologi, kepemimpinan, dan sosial.</p>
                <p>Melalui berbagai kegiatan seperti seminar, workshop, kompetisi, pengabdian masyarakat, dan diskusi teknologi, HIMSI berperan dalam membangun ekosistem mahasiswa yang aktif, adaptif, dan inovatif.</p>
            </div>

            <div class="profile-card">
                <h3>Identitas Organisasi</h3>
                <ul>
                    <li><strong>Nama:</strong> Himpunan Mahasiswa Sistem Informasi</li>
                    <li><strong>Universitas:</strong> Universitas Bina Sarana Informatika</li>
                    <li><strong>Fokus:</strong> Akademik, teknologi, organisasi, dan pengabdian</li>
                    <li><strong>Bidang:</strong> Sistem Informasi dan Teknologi Digital</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section class="section section-soft">
        <div class="container vision-grid">
            <div class="vision-card">
                <h2>Visi</h2>
                <p>Menjadi organisasi mahasiswa Sistem Informasi yang unggul, kolaboratif, inovatif, dan berperan aktif dalam pengembangan kompetensi mahasiswa di era digital.</p>
            </div>

            <div class="vision-card">
                <h2>Misi</h2>
                <ul>
                    <li>Mengembangkan kompetensi mahasiswa di bidang sistem informasi dan teknologi.</li>
                    <li>Menjadi wadah aspirasi dan kolaborasi mahasiswa Sistem Informasi.</li>
                    <li>Menyelenggarakan kegiatan akademik dan non-akademik yang bermanfaat.</li>
                    <li>Membangun karakter kepemimpinan, tanggung jawab, dan profesionalisme anggota.</li>
                    <li>Meningkatkan kontribusi mahasiswa melalui kegiatan sosial dan pengabdian masyarakat.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Struktur Organisasi Section - Interactive -->
    <section class="section struktur-section">
        <div class="container">
            <div class="section-heading center">
                <span class="section-badge">STRUKTUR</span>
                <h2>Struktur Kepengurusan</h2>
                <p>Susunan pengurus HIMSI UBSI. Klik pada setiap level untuk melihat detail.</p>
            </div>

            <!-- Interactive Organization Tree -->
            <div class="org-tree-container">
                <!-- Level 1: Ketua Umum -->
                <div class="org-level level-pengurus-inti">
                    <div class="org-node node-ketua" onclick="toggleExpand(this)">
                        <div class="node-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="node-info">
                            <h3>Ketua Umum</h3>
                            <p>Nama Ketua Umum</p>
                        </div>
                        <div class="node-expand">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>

                    <!-- Level 2: Wakil Ketua -->
                    <div class="org-row-level-2">
                        <div class="org-node node-wakil" onclick="toggleExpand(this)">
                            <div class="node-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                            <div class="node-info">
                                <h3>Wakil Ketua</h3>
                                <p>Nama Wakil Ketua</p>
                            </div>
                            <div class="node-expand">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        <!-- Level 3: Sekjen & Bendahara -->
                        <div class="org-row-level-3">
                            <div class="org-node node-sekjen" onclick="toggleExpand(this)">
                                <div class="node-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                </div>
                                <div class="node-info">
                                    <h3>Sekretaris</h3>
                                    <p>Nama Sekretaris</p>
                                </div>
                            </div>

                            <div class="org-node node-bendahara" onclick="toggleExpand(this)">
                                <div class="node-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.36c-1.41.41-2.7 1.03-2.7 2.15 0 1.95 2.11 2.02 2.57 2.84.37.66.64 1.36.64 1.95 0 2.36-2.01 2.75-3.54 3.28-.87.3-1.64 1.03-1.64 2.3v.2h12v-.2c0-1.41-.9-2.3-2.21-2.64-1.15-.3-3.54-.92-3.54-3.54 0-1.81.9-2.71 2.01-3.14.64-.25 1.36-.39 2.01-.39V11h-2V9.1l.9-.2z"/></svg>
                                </div>
                                <div class="node-info">
                                    <h3>Bendahara</h3>
                                    <p>Nama Bendahara</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connector Line -->
                <div class="org-connector">
                    <div class="connector-line"></div>
                    <div class="connector-branch"></div>
                </div>

                <!-- Level 4: Coordinator Divisi -->
                <div class="org-level level-divisi">
                    <div class="level-divisi-header" onclick="toggleExpand(this)">
                        <div class="header-content">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            <span>Koordinator Divisi</span>
                        </div>
                        <div class="expand-hint">
                            <span>Klik untuk lihat anggota</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>

                    <!-- Division Nodes -->
                    <div class="divisi-grid">
                        <?php if (!empty($divisions)): ?>
                            <?php foreach ($divisions as $div): ?>
                                <?php $members = $membersByDivision[$div['id']] ?? []; ?>
                                <div class="divisi-card" onclick="toggleExpand(this)">
                                    <div class="divisi-header">
                                        <div class="divisi-icon">
                                            <?php
                                            $parts = preg_split('/\s+/', trim($div['name']));
                                            $initials = strtoupper(substr($parts[0] ?? 'D', 0, 1));
                                            if (!empty($parts[1])) {
                                                $initials .= strtoupper(substr($parts[1], 0, 1));
                                            }
                                            echo e($initials);
                                            ?>
                                        </div>
                                        <div class="divisi-info">
                                            <h4><?= e($div['name']); ?></h4>
                                            <?php if (!empty($div['tagline'])): ?>
                                                <small><?= e($div['tagline']); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="divisi-expand">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>

                                    <!-- Expanded Members -->
                                    <div class="divisi-members">
                                        <?php if (!empty($members)): ?>
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

                                            <?php if ($koordinator): ?>
                                                <div class="member-koordinator">
                                                    <div class="member-avatar">
                                                        <?php if (!empty($koordinator['photo'])): ?>
                                                            <img src="<?= image_url($koordinator['photo']); ?>" alt="">
                                                        <?php else: ?>
                                                            <div class="avatar-placeholder">
                                                                <?= e(substr($koordinator['name'], 0, 1)); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="member-detail">
                                                        <strong><?= e($koordinator['name']); ?></strong>
                                                        <span><?= e($koordinator['position'] ?: 'Koordinator'); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($staffs)): ?>
                                                <div class="member-staff-grid">
                                                    <?php foreach ($staffs as $staff): ?>
                                                        <div class="member-staff">
                                                            <div class="member-avatar-sm">
                                                                <?php if (!empty($staff['photo'])): ?>
                                                                    <img src="<?= image_url($staff['photo']); ?>" alt="">
                                                                <?php else: ?>
                                                                    <div class="avatar-placeholder-sm">
                                                                        <?= e(substr($staff['name'], 0, 1)); ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="member-detail-sm">
                                                                <strong><?= e($staff['name']); ?></strong>
                                                                <small><?= e($staff['position'] ?: 'Staff'); ?></small>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p class="no-members">Belum ada data anggota</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-divisi">
                                <p>Data divisi belum tersedia</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Toggle expand/collapse for org nodes
function toggleExpand(element) {
    element.classList.toggle('expanded');

    // Special handling for level-divisi-header
    if (element.classList.contains('level-divisi-header')) {
        const grid = element.nextElementSibling;
        if (grid && grid.classList.contains('divisi-grid')) {
            grid.classList.toggle('show');
        }
    }
}

// Show divisi grid by default on load
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.level-divisi-header');
    const grid = document.querySelector('.divisi-grid');
    if (header && grid) {
        header.classList.add('expanded');
        grid.classList.add('show');
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>