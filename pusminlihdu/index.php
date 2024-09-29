<?php
session_name('eSPPO-PAPT');
session_start();

$versi_esppo = '1.0.0';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Mendapatkan halaman dari URL
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Fungsi untuk memuat halaman
function loadPage($page) {
    // Daftar halaman yang valid
    $valid_pages = ['absen_pemilih',
                    'cetak_daftar_calon',
                    'cetak_dpt',
                    'cetak_sse_ljk',
                    'daftar_paslon',
                    'daftar_pemilih',
                    'dashboard',
                    'data_konstituensi',
                    'data_pemilihan',
                    'data_sekolah',
                    'edit_konstituensi',
                    'edit_paslon',
                    'edit_pemilih',
                    'hasil_pemilihan',
                    'laporan_absensi',
                    'laporan_pemilihan',
                    'preview-sse-index',
                    'rincian_suara',
                    'tambah_massal_pemilih',
                    'tambah_paslon',
                    'tambah_pemilih'];

    // Jika halaman valid, sertakan halaman yang dimaksud
    if (in_array($page, $valid_pages)) {
        include "$page.php";
    } else {
        // Jika halaman tidak valid, tampilkan pesan error atau arahkan ke halaman 404
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found",true,404);
        include "404.php";
    }
}

// Parameter tambahan setelah '&' akan diteruskan otomatis ke halaman yang di-include,
// karena halaman tersebut akan tetap dapat mengakses semua parameter yang dikirim melalui URL,
// misalnya $_GET['id'], $_GET['action'], dll.
?>

<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../vendors/adminlte-3.2.0-dist/plugins/fontawesome-free/css/all.css" rel="stylesheet" crossorigin="anonymous">
        <link href="../vendors/adminlte-3.2.0-dist/plugins/datatables-bs4/css/dataTables.bootstrap4.css" rel="stylesheet" crossorigin="anonymous">
        <link href="../vendors/adminlte-3.2.0-dist/plugins/select2/css/select2.css" rel="stylesheet" crossorigin="anonymous">
        <link href="../vendors/adminlte-3.2.0-dist/plugins/select2-bootstrap4-theme/select2-bootstrap4.css" rel="stylesheet" crossorigin="anonymous">
        <link href="../vendors/adminlte-3.2.0-dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css" rel="stylesheet" crossorigin="anonymous">
        <link href="../vendors/adminlte-3.2.0-dist/css/adminlte.css" rel="stylesheet" crossorigin="anonymous">

        <script src="../vendors/adminlte-3.2.0-dist/plugins/jquery/jquery.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/bootstrap/js/bootstrap.bundle.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/datatables/jquery.dataTables.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/moment/moment-with-locales.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/select2/js/select2.full.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
        <script src="../vendors/adminlte-3.2.0-dist/js/adminlte.js" crossorigin="anonymous"></script>
        <title>Pusat Administrasi Pemilihan Terpadu eSPPO</title>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Header -->
            <?php include 'header.php'; ?>

            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Halaman Kerja Utama -->
            <div class="content-wrapper">
                <?php loadPage($page); ?>
            </div>

            <!-- Footer -->
            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>
