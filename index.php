<?php
include 'inc/config.php';
include 'inc/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'inc/header.php';

$page = $_GET['page'] ?? 'dashboard';

$allowed = [
    'dashboard',
    'transaksi_kas',
    'kas_kecil',
    'kontak',
    'kategori',
    'akun',
    'pengaturan'
];

if (in_array($page, $allowed)) {
    include "views/$page.php";
} else {
    echo "<h3>Halaman tidak ditemukan</h3>";
}

include 'inc/footer.php';
    
