<!doctype html>
<html lang="id">
<head>
    <title>Sistem Penyelenggaraan Pemilihan OSIS Elektronik (eSPPO) - SMA Negeri 1 Bati-Bati</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendors/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="vendors/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        /* Wrapper untuk Konten Utama dengan Background Gambar */
        .content-wrapper {
            background-image: url('assets/img/pages/Foto_Lapangan_Upacara_Edit.jpg');
            background-attachment: fixed;
            background-size: cover;
            padding-bottom: 50px; /* Beri padding untuk ruang footer */
        }

        /* Footer dengan Background Solid */
        footer {
            background-color: #f8f9fa; /* Warna latar belakang footer */
            color: #6c757d; /* Warna teks footer */
            border-top: 1px solid #dee2e6; /* Garis atas footer */
            padding: 20px 0;
        }

        footer .bi {
            width: 64px;
            height: 64px;
        }
    </style>
</head>

<body>
    <!-- Konten Utama dalam Wrapper -->
    <div class="content-wrapper">
        <!-- Navigation Bar -->
        <nav class="py-2 bg-body-tertiary border-bottom">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link link-body-emphasis px-2">Rumah</a></li>
                    <li class="nav-item"><a href="info-pemilihan.php" class="nav-link link-body-emphasis px-2">Informasi Pemilihan</a></li>
                    <li class="nav-item"><a href="info-paslon.php" class="nav-link link-body-emphasis px-2">Daftar Kandidat</a></li>
                    <li class="nav-item"><a href="data-pemilih.php" class="nav-link link-body-emphasis px-2">Daftar Pemilih</a></li>
                    <li class="nav-item"><a href="hasil-pemilihan.php" class="nav-link link-body-emphasis px-2">Hasil Pemilihan</a></li>
                </ul>
                <ul class="nav">
                    <li class="nav-item"><a href="bantuan.php" class="nav-link link-body-emphasis px-2">Bantuan dan Pengaduan</a></li>
                    <li class="nav-item"><a href="kontak-panselih.php" class="nav-link link-body-emphasis px-2">Kontak Panselih OSIS</a></li>
                </ul>
            </div>
        </nav>

        <!-- Header -->
        <header class="py-3 mb-4 border-bottom">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="/pilketos-smabat-webapp/index.php" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                    <img src="assets/img/pages/Logo_Panselih_OSIS_(Desain_1A).png" style="width:56px;height:56px" alt="Logo Panselih OSIS">
                    <span class="fs-3 ms-3">Sistem Penyelenggaraan Pemilihan OSIS Elektronik</span>
                </a>
                <div class="col-md-0 text-end">
                    <a href="asse/index.php"><button type="button" class="btn btn-primary">Login Pemilih</button></a>
                    <a href="pusminlihdu/index.php"><button type="button" class="btn btn-primary">Login Panitia/Pengawas</button></a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-6 fw-bold text-body-emphasis">Selamat datang di Portal Sistem Penyelenggaraan Pemilihan OSIS Elektronik di SMA Negeri 1 Bati-Bati!</h1>
            <div class="col-lg-6 mx-auto">
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="asse/index.php"><button type="button" class="btn btn-outline-primary btn-lg px-4 gap-3">Login Pemilih</button></a>
                    <a href="pusminlihdu/index.php"><button type="button" class="btn btn-outline-secondary btn-lg px-4">Login Panitia/Pengawas</button></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <span class="mb-3 mb-md-0 text-body-secondary">&copy; <?php echo date("Y") ?> Panselih OSIS SMA Negeri 1 Bati-Bati</span>
        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="https://kalselprov.go.id/"><img src="assets/img/pages/Lambang_Provinsi_Kalimantan_Selatan.png" alt="Website Pemerintah Provinsi Kalimantan Selatan" style="width:64px;height:64px"></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="https://www.sman1batibati.sch.id/"><img src="assets/img/pages/Logo_SMABAT_Bungas-Tulisan_Jelas.png" alt="Website SMA Negeri 1 Bati-Bati" style="width:96px;height:64px"></a></li>
        </ul>
    </footer>
</body>
</html>
