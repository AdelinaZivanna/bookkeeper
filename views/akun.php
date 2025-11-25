<?php 
$page_title = "Akun"; 

include '../inc/header.php';
include '../inc/sidebar.php';

if (isset($_POST['add_account'])) {

    akun_add(
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['mata_uang'] ?? 'IDR',
        $_POST['saldo_awal'] ?? 0
    );

    echo '<script>window.location.href = "akun.php"</script>';
    exit;
}

if (isset($_POST['update_account'])) {

    akun_update(
        $_POST['id'],
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['mata_uang'],
        $_POST['saldo_awal']
    );

    echo '<script>window.location.href = "akun.php"</script>';
    exit;
}

if (isset($_GET['hapus'])) {
    akun_delete(intval($_GET['hapus']));
    echo '<script>window.location.href = "akun.php"</script>';
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = GetAkun($_GET['edit']);
}

$add = isset($_GET['add']);
    
?>

<div id="page-accounts">
    <div class="card card-outline card-primary shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Akun Kas/Bank</h3>
            <a href="akun.php?add" class="btn btn-primary ml-auto">
                <i class="fas fa-plus"></i> Akun
            </a>
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
                                <td class="text-right">Rp <?php echo number_format($a['saldoawal'], 0, ',', '.'); ?></td>
                                <td class="text-right text-danger">- Rp <?php echo number_format($total_pengeluaran, 0, ',', '.'); ?></td>
                                <td class="text-right font-weight-bold">Rp <?php echo number_format($saldoakhir, 0, ',', '.'); ?></td>
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
                        <td><?= htmlspecialchars($a['nama']) ?></td>
                        <td><?= htmlspecialchars($a['jenis']) ?></td>
                        <td><?= htmlspecialchars($a['mata_uang']) ?></td>
                        <td>Rp <?= number_format($saldoakhir, 0, ',', '.') ?></td>
                        <td>
                            <a href="akun.php?edit=<?= $a['id'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="akun.php?hapus=<?= $a['id'] ?>" onclick="return confirm('Hapus akun ini?')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>

    </div>
</div>


<div class="modal fade <?= ($edit || $add) ? 'show' : '' ?>" 
     id="modal-account" 
     tabindex="-1" aria-hidden="true"
     style="<?= ($edit || $add) ? 'display:block; background:rgba(0,0,0,.5);' : '' ?>">

    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= ($edit) ? 'Edit Akun' : 'Tambah Akun' ?>
                    </h5>
                    <a href="akun.php" class="close">&times;</a>
                </div>

                <div class="modal-body">

                    <?php if ($edit): ?>
                        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                    <?php endif; ?>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama Akun</label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= $edit ? $edit['nama'] : '' ?>" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Jenis</label>
                            <select name="jenis" class="custom-select">
                                <?php 
                                $jenis_opt = ['Kas', 'Bank', 'Clearing', 'Petty'];
                                foreach ($jenis_opt as $opt):
                                ?>
                                    <option value="<?= $opt ?>" 
                                            <?= ($edit && $edit['jenis']==$opt) ? 'selected':'' ?>>
                                        <?= $opt ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Mata Uang</label>
                            <select name="mata_uang" class="custom-select">
                                <option value="IDR" <?= (!$edit || ($edit && $edit['mata_uang']=='IDR')) ? 'selected':'' ?>>IDR</option>
                                <option value="USD" <?= ($edit && $edit['mata_uang']=='USD')?'selected':'' ?>>USD</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Saldo Awal</label>
                            <input type="number" name="saldo_awal" class="form-control"
                                   value="<?= $edit ? $edit['saldoawal'] : '' ?>"
                                   min="0" step="100">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <?php if ($edit): ?>
                        <button type="submit" name="update_account" class="btn btn-warning">Update</button>
                        <a href="akun.php" class="btn btn-secondary">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="add_account" class="btn btn-primary">Simpan</button>
                    <?php endif ?>
                </div>

            </form>
        </div>
    </div>
</div>


<?php if ($edit || $add): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    $('#modal-account').modal('show');
});
</script>
<?php endif; ?>


<?php include '../inc/footer.php'; ?>