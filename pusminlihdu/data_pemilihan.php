<?php
// data_pemilihan.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data pemilihan dari database
$query = "SELECT * FROM tabel_data_pemilihan LIMIT 1";
$stmt = $pdo->query($query);
$data_pemilihan = $stmt->fetch(PDO::FETCH_ASSOC);

// Proses pembaruan data jika formulir dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemilihan = $_POST['nama_pemilihan'];
    $tanggal_pemilihan = $_POST['tanggal_pemilihan'];
    $jumlah_tps = $_POST['jumlah_tps'];
    $jumlah_passe = $_POST['jumlah_passe'];
    $status_pemilihan = $_POST['status_pemilihan'];

    $updateQuery = "UPDATE tabel_data_pemilihan SET
        nama_pemilihan = :nama_pemilihan,
        tanggal_pemilihan = :tanggal_pemilihan,
        jumlah_tps = :jumlah_tps,
        jumlah_passe = :jumlah_passe,
        status_pemilihan = :status_pemilihan";

    $stmt = $pdo->prepare($updateQuery);

    // Bind parameter
    $stmt->bindParam(':nama_pemilihan', $nama_pemilihan);
    $stmt->bindParam(':tanggal_pemilihan', $tanggal_pemilihan);
    $stmt->bindParam(':jumlah_tps', $jumlah_tps);
    $stmt->bindParam(':jumlah_passe', $jumlah_passe);
    $stmt->bindParam(':status_pemilihan', $status_pemilihan);

    if ($stmt->execute()) {
        $success_message = "Data kegiatan pemilihan berhasil diperbarui.";
        // Refresh data setelah update
        $stmt = $pdo->query("SELECT * FROM tabel_data_pemilihan LIMIT 1");
        $data_pemilihan = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui data.";
    }
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Kegiatan Pemilihan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Data Kegiatan Pemilihan</li>
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

                    <!-- Formulir Data Pemilihan -->
                    <form action="index.php?page=data_pemilihan" method="post">
                        <div class="card-body">
                            <!-- Nama Pemilihan -->
                            <div class="form-group">
                                <label for="nama_pemilihan" class="form-label">Nama Pemilihan</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-vote-yea"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nama_pemilihan" name="nama_pemilihan" value="<?php echo htmlspecialchars($data_pemilihan['nama_pemilihan']); ?>" required>
                                </div>
                            </div>

                            <!-- Tanggal Pemilihan dengan DateTimePicker -->
                            <div class="form-group">
                                <label for="tanggal_pemilihan" class="form-label">Tanggal Pemilihan</label>
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="tanggal_pemilihan" name="tanggal_pemilihan" value="<?php echo htmlspecialchars($data_pemilihan['tanggal_pemilihan']); ?>" data-target="#datetimepicker4" required/>
                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah TPS -->
                            <div class="form-group">
                                <label for="jumlah_tps" class="form-label">Jumlah TPS</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="jumlah_tps" name="jumlah_tps" value="<?php echo htmlspecialchars($data_pemilihan['jumlah_tps']); ?>" required>
                                </div>
                            </div>

                            <!-- Jumlah PASSE -->
                            <div class="form-group">
                                <label for="jumlah_passe" class="form-label">Jumlah <abbr title="Perangkat Akses Surat Suara Elektronik" class="initialism">PASSE</abbr></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-desktop"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="jumlah_passe" name="jumlah_passe" value="<?php echo htmlspecialchars($data_pemilihan['jumlah_passe']); ?>" required>
                                </div>
                            </div>

                            <!-- Status Pemilihan -->
                            <div class="form-group">
                                <label for="status_pemilihan" class="form-label">Status Pemilihan</label>
                                <div class="input-group mb-3">
                                    <select class="form-control select2bs4" id="status_pemilihan" name="status_pemilihan" required>
                                        <option value="BELUM DILAKSANAKAN" <?php echo $data_pemilihan['status_pemilihan'] == 'BELUM DILAKSANAKAN' ? 'selected' : ''; ?>>BELUM DILAKSANAKAN</option>
                                        <option value="SEDANG DILAKSANAKAN" <?php echo $data_pemilihan['status_pemilihan'] == 'SEDANG DILAKSANAKAN' ? 'selected' : ''; ?>>SEDANG DILAKSANAKAN</option>
                                        <option value="SELESAI DILAKSANAKAN" <?php echo $data_pemilihan['status_pemilihan'] == 'SELESAI DILAKSANAKAN' ? 'selected' : ''; ?>>SELESAI DILAKSANAKAN</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        // DateTimePicker
        $('#datetimepicker4').datetimepicker({
            locale: 'id',
            format: 'YYYY-MM-DD'  // Format tanggal (sesuaikan dengan kebutuhan)
        });

        // Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>
