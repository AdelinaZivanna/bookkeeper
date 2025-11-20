<?php 
include '../inc/config.php';
include '../inc/functions.php';

$page_title = "Kas Kecil"; 

// Handle POST untuk Create/Update/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create') {
            $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
            $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
            $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
            $akun = mysqli_real_escape_string($conn, $_POST['akun']);
            $jumlah = (int)$_POST['jumlah'];
            
            $query = "INSERT INTO kaskecil (tanggal, deskripsi, kategori, akun, jumlah) 
                      VALUES ('$tanggal', '$deskripsi', '$kategori', '$akun', $jumlah)";
            mysqli_query($conn, $query);
            
        } elseif ($action === 'update') {
            $id = (int)$_POST['id'];
            $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
            $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
            $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
            $akun = mysqli_real_escape_string($conn, $_POST['akun']);
            $jumlah = (int)$_POST['jumlah'];
            
            $query = "UPDATE kaskecil SET tanggal='$tanggal', deskripsi='$deskripsi', kategori='$kategori', akun='$akun', jumlah=$jumlah WHERE id=$id";
            mysqli_query($conn, $query);
            
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $query = "DELETE FROM kaskecil WHERE id=$id";
            mysqli_query($conn, $query);
        }
        header("Location: kas_kecil.php");
        exit;
    }
}

// Handle GET untuk Edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM kaskecil WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Ambil semua data
$result = mysqli_query($conn, "SELECT * FROM kaskecil ORDER BY tanggal DESC");

// Data kategori & akun
$kategoriList = mysqli_query($conn, "SELECT DISTINCT nama FROM kategori ORDER BY nama ASC");
$akunList = mysqli_query($conn, "SELECT nama, saldoawal FROM akun WHERE jenis='kas' ORDER BY nama ASC");

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
                    <a href="#" class="nav-link font-weight-bold">Kas Kecil</a>
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

<div class="container-fluid pt-2"> <!-- pt-2 supaya card agak nempel atas -->
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Kas Kecil</h3>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-transaksi-kas">
                <i class="fas fa-plus mr-1"></i> Pengeluaran
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbl-petty" style="margin-left:0;">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Akun</th>
                            <th class="text-right">Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        while ($row = mysqli_fetch_assoc($result)):
                            $total += $row['jumlah'];
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                            <td><?php echo htmlspecialchars($row['akun']); ?></td>
                            <td class="text-right">Rp <?php echo number_format($row['jumlah'],0,',','.'); ?></td>
                            <td>
                                <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">Total Pengeluaran:</td>
                            <td class="text-right">Rp <?php echo number_format($total,0,',','.'); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modal-transaksi-kas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" id="formTransaksi">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $editData ? 'Edit Transaksi' : 'Tambah Transaksi'; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?php echo $editData ? 'update' : 'create'; ?>">
                    <?php if($editData): ?>
                        <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="required">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?php echo $editData['tanggal'] ?? date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="required">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" value="<?php echo htmlspecialchars($editData['deskripsi'] ?? ''); ?>" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="required">Kategori</label>
                            <select class="custom-select" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php mysqli_data_seek($kategoriList,0);
                                while($kat=mysqli_fetch_assoc($kategoriList)): ?>
                                    <option value="<?php echo htmlspecialchars($kat['nama']); ?>" <?php echo ($editData['kategori']??'')==$kat['nama']?'selected':''; ?>>
                                        <?php echo htmlspecialchars($kat['nama']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label class="required">Akun</label>
                            <select class="custom-select" name="akun" required>
                                <option value="">-- Pilih Akun --</option>
                                <?php mysqli_data_seek($akunList,0);
                                while($akun=mysqli_fetch_assoc($akunList)): ?>
                                    <option value="<?php echo htmlspecialchars($akun['nama']); ?>" <?php echo ($editData['akun']??'')==$akun['nama']?'selected':''; ?>>
                                        <?php echo htmlspecialchars($akun['nama']); ?> (Saldo: <?php echo number_format($akun['saldoawal'],0,',','.'); ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" value="<?php echo $editData['jumlah'] ?? ''; ?>" min="0" step="1000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php echo $editData?'Update':'Simpan'; ?></button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    <?php if($editData): ?>
        $('#modal-transaksi-kas').modal('show');
    <?php endif; ?>
    
    $('#formTransaksi').on('submit', function(e){
        var jumlah = parseInt($('input[name="jumlah"]').val());
        if(jumlah <= 0){
            alert('Jumlah harus lebih besar dari 0');
            e.preventDefault();
        }
    });
});
</script>

<?php include '../inc/footer.php'; ?>
