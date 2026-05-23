<?php

function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function url($path = '')
{
    return BASE_URL . ltrim($path, '/');
}

function create_slug($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function format_tanggal($date)
{
    if (!$date) {
        return '-';
    }

    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $timestamp = strtotime($date);
    $tanggal = date('d', $timestamp);
    $bulanIndex = (int) date('m', $timestamp);
    $tahun = date('Y', $timestamp);

    return $tanggal . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
}

function excerpt($text, $limit = 120)
{
    $text = strip_tags($text);

    if (strlen($text) <= $limit) {
        return $text;
    }

    return substr($text, 0, $limit) . '...';
}