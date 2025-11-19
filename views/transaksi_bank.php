                    <!-- CASH/BANK TRANSACTIONS -->
                    <div id="page-cash" class="page d-none">
                        <div class="card card-outline card-primary shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Transaksi Kas & Bank</h3>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                        data-target="#modal-transfer"><i class="fas fa-random mr-1"></i>
                                        Transfer</button>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#modal-transaksi-bank"><i class="fas fa-plus mr-1"></i> Tambah</button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="tbl-cash">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Deskripsi</th>
                                                <th>Kategori</th>
                                                <th>Akun</th>
                                                <th class="text-right">Jumlah</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /CASH -->

                     <!-- Modal Transfer -->
                    <div class="modal fade" id="modal-transfer" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Transfer Antar Akun</h5><button type="button" class="close"
                                        data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-row">
                                            <div class="form-group col-md-6"><label class="required">Dari</label><select
                                                    class="custom-select">
                                                    <option>Kas Kecil</option>
                                                    <option>BCA 1234</option>
                                                </select></div>
                                            <div class="form-group col-md-6"><label class="required">Ke</label><select
                                                    class="custom-select">
                                                    <option>Mandiri 5678</option>
                                                    <option>BCA 1234</option>
                                                </select></div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6"><label class="required">Tanggal</label><input type="date"
                                                    class="form-control" required></div>
                                            <div class="form-group col-md-6"><label class="required">Jumlah</label><input type="number"
                                                    class="form-control" min="0" step="100" required></div>
                                        </div>
                                        <div class="form-group"><label>Catatan</label><input type="text" class="form-control"
                                                placeholder="Opsional"></div>
                                    </form>
                                </div>
                                <div class="sticky-actions text-right"><button class="btn btn-primary"
                                        data-dismiss="modal">Simpan</button></div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal tambah transaksi -->
                    <div class="modal fade" id="modal-transaksi-bank" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Transaksi</h5><button type="button" class="close"
                                        data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-quick">
                                        <div class="form-group">
                                            <label class="required">Tanggal</label>
                                            <input type="date" class="form-control" name="date" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="required">Deskripsi</label>
                                            <input type="text" class="form-control" name="desc" placeholder="Contoh: Beli ATK"
                                                required>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label class="required">Kategori</label>
                                                <select class="custom-select" name="category" required>
                                                    <option value="Operasional">Operasional</option>
                                                    <option value="Marketing">Marketing</option>
                                                    <option value="Langganan">Langganan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="required">Akun</label>
                                                <select class="custom-select" name="account" required>
                                                    <option value="Kas Kecil">Kas Kecil</option>
                                                    <option value="BCA 1234">BCA 1234</option>
                                                    <option value="Mandiri 5678">Mandiri 5678</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="required">Jumlah</label>
                                            <input type="number" class="form-control" name="amount" min="0" step="100" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Lampiran</label>
                                            <input type="file" class="form-control-file" name="attachment"
                                                accept="image/*,application/pdf">
                                        </div>
                                    </form>
                                </div>
                                <div class="sticky-actions">
                                    <button type="button" class="btn btn-primary" id="btn-save-quick"><i class="fas fa-save mr-1"></i>
                                        Simpan</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
        

