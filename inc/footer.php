                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer text-sm">
            <strong>Bookkeeper MVP</strong>
            <span class="ml-1">&copy; <span id="year"></span></span>
            <div class="float-right d-none d-sm-inline">v0.1</div>
        </footer>

    </div>
   
    <div class="modal fade" id="modal-contact" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kontak</h5><button type="button" class="close"
                        data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-8"><label class="required">Nama</label><input type="text"
                                    class="form-control" required></div>
                            <div class="form-group col-md-4"><label class="required">Jenis</label><select
                                    class="custom-select">
                                    <option>Customer</option>
                                    <option>Vendor</option>
                                </select></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6"><label>Email</label><input type="email"
                                    class="form-control"></div>
                            <div class="form-group col-md-6"><label>Telepon</label><input type="text"
                                    class="form-control"></div>
                        </div>
                    </form>
                </div>
                <div class="sticky-actions text-right"><button class="btn btn-primary"
                        data-dismiss="modal">Simpan</button></div>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div class="modal fade" id="modal-category" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5><button type="button" class="close"
                        data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-8"><label class="required">Nama</label><input type="text"
                                    class="form-control" required></div>
                            <div class="form-group col-md-4"><label class="required">Jenis</label><select
                                    class="custom-select">
                                    <option>Pendapatan</option>
                                    <option>Biaya</option>
                                    <option>Lainnya</option>
                                </select></div>
                        </div>
                        <div class="form-group"><label>PPN</label><select class="custom-select">
                                <option>Non PPN</option>
                                <option>PPN 11%</option>
                            </select></div>
                    </form>
                </div>
                <div class="sticky-actions text-right"><button class="btn btn-primary"
                        data-dismiss="modal">Simpan</button></div>
            </div>
        </div>
    </div>

    <!-- Account Modal -->
    <div class="modal fade" id="modal-account" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5><button type="button" class="close"
                        data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6"><label class="required">Nama Akun</label><input type="text"
                                    class="form-control" required></div>
                            <div class="form-group col-md-6"><label class="required">Jenis</label><select
                                    class="custom-select">
                                    <option>Kas</option>
                                    <option>Bank</option>
                                    <option>Clearing</option>
                                    <option>Petty</option>
                                </select></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6"><label>Mata Uang</label><select class="custom-select">
                                    <option>IDR</option>
                                    <option>USD</option>
                                </select></div>
                            <div class="form-group col-md-6"><label>Saldo Awal</label><input type="number"
                                    class="form-control" min="0" step="100"></div>
                        </div>
                    </form>
                </div>
                <div class="sticky-actions text-right"><button class="btn btn-primary"
                        data-dismiss="modal">Simpan</button></div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS ====================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        (function () {
            const fmtIDR = n => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n || 0)
            const state = {
                latest: [
                    { date: '2025-10-28', desc: 'Beli ATK', category: 'Operasional', amount: -250000, account: 'Kas Kecil', att: true },
                    { date: '2025-10-27', desc: 'Pembayaran Invoice INV-1024', category: 'Penjualan', amount: 4500000, account: 'BCA 1234', att: false },
                    { date: '2025-10-26', desc: 'Langganan SaaS', category: 'Langganan', amount: -350000, account: 'Mandiri 5678', att: true }
                ],
                invoices: [
                    { no: 'INV-1024', date: '2025-10-20', customer: 'PT Nusantara', total: 4500000, status: 'Belum Lunas' },
                    { no: 'INV-1023', date: '2025-10-12', customer: 'CV Maju', total: 2100000, status: 'Lunas' }
                ],
                bills: [
                    { no: 'BILL-2008', date: '2025-10-21', vendor: 'UD Sukses', total: 1250000, status: 'Belum Lunas' }
                ],
                cash: [], petty: [],
                bank: [
                    { date: '2025-10-20', desc: 'Incoming transfer PT Nusantara', amount: 4500000, matched: false },
                    { date: '2025-10-21', desc: 'Langganan SaaS', amount: -350000, matched: true }
                ],
                ledger: [
                    { date: '2025-10-20', desc: 'INV-1024 PT Nusantara', amount: 4500000 },
                    { date: '2025-10-21', desc: 'Langganan SaaS', amount: -350000 }
                ],
                contacts: [{ name: 'PT Nusantara', type: 'Customer', email: 'finance@nusantara.co', phone: '021-555-100' }],
                categories: [{ name: 'Operasional', type: 'Biaya', tax: 'Non PPN' }, { name: 'Marketing', type: 'Biaya', tax: 'Non PPN' }, { name: 'Penjualan', type: 'Pendapatan', tax: 'PPN 11%' }],
                accounts: [{ name: 'Kas Kecil', type: 'Kas', ccy: 'IDR' }, { name: 'BCA 1234', type: 'Bank', ccy: 'IDR' }, { name: 'Mandiri 5678', type: 'Bank', ccy: 'IDR' }]
            }

            // NAVIGATION
            $(document).on('click', '[data-nav]', function (e) {
                e.preventDefault();
                const target = $(this).data('nav');
                $('.nav-link').removeClass('active');
                $(this).closest('.nav-link').addClass('active');
                $('.page').addClass('d-none').removeClass('active');
                $(target).removeClass('d-none').addClass('active');
                $('#page-title').text($(this).text().trim());
                if (window.innerWidth < 992) { $('[data-widget="pushmenu"]').PushMenu('collapse') }
            })

            // QUICK ADD
            $('#btn-quick-add').on('click', function () { $('#modal-quick').modal('show') })
            $('#btn-save-quick').on('click', function () {
                const f = Object.fromEntries(new FormData(document.getElementById('form-quick')).entries());
                if (!f.date || !f.desc || !f.category || !f.account || !f.amount) { return alert('Lengkapi data yang wajib diisi.') }
                const amt = Number(f.amount)
                state.latest.unshift({ date: f.date, desc: f.desc, category: f.category, amount: amt, account: f.account, att: !!f.attachment })
                renderLatest(); renderCash();
                $('#modal-quick').modal('hide'); $('#form-quick')[0].reset();
            })

            // RENDER HELPERS
            function renderLatest() {
                const $tb = $('#tbl-latest tbody').empty()
                state.latest.slice(0, 10).forEach(r => {
                    $tb.append(`<tr>
                    <td>${r.date}</td>
                    <td>${r.desc}</td>
                    <td><span class="badge badge-soft">${r.category}</span></td>
                    <td class="text-right ${r.amount < 0 ? 'text-danger' : ''}">${fmtIDR(r.amount)}</td>
                    <td>${r.account}</td>
                    <td>${r.att ? '<i class="fas fa-paperclip"></i>' : '-'}</td>
                </tr>`)
                })
            }

            function renderCash() {
                const $tb = $('#tbl-cash tbody').empty()
                state.latest.forEach(r => {
                    $tb.append(`<tr>
                    <td>${r.date}</td><td>${r.desc}</td><td>${r.category}</td><td>${r.account}</td><td class="text-right ${r.amount < 0 ? 'text-danger' : ''}">${fmtIDR(r.amount)}</td>
                    <td class="text-right"><button class="btn btn-xs btn-light"><i class="fas fa-paperclip"></i></button></td>
                </tr>`)
                })
            }

            function renderContacts() {
                const $tb = $('#tbl-contacts tbody').empty()
                state.contacts.forEach(x => { $tb.append(`<tr><td>${x.name}</td><td>${x.type}</td><td>${x.email || '-'}</td><td>${x.phone || '-'}</td><td class="text-right"><button class="btn btn-xs btn-light"><i class="fas fa-edit"></i></button></td></tr>`) })
            }

            function renderCategories() {
                const $tb = $('#tbl-categories tbody').empty()
                state.categories.forEach(x => { $tb.append(`<tr><td>${x.name}</td><td>${x.type}</td><td>${x.tax}</td><td class="text-right"><button class="btn btn-xs btn-light"><i class="fas fa-edit"></i></button></td></tr>`) })
            }

            function renderAccounts() {
                const $tb = $('#tbl-accounts tbody').empty()
                state.accounts.forEach(x => { $tb.append(`<tr><td>${x.name}</td><td>${x.type}</td><td>${x.ccy}</td><td class="text-right"><button class="btn btn-xs btn-light"><i class="fas fa-edit"></i></button></td></tr>`) })
            }

            // DARK MODE TOGGLE
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            if (prefersDark) { document.body.classList.add('dark-mode') }
            $('#toggle-dark').on('click', function (e) { e.preventDefault(); $('body').toggleClass('dark-mode') })

            // INIT
            function init() {
                $('#year').text(new Date().getFullYear())
                renderLatest(); renderInvoices(); renderBills(); renderCash(); renderReconcile(); renderContacts(); renderCategories(); renderAccounts();
            }
            init();
        })()
    </script>
</body>

</html>

