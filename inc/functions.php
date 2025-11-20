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

?>
