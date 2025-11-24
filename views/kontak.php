<?php
$page_title = "Kontak"; 

include '../inc/header.php';
include '../inc/sidebar.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['add_contact'])) {
    kontak_add(
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['email'],
        $_POST['telepon']
    );

    header("Location: kontak.php");
    exit;
}

if (isset($_POST['update_contact'])) {
    kontak_update(
        $_POST['id'],
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['email'],
        $_POST['telepon']
    );

    header("Location: kontak.php");
    exit;
}

if (isset($_GET['delete'])) {
    kontak_delete($_GET['delete']);
    header("Location: kontak.php");
    exit;
}


$edit = null;
if (isset($_GET['edit'])) {
    $edit = kontak_get($_GET['edit']);
}

$kontaks = kontak_all();
?>

<div class="card card-outline card-primary shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Kontak</h3>
        <button class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#modal-contact">
            <i class="fas fa-plus mr-1"></i> Kontak
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($kontaks)) : ?>
                        <?php foreach ($kontaks as $k): ?>
                            <tr>
                                <td><?= htmlspecialchars($k['id']) ?></td>                
                                <td><?= htmlspecialchars($k['nama']) ?></td>
                                <td><?= htmlspecialchars($k['jenis']) ?></td>
                                <td><?= htmlspecialchars($k['email']) ?></td>
                                <td><?= htmlspecialchars($k['telepon']) ?></td>
                                <td>
                                    <a href="?edit=<?= $k['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="?delete=<?= $k['id'] ?>"
                                       onclick="return confirm('Hapus kontak ini?')"
                                       class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Belum ada kontak.
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade <?php echo $edit ? 'show' : '' ?>" id="modal-contact"
    tabindex="-1" aria-hidden="true"
    style="<?php echo $edit ? 'display:block; background:rgba(0,0,0,.5);' : '' ?>">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= $edit ? 'Edit Kontak' : 'Tambah Kontak' ?>
                    </h5>
                    <a href="kontak.php" class="close">&times;</a>
                </div>

                <div class="modal-body">

                    <?php if ($edit): ?>
                        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                    <?php endif ?>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                value="<?= $edit ? htmlspecialchars($edit['nama']) : '' ?>"
                                required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="custom-select" required>
                                <option value="Customer"
                                    <?= ($edit && $edit['jenis']=='Customer') ? 'selected' : '' ?>>
                                    Customer
                                </option>
                                <option value="Vendor"
                                    <?= ($edit && $edit['jenis']=='Vendor') ? 'selected' : '' ?>>
                                    Vendor
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= $edit ? htmlspecialchars($edit['email']) : '' ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                value="<?= $edit ? htmlspecialchars($edit['telepon']) : '' ?>">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <?php if ($edit): ?>
                        <button type="submit" name="update_contact" class="btn btn-warning">
                            Update
                        </button>
                        <a href="kontak.php" class="btn btn-secondary">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="add_contact" class="btn btn-primary">
                            Simpan
                        </button>
                    <?php endif ?>
                </div>

            </form>

        </div>
    </div>
</div>

<?php if ($edit): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#modal-contact').modal('show');
});
</script>
<?php endif; ?>

<?php include '../inc/footer.php'; ?>
