<?php
include '../inc/config.php';
include '../inc/functions.php';

$page_title = "Pengaturan";

// Ambil data settings dari database
$set = settings_get();

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_perusahaan = $_POST['nama_perusahaan'];
    $mata_uang       = $_POST['mata_uang'];
    $ppn_default     = $_POST['ppn_default'];
    $periode         = $_POST['periode_terkunci'];

    settings_update($nama_perusahaan, $mata_uang, $ppn_default, $periode);

    header("Location: settings.php?sukses=1");
    exit;
}

include '../inc/header.php';
?>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link font-weight-bold">Pengaturan</a>
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
                        <a href="#" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i>
                            Keluar</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

<?php
include '../inc/sidebar.php';
?>

<div class="container-fluid pt-2">
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Pengaturan</h3>
        </div>

        <div class="card-body">

            <?php if (isset($_GET['sukses'])): ?>
                <div class="alert alert-success">Pengaturan berhasil disimpan.</div>
            <?php endif; ?>

            <form class="row" method="POST">
                <div class="form-group col-md-6">
                    <label class="required">Nama Perusahaan</label>
                    <input type="text" class="form-control" name="nama_perusahaan"
                        value="<?php echo htmlspecialchars($set['nama_perusahaan']); ?>" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Mata Uang Default</label>
                    <select class="custom-select" name="mata_uang">
                        <option value="IDR" <?php echo $set['mata_uang']=='IDR'?'selected':''; ?>>IDR</option>
                        <option value="USD" <?php echo $set['mata_uang']=='USD'?'selected':''; ?>>USD</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>PPN Default</label>
                    <select class="custom-select" name="ppn_default">
                        <option value="Non PPN" <?php echo $set['ppn_default']=='Non PPN'?'selected':''; ?>>Non PPN</option>
                        <option value="PPN 11%" <?php echo $set['ppn_default']=='PPN 11%'?'selected':''; ?>>PPN 11%</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Periode Terkunci s/d</label>
                    <input type="date" class="form-control" name="periode_terkunci"
                        value="<?php echo $set['periode_terkunci']; ?>">
                </div>

                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
