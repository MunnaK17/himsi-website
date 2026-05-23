<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id          = (int) ($_POST['id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$event_date  = trim($_POST['event_date'] ?? date('Y-m-d'));
$status      = trim($_POST['status'] ?? 'active');
$oldImage    = trim($_POST['old_image'] ?? '');

if (!$id || $title === '' || $description === '') {
    die('Data wajib belum lengkap.');
}

if (!in_array($status, ['active', 'inactive'], true)) {
    $status = 'active';
}

$imageName = $oldImage; // default: pakai gambar lama

if (!empty($_FILES['image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024;

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die('Upload gambar gagal. Coba ulangi.');
    }

    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileTmp  = $_FILES['image']['tmp_name'];

    if (!in_array($fileType, $allowedTypes, true)) {
        die('Format gambar tidak valid. Gunakan JPG, PNG, atau WEBP.');
    }

    if ($fileSize > $maxSize) {
        die('Ukuran gambar terlalu besar. Maksimal 2MB.');
    }

    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $uniqueName = 'program-' . time() . '-' . rand(1000, 9999) . '.' . $extension;

    $uploadDir = __DIR__ . '/../../assets/images/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($fileTmp, $uploadDir . $uniqueName)) {
        die('Gagal menyimpan gambar.');
    }

    // hapus file lama bila benar-benar berasal dari folder uploads/
    if ($oldImage && str_starts_with($oldImage, 'uploads/')) {
        $oldPath = $uploadDir . basename($oldImage);
        if (is_file($oldPath)) {
            @unlink($oldPath);
        }
    }

    $imageName = 'uploads/' . $uniqueName;
}

$sql = "UPDATE programs
           SET title = :title,
               description = :description,
               image = :image,
               event_date = :event_date,
               status = :status
         WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':title'       => $title,
    ':description' => $description,
    ':image'       => $imageName,
    ':event_date'  => $event_date,
    ':status'      => $status,
    ':id'          => $id,
]);

header('Location: index.php?success=Program kerja berhasil diperbarui');
exit;
