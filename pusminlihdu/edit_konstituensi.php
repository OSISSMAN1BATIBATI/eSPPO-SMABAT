<?php
// edit_konstituensi.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Pesan notifikasi
$success_message = '';
$error_message = '';

// Proses penambahan data
if (isset($_POST['add_konstituensi'])) {
    $kode_konstituensi = $_POST['kode_konstituensi'];
    $nama_konstituensi = $_POST['nama_konstituensi'];
    $tipe_konstituensi = $_POST['tipe_konstituensi'];

    $query = "INSERT INTO tabel_data_konstituensi (kode_konstituensi, nama_konstituensi, tipe_konstituensi) VALUES (:kode_konstituensi, :nama_konstituensi, :tipe_konstituensi)";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':kode_konstituensi', $kode_konstituensi);
    $stmt->bindParam(':nama_konstituensi', $nama_konstituensi);
    $stmt->bindParam(':tipe_konstituensi', $tipe_konstituensi);

    if ($stmt->execute()) {
        $success_message = "Data konstituensi berhasil ditambahkan!";
    } else {
        $error_message = "Terjadi kesalahan saat menambahkan data.";
    }
}

// Proses pembaruan data
if (isset($_POST['update_konstituensi'])) {
    $kode_konstituensi = $_POST['kode_konstituensi_update'];
    $nama_konstituensi = $_POST['nama_konstituensi_update'];
    $tipe_konstituensi = $_POST['tipe_konstituensi_update'];

    $query = "UPDATE tabel_data_konstituensi SET nama_konstituensi = :nama_konstituensi, tipe_konstituensi = :tipe_konstituensi WHERE kode_konstituensi = :kode_konstituensi";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':kode_konstituensi', $kode_konstituensi);
    $stmt->bindParam(':nama_konstituensi', $nama_konstituensi);
    $stmt->bindParam(':tipe_konstituensi', $tipe_konstituensi);

    if ($stmt->execute()) {
        $success_message = "Data konstituensi berhasil diperbarui!";
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui data.";
    }
}

// Proses penghapusan data
if (isset($_POST['delete_konstituensi'])) {
    $kode_konstituensi = $_POST['kode_konstituensi_delete'];

    $query = "DELETE FROM tabel_data_konstituensi WHERE kode_konstituensi = :kode_konstituensi";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':kode_konstituensi', $kode_konstituensi);

    if ($stmt->execute()) {
        $success_message = "Data konstituensi berhasil dihapus!";
    } else {
        $error_message = "Terjadi kesalahan saat menghapus data.";
    }
}

// Ambil data konstituensi untuk dropdown pembaruan dan penghapusan
$query = "SELECT kode_konstituensi, nama_konstituensi, tipe_konstituensi FROM tabel_data_konstituensi ORDER BY kode_konstituensi";
$stmt = $pdo->query($query);
$data_konstituensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kelola Data Konstituensi Pemilih</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Kelola Data Konstituensi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <!-- Pesan Sukses atau Error -->
    <?php if ($success_message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Formulir Penambahan Data Konstituensi -->
    <div class="card mb-4">
        <div class="card-header">Tambah Data Konstituensi</div>
        <div class="card-body">
            <form action="index.php?page=edit_konstituensi" method="post">
                <div class="mb-3">
                    <label for="kode_konstituensi" class="form-label">Kode Konstituensi</label>
                    <input type="number" class="form-control" id="kode_konstituensi" name="kode_konstituensi" required>
                </div>
                <div class="mb-3">
                    <label for="nama_konstituensi" class="form-label">Nama Konstituensi</label>
                    <input type="text" class="form-control" id="nama_konstituensi" name="nama_konstituensi" required>
                </div>
                <div class="mb-3">
                    <label for="tipe_konstituensi" class="form-label">Tipe Konstituensi</label>
                    <select class="form-select select2bs4" id="tipe_konstituensi" name="tipe_konstituensi" required>
                        <option value="KELAS">KELAS</option>
                        <option value="KEPEGAWAIAN">KEPEGAWAIAN</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="add_konstituensi">Tambah</button>
            </form>
        </div>
    </div>

    <!-- Formulir Perubahan Data Konstituensi -->
    <div class="card card-warning mb-4">
        <div class="card-header">Ubah Data Konstituensi</div>
        <div class="card-body">
            <form action="index.php?page=edit_konstituensi" method="post">
                <div class="mb-3">
                    <label for="kode_konstituensi_update" class="form-label">Kode Konstituensi</label>
                    <select class="form-select select2bs4" id="kode_konstituensi_update" name="kode_konstituensi_update" required>
                        <option value="" selected disabled>Pilih Kode Konstituensi</option>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <option value="<?php echo htmlspecialchars($konstituensi['kode_konstituensi']); ?>">
                                <?php echo htmlspecialchars($konstituensi['kode_konstituensi'] . ' - ' . $konstituensi['nama_konstituensi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama_konstituensi_update" class="form-label">Nama Konstituensi Baru</label>
                    <input type="text" class="form-control" id="nama_konstituensi_update" name="nama_konstituensi_update" required>
                </div>
                <div class="mb-3">
                    <label for="tipe_konstituensi_update" class="form-label">Tipe Konstituensi Baru</label>
                    <select class="form-select select2bs4" id="tipe_konstituensi_update" name="tipe_konstituensi_update" required>
                        <option value="KELAS">KELAS</option>
                        <option value="KEPEGAWAIAN">KEPEGAWAIAN</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning" name="update_konstituensi">Ubah</button>
            </form>
        </div>
    </div>

    <!-- Formulir Penghapusan Data Konstituensi -->
    <div class="card card-danger mb-4">
        <div class="card-header">Hapus Data Konstituensi</div>
        <div class="card-body">
            <form action="index.php?page=edit_konstituensi" method="post">
                <div class="mb-3">
                    <label for="kode_konstituensi_delete" class="form-label">Kode Konstituensi</label>
                    <select class="form-select select2bs4" id="kode_konstituensi_delete" name="kode_konstituensi_delete" required>
                        <option value="" selected disabled>Pilih Kode Konstituensi</option>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <option value="<?php echo htmlspecialchars($konstituensi['kode_konstituensi']); ?>">
                            <?php echo htmlspecialchars($konstituensi['kode_konstituensi'] . ' - ' . $konstituensi['nama_konstituensi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger" name="delete_konstituensi">Hapus</button>
            </form>
        </div>
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
