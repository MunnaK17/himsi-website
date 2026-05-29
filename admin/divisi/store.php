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

$name        = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$focus       = trim($_POST['focus'] ?? '');
$icon        = strtoupper(trim($_POST['icon'] ?? ''));
$status      = trim($_POST['status'] ?? 'active');
$tagline     = trim($_POST['tagline'] ?? '');
$cover_image = '';

if ($name === '' || $description === '') {
    die('Nama dan deskripsi divisi wajib diisi.');
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

// Handle cover image upload
try {
    $cover_image = upload_image('cover_image');
} catch (RuntimeException $e) {
    // If no file uploaded, that's ok - cover_image will be empty
    $cover_image = '';
}

$sql = "INSERT INTO divisions (name, description, focus, icon, status, tagline, cover_image)
        VALUES (:name, :description, :focus, :icon, :status, :tagline, :cover_image)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':name'        => $name,
    ':description' => $description,
    ':focus'       => $focus,
    ':icon'        => $icon,
    ':status'      => $status,
    ':tagline'     => $tagline,
    ':cover_image' => $cover_image,
]);

header('Location: index.php?success=Divisi berhasil ditambahkan');
exit;