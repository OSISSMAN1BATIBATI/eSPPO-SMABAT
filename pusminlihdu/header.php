<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
            <!-- Brand Logo -->
        <li class="nav-item">
            <img src="../assets/img/pages/Logo_Panselih_OSIS_(Desain_1A).png" alt="AdminLTE Logo" style="width: 44px; height: 44px;">
            <span style="padding-left: 8px;">Pusat Administrasi Pemilihan Terpadu</span>
        </li>
        <li class="nav-item d-none d-sm-inline-block" style="padding-left: 16px;">
            <a href="index.php?page=dashboard" class="nav-link">Rumah</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="../asse/index.php" class="nav-link">Aplikasi Surat Suara Elektronik</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Bantuan
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <a class="dropdown-item" href="../panduan-esppo/">Panduan Penggunaan</a>
                <!-- <div class="dropdown-divider"></div> -->
                <!-- <a class="dropdown-item" href="#">Kontak Tim Teknis</a> -->
            </div>
        </li>
    </ul>

  <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <span style="padding-top: 8px;"><?php echo $_SESSION['id_akun_admin']; ?> (<?php echo $_SESSION['tipe_akun_admin']; ?>)</span>
        <li class="nav-item d-none d-sm-inline-block text-right">
            <a href="logout.php" class="nav-link">Keluar</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
