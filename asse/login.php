<?php
session_name('eSPPO-SSE');
session_start();

$versi_esppo = '1.0.0';
require '../config/config_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_akun_pemilih = $_POST['id_akun_pemilih'];
    $password_akun_pemilih = $_POST['password_akun_pemilih'];

    // Cek apakah ID Akun Pemilih ada di database
    $stmt = $pdo->prepare("SELECT * FROM tabel_akun_pemilih WHERE id_akun_pemilih = ?");
    $stmt->execute([$id_akun_pemilih]);
    $akun = $stmt->fetch();

    if ($akun) {
        // Cek apakah pemilih sudah memberikan suara
        if ($akun['status_pemilih'] == 'SUDAH MEMILIH' || checkIfVoted($pdo, $id_akun_pemilih)) {
            $error = "Akun anda sudah digunakan untuk memberikan suara dan telah dinonaktifkan. Jika anda merasa belum memilih sebelummnya, harap melapor ke Tim Administrasi Pemilihan Panselih OSIS untuk mereset dan mengaktivasi kembali akun pemilih Anda.";
        } else {
            // Verifikasi kata sandi Akun Pemilih
            if (password_verify($password_akun_pemilih, $akun['hash_kata_sandi_pemilih'])) {
                // Jika kata sandi benar, izinkan akses ke surat suara
                $_SESSION['voter_logged_in'] = true;
                $_SESSION['id_akun_pemilih'] = $id_akun_pemilih;
                $_SESSION['nama_pemilih'] = $akun['nama_pemilih'];

                // Isi absen pemilih
                $stmt = $pdo->prepare("
                    INSERT INTO tabel_data_absensi (timestamp_absen_pemilih, id_akun_pemilih, kk_pemilih)
                    VALUES (:timestamp_absen_pemilih, :id_akun_pemilih, :kk_pemilih)
                    ");
                $stmt->execute([
                    'timestamp_absen_pemilih' => date('Y-m-d H:i:s'),
                    'id_akun_pemilih' => $id_akun_pemilih,
                    'kk_pemilih' => $akun['kk_pemilih']
                    ]);

                // Alihkan ke halaman surat suara
                header("Location: index.php");
                exit();
            } else {
                // Jika kata sandi salah
                $error = "Kata sandi Akun Pemilih salah.";
            }
        }
    } else {
        // Jika ID Pemilih salah
        $error = "ID Akun Pemilih salah.";
    }
}

function checkIfVoted($pdo, $id_akun_pemilih) {
    // Ambil semua entri di tabel_data_suara
    $stmt = $pdo->prepare("SELECT hash_id_pemilih FROM tabel_data_suara");
    $stmt->execute();
    $data_suara = $stmt->fetchAll();

    // Periksa setiap entri apakah hash cocok dengan id_akun_pemilih yang diinput
    foreach ($data_suara as $suara) {
        if (password_verify($id_akun_pemilih, $suara['hash_id_pemilih'])) {
            return true; // Pemilih sudah memberikan suara
            break;
        }
    }
    return false; // Pemilih belum memberikan suara
}
?>

<!doctype html>
<html lang="id">
<head>
    <title>Surat Suara Elektronik eSPPO &ndash; Masuk</title>
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

    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalTour">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-body p-5 text-center">
                    <main class="form-signin w-100 m-auto">
                        <form method="POST" action="login.php">
                            <img class="mb-4" src="../assets/img/pages/Logo_Panselih_OSIS_(Desain_1A).png" width="96" height="96">
                            <h1 class="h3 mb-3 fw-normal">Surat Suara Elektronik eSPPO<br>Panselih OSIS SMA Negeri 1 Bati-Bati</h1>
                            <p>
                                Masukkan ID dan kata sandi Akun Pemilih anda untuk mengakses Aplikasi SSE Pemilihan Ketua dan Wakil Ketua OSIS.
                            </p>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-floating" style="padding-bottom: 6px;">
                                <input type="text" class="form-control" id="Id_Akun_Pemilih" name="id_akun_pemilih" placeholder="S1234" required>
                                <label for="Id_Akun_Pemilih">ID Akun Pemilih</label>
                            </div>
                            <div class="form-floating" style="padding-bottom: 8px;">
                                <input type="password" class="form-control" id="Password_Akun_Pemilih" name="password_akun_pemilih" placeholder="Kata Sandi" required>
                                <label for="Password_Akun_Pemilih">Kata sandi Akun Pemilih</label>
                            </div>
                            <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
                            <p class="mt-5 mb-3 text-body-secondary">Aplikasi <b>Surat Suara Elektronik (SSE) eSPPO</b> &ndash; versi <b><?php echo $versi_esppo; ?></b></p>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
