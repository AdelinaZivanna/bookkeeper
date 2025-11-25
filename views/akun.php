<?php 

$page_title = "Kategori"; 
include '../inc/header.php';
include '../inc/sidebar.php';

if (isset($_POST['add_category'])) {
    kategori_add(
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['ppn'] ?? 'Non PPN'
    );

    echo '<script>window.location.href = "kategori.php"</script>';
    exit;
}

if (isset($_POST['update_category'])) {
    kategori_update(
        $_POST['id'],
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['ppn'] ?? 'Non PPN'
    );

    echo '<script>window.location.href = "kategori.php"</script>';
    exit;
}

if (isset($_GET['hapus'])) {
    kategori_delete(intval($_GET['hapus']));
    echo '<script>window.location.href = "kategori.php"</script>';
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = kategori_get($_GET['edit']);
}
?>

<div class="card card-outline card-primary shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Kategori</h3>
        <button class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#modal-category">
            <i class="fas fa-plus"></i> Kategori
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>PPN</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $kategori = kategori_all();
                foreach ($kategori as $k): ?>
                    <tr>
                        <td><?= htmlspecialchars($k['id']) ?></td>
                        <td><?= htmlspecialchars($k['nama']) ?></td>
                        <td><?= htmlspecialchars($k['jenis']) ?></td>
                        <td><?= htmlspecialchars($k['PPN']) ?></td>
                        <td>
                            <a href="kategori.php?edit=<?= $k['id'] ?>" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="kategori.php?hapus=<?= $k['id'] ?>"
                               onclick="return confirm('Hapus kategori?')"
                               class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade <?php echo $edit ? 'show' : '' ?>"
     id="modal-category"
     tabindex="-1"
     aria-hidden="true"
     style="<?php echo $edit ? 'display:block; background:rgba(0,0,0,.5);' : '' ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= $edit ? 'Edit Kategori' : 'Tambah Kategori' ?>
                    </h5>
                    <a href="kategori.php" class="close">&times;</a>
                </div>
                <div class="modal-body">

                    <?php if ($edit): ?>
                        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                    <?php endif ?>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= $edit ? htmlspecialchars($edit['nama']) : '' ?>"
                                   required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Jenis</label>
                            <select name="jenis" class="custom-select">
                                <option value="Pendapatan" 
                                    <?= ($edit && $edit['jenis']=='Pendapatan')?'selected':'' ?>>
                                    Pendapatan
                                </option>
                                <option value="Biaya" 
                                    <?= ($edit && $edit['jenis']=='Biaya')?'selected':'' ?>>
                                    Biaya
                                </option>
                                <option value="Lainnya" 
                                    <?= ($edit && $edit['jenis']=='Lainnya')?'selected':'' ?>>
                                    Lainnya
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>PPN</label>
                        <select name="ppn" class="custom-select">
                            <option value="Non PPN" 
                                <?= ($edit && $edit['PPN']=='Non PPN')?'selected':'' ?>>
                                Non PPN
                            </option>
                            <option value="PPN 11%" 
                                <?= ($edit && $edit['PPN']=='PPN 11%')?'selected':'' ?>>
                                PPN 11%
                            </option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <?php if ($edit): ?>
                        <button type="submit" name="update_category" class="btn btn-warning">Update</button>
                        <a href="kategori.php" class="btn btn-secondary">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="add_category" class="btn btn-primary">Simpan</button>
                    <?php endif ?>

                </div>

            </form>

        </div>
    </div>
</div>

<?php if ($edit): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    $('#modal-category').modal('show');
});
</script>
<?php endif; ?>

<?php include '../inc/footer.php'; ?> 
