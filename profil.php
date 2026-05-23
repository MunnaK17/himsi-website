<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Profil HIMSI';
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
            <span class="section-badge">PROFIL HIMSI</span>
            <h1>Mengenal HIMSI UBSI</h1>
            <p>Himpunan Mahasiswa Sistem Informasi sebagai wadah aspirasi, pengembangan diri, dan kolaborasi mahasiswa Sistem Informasi UBSI.</p>
        </div>
    </section>

    <section class="section">
        <div class="container profile-grid">
            <div>
                <span class="section-badge">SEJARAH</span>
                <h2>Sejarah Organisasi</h2>
                <p>
                    HIMSI Universitas Bina Sarana Informatika merupakan organisasi kemahasiswaan yang dibentuk sebagai wadah pengembangan potensi mahasiswa Sistem Informasi dalam bidang akademik, teknologi, kepemimpinan, dan sosial.
                </p>
                <p>
                    Melalui berbagai kegiatan seperti seminar, workshop, kompetisi, pengabdian masyarakat, dan diskusi teknologi, HIMSI berperan dalam membangun ekosistem mahasiswa yang aktif, adaptif, dan inovatif.
                </p>
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

    <section class="section section-soft">
        <div class="container vision-grid">
            <div class="vision-card">
                <h2>Visi</h2>
                <p>
                    Menjadi organisasi mahasiswa Sistem Informasi yang unggul, kolaboratif, inovatif, dan berperan aktif dalam pengembangan kompetensi mahasiswa di era digital.
                </p>
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

    <section class="section">
        <div class="container">
            <div class="section-heading">
                <span class="section-badge">STRUKTUR ORGANISASI</span>
                <h2>Struktur Kepengurusan</h2>
                <p>Susunan pengurus inti HIMSI UBSI periode berjalan.</p>
            </div>

            <div class="structure-grid">
                <div class="structure-card main">
                    <h3>Ketua HIMSI</h3>
                    <p>Memimpin organisasi dan mengoordinasikan seluruh program kerja.</p>
                </div>

                <div class="structure-card">
                    <h3>Wakil Ketua</h3>
                    <p>Mendampingi ketua dalam pengawasan dan pelaksanaan agenda organisasi.</p>
                </div>

                <div class="structure-card">
                    <h3>Sekretaris</h3>
                    <p>Mengelola administrasi, surat-menyurat, dan dokumentasi organisasi.</p>
                </div>

                <div class="structure-card">
                    <h3>Bendahara</h3>
                    <p>Mengelola keuangan organisasi secara tertib dan transparan.</p>
                </div>

                <div class="structure-card">
                    <h3>Koordinator Divisi</h3>
                    <p>Mengoordinasikan program kerja pada masing-masing divisi HIMSI.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>