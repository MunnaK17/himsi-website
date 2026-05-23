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
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$schedule = trim($_POST['schedule'] ?? '');
$requirements = trim($_POST['requirements'] ?? '');
$selection_steps = trim($_POST['selection_steps'] ?? '');
$divisions = trim($_POST['divisions'] ?? '');
$status = trim($_POST['status'] ?? 'inactive');
$oldPoster = $_POST['old_poster'] ?? '';

if (!$id || $title === '') {
    die('Data wajib belum lengkap.');
}

if (!in_array($status, ['active', 'inactive'])) {
    $status = 'inactive';
}

$posterName = $oldPoster;

if (!empty($_FILES['poster']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024;

    $fileType = $_FILES['poster']['type'];
    $fileSize = $_FILES['poster']['size'];
    $fileTmp = $_FILES['poster']['tmp_name'];

    if (!in_array($fileType, $allowedTypes)) {
        die('Format poster tidak valid. Gunakan JPG, PNG, atau WEBP.');
    }

    if ($fileSize > $maxSize) {
        die('Ukuran poster terlalu besar. Maksimal 2MB.');
    }

    $extension = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
    $posterName = 'oprec-' . time() . '-' . rand(1000, 9999) . '.' . $extension;

    $uploadDir = __DIR__ . '/../../assets/images/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($fileTmp, $uploadDir . $posterName)) {
        die('Gagal upload poster.');
    }

    if ($oldPoster && file_exists($uploadDir . $oldPoster)) {
        unlink($uploadDir . $oldPoster);
    }
}

$sql = "UPDATE open_recruitments SET
        title = :title,
        description = :description,
        schedule = :schedule,
        requirements = :requirements,
        selection_steps = :selection_steps,
        divisions = :divisions,
        poster = :poster,
        status = :status
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':title' => $title,
    ':description' => $description,
    ':schedule' => $schedule,
    ':requirements' => $requirements,
    ':selection_steps' => $selection_steps,
    ':divisions' => $divisions,
    ':poster' => $posterName,
    ':status' => $status,
    ':id' => $id
]);

header('Location: index.php?success=Open recruitment berhasil diperbarui');
exit;