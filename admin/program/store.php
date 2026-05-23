<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$event_date  = trim($_POST['event_date'] ?? date('Y-m-d'));
$status      = trim($_POST['status'] ?? 'active');

if ($title === '' || $description === '') {
    die('Nama program dan deskripsi wajib diisi.');
}

if (!in_array($status, ['active', 'inactive'], true)) {
    $status = 'active';
}

$imageName = null;

if (!empty($_FILES['image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024;

    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileTmp  = $_FILES['image']['tmp_name'];

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die('Upload gambar gagal. Coba ulangi.');
    }

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

    // simpan dengan prefix "uploads/" agar image_url() mendeteksinya sebagai file upload
    $imageName = 'uploads/' . $uniqueName;
}

$sql = "INSERT INTO programs (title, description, image, event_date, status)
        VALUES (:title, :description, :image, :event_date, :status)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':title'       => $title,
    ':description' => $description,
    ':image'       => $imageName,
    ':event_date'  => $event_date,
    ':status'      => $status,
]);

header('Location: index.php?success=Program kerja berhasil ditambahkan');
exit;
