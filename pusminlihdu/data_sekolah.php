<?php
// data_sekolah.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data sekolah dari database
$query = "SELECT * FROM tabel_data_sekolah LIMIT 1";
$stmt = $pdo->query($query);
$data_sekolah = $stmt->fetch(PDO::FETCH_ASSOC);

// Proses pembaruan data jika formulir dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_sekolah = $_POST['nama_sekolah'];
    $npsn_sekolah = $_POST['npsn_sekolah'];
    $alamat_sekolah = $_POST['alamat_sekolah'];
    $nama_kepala_sekolah = $_POST['nama_kepala_sekolah'];
    $nip_kepala_sekolah = $_POST['nip_kepala_sekolah'];
    $telepon_sekolah = $_POST['telepon_sekolah'];
    $email_sekolah = $_POST['email_sekolah'];

    $updateQuery = "UPDATE tabel_data_sekolah SET
        nama_sekolah = :nama_sekolah,
        npsn_sekolah = :npsn_sekolah,
        alamat_sekolah = :alamat_sekolah,
        nama_kepala_sekolah = :nama_kepala_sekolah,
        nip_kepala_sekolah = :nip_kepala_sekolah,
        telepon_sekolah = :telepon_sekolah,
        email_sekolah = :email_sekolah";

    $stmt = $pdo->prepare($updateQuery);

    // Bind parameter
    $stmt->bindParam(':nama_sekolah', $nama_sekolah);
    $stmt->bindParam(':npsn_sekolah', $npsn_sekolah);
    $stmt->bindParam(':alamat_sekolah', $alamat_sekolah);
    $stmt->bindParam(':nama_kepala_sekolah', $nama_kepala_sekolah);
    $stmt->bindParam(':nip_kepala_sekolah', $nip_kepala_sekolah);
    $stmt->bindParam(':telepon_sekolah', $telepon_sekolah);
    $stmt->bindParam(':email_sekolah', $email_sekolah);

    if ($stmt->execute()) {
        $success_message = "Data sekolah berhasil diperbarui!";
        // Refresh data setelah update
        $stmt = $pdo->query("SELECT * FROM tabel_data_sekolah LIMIT 1");
        $data_sekolah = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui data.";
    }
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Sekolah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Data Sekolah</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">

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

                    <!-- Formulir Data Sekolah -->
                    <form action="index.php?page=data_sekolah" method="post">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="<?php echo htmlspecialchars($data_sekolah['nama_sekolah']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="npsn_sekolah"><abbr title="Nomor Pokok Sekolah Nasional" class="initialism">NPSN</abbr></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="npsn_sekolah" name="npsn_sekolah" value="<?php echo htmlspecialchars($data_sekolah['npsn_sekolah']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat_sekolah">Alamat Sekolah</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah" rows="2" required><?php echo htmlspecialchars($data_sekolah['alamat_sekolah']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama_kepala_sekolah">Nama Kepala Sekolah</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nama_kepala_sekolah" name="nama_kepala_sekolah" value="<?php echo htmlspecialchars($data_sekolah['nama_kepala_sekolah']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nip_kepala_sekolah"><abbr title="Nomor Induk Pegawai" class="initialism">NIP</abbr> Kepala Sekolah</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="<?php echo htmlspecialchars($data_sekolah['nip_kepala_sekolah']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telepon_sekolah">Nomor Telepon Sekolah</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="telepon_sekolah" name="telepon_sekolah" value="<?php echo htmlspecialchars($data_sekolah['telepon_sekolah']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email_sekolah">Alamat Email Sekolah</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email_sekolah" name="email_sekolah" value="<?php echo htmlspecialchars($data_sekolah['email_sekolah']); ?>" required>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
