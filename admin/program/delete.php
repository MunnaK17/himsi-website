<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT image FROM programs WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if ($item && !empty($item['image']) && str_starts_with($item['image'], 'uploads/')) {
    $imagePath = __DIR__ . '/../../assets/images/' . $item['image'];
    if (is_file($imagePath)) {
        @unlink($imagePath);
    }
}

$delete = $pdo->prepare("DELETE FROM programs WHERE id = ?");
$delete->execute([$id]);

header('Location: index.php?success=Program kerja berhasil dihapus');
exit;
