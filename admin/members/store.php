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

$name       = trim($_POST['name'] ?? '');
$position   = trim($_POST['position'] ?? '');
$division_id = (int) ($_POST['division_id'] ?? 0);
$is_leader  = isset($_POST['is_leader']) ? 1 : 0;
$photo      = '';

if ($name === '' || !$division_id) {
    header('Location: create.php?error=' . urlencode('Nama dan divisi wajib diisi.'));
    exit;
}

try {
    $photo = upload_image('photo');
} catch (RuntimeException $e) {
    header('Location: create.php?error=' . urlencode($e->getMessage()));
    exit;
}

$sql = "INSERT INTO division_members (division_id, name, position, photo, is_leader)
        VALUES (:division_id, :name, :position, :photo, :is_leader)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':division_id' => $division_id,
    ':name'        => $name,
    ':position'    => $position,
    ':photo'       => $photo,
    ':is_leader'   => $is_leader,
]);

header('Location: index.php?success=Anggota berhasil ditambahkan');
exit;
