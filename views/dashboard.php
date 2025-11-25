<?php 
$page_title = "Dashboard"; 

include '../inc/header.php';
include '../inc/sidebar.php';




$page_title = "Dashboard";
if (isset($_GET['logout'])) {
    session_destroy();
    echo '<script>window.location.href = "../index.php"</script>';
    exit;
}


$total_saldo = getTotalSaldo($conn);
$history = history_all($conn);

?>

<!-- DASHBOARD -->
<div id="page-dashboard" class="page active">
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-white shadow-sm">
                <div class="inner">
                    <h3 id="kpi-cash">Rp <?= $total_saldo; ?></h3>
                   
                    <p>Saldo Kas & Bank</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
                <a href="akun.php" class="small-box-footer" data-nav="#page-cash">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-white shadow-sm">
                <div class="inner">
                    <h3 id="kpi-ar">18</h3>
                    <p>Invoice Jatuh Tempo</p>
                </div>
                <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <a href="#" class="small-box-footer" data-nav="#page-invoices">Lihat Invoice <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-white shadow-sm">
                <div class="inner">
                    <h3 id="kpi-unmatched">12</h3>
                    <p>Mutasi Belum Match</p>
                </div>
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
                <a href="#" class="small-box-footer" data-nav="#page-reconcile">Rekonsiliasi <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-white shadow-sm">
                <div class="inner">
                    <h3 id="kpi-missing">9</h3>
                    <p>Transaksi tanpa Lampiran</p>
                </div>
                <div class="icon"><i class="fas fa-paperclip"></i></div>
                <a href="#" class="small-box-footer" data-nav="#page-inbox">Lengkapi Bukti <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- HISTORY GABUNGAN TRANSAKSI (DARI TRANSAKSI + KAS KECIL) -->
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">History Transaksi (Semua)</h3>
            <div>
                <a href="transaksi_bank.php" class="btn btn-xs btn-primary"><i class="fas fa-plus mr-1"></i> Tambah</a>
                <a href="transaksi_kas.php" class="btn btn-xs btn-outline-primary ml-1"><i class="fas fa-wallet mr-1"></i> Kas Kecil</a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbl-history">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th class="text-right">Jumlah</th>
                            <th>Akun</th>
                            <th>Sumber</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $has = false;
                        while ($row = mysqli_fetch_assoc($history)): 
                            $has = true;
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                            <td class="text-right">Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['akun']); ?></td>
                            <td><?php echo htmlspecialchars($row['sumber']); ?></td> <!-- TAMBAHAN -->
                        </tr>
                        <?php endwhile; ?>

                        <?php if (!$has): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Belum ada transaksi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /HISTORY GABUNGAN -->
</div>
<!-- /DASHBOARD -->

    <?php include '../inc/footer.php'; ?>