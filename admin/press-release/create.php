<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

$activeAdmin = 'press-release';
$pageTitle = 'Tambah Press Release';
$error = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/../includes/head.php'; ?>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<main class="admin-main">
    <header class="admin-header">
        <div>
            <p>Press Release</p>
            <h1>Tambah Artikel</h1>
        </div>

        <a class="btn btn-view" href="index.php">Kembali</a>
    </header>

    <?php if ($error): ?>
        <div class="alert error">
            <?= e($error); ?>
        </div>
    <?php endif; ?>

    <section class="form-card">
        <form class="admin-form" method="POST" action="store.php" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="title">Judul Artikel</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    placeholder="Contoh: Workshop UI/UX HIMSI UBSI 2026"
                    required
                >
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <input 
                    type="text" 
                    id="category" 
                    name="category" 
                    value="Berita"
                    placeholder="Contoh: Workshop, Kegiatan, Seminar"
                    required
                >
            </div>

            <div class="form-group">
                <label for="excerpt">Ringkasan</label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    rows="3" 
                    placeholder="Tulis ringkasan singkat artikel..."
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="content">Isi Artikel</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="10" 
                    placeholder="Tulis isi lengkap press release..."
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="image">Gambar Utama</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/jpeg,image/png,image/webp"
                >
                <small>Format yang disarankan: JPG, PNG, atau WEBP. Maksimal 2MB.</small>
            </div>

            <div class="form-group">
                <label for="author">Penulis</label>
                <input 
                    type="text" 
                    id="author" 
                    name="author" 
                    value="Admin HIMSI" 
                    required
                >
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="published_at">Tanggal Publish</label>
                    <input 
                        type="date" 
                        id="published_at" 
                        name="published_at" 
                        value="<?= date('Y-m-d'); ?>" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" type="submit">
                    Simpan Artikel
                </button>

                <a class="btn btn-edit" href="index.php">
                    Batal
                </a>
            </div>

        </form>
    </section>
</main>

</body>
</html>