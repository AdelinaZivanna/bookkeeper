<?php 
include '../inc/header.php';
include '../inc/sidebar.php';

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
            
            $query = "INSERT INTO kaskecil (tanggal, deskripsi, kategori, akun, jumlah) VALUES ('$tanggal', '$deskripsi', '$kategori', '$akun', $jumlah)";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data berhasil ditambahkan');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } elseif ($action === 'update') {
            $id = (int)$_POST['id'];
            $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
            $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
            $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
            $akun = mysqli_real_escape_string($conn, $_POST['akun']);
            $jumlah = (int)$_POST['jumlah'];
            
            $query = "UPDATE kaskecil SET tanggal='$tanggal', deskripsi='$deskripsi', kategori='$kategori', akun='$akun', jumlah=$jumlah WHERE id=$id";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data berhasil diupdate');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $query = "DELETE FROM kaskecil WHERE id=$id";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data berhasil dihapus');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}

// Handle GET untuk Edit (isi modal dengan data)
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM kaskecil WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Read: Ambil semua data untuk tabel
$result = mysqli_query($conn, "SELECT * FROM kaskecil ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kas Kecil</title>
    <!-- Include Bootstrap CSS/JS jika belum ada -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <!-- PETTY CASH -->
        <div id="page-petty" class="page">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Kas Kecil</h3>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-transaksi-kas"><i class="fas fa-plus mr-1"></i> Pengeluaran</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tbl-petty">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th class="text-right">Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['tanggal']; ?></td>
                                        <td><?php echo $row['deskripsi']; ?></td>
                                        <td class="text-right"><?php echo $row['jumlah']; ?></td>
                                        <td>
                                            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /PETTY -->

        <!-- Modal tambah/edit transaksi -->
        <div class="modal fade" id="modal-transaksi-kas" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $editData ? 'Edit Transaksi' : 'Tambah Transaksi'; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $editData ? 'update' : 'create'; ?>">
                            <?php if ($editData): ?>
                                <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="required">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="<?php echo $editData['tanggal'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="required">Deskripsi</label>
                                <input type="text" class="form-control" name="deskripsi" value="<?php echo $editData['deskripsi'] ?? ''; ?>" placeholder="Contoh: Beli ATK" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label class="required">Kategori</label>
                                    <select class="custom-select" name="kategori" required>
                                        <option value="Operasional" <?php echo ($editData['kategori'] ?? '') == 'Operasional' ? 'selected' : ''; ?>>Operasional</option>
                                        <option value="Marketing" <?php echo ($editData['kategori'] ?? '') == 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                                        <option value="Langganan" <?php echo ($editData['kategori'] ?? '') == 'Langganan' ? 'selected' : ''; ?>>Langganan</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label class="required">Akun</label>
                                    <select class="custom-select" name="akun" required>
                                        <option value="Kas Kecil" <?php echo ($editData['akun'] ?? '') == 'Kas Kecil' ? 'selected' : ''; ?>>Kas Kecil</option>
                                        <option value="BCA 1234" <?php echo ($editData['akun'] ?? '') == 'BCA 1234' ? 'selected' : ''; ?>>BCA 1234</option>
                                        <option value="Mandiri 5678" <?php echo ($editData['akun'] ?? '') == 'Mandiri 5678' ? 'selected' : ''; ?>>Mandiri 5678</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="required">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" value="<?php echo $editData['jumlah'] ?? ''; ?>" min="0" step="100" required>
                            </div>
                            <div class="sticky-actions">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> <?php echo $editData ? 'Update' : 'Simpan'; ?></button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-show modal jika edit
        <?php if ($editData): ?>
            $(document).ready(function() {
                $('#modal-transaksi-kas').modal('show');
            });
        <?php endif; ?>
    </script>
</body>
</html>

<?php include '../inc/footer.php'; ?>