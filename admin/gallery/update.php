<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id          = (int) ($_POST['id'] ?? 0);
$division_id = (int) ($_POST['division_id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$caption     = trim($_POST['caption'] ?? '');
$is_featured = isset($_POST['is_featured']) ? 1 : 0;

if (!$id || !$division_id) {
    header('Location: index.php?error=' . urlencode('Data wajib belum lengkap.'));
    exit;
}

// Ambil gambar lama
$stmt = $pdo->prepare("SELECT image FROM division_galleries WHERE id = ?");
$stmt->execute([$id]);
$oldItem = $stmt->fetch();
$oldImage = $oldItem['image'] ?? '';

// Upload gambar baru jika ada
$image = $oldImage;
try {
    if (!empty($_FILES['image']['name'])) {
        $image = upload_image('image', $oldImage);
    }
} catch (RuntimeException $e) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode($e->getMessage()));
    exit;
}

$sql = "UPDATE division_galleries
           SET division_id = :division_id,
               title = :title,
               image = :image,
               caption = :caption,
               is_featured = :is_featured
         WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':division_id' => $division_id,
    ':title'       => $title,
    ':image'       => $image,
    ':caption'     => $caption,
    ':is_featured' => $is_featured,
    ':id'          => $id,
]);

header('Location: index.php?success=Foto galeri berhasil diperbarui');
exit;
