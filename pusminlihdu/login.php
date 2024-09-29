<?php
session_name('eSPPO-PAPT');
session_start();
$versi_esppo = '1.0.0';
include '../config/config_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_akun_admin = $_POST['id_akun_admin'];
    $password_akun_admin = $_POST['password_akun_admin'];

    // Cek apakah ID Akun Admin ada di database
    $stmt = $pdo->prepare("SELECT * FROM tabel_akun_administrasi WHERE id_akun_admin = ?");
    $stmt->execute([$id_akun_admin]);
    $akun = $stmt->fetch();

    if ($akun) {
        // Verifikasi kata sandi admin
        if (password_verify($password_akun_admin, $akun['hash_kata_sandi_akun'])) {
            // Jika kata sandi benar, izinkan akses ke halaman admin
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['id_akun_admin'] = $id_akun_admin;
            $_SESSION['tipe_akun_admin'] = $akun['tipe_akun_admin'];

            // Perbarui timestamp login admin terakhir
            $stmt = $pdo->prepare("UPDATE tabel_akun_administrasi SET timestamp_login_terakhir = NOW() WHERE id_akun_admin = ?");
            $stmt->execute([$id_akun_admin]);

            // Alihkan ke halaman indeks
            header("Location: index.php");
            exit();
        } else {
            // Jika kata sandi salah
            $error = "Kata sandi Akun salah.";
        }
    } else {
        // Jika ID Akun Admin salah
        $error = "ID Akun salah.";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <title>Pusat Administrasi Pemilihan Terpadu eSPPO &ndash; Masuk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../vendors/adminlte-3.2.0-dist/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../vendors/adminlte-3.2.0-dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link href="../vendors/adminlte-3.2.0-dist/css/adminlte.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../vendors/adminlte-3.2.0-dist/plugins/jquery/jquery.min.js"></script>
    <script src="../vendors/adminlte-3.2.0-dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendors/adminlte-3.2.0-dist/js/adminlte.js" crossorigin="anonymous"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b>Pusat Administrasi Pemilihan Terpadu eSPPO</b><br>
                Panselih OSIS SMA Negeri 1 Bati-Bati
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    Masukkan ID dan kata sandi Akun Panitia/Pengawas anda untuk mengakses Aplikasi Pusminlihdu eSPPO.
                </p>

                <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <form action="login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="ID Akun Admin" name="id_akun_admin" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password_akun_admin" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
            <p class="mb-1 text-center">Aplikasi <b>Pusminlihdu eSPPO</b> &ndash; versi <b><?php echo $versi_esppo; ?></b></p>
            </div>
        </div>
    </div>
</body>
</html>
