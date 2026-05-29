<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../includes/upload.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$division_id = (int) ($_POST['division_id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$caption     = trim($_POST['caption'] ?? '');
$is_featured = isset($_POST['is_featured']) ? 1 : 0;
$image       = '';

try {
    $image = upload_image('image');
} catch (RuntimeException $e) {
    header('Location: create.php?error=' . urlencode($e->getMessage()));
    exit;
}

if (!$division_id || $image === '') {
    header('Location: create.php?error=' . urlencode('Divisi dan gambar wajib diisi.'));
    exit;
}

$sql = "INSERT INTO division_galleries (division_id, title, image, caption, is_featured)
        VALUES (:division_id, :title, :image, :caption, :is_featured)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':division_id' => $division_id,
    ':title'       => $title,
    ':image'       => $image,
    ':caption'     => $caption,
    ':is_featured' => $is_featured,
]);

header('Location: index.php?success=Foto galeri berhasil ditambahkan');
exit;
