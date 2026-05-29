<?php
// Suppress deprecated warnings for PHP 8.1+
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// config/database.php
// Auto-detect environment: localhost (lokal) vs domain VPS (production)

$host = $_SERVER['HTTP_HOST'] ?? '';
$isLocal = (
    strpos($host, 'localhost') !== false ||
    strpos($host, '127.0.0.1') !== false ||
    strpos($host, '.test') !== false
);

if ($isLocal) {
    // ===== LOKAL (Laragon) =====
    define('BASE_URL', '/himsi-website/');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'himsi');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // ===== VPS / PRODUCTION =====
    define('BASE_URL', '/');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'himsi');
    define('DB_USER', 'himsi');
    define('DB_PASS', 'root');
}

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}
