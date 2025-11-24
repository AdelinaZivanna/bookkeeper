<?php 
include '../inc/config.php';
include '../inc/functions.php';
include '../inc/header.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$page_title = "Akun"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_account'])) {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $mata_uang = $_POST['mata_uang'] ?? 'IDR';
    $saldo_awal = $_POST['saldo_awal'] ?? 0;

    akun_add($nama, $jenis, $mata_uang, $saldo_awal);

    header("Location: akun.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    akun_delete($id);

    header("Location: akun.php");
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = GetAkun($_GET['edit']);
}

?>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link font-weight-bold">Dashboard</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-md-block mr-2">
                    <button id="btn-quick-add" class="btn btn-sm btn-primary"><i class="fas fa-plus mr-1"></i>
                        Transaksi</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toggle-dark" href="#" role="button" title="Tema Gelap/Terang"><i
                            class="far fa-moon"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <span class="dropdown-item-text">Signed in as<br><b>nuna@company.id</b></span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" data-nav="#page-settings"><i class="fas fa-cog mr-2"></i>
                            Pengaturan</a>
                        <div class="dropdown-divider"></div>
                        <a href="?logout=1" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin keluar?')"> <i class="fas fa-sign-out-alt mr-2"></i> Keluar</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

<?php 
include '../inc/sidebar.php';
?>

<div id="page-accounts">
    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Akun Kas/Bank</h3>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-account">
                <i class="fas fa-plus mr-1"></i> Akun
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Mata Uang</th>
                            <th>Saldo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $akun = akun_all();
                        $transaksi_kas = getAllKasKecil($conn);
                        
                        $total_pengeluaran = 0;
                        while ($transaksi = mysqli_fetch_assoc($transaksi_kas)) {
                            $total_pengeluaran += $transaksi['jumlah'];
                        }
                        
                        foreach ($akun as $a): 
                            $saldoakhir = $a['saldoawal'] - $total_pengeluaran;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($a['nama']); ?></td>
                                <td><?php echo htmlspecialchars($a['jenis']); ?></td>
                                <td><?php echo htmlspecialchars($a['mata_uang']); ?></td>
                                <td>Rp <?php echo number_format($saldoakhir, 0, ',', '.'); ?></td>
                                <td class="text-right">

                                    <a href="akun.php?edit=<?= $a['id'] ?>" 
                                    class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="akun.php?hapus=<?php echo $a['id']; ?>"
                                    onclick="return confirm('Hapus akun ini?')"
                                    class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

<!-- Account Modal -->
<div class="modal fade" id="modal-account" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama Akun <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="custom-select" required>
                                <option value="Kas">Kas</option>
                                <option value="Bank">Bank</option>
                                <option value="Clearing">Clearing</option>
                                <option value="Petty">Petty</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Mata Uang</label>
                            <select name="mata_uang" class="custom-select">
                                <option value="IDR">IDR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Saldo Awal</label>
                            <input type="number" name="saldo_awal" class="form-control" min="0" step="100">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="add_account" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Account Modal -->

<?php include '../inc/footer.php'; ?>