<?php
include '../inc/config.php';
include '../inc/functions.php';

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

if (isset($_GET['delete'])) {
    kontak_delete($_GET['delete']);
    header("Location: kontak.php");
    exit;
}

$kontaks = kontak_all();

include '../inc/header.php';
?>

<div class="card card-outline card-primary shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Kontak</h3>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-contact">
            <i class="fas fa-plus mr-1"></i> Kontak
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
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
                                <td><?php echo htmlspecialchars($k['nama']) ?></td>
                                <td><?php echo htmlspecialchars($k['jenis']) ?></td>
                                <td><?php echo htmlspecialchars($k['email']) ?></td>
                                <td><?php echo htmlspecialchars($k['telepon']) ?></td>
                                <td>
                                    <a href="?delete=<?php echo $k['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Hapus kontak ini?')">
                                        Hapus
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

<div class="modal fade" id="modal-contact" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kontak</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="custom-select" required>
                                <option value="Customer">Customer</option>
                                <option value="Vendor">Vendor</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" name="add_contact" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include '../inc/footer.php';
?>

