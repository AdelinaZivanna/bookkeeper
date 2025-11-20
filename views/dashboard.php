<?php 
include '../inc/header.php';
include '../inc/sidebar.php';
?>
<!-- DASHBOARD -->
                    <div id="page-dashboard" class="page active">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="small-box bg-white shadow-sm">
                                    <div class="inner">
                                        <h3 id="kpi-cash">Rp 125.450.000</h3>
                                        <p>Saldo Kas & Bank</p>
                                    </div>
                                    <div class="icon"><i class="fas fa-wallet"></i></div>
                                    <a href="#" class="small-box-footer" data-nav="#page-cash">Detail <i
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

                        <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Transaksi Terakhir</h3>
                                <div>
                                    <button class="btn btn-xs btn-primary" data-toggle="modal"
                                        data-target="#modal-quick"><i class="fas fa-plus mr-1"></i> Tambah</button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="tbl-latest">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Deskripsi</th>
                                                <th>Kategori</th>
                                                <th class="text-right">Jumlah</th>
                                                <th>Akun</th>
                                                <th>Lampiran</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /DASHBOARD -->
<?php include '../inc/footer.php'; ?>
