<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../config/auth.php';

require_admin();

if (!function_exists('create_slug')) {
    function create_slug($text)
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$title        = trim($_POST['title'] ?? '');
$category     = trim($_POST['category'] ?? '');
$excerpt      = trim($_POST['excerpt'] ?? '');
$content      = trim($_POST['content'] ?? '');
$author       = trim($_POST['author'] ?? 'Admin HIMSI');
$published_at = trim($_POST['published_at'] ?? date('Y-m-d'));
$status       = trim($_POST['status'] ?? 'draft');

if ($title === '' || $category === '' || $excerpt === '' || $content === '') {
    die('Data wajib belum lengkap.');
}

if (!in_array($status, ['published', 'draft'])) {
    $status = 'draft';
}

$slug = create_slug($title);

/*
|--------------------------------------------------------------------------
| Cek slug agar tidak duplikat
|--------------------------------------------------------------------------
*/
$checkSlug = $pdo->prepare("SELECT COUNT(*) FROM press_releases WHERE slug = ?");
$checkSlug->execute([$slug]);

if ($checkSlug->fetchColumn() > 0) {
    $slug = $slug . '-' . time();
}

/*
|--------------------------------------------------------------------------
| Upload gambar
|--------------------------------------------------------------------------
*/
$imageName = null;

if (!empty($_FILES['image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileTmp  = $_FILES['image']['tmp_name'];

    if (!in_array($fileType, $allowedTypes)) {
        die('Format gambar tidak valid. Gunakan JPG, PNG, atau WEBP.');
    }

    if ($fileSize > $maxSize) {
        die('Ukuran gambar terlalu besar. Maksimal 2MB.');
    }

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = 'press-' . time() . '-' . rand(1000, 9999) . '.' . strtolower($extension);

    $uploadDir = __DIR__ . '/../../assets/images/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $imageName;

    if (!move_uploaded_file($fileTmp, $uploadPath)) {
        die('Gagal upload gambar.');
    }
}

/*
|--------------------------------------------------------------------------
| Simpan ke database
|--------------------------------------------------------------------------
*/
$sql = "INSERT INTO press_releases 
        (title, slug, category, excerpt, content, image, author, status, published_at)
        VALUES 
        (:title, :slug, :category, :excerpt, :content, :image, :author, :status, :published_at)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':title'        => $title,
    ':slug'         => $slug,
    ':category'     => $category,
    ':excerpt'      => $excerpt,
    ':content'      => $content,
    ':image'        => $imageName,
    ':author'       => $author,
    ':status'       => $status,
    ':published_at' => $published_at
]);

header('Location: index.php?success=Artikel berhasil ditambahkan');
exit;