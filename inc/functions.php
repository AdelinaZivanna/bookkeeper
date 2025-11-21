<?php
session_start();
include 'config.php';

function kontak_all() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM kontak ORDER BY id DESC");
}

function kontak_add($nama, $jenis, $email, $telepon) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO kontak (nama, jenis, email, telepon) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $jenis, $email, $telepon);
    return $stmt->execute();
}

function kontak_delete($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM kontak WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function kategori_all() {
    global $conn;
    $sql = "SELECT * FROM kategori ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function kategori_add($nama, $jenis, $ppn) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO kategori (nama, jenis, ppn) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $jenis, $ppn);
    return $stmt->execute();
}

function kategori_delete($id) {
    global $conn;
    $id = intval($id);
    return mysqli_query($conn, "DELETE FROM kategori WHERE id = $id");
}

function akun_all() {
    global $conn;
    $sql = "SELECT * FROM akun ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function akun_add($nama, $jenis, $mata_uang, $saldoawal) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO akun (nama, jenis, mata_uang, saldoawal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $jenis, $mata_uang, $saldoawal);
    return $stmt->execute();
}

function akun_delete($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM akun WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function settings_get() {
    global $conn;
    $sql = "SELECT * FROM settings WHERE id = 1 LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function settings_update($nama, $mata_uang, $ppn, $periode) {
    global $conn;

    $stmt = $conn->prepare("
        UPDATE settings 
        SET nama_perusahaan = ?, mata_uang = ?, ppn_default = ?, periode_terkunci = ?
        WHERE id = 1
    ");

    $stmt->bind_param("ssss", $nama, $mata_uang, $ppn, $periode);
    return $stmt->execute();
}

function createKasKecil($conn, $data) {
    $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $data['kategori']);
    $akun = mysqli_real_escape_string($conn, $data['akun']);
    $jumlah = (int)$data['jumlah'];
    
    $query = "INSERT INTO kaskecil (tanggal, deskripsi, kategori, akun, jumlah) 
              VALUES ('$tanggal', '$deskripsi', '$kategori', '$akun', $jumlah)";
    
    return mysqli_query($conn, $query);
}

function updateKasKecil($conn, $id, $data) {
    $id = (int)$id;
    $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $data['kategori']);
    $akun = mysqli_real_escape_string($conn, $data['akun']);
    $jumlah = (int)$data['jumlah'];
    
    $query = "UPDATE kaskecil 
              SET tanggal='$tanggal', 
                  deskripsi='$deskripsi', 
                  kategori='$kategori', 
                  akun='$akun', 
                  jumlah=$jumlah 
              WHERE id=$id";
    
    return mysqli_query($conn, $query);
}

function deleteKasKecil($conn, $id) {
    $id = (int)$id;
    $query = "DELETE FROM kaskecil WHERE id=$id";
    return mysqli_query($conn, $query);
}

function getKasKecilById($conn, $id) {
    $id = (int)$id;
    $result = mysqli_query($conn, "SELECT * FROM kaskecil WHERE id=$id");
    return mysqli_fetch_assoc($result);
}

function getAllKasKecil($conn, $orderBy = 'tanggal DESC') {
    $query = "SELECT * FROM kaskecil ORDER BY $orderBy";
    return mysqli_query($conn, $query);
}

function getTotalKasKecil($conn, $startDate = null, $endDate = null) {
    $query = "SELECT SUM(jumlah) as total FROM kaskecil WHERE 1=1";
    
    if ($startDate) {
        $startDate = mysqli_real_escape_string($conn, $startDate);
        $query .= " AND tanggal >= '$startDate'";
    }
    
    if ($endDate) {
        $endDate = mysqli_real_escape_string($conn, $endDate);
        $query .= " AND tanggal <= '$endDate'";
    }
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return (int)$row['total'];
}

function getKasKecilByDateRange($conn, $startDate, $endDate) {
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);
    
    $query = "SELECT * FROM kaskecil 
              WHERE tanggal BETWEEN '$startDate' AND '$endDate' 
              ORDER BY tanggal DESC";
    
    return mysqli_query($conn, $query);
}

function getKasKecilByKategori($conn, $kategori) {
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $query = "SELECT * FROM kaskecil WHERE kategori='$kategori' ORDER BY tanggal DESC";
    return mysqli_query($conn, $query);
}

function getKasKecilByAkun($conn, $akun) {
    $akun = mysqli_real_escape_string($conn, $akun);
    $query = "SELECT * FROM kaskecil WHERE akun='$akun' ORDER BY tanggal DESC";
    return mysqli_query($conn, $query);
}

function getKategoriList($conn) {
    return mysqli_query($conn, "SELECT DISTINCT nama FROM kategori ORDER BY nama ASC");
}

function getAkunKasList($conn) {
    return mysqli_query($conn, "SELECT nama, saldoawal, mata_uang FROM akun WHERE jenis='kas' ORDER BY nama ASC");
}

function getKasKecilStatsByKategori($conn) {
    $query = "SELECT kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total_pengeluaran 
              FROM kaskecil 
              GROUP BY kategori 
              ORDER BY total_pengeluaran DESC";
    
    return mysqli_query($conn, $query);
}

function getKasKecilStatsByAkun($conn) {
    $query = "SELECT akun, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total_pengeluaran 
              FROM kaskecil 
              GROUP BY akun 
              ORDER BY total_pengeluaran DESC";
    
    return mysqli_query($conn, $query);
}

