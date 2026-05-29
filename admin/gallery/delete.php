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

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM division_galleries WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php?success=Foto galeri berhasil dihapus');
exit;
