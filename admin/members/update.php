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
$position    = trim($_POST['position'] ?? '');
$division_id = (int) ($_POST['division_id'] ?? 0);
$is_leader   = isset($_POST['is_leader']) ? 1 : 0;

if (!$id || $name === '' || !$division_id) {
    header('Location: index.php?error=' . urlencode('Data wajib belum lengkap.'));
    exit;
}

// Ambil foto lama
$stmt = $pdo->prepare("SELECT photo FROM division_members WHERE id = ?");
$stmt->execute([$id]);
$oldItem = $stmt->fetch();
$oldPhoto = $oldItem['photo'] ?? '';

// Upload foto baru jika ada
$photo = $oldPhoto;
try {
    if (!empty($_FILES['photo']['name'])) {
        $photo = upload_image('photo', $oldPhoto);
    }
} catch (RuntimeException $e) {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode($e->getMessage()));
    exit;
}

$sql = "UPDATE division_members
           SET division_id = :division_id,
               name = :name,
               position = :position,
               photo = :photo,
               is_leader = :is_leader
         WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':division_id' => $division_id,
    ':name'        => $name,
    ':position'    => $position,
    ':photo'       => $photo,
    ':is_leader'   => $is_leader,
    ':id'          => $id,
]);

header('Location: index.php?success=Anggota berhasil diperbarui');
exit;