function searchKasKecil($conn, $keyword) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM kaskecil 
              WHERE deskripsi LIKE '%$keyword%' 
                 OR kategori LIKE '%$keyword%' 
                 OR akun LIKE '%$keyword%' 
              ORDER BY tanggal DESC";
    
    return mysqli_query($conn, $query);
}

// ==========================================
// FUNCTIONS UNTUK TRANSAKSI KAS & BANK
// File: inc/functions.php (tambahkan di bagian bawah)
// ==========================================

/**
 * Create transaksi kas & bank
 */
function createTransaksi($conn, $data) {
    $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $data['kategori']);
    $akun = mysqli_real_escape_string($conn, $data['akun']);
    $jumlah = (int)$data['jumlah'];
    
    $query = "INSERT INTO transaksi (tanggal, deskripsi, kategori, akun, jumlah) 
              VALUES ('$tanggal', '$deskripsi', '$kategori', '$akun', $jumlah)";
    
    return mysqli_query($conn, $query);
}

/**
 * Update transaksi kas & bank
 */
function updateTransaksi($conn, $id, $data) {
    $id = (int)$id;
    $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $data['kategori']);
    $akun = mysqli_real_escape_string($conn, $data['akun']);
    $jumlah = (int)$data['jumlah'];
    
    $query = "UPDATE transaksi 
              SET tanggal='$tanggal', 
                  deskripsi='$deskripsi', 
                  kategori='$kategori', 
                  akun='$akun', 
                  jumlah=$jumlah 
              WHERE id=$id";
    
    return mysqli_query($conn, $query);
}

/**
 * Delete transaksi kas & bank
 */
function deleteTransaksi($conn, $id) {
    $id = (int)$id;
    $query = "DELETE FROM transaksi WHERE id=$id";
    return mysqli_query($conn, $query);
}

/**
 * Get single transaksi by ID
 */
function getTransaksiById($conn, $id) {
    $id = (int)$id;
    $result = mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$id");
    return mysqli_fetch_assoc($result);
}

/**
 * Get all transaksi kas & bank
 */
function getAllTransaksi($conn, $orderBy = 'tanggal DESC') {
    $query = "SELECT * FROM transaksi ORDER BY $orderBy";
    return mysqli_query($conn, $query);
}

/**
 * Get total transaksi
 */
function getTotalTransaksi($conn, $startDate = null, $endDate = null) {
    $query = "SELECT SUM(jumlah) as total FROM transaksi WHERE 1=1";
    
    if ($startDate) {
        $startDate = mysqli_real_escape_string($conn, $startDate);
        $query .= " AND tanggal >= '$startDate'";
    }
    
    if ($endDate) {
        $endDate = mysqli_real_escape_string($conn, $endDate);
        $query .= " AND tanggal <= '$endDate'";
    }
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return (int)$row['total'];
}

/**
 * Get transaksi by date range
 */
function getTransaksiByDateRange($conn, $startDate, $endDate) {
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);
    
    $query = "SELECT * FROM transaksi 
              WHERE tanggal BETWEEN '$startDate' AND '$endDate' 
              ORDER BY tanggal DESC";
    
    return mysqli_query($conn, $query);
}

/**
 * Get transaksi by kategori
 */
function getTransaksiByKategori($conn, $kategori) {
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $query = "SELECT * FROM transaksi WHERE kategori='$kategori' ORDER BY tanggal DESC";
    return mysqli_query($conn, $query);
}

/**
 * Get transaksi by akun
 */
function getTransaksiByAkun($conn, $akun) {
    $akun = mysqli_real_escape_string($conn, $akun);
    $query = "SELECT * FROM transaksi WHERE akun='$akun' ORDER BY tanggal DESC";
    return mysqli_query($conn, $query);
}

/**
 * Get statistik transaksi by kategori
 */
function getTransaksiStatsByKategori($conn) {
    $query = "SELECT kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total 
              FROM transaksi 
              GROUP BY kategori 
              ORDER BY total DESC";
    
    return mysqli_query($conn, $query);
}

/**
 * Get statistik transaksi by akun
 */
function getTransaksiStatsByAkun($conn) {
    $query = "SELECT akun, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total 
              FROM transaksi 
              GROUP BY akun 
              ORDER BY total DESC";
    
    return mysqli_query($conn, $query);
}

/**
 * Search transaksi
 */
function searchTransaksi($conn, $keyword) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM transaksi 
              WHERE deskripsi LIKE '%$keyword%' 
                 OR kategori LIKE '%$keyword%' 
                 OR akun LIKE '%$keyword%' 
              ORDER BY tanggal DESC";
    
    return mysqli_query($conn, $query);
}

/**
 * Get list semua akun (kas + bank)
 */
function getAllAkunList($conn) {
    return mysqli_query($conn, "SELECT nama, jenis, saldoawal, mata_uang FROM akun ORDER BY nama ASC");
}

// ==========================================
// SHARED FUNCTIONS (jika belum ada)
// ==========================================

/**
 * Get list kategori untuk dropdown (shared dengan kas kecil)
 */
if (!function_exists('getKategoriList')) {
    function getKategoriList($conn) {
        return mysqli_query($conn, "SELECT DISTINCT nama FROM kategori ORDER BY nama ASC");
    }
}

/**
 * Get list akun kas untuk dropdown (shared dengan kas kecil)
 */
if (!function_exists('getAkunKasList')) {
    function getAkunKasList($conn) {
        return mysqli_query($conn, "SELECT nama, saldoawal, mata_uang FROM akun WHERE jenis='kas' ORDER BY nama ASC");
    }
}

?>
