<?php 
$page_title = "Akun"; 

include '../inc/header.php';
include '../inc/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_account'])) {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $mata_uang = $_POST['mata_uang'] ?? 'IDR';
    $saldo_awal = $_POST['saldo_awal'] ?? 0;

    akun_add($nama, $jenis, $mata_uang, $saldo_awal);

    echo '<script>window.location.href = "akun.php"</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $mata_uang = $_POST['mata_uang'];
    $saldo_awal = $_POST['saldo_awal'] ?? 0;

    akun_update($id, $nama, $jenis, $mata_uang, $saldo_awal);

    echo '<script>window.location.href = "akun.php"</script>';
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    akun_delete($id);

    echo '<script>window.location.href = "akun.php"</script>';
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = GetAkun($_GET['edit']);
}

?>

<div id="page-accounts">
    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Akun Kas/Bank</h3>
            <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#modal-account">
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
                            <th>Saldo Awal</th>
                            <th>Total Pengeluaran</th>
                            <th>Saldo Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $akun = akun_all();
                        
                        foreach ($akun as $a): 
                            $total_pengeluaran = getTotalPengeluaranByAkun($conn, $a['nama']);
                            $saldoakhir = $a['saldoawal'] - $total_pengeluaran;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($a['nama']); ?></td>
                                <td><?php echo htmlspecialchars($a['jenis']); ?></td>
                                <td><?php echo htmlspecialchars($a['mata_uang']); ?></td>
                                <td>Rp <?php echo number_format($a['saldoawal'], 0, ',', '.'); ?></td>
                                <td class="text-danger">- Rp <?php echo number_format($total_pengeluaran, 0, ',', '.'); ?></td>
                                <td class="font-weight-bold">Rp <?php echo number_format($saldoakhir, 0, ',', '.'); ?></td>
                                <td>
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
