<?php
// edit_pemilih.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Inisialisasi variabel pesan
$message = '';
$pemilih = null;

// Proses pencarian data pemilih berdasarkan ID Pemilih
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cari_pemilih'])) {
    $id_akun_pemilih = $_POST['id_akun_pemilih'];

    // Ambil data pemilih dari database
    $query = "SELECT * FROM tabel_akun_pemilih WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id_akun_pemilih' => $id_akun_pemilih]);
    $pemilih = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pemilih) {
        $message = 'Pemilih tidak ditemukan.';
    }
}

// Proses ubah data pokok pemilih
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ubah_data_pokok'])) {
    $id_akun_pemilih = $_POST['id_akun_pemilih'];
    $no_pemilih = $_POST['no_pemilih']; // nomor_urut_pemilih sebelumnya
    $nama_pemilih = $_POST['nama_pemilih'];
    $jk_pemilih = $_POST['jk_pemilih'];
    $kk_pemilih = $_POST['kk_pemilih']; // kode_konstituensi sebelumnya

    // Query untuk update data pokok pemilih
    $query = "UPDATE tabel_akun_pemilih SET no_pemilih = :no_pemilih, nama_pemilih = :nama_pemilih, jk_pemilih = :jk_pemilih, kk_pemilih = :kk_pemilih WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([
        ':no_pemilih' => $no_pemilih,
        ':nama_pemilih' => $nama_pemilih,
        ':jk_pemilih' => $jk_pemilih,
        ':kk_pemilih' => $kk_pemilih,
        ':id_akun_pemilih' => $id_akun_pemilih,
    ])) {
        $message = 'Data pokok pemilih berhasil diperbarui!';
    } else {
        $message = 'Gagal memperbarui data pokok pemilih. Silakan coba lagi.';
    }
}

// Proses ubah data akun pemilih
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ubah_data_akun'])) {
    $id_akun_pemilih = $_POST['id_akun_pemilih'];
    $id_akun_pemilih_baru = $_POST['id_akun_pemilih_baru'];
    $kata_sandi_pemilih = password_hash($_POST['kata_sandi_pemilih'], PASSWORD_BCRYPT); // Hash kata sandi

    // Query untuk update data akun pemilih
    $query = "UPDATE tabel_akun_pemilih SET id_akun_pemilih = :id_akun_pemilih_baru, hash_kata_sandi_pemilih = :kata_sandi_pemilih WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([
        ':id_akun_pemilih_baru' => $id_akun_pemilih_baru,
        ':kata_sandi_pemilih' => $kata_sandi_pemilih,
        ':id_akun_pemilih' => $id_akun_pemilih,
    ])) {
        $message = 'Data akun pemilih berhasil diperbarui!';
        $pemilih['id_akun_pemilih'] = $id_akun_pemilih_baru;
    } else {
        $message = 'Gagal memperbarui data akun pemilih. Silakan coba lagi.';
    }
}

// Proses hapus pemilih
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus_pemilih'])) {
    $id_akun_pemilih = $_POST['id_akun_pemilih'];

    // Query untuk menghapus pemilih
    $query = "DELETE FROM tabel_akun_pemilih WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([':id_akun_pemilih' => $id_akun_pemilih])) {
        $message = 'Pemilih berhasil dihapus!';
        $pemilih = null; // Mengosongkan data pemilih setelah dihapus
    } else {
        $message = 'Gagal menghapus pemilih. Silakan coba lagi.';
    }
}

// Proses reset akun pemilih
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_akun_pemilih'])) {
    $id_akun_pemilih = $_POST['id_akun_pemilih'];

    // Cari dan hapus data suara milik pemilih di tabel_data_suara
    $query_suara = "SELECT * FROM tabel_data_suara";
    $stmt_suara = $pdo->query($query_suara);
    $suara_records = $stmt_suara->fetchAll(PDO::FETCH_ASSOC);

    foreach ($suara_records as $suara) {
        $hash_suara = password_verify($id_akun_pemilih, $suara['hash_id_pemilih']);
        if ($hash_suara = true) {
            // Hapus entri suara pemilih
            $query_hapus_suara = "DELETE FROM tabel_data_suara WHERE hash_id_pemilih = :hash_id_pemilih";
            $stmt_hapus_suara = $pdo->prepare($query_hapus_suara);
            $stmt_hapus_suara->execute([':hash_id_pemilih' => $suara['hash_id_pemilih']]);
            break;
        }
    }

    // Hapus data absensi milik pemilih di tabel_data_absensi
    $query_hapus_absensi = "DELETE FROM tabel_data_absensi WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt_hapus_absensi = $pdo->prepare($query_hapus_absensi);
    $stmt_hapus_absensi->execute([':id_akun_pemilih' => $id_akun_pemilih]);

    // Ubah status_pemilih di tabel_akun_pemilih menjadi 'BELUM MEMILIH'
    $query_reset_status = "UPDATE tabel_akun_pemilih SET status_pemilih = 'BELUM MEMILIH' WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt_reset_status = $pdo->prepare($query_reset_status);
    $stmt_reset_status->execute([':id_akun_pemilih' => $id_akun_pemilih]);

    $message = 'Akun pemilih berhasil di-reset!';
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
                <h1>Kelola Data Pemilih</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Kelola Data Pemilih</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="container-fluid">
        <!-- Tampilkan pesan -->
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Formulir pencarian pemilih berdasarkan ID -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Cari Pemilih berdasarkan ID Akun Pemilih</h3>
                    </div>
                    <form method="POST" action="index.php?page=edit_pemilih">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_akun_pemilih">ID Akun Pemilih</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="id_akun_pemilih" name="id_akun_pemilih" value="<?php echo isset($id_akun_pemilih) ? htmlspecialchars($id_akun_pemilih) : ''; ?>" autofocus required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="cari_pemilih" class="btn btn-info">Cari Pemilih</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if ($pemilih): ?>
            <div class="row">
                <!-- Kartu Formulir Ubah Data Pokok Pemilih -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ubah Data Pokok Pemilih</h3>
                        </div>
                        <form method="POST" action="index.php?page=edit_pemilih">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_pemilih">Nomor DPT Pemilih</label>
                                    <input type="number" class="form-control" id="no_pemilih" name="no_pemilih" value="<?php echo htmlspecialchars($pemilih['no_pemilih']); ?>" maxlength="4" size="4" min="1" max="9999" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pemilih">Nama Pemilih</label>
                                    <input type="text" class="form-control" id="nama_pemilih" name="nama_pemilih" value="<?php echo htmlspecialchars($pemilih['nama_pemilih']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="jk_pemilih">Jenis Kelamin</label>
                                    <select class="form-select select2bs4" id="jk_pemilih" name="jk_pemilih" required>
                                        <option value="LAKI-LAKI" <?php echo $pemilih['jk_pemilih'] == 'LAKI-LAKI' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="PEREMPUAN" <?php echo $pemilih['jk_pemilih'] == 'PEREMPUAN' ? 'selected' : ''; ?>>Perempuan</option>
                                        <option value="TIDAK DITENTUKAN" <?php echo $pemilih['jk_pemilih'] == 'TIDAK DITENTUKAN' ? 'selected' : ''; ?>>Tidak Ditentukan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kk_pemilih">Konstituensi Pemilih</label>
                                    <select class="form-select select2bs4" id="kk_pemilih" name="kk_pemilih" required>
                                        <?php foreach ($konstituensi as $k): ?>
                                            <option value="<?php echo htmlspecialchars($k['kode_konstituensi']); ?>" <?php echo $pemilih['kk_pemilih'] == $k['kode_konstituensi'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($k['nama_konstituensi']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id_akun_pemilih" value="<?php echo htmlspecialchars($pemilih['id_akun_pemilih']); ?>">
                                <button type="submit" name="ubah_data_pokok" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kartu Formulir Ubah Data Akun Pemilih -->
                <div class="col-md-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Ubah Data Akun Pemilih</h3>
                        </div>
                        <form method="POST" action="index.php?page=edit_pemilih">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_akun_pemilih_baru">ID Akun Pemilih Baru</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="id_akun_pemilih_baru" name="id_akun_pemilih_baru" value="<?php echo htmlspecialchars($pemilih['id_akun_pemilih']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kata_sandi_pemilih">Kata Sandi Baru</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="kata_sandi_pemilih" name="kata_sandi_pemilih" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id_akun_pemilih" value="<?php echo htmlspecialchars($pemilih['id_akun_pemilih']); ?>">
                                <button type="submit" name="ubah_data_akun" class="btn btn-warning">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kartu Formulir Reset Akun Pemilih -->
                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Reset Akun Pemilih</h3>
                        </div>
                        <form method="POST" action="index.php?page=edit_pemilih">
                            <div class="card-body">
                                <p>Proses ini akan menghapus semua data suara dan absensi pemilih, serta mereset status pemilih ke "BELUM MEMILIH". Anda yakin ingin mereset akun pemilih ini?</p>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id_akun_pemilih" value="<?php echo htmlspecialchars($pemilih['id_akun_pemilih']); ?>">
                                <button type="submit" name="reset_akun_pemilih" class="btn btn-danger">Reset Akun Pemilih</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kartu Formulir Hapus Pemilih -->
                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Hapus Pemilih</h3>
                        </div>
                        <form method="POST" action="index.php?page=edit_pemilih">
                            <div class="card-body">
                                <p>Proses ini akan menghapus semua data pokok dan akun pemilih. Anda yakin ingin menghapus pemilih ini?</p>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id_akun_pemilih" value="<?php echo htmlspecialchars($pemilih['id_akun_pemilih']); ?>">
                                <button type="submit" name="hapus_pemilih" class="btn btn-danger">Hapus Pemilih</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>
