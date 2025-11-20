<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">

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
                        <a href="#" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i>
                            Keluar</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <i class="fas fa-ledger ml-2 mr-2"></i>
                <span class="brand-text">Bookkeeper</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link active" >
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview menu-close">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cash-register"></i>
                                <p> Kas & Bank<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="transaksi_bank.php" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Transaksi Kas/Bank</p>
                                    </a></li>
                                <li class="nav-item"><a href="transaksi_kas.php" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Kas Kecil</p>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-header">Master</li>
                        <li class="nav-item">
                            <a href="kontak.php" class="nav-link">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>Kontak</p>
                            </a>
                        </li>
                        <li class="nav-item"><a href="kategori.php" class="nav-link"><i
                                    class="nav-icon fas fa-tags"></i>
                                <p>Kategori</p>
                            </a></li>
                        <li class="nav-item"><a href="akun.php" class="nav-link"><i
                                    class="nav-icon fas fa-university"></i>
                                <p>Akun Kas/Bank</p>
                            </a></li>
                        <li class="nav-header">Lainnya</li>
                        <li class="nav-item"><a href="pengaturan.php" class="nav-link"><i
                                    class="nav-icon fas fa-cog"></i>
                                <p>Pengaturan</p>
                            </a></li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-6">
                            <h1 id="page-title">Dashboard</h1>
                        </div>
                        <div class="col-sm-6 text-right">&nbsp;</div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
