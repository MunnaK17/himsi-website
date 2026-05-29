<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

$activeAdmin = 'divisi';
$pageTitle = 'Tambah Divisi';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/../includes/head.php'; ?>
</head>
<body>

<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<main class="admin-main">
    <header class="admin-header">
        <div>
            <p>Divisi</p>
            <h1>Tambah Divisi</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <section class="form-card">
        <form class="admin-form" method="POST" action="store.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Divisi</label>
                <input type="text" id="name" name="name" placeholder="Contoh: Divisi Kominfo" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Divisi</label>
                <textarea id="description" name="description" rows="4" placeholder="Tugas utama dan peran divisi..." required></textarea>
            </div>

            <div class="form-group">
                <label for="focus">Fokus Kerja</label>
                <textarea id="focus" name="focus" rows="3" placeholder="Contoh: Publikasi, dokumentasi, branding."></textarea>
            </div>

            <div class="form-group">
                <label for="tagline">Tagline Divisi</label>
                <input type="text" id="tagline" name="tagline" maxlength="255" placeholder="Contoh: Membangun komunikasi digital yang efektif">
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp">
                <small>Upload cover image. Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="icon">Inisial / Ikon (maks 3 huruf)</label>
                    <input type="text" id="icon" name="icon" maxlength="3" placeholder="Contoh: KI">
                    <small>Dikosongkan = otomatis dari nama divisi.</small>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Simpan Divisi</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>