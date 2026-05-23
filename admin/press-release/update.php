<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id           = $_POST['id'] ?? '';
$title        = trim($_POST['title'] ?? '');
$category     = trim($_POST['category'] ?? '');
$excerpt      = trim($_POST['excerpt'] ?? '');
$content      = trim($_POST['content'] ?? '');
$author       = trim($_POST['author'] ?? 'Admin HIMSI');
$published_at = trim($_POST['published_at'] ?? date('Y-m-d'));
$status       = trim($_POST['status'] ?? 'draft');
$oldImage     = $_POST['old_image'] ?? '';

if (!$id || $title === '' || $category === '' || $excerpt === '' || $content === '') {
    die('Data wajib belum lengkap.');
}

if (!in_array($status, ['published', 'draft'])) {
    $status = 'draft';
}

$slug = create_slug($title);

$checkSlug = $pdo->prepare("SELECT COUNT(*) FROM press_releases WHERE slug = ? AND id != ?");
$checkSlug->execute([$slug, $id]);

if ($checkSlug->fetchColumn() > 0) {
    $slug = $slug . '-' . time();
}

$imageName = $oldImage;

if (!empty($_FILES['image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024;

    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileTmp  = $_FILES['image']['tmp_name'];

    if (!in_array($fileType, $allowedTypes)) {
        die('Format gambar tidak valid. Gunakan JPG, PNG, atau WEBP.');
    }

    if ($fileSize > $maxSize) {
        die('Ukuran gambar terlalu besar. Maksimal 2MB.');
    }

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = 'press-' . time() . '-' . rand(1000, 9999) . '.' . strtolower($extension);

    $uploadDir = __DIR__ . '/../../assets/images/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($fileTmp, $uploadDir . $imageName)) {
        die('Gagal upload gambar.');
    }

    if ($oldImage && file_exists($uploadDir . $oldImage)) {
        unlink($uploadDir . $oldImage);
    }
}

$sql = "UPDATE press_releases SET
        title = :title,
        slug = :slug,
        category = :category,
        excerpt = :excerpt,
        content = :content,
        image = :image,
        author = :author,
        status = :status,
        published_at = :published_at
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':title'        => $title,
    ':slug'         => $slug,
    ':category'     => $category,
    ':excerpt'      => $excerpt,
    ':content'      => $content,
    ':image'        => $imageName,
    ':author'       => $author,
    ':status'       => $status,
    ':published_at' => $published_at,
    ':id'           => $id
]);

header('Location: index.php?success=Artikel berhasil diperbarui');
exit;