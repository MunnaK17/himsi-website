<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? '';

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT image FROM press_releases WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if ($item && !empty($item['image'])) {
    $imagePath = __DIR__ . '/../../assets/images/uploads/' . $item['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

$delete = $pdo->prepare("DELETE FROM press_releases WHERE id = ?");
$delete->execute([$id]);

header('Location: index.php?success=Artikel berhasil dihapus');
exit;