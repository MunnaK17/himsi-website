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
$name        = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$focus       = trim($_POST['focus'] ?? '');
$icon        = strtoupper(trim($_POST['icon'] ?? ''));
$status      = trim($_POST['status'] ?? 'active');
$tagline     = trim($_POST['tagline'] ?? '');

if (!$id || $name === '' || $description === '') {
    die('Data wajib belum lengkap.');
}

if (!in_array($status, ['active', 'inactive'], true)) {
    $status = 'active';
}

if ($icon === '') {
    $parts = preg_split('/\s+/', $name);
    $icon = strtoupper(substr($parts[0] ?? 'D', 0, 1));
    if (!empty($parts[1])) {
        $icon .= strtoupper(substr($parts[1], 0, 1));
    }
}

$icon = substr($icon, 0, 3);

// Get current cover_image
$stmt = $pdo->prepare("SELECT cover_image FROM divisions WHERE id = ?");
$stmt->execute([$id]);
$currentItem = $stmt->fetch();
$oldCoverImage = $currentItem['cover_image'] ?? '';

// Handle cover image upload
$cover_image = $oldCoverImage;
try {
    if (!empty($_FILES['cover_image']['name'])) {
        $cover_image = upload_image('cover_image', $oldCoverImage);
    }
} catch (RuntimeException $e) {
    // If upload fails, keep old image
    $cover_image = $oldCoverImage;
}

$sql = "UPDATE divisions
           SET name = :name,
               description = :description,
               focus = :focus,
               icon = :icon,
               status = :status,
               tagline = :tagline,
               cover_image = :cover_image
         WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':name'        => $name,
    ':description' => $description,
    ':focus'       => $focus,
    ':icon'        => $icon,
    ':status'      => $status,
    ':tagline'     => $tagline,
    ':cover_image' => $cover_image,
    ':id'          => $id,
]);

header('Location: index.php?success=Divisi berhasil diperbarui');
exit;