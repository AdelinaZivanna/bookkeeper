<?php

function logout() {
    if (isset($_GET['logout'])) {
    session_destroy();
    echo '<script>window.location.href = "../index.php"</script>';
    exit;
}

}
// -----------------------------
// KONTAK
// -----------------------------
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

function kontak_get($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM kontak WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function kontak_update($id, $nama, $jenis, $email, $telepon) {
    global $conn;
    $stmt = $conn->prepare("UPDATE kontak SET nama=?, jenis=?, email=?, telepon=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $jenis, $email, $telepon, $id);
    return $stmt->execute();
}

// -----------------------------
// KATEGORI
// -----------------------------


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

function kategori_get($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM kategori WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function kategori_update($id, $nama, $jenis, $ppn) {
    global $conn;
    $stmt = $conn->prepare("UPDATE kategori SET nama=?, jenis=?, ppn=? WHERE id=?");
    $stmt->bind_param("sssi", $nama, $jenis, $ppn, $id);
    return $stmt->execute();
}

// -----------------------------
// AKUN
// -----------------------------


function GetAkun($id) {
        global $conn;
    $stmt = $conn->prepare("SELECT * FROM akun WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
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

// -----------------------------
// SETTINGS
// -----------------------------
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

// -----------------------------
// KAS KECIL
// -----------------------------
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
// ==========================================
function createTransaksi($conn, $data) {
    $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $data['kategori']);
    $akun = mysqli_real_escape_string($conn, $data['akun']); // nama akun
    $jumlah_input = (int)$data['jumlah'];
    $tipe = isset($data['tipe']) ? $data['tipe'] : 'pengeluaran'; // default pengeluaran

    // sesuaikan tanda jumlah berdasarkan tipe
    if ($tipe === 'pengeluaran') {
        $jumlah = -abs($jumlah_input);
    } else {
        $jumlah = abs($jumlah_input);
    }

    // 1) insert transaksi (simpan jumlah sudah bertanda +/-)
    $stmt = $conn->prepare("INSERT INTO transaksi (tanggal, deskripsi, kategori, akun, jumlah) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $tanggal, $deskripsi, $kategori, $akun, $jumlah);
    $res = $stmt->execute();
    if (!$res) {
        return false;
    }

    // 2) update saldo akun (saldoawal kolom digunakan sebagai saldo sekarang)
    $safeJumlah = $jumlah; // sudah integer
    $akunEsc = mysqli_real_escape_string($conn, $akun);
    $updateQuery = "UPDATE akun SET saldoawal = saldoawal + ($safeJumlah) WHERE nama = '$akunEsc'";
    mysqli_query($conn, $updateQuery);

    return true;
}


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

function deleteTransaksi($conn, $id) {
    $id = (int)$id;
    // ambil transaksi dulu supaya bisa koreksi saldo
    $res = mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $akun = mysqli_real_escape_string($conn, $row['akun']);
        $jumlah = (int)$row['jumlah'];
        // koreksi saldo: kurangi efek transaksi yang dihapus (karena saat insert kita menambahkan jumlah ke akun)
        $corr = -$jumlah;
        mysqli_query($conn, "UPDATE akun SET saldoawal = saldoawal + ($corr) WHERE nama = '$akun'");
    }

    $query = "DELETE FROM transaksi WHERE id=$id";
    return mysqli_query($conn, $query);
}

function getTransaksiById($conn, $id) {
    $id = (int)$id;
    $result = mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$id");
    return mysqli_fetch_assoc($result);
}









// ======================
// GET ALL TRANSAKSI (FINAL FIX)
// ======================
function getAllTransaksi($conn, $orderBy = 'tanggal DESC', $limit = null) {

    // Sanitasi kolom ORDER BY
    $orderByClean = mysqli_real_escape_string($conn, $orderBy);

    // Jika limit null → tampilkan SEMUA transaksi
    if ($limit === null) {
        $query = "SELECT * FROM transaksi ORDER BY $orderByClean";
    } else {
        // Jika limit angka → batasi
        $limit = (int)$limit;
        $query = "SELECT * FROM transaksi ORDER BY $orderByClean LIMIT $limit";
    }

    return mysqli_query($conn, $query);
}




function insertTransaksi($conn, $data) {
    $tanggal = $data['tanggal'];
    $deskripsi = $data['deskripsi'];
    $kategori = $data['kategori'];
    $akun = $data['akun'];
    $jumlah = $data['jumlah'];

    $sql = "INSERT INTO transaksi (tanggal, deskripsi, kategori, akun, jumlah)
            VALUES ('$tanggal', '$deskripsi', '$kategori', '$akun', '$jumlah')";
    return mysqli_query($conn, $sql);
}





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

function getTransaksiByDateRange($conn, $startDate, $endDate) {
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);
    
    $query = "SELECT * FROM transaksi 
              WHERE tanggal BETWEEN '$startDate' AND '$endDate' 
              ORDER BY tanggal DESC";
    
    return mysqli_query($conn, $query);
}

function getTransaksiByKategori($conn, $kategori) {
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $query = "SELECT * FROM transaksi WHERE kategori='$kategori' ORDER BY tanggal DESC";
    return mysqli_query($conn, $query);
}

function getTransaksiByAkun($conn, $akun) {
    $akun = mysqli_real_escape_string($conn, $akun);
    $query = "SELECT * FROM transaksi WHERE akun='$akun' ORDER BY tanggal DESC";
    return mysqli_query($conn, $query);
}

function getTransaksiStatsByKategori($conn) {
    $query = "SELECT kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total 
              FROM transaksi 
              GROUP BY kategori 
              ORDER BY total DESC";
    
    return mysqli_query($conn, $query);
}

function getTransaksiStatsByAkun($conn) {
    $query = "SELECT akun, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total 
              FROM transaksi 
              GROUP BY akun 
              ORDER BY total DESC";
    
    return mysqli_query($conn, $query);
}

function searchTransaksi($conn, $keyword) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM transaksi 
              WHERE deskripsi LIKE '%$keyword%' 
                 OR kategori LIKE '%$keyword%' 
                 OR akun LIKE '%$keyword%' 
              ORDER BY tanggal DESC";
    
    return mysqli_query($conn, $query);
}

function getAllAkunList($conn) {
    return mysqli_query($conn, "SELECT id, nama, jenis, saldoawal, mata_uang FROM akun ORDER BY nama ASC");
}

$history_sql = "
    SELECT 'Transaksi' AS sumber, id, tanggal, deskripsi, kategori, akun, jumlah
    FROM transaksi
    UNION ALL
    SELECT 'Kas Kecil' AS sumber, id, tanggal, deskripsi, kategori, akun, jumlah
    FROM kaskecil
    ORDER BY tanggal DESC, id DESC
";

function getTotalSaldo($conn) {
    $result = mysqli_query($conn, "SELECT SUM(saldoawal) AS total FROM akun");
    $row = mysqli_fetch_assoc($result);
    return (int)$row['total'];
}

// SHARED FALLBACKS
if (!function_exists('getKategoriList')) {
    function getKategoriList($conn) {
        return mysqli_query($conn, "SELECT DISTINCT nama FROM kategori ORDER BY nama ASC");
    }
}

if (!function_exists('getAkunKasList')) {
    function getAkunKasList($conn) {
        return mysqli_query($conn, "SELECT nama, saldoawal, mata_uang FROM akun WHERE jenis='kas' ORDER BY nama ASC");
    }
}

?>
