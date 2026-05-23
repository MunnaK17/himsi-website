<?php
function upload_image($fieldName, $oldImage = null)
{
    if (empty($_FILES[$fieldName]['name'])) {
        return $oldImage;
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload gambar gagal.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = mime_content_type($_FILES[$fieldName]['tmp_name']);

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Format gambar harus JPG, PNG, atau WEBP.');
    }

    if ($_FILES[$fieldName]['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 2MB.');
    }

    $uploadDir = __DIR__ . '/../../assets/images/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $filename = date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $allowed[$mime];
    $target = $uploadDir . $filename;

    if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $target)) {
        throw new RuntimeException('Gagal menyimpan gambar ke folder uploads.');
    }

    if ($oldImage && str_starts_with($oldImage, 'uploads/')) {
        $oldPath = $uploadDir . basename($oldImage);
        if (is_file($oldPath)) {
            unlink($oldPath);
        }
    }

    return 'uploads/' . $filename;
}
