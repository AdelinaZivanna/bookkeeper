<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">


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
                            <a href="<?php echo $base_url; ?>views/dashboard.php" class="nav-link active" >
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
                                <li class="nav-item">
                                    <a href="<?php echo $base_url; ?>views/transaksi_bank.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaksi Kas/Bank</p>
                                    </a></li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url; ?>views/transaksi_kas.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kas Kecil</p>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-header">Master</li>
                        <li class="nav-item">
                                <a href="<?php echo $base_url; ?>views/kontak.php" class="nav-link">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>Kontak</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_url; ?>views/kategori.php" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Kategori</p>
                            </a></li>
                        <li class="nav-item">
                            <a href="<?php echo $base_url; ?>views/akun.php" class="nav-link">
                                <i class="nav-icon fas fa-university"></i>
                                <p>Akun Kas/Bank</p>
                            </a></li>
                        <li class="nav-header">Lainnya</li>
                        <li class="nav-item">
                            <a href="<?php echo $base_url; ?>views/pengaturan.php" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
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
                        <h1 id="page-title">
                            <?php echo isset($page_title) ? $page_title : "Halaman"; ?>
                        </h1>
                        </div>
                        <div class="col-sm-6 text-right">&nbsp;</div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
