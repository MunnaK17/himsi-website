<?php
// includes/functions.php

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url($path = '')
{
    return BASE_URL . ltrim($path, '/');
}

function asset($path = '')
{
    return url('assets/' . ltrim($path, '/'));
}

function active_menu($pageName, $activePage)
{
    return $pageName === $activePage ? 'active' : '';
}

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function excerpt($text, $limit = 140)
{
    $text = strip_tags((string) $text);
    if (strlen($text) <= $limit) {
        return $text;
    }
    return substr($text, 0, $limit) . '...';
}

function format_tanggal($date)
{
    if (!$date) {
        return '-';
    }

    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $timestamp = strtotime($date);
    return date('d', $timestamp) . ' ' . $bulan[(int) date('m', $timestamp)] . ' ' . date('Y', $timestamp);
}

function image_url($path, $fallback = 'default/press-ai.svg')
{
    if (!$path) {
        return asset('images/' . $fallback);
    }

    if (str_starts_with($path, 'uploads/')) {
        return asset('images/' . $path);
    }

    return asset('images/default/' . ltrim($path, '/'));
}

function create_slug($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Redirect 301 dari URL ber-.php ke URL bersih.
 * Contoh: /profil.php  ->  /profil
 *         /detail-press-release.php?slug=x  ->  /detail-press-release?slug=x
 *         /index.php  ->  /
 *
 * Tidak berlaku untuk:
 *  - Folder /admin/ (admin tetap pakai .php internal)
 *  - Request method selain GET
 *  - Internal rewrite (REQUEST_URI sudah bersih, regex tidak match)
 */
function maybe_redirect_clean_url()
{
    if (PHP_SAPI === 'cli') {
        return;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
        return;
    }

    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if ($uri === '') {
        return;
    }

    // Skip semua URL di folder /admin/
    if (strpos($uri, '/admin/') !== false) {
        return;
    }

    // Pisahkan path dan query string
    if (!preg_match('#^([^?]+)\.php(\?.*)?$#i', $uri, $m)) {
        return;
    }

    $path  = $m[1];
    $query = $m[2] ?? '';

    // /folder/index -> /folder/  (homepage tidak butuh /index)
    $path = preg_replace('#/index$#', '/', $path);

    header('Location: ' . $path . $query, true, 301);
    exit;
}

// Auto-jalan setiap kali functions.php di-include
maybe_redirect_clean_url();
