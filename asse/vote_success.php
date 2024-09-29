<?php
session_name('eSPPO-SSE');
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['voter_logged_in']) || $_SESSION['voter_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="id">
<head>
    <title>Surat Suara Elektronik eSPPO &ndash; Memilih Berhasil!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../vendors/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../vendors/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <style>
        body {
            background-image: url('../assets/img/pages/Foto_Lapangan_Upacara_Edit.jpg');
            background-attachment: fixed;
            background-size: cover;
            opacity: 0.9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .modal-sheet {
            background-color: rgba(255, 255, 255, 0.85);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004b9c;
        }
    </style>

    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSuccess">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-body p-5 text-center">
                    <img class="mb-4" src="../assets/img/pages/Logo_Panselih_OSIS_(Desain_1A).png" width="80" height="80">
                    <h1 class="h3 mb-3 fw-normal">Data Suara Anda Telah Diterima!</h1>
                    <p>Terima kasih atas partisipasi Anda dalam Pemilihan Ketua dan Wakil Ketua OSIS tahun ini. Suara Anda telah berhasil direkam dan disimpan oleh Aplikasi SSE eSPPO. Harap keluar dari aplikasi dengan menekan tombol Selesai di bawah ini.</p>
                    <button class="btn btn-primary w-100 py-2" onclick="window.location.href='execute_logout.php'">Selesai</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
