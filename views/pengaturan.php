<?php
$page_title = "Pengaturan";

include '../inc/header.php';
include '../inc/sidebar.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

$set = settings_get();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_perusahaan = $_POST['nama_perusahaan'];
    $mata_uang       = $_POST['mata_uang'];
    $ppn_default     = $_POST['ppn_default'];
    $periode         = $_POST['periode_terkunci'];

    settings_update($nama_perusahaan, $mata_uang, $ppn_default, $periode);

    header("Location: settings.php?sukses=1");
    exit;
}


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

