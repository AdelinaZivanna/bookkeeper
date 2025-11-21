<?php 
include '../inc/config.php';
include '../inc/functions.php';
include '../inc/header.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$page_title = "Kategori";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {

    $nama  = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $ppn   = $_POST['ppn'] ?? 'Non PPN';

    kategori_add($nama, $jenis, $ppn);

    header("Location: kategori.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    kategori_delete($id);

    header("Location: kategori.php");
    exit;
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
                    <a href="#" class="nav-link font-weight-bold">Kategori</a>
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

<div id="page-categories">
    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Kategori</h3>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-category">
                <i class="fas fa-plus mr-1"></i> Kategori
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbl-categories">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>PPN</th>
                            <th width="80"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $kategori = kategori_all();
                        foreach ($kategori as $k): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($k['nama']); ?></td>
                                <td><?php echo htmlspecialchars($k['jenis']); ?></td>
                                <td><?php echo htmlspecialchars($k['ppn'] ?? 'Non PPN'); ?></td>
                                <td class="text-right">
                                    <a href="kategori.php?hapus=<?php echo $k['id']; ?>"
                                       onclick="return confirm('Hapus kategori ini?')"
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

<div class="modal fade" id="modal-category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="POST">
                <input type="hidden" name="add_category" value="1">

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="required">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="required">Jenis</label>
                            <select name="jenis" class="custom-select">
                                <option>Pendapatan</option>
                                <option>Biaya</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>PPN</label>
                        <select name="ppn" class="custom-select">
                            <option>Non PPN</option>
                            <option>PPN 11%</option>
                        </select>
                    </div>

                </div>

                <div class="sticky-actions text-right">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
