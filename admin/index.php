<?php
// admin/index.php
// Auto-redirect: kalau sudah login -> dashboard, kalau belum -> form login.
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/auth.php';

if (admin_logged_in()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
