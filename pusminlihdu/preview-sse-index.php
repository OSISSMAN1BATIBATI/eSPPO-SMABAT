<?php

$versi_esppo = '1.0.0';
require '../config/config_db.php';

// Ambil data pemilihan dari database
$stmt_pemilihan = $pdo->prepare("SELECT nama_pemilihan, tanggal_pemilihan FROM tabel_data_pemilihan LIMIT 1");
$stmt_pemilihan->execute();
$pemilihan = $stmt_pemilihan->fetch();
$nama_pemilihan = $pemilihan['nama_pemilihan'];
$tanggal_pemilihan = date_create($pemilihan['tanggal_pemilihan']);

// Ambil data kandidat dari database
$stmt_kandidat = $pdo->prepare("SELECT no_urut_kandidat, foto_kandidat, nama_calon_ketua, nama_calon_wakil FROM tabel_data_kandidat");
$stmt_kandidat->execute();
$kandidat = $stmt_kandidat->fetchAll();

$dateformat_id = datefmt_create("id_ID", IntlDateFormatter::FULL, IntlDateFormatter::FULL,
    'Asia/Makassar', IntlDateFormatter::GREGORIAN, "EEEE, dd MMMM yyyy");

?>

<!doctype html>
<html lang="id">
<head>
    <title>Pusat Administrasi Pemilihan Terpadu eSPPO &dash; (PREVIEW) Surat Suara Elektronik eSPPO &ndash; Lembar Surat Suara (PREVIEW)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../vendors/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../vendors/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        header {
            background-color: #FF8C00; /* Warna oranye */
            color: white;
            padding: 15px;
            text-align: center;
            position: relative;
        }

        header .logo-left, header .logo-right {
            position: absolute;
            top: 15px;
        }

        header .logo-left {
            left: 20px;
        }

        header .logo-right {
            right: 20px;
        }

        header img {
            height: 60px; /* Tinggi logo */
        }

        body {
            background-color: #f7f7f7;
        }
    </style>
</head>
<body>
    <header class="text-white">
        <img src="../assets/img/pages/Logo_SMABAT_Besar.png" alt="Logo SMA Negeri 1 Bati-Bati" class="logo-left">
        <h1>(PREVIEW) Surat Suara Elektronik eSPPO (PREVIEW)</h1>
        <img src="../assets/img/pages/Logo_OSIS_SMABAT.png" alt="Logo OSIS SMA Negeri 1 Bati-Bati" class="logo-right">
    </header>

    <div class="container my-4">
        <h2 class="text-center"><?php echo $nama_pemilihan; ?></h2>
        <h5 class="text-center"><?php echo datefmt_format($dateformat_id, $tanggal_pemilihan); ?></h5>

        <div class="row">
            <?php foreach ($kandidat as $k): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="../assets/img/foto-paslon/<?php echo $k['foto_kandidat']; ?>" class="card-img-top" alt="Foto Kandidat">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $k['no_urut_kandidat']; ?></h5>
                            <p class="card-text">Calon Ketua OSIS: <?php echo $k['nama_calon_ketua']; ?></p>
                            <p class="card-text">Calon Wakil Ketua OSIS: <?php echo $k['nama_calon_wakil']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="text-center text-lg-start">
        <div class="text-center p-3">
            Aplikasi <b>Surat Suara Elektronik (SSE) eSPPO</b> &ndash; versi <b><?php echo $versi_esppo; ?></b>
            <br>
            &copy; 2024 &ndash; <?php echo date("Y") ?> Panselih OSIS SMA Negeri 1 Bati-Bati
        </div>
    </footer>
</body>
</html>
