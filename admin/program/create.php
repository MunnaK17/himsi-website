<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'program';
$pageTitle = 'Tambah Program Kerja';
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
            <p>Program Kerja</p>
            <h1>Tambah Program</h1>
        </div>
        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <section class="form-card">
        <form class="admin-form" method="POST" action="store.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Nama Program</label>
                <input type="text" id="title" name="title" placeholder="Contoh: Workshop UI/UX 2026" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Program</label>
                <textarea id="description" name="description" rows="5" placeholder="Tujuan kegiatan, peserta, output, dll." required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="event_date">Tanggal Kegiatan</label>
                    <input type="date" id="event_date" name="event_date" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Gambar Program</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
                <small>Format JPG, PNG, atau WEBP. Maksimal 2MB. Boleh dikosongkan.</small>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">Simpan Program</button>
                <a class="btn btn-edit" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>
