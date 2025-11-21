<?php 
include '../inc/config.php';
include '../inc/functions.php';
include '../inc/header.php';

$page_title = "Transaksi Kas & Bank"; 

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Handle POST untuk Create/Update/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create') {
            createTransaksi($conn, $_POST);
            
        } elseif ($action === 'update') {
            updateTransaksi($conn, $_POST['id'], $_POST);
            
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            deleteTransaksi($conn, $_POST['id']);
        }
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Ambil semua data
$result = getAllTransaksi($conn);

// Data kategori & akun
$kategoriList = getKategoriList($conn);
$akunList = getAllAkunList($conn);


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

<div class="container-fluid pt-2">
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Transaksi Kas & Bank</h3>
            <div class="ml-auto">
                <button class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#modal-transfer">
                    <i class="fas fa-random mr-1"></i> Transfer
                </button>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-transaksi-bank">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="100">Tanggal</th>
                            <th width="150">Deskripsi</th>
                            <th width="150">Kategori</th>
                            <th width="100">Akun</th>
                            <th width="120" class="text-right">Jumlah</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $total = 0;
                        $hasData = false;
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                            $hasData = true;
                            $total += $row['jumlah'];
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                                <td><?php echo htmlspecialchars($row['deskripsi']) ?></td>
                                <td><?php echo htmlspecialchars($row['kategori']) ?></td>
                                <td><?php echo htmlspecialchars($row['akun']) ?></td>
                                <td class="text-right">Rp <?php echo number_format($row['jumlah'],0,',','.') ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning mr-1" 
                                            onclick="editData(this)"
                                            data-id="<?php echo $row['id'] ?>"
                                            data-tanggal="<?php echo $row['tanggal'] ?>"
                                            data-deskripsi="<?php echo htmlspecialchars($row['deskripsi']) ?>"
                                            data-kategori="<?php echo htmlspecialchars($row['kategori']) ?>"
                                            data-akun="<?php echo htmlspecialchars($row['akun']) ?>"
                                            data-jumlah="<?php echo $row['jumlah'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile ?>

                        <?php if (!$hasData): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>

                    <?php if ($hasData): ?>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="5" class="text-right">Total Transaksi:</td>
                            <td class="text-right">Rp <?php echo number_format($total,0,',','.') ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    <?php endif ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Transfer -->
<div class="modal fade" id="modal-transfer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Antar Akun</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formTransfer">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="required">Dari</label>
                            <select class="custom-select" name="dari" required>
                                <option value="">-- Pilih Akun --</option>
                                <?php 
                                mysqli_data_seek($akunList, 0);
                                while($akun = mysqli_fetch_assoc($akunList)): 
                                ?>
                                    <option value="<?php echo htmlspecialchars($akun['nama']) ?>">
                                        <?php echo htmlspecialchars($akun['nama']) ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="required">Ke</label>
                            <select class="custom-select" name="ke" required>
                                <option value="">-- Pilih Akun --</option>
                                <?php 
                                mysqli_data_seek($akunList, 0);
                                while($akun = mysqli_fetch_assoc($akunList)): 
                                ?>
                                    <option value="<?php echo htmlspecialchars($akun['nama']) ?>">
                                        <?php echo htmlspecialchars($akun['nama']) ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="required">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="required">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" min="0" step="1000" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <input type="text" class="form-control" name="catatan" placeholder="Opsional">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="alert('Fitur transfer dalam pengembangan')">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Transaksi -->
<div class="modal fade" id="modal-transaksi-bank" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" id="formTransaksi">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="formAction" value="create">
                    <input type="hidden" name="id" id="formId" value="">

                    <div class="form-group">
                        <label class="required">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="formTanggal" 
                               value="<?php echo date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="required">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="formDeskripsi"
                               placeholder="Contoh: Beli ATK" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="required">Kategori</label>
                            <select class="custom-select" name="kategori" id="formKategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php 
                                mysqli_data_seek($kategoriList, 0);
                                while($kat = mysqli_fetch_assoc($kategoriList)): 
                                ?>
                                    <option value="<?php echo htmlspecialchars($kat['nama']) ?>">
                                        <?php echo htmlspecialchars($kat['nama']) ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label class="required">Akun</label>
                            <select class="custom-select" name="akun" id="formAkun" required>
                                <option value="">-- Pilih Akun --</option>
                                <?php 
                                mysqli_data_seek($akunList, 0);
                                while($akun = mysqli_fetch_assoc($akunList)): 
                                ?>
                                    <option value="<?php echo htmlspecialchars($akun['nama']) ?>">
                                        <?php echo htmlspecialchars($akun['nama']) ?> 
                                        (<?php echo htmlspecialchars($akun['jenis']) ?> - Saldo: Rp <?php echo number_format($akun['saldoawal'],0,',','.') ?>)
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="required">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="formJumlah"
                               min="0" step="1000" placeholder="0" required>
                        <small class="form-text text-muted">Masukkan nominal dalam Rupiah</small>
                    </div>

                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="file" class="form-control-file" name="lampiran" accept="image/*,application/pdf">
                        <small class="form-text text-muted">Format: JPG, PNG, PDF (Max 2MB)</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi reset form
function resetForm() {
    document.getElementById('modalTitle').textContent = 'Tambah Transaksi';
    document.getElementById('formAction').value = 'create';
    document.getElementById('formId').value = '';
    document.getElementById('formTransaksi').reset();
    document.getElementById('formTanggal').value = '<?php echo date('Y-m-d') ?>';
    document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-save mr-1"></i> Simpan';
}

// Fungsi untuk edit data
function editData(btn) {
    var id = btn.getAttribute('data-id');
    var tanggal = btn.getAttribute('data-tanggal');
    var deskripsi = btn.getAttribute('data-deskripsi');
    var kategori = btn.getAttribute('data-kategori');
    var akun = btn.getAttribute('data-akun');
    var jumlah = btn.getAttribute('data-jumlah');

    // Set modal title dan action
    document.getElementById('modalTitle').textContent = 'Edit Transaksi';
    document.getElementById('formAction').value = 'update';
    document.getElementById('formId').value = id;
    
    // Isi form dengan data
    document.getElementById('formTanggal').value = tanggal;
    document.getElementById('formDeskripsi').value = deskripsi;
    document.getElementById('formKategori').value = kategori;
    document.getElementById('formAkun').value = akun;
    document.getElementById('formJumlah').value = jumlah;
    
    // Ubah text button submit
    document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-save mr-1"></i> Update';

    // Show modal
    $('#modal-transaksi-bank').modal('show');
}

$(document).ready(function(){
    
    // Validasi form sebelum submit
    $('#formTransaksi').on('submit', function(e){
        var jumlah = parseInt($('input[name="jumlah"]').val());
        if(jumlah <= 0){
            alert('Jumlah harus lebih besar dari 0');
            e.preventDefault();
            return false;
        }
    });

    // Quick add button - trigger modal untuk tambah
    $('#btn-quick-add').on('click', function(){
        resetForm();
        $('#modal-transaksi-bank').modal('show');
    });

    // Tombol tambah di header card
    $('[data-target="#modal-transaksi-bank"]').on('click', function(){
        resetForm();
    });

    // Reset form saat modal ditutup
    $('#modal-transaksi-bank').on('hidden.bs.modal', function () {
        resetForm();
    });
});
</script>

<?php include '../inc/footer.php'; ?>