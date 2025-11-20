<?php 
include '../inc/config.php';
include '../inc/functions.php';

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

include '../inc/header.php';
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
