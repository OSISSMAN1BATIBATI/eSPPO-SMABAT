<?php
// tambah_pemilih.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Inisialisasi variabel pesan
$message = '';

// Fungsi untuk mendapatkan nomor pemilih terbaru untuk pemilih reguler
function getNextPemilihNumber($pdo) {
    // Cari nomor pemilih terakhir yang bukan uji coba (di luar rentang 99XX)
    $query = "SELECT MAX(no_pemilih) AS max_no_pemilih FROM tabel_akun_pemilih WHERE no_pemilih < 9900";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Jika tidak ada pemilih, nomor dimulai dari 1
    return ($result['max_no_pemilih'] !== null) ? $result['max_no_pemilih'] + 1 : 1;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_pemilih'])) {
    // Ambil data dari form
    $nama_pemilih = $_POST['nama_pemilih'];
    $jk_pemilih = $_POST['jk_pemilih'];
    $kk_pemilih = $_POST['kk_pemilih'];
    $id_akun_pemilih = $_POST['id_akun_pemilih'];
    $hash_kata_sandi_pemilih = password_hash($_POST['kata_sandi_pemilih'], PASSWORD_BCRYPT); // Hash kata sandi
    $status_pemilih = 'BELUM MEMILIH'; // Status default

    // Ambil nomor pemilih selanjutnya
    $no_pemilih = getNextPemilihNumber($pdo);

    // Query untuk menambah data pemilih
    $query = "INSERT INTO tabel_akun_pemilih (no_pemilih, nama_pemilih, jk_pemilih, kk_pemilih, id_akun_pemilih, hash_kata_sandi_pemilih, status_pemilih) 
              VALUES (:no_pemilih, :nama_pemilih, :jk_pemilih, :kk_pemilih, :id_akun_pemilih, :hash_kata_sandi_pemilih, :status_pemilih)";
    $stmt = $pdo->prepare($query);

    // Eksekusi query dengan data dari form
    if ($stmt->execute([
        ':no_pemilih' => $no_pemilih,
        ':nama_pemilih' => $nama_pemilih,
        ':jk_pemilih' => $jk_pemilih,
        ':kk_pemilih' => $kk_pemilih,
        ':id_akun_pemilih' => $id_akun_pemilih,
        ':hash_kata_sandi_pemilih' => $hash_kata_sandi_pemilih,
        ':status_pemilih' => $status_pemilih,
    ])) {
        $success_message = 'Data pemilih berhasil ditambahkan dengan nomor DPT: ' . $no_pemilih;
    } else {
        $error_message = 'Gagal menambahkan data pemilih. Silakan coba lagi.';
    }
}

// Ambil daftar konstituensi dari database untuk dropdown
$query_konstituensi = "SELECT kode_konstituensi, nama_konstituensi FROM tabel_data_konstituensi";
$stmt_konstituensi = $pdo->query($query_konstituensi);
$konstituensi = $stmt_konstituensi->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Data Pemilih</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Tambah Data Pemilih</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="container-fluid">

        <!-- Pesan Sukses atau Error -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <?php
        // Pesan sukses atau error dari tambah_massal_pemilih.php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo '<div class="alert alert-success" role="alert">
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                Data pemilih berhasil diimpor!
                </div>';
        } elseif ($_GET['status'] == 'error') {
            echo '<div class="alert alert-danger" role="alert">
                <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                Terjadi kesalahan saat mengimpor data pemilih.
                </div>';
            }
        }
        ?>

        <div class="row">
            <!-- Kartu Formulir Tambah Pemilih secara Manual -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pemilih Individual</h3>
                    </div>
                    <form method="POST" action="index.php?page=tambah_pemilih">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_pemilih">Nama Pemilih</label>
                                <input type="text" class="form-control" id="nama_pemilih" name="nama_pemilih" required>
                            </div>
                            <div class="form-group">
                                <label for="jk_pemilih">Jenis Kelamin</label>
                                <select class="form-select select2bs4" id="jk_pemilih" name="jk_pemilih" required>
                                    <option value="LAKI-LAKI">Laki-laki</option>
                                    <option value="PEREMPUAN">Perempuan</option>
                                    <option value="TIDAK DITENTUKAN">Tidak Ditentukan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kk_pemilih">Konstituensi Pemilih</label>
                                <select class="form-select select2bs4" id="kk_pemilih" name="kk_pemilih" required>
                                    <?php foreach ($konstituensi as $k): ?>
                                        <option value="<?php echo htmlspecialchars($k['kode_konstituensi']); ?>">
                                            <?php echo htmlspecialchars($k['nama_konstituensi']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_akun_pemilih">ID Akun Pemilih</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="id_akun_pemilih" name="id_akun_pemilih" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kata_sandi_pemilih">Kata Sandi Akun Pemilih</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="kata_sandi_pemilih" name="kata_sandi_pemilih" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="tambah_pemilih" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah Pemilih</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kartu Formulir Tambah Pemilih secara Massal -->
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pemilih Massal</h3>
                    </div>
                    <div class="card-body">
                        <h5>Perhatian!</h5>
                        <p>Sebelum anda mengunggah berkas data pemilih, pastikan tipe berkas didukung dan format lembar dan data sesuai. Anda dapat mengunduh berkas templat data pemilih di bawah ini.</p>
                        <a href="../assets/spreadsheet/Templat_Format_Data_Akun_DPT_Pusminlihdu_eSPPO.xltx"><button name="download_template" class="btn btn-info"><i class="fas fa-file-download"></i> Unduh Templat Berkas Data Pemilih</button></a>
                        <hr>
                        <form action="tambah_massal_pemilih.php" method="post" enctype="multipart/form-data" id="importXLS">
                            <div class="form-group">
                                <label for="file">Unggah Berkas Data Pemilih (Spreadsheet tipe CSV, XLS, XLSX, XLSM):</label>
                                <div class="custom-file">
                                    <input type="file" name="file" id="file" accept="text/x-comma-separated-values,text/comma-separated-values,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel.sheet.macroEnabled.12,text/csv" class="custom-file-input" required>
                                    <label class="custom-file-label" for="file">Pilih salah satu Berkas Spreadsheet</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" form="importXLS" name="import" class="btn btn-primary"><i class="fas fa-file-import"></i> Impor Data Pemilih</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        //
        bsCustomFileInput.init();
        // Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>