<?php
// edit_paslon.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data konstituensi yang bertipe 'KELAS'
$query_konstituensi = "SELECT kode_konstituensi, nama_konstituensi FROM tabel_data_konstituensi WHERE tipe_konstituensi = 'KELAS'";
$stmt_konstituensi = $pdo->query($query_konstituensi);
$data_konstituensi = $stmt_konstituensi->fetchAll(PDO::FETCH_ASSOC);

// Ambil data paslon berdasarkan ID paslon dari URL
$kode_id_kandidat = $_GET['id'];
$query_paslon = "SELECT * FROM tabel_data_kandidat WHERE kode_id_kandidat = :kode_id_kandidat";
$stmt_paslon = $pdo->prepare($query_paslon);
$stmt_paslon->execute(['kode_id_kandidat' => $kode_id_kandidat]);
$data_paslon = $stmt_paslon->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Ambil data dari form
        $no_urut_kandidat = $_POST['no_urut_kandidat'];
        $nama_calon_ketua = $_POST['nama_calon_ketua'];
        $nama_calon_wakil = $_POST['nama_calon_wakil'];
        $kelas_calon_ketua = $_POST['kelas_calon_ketua'];
        $kelas_calon_wakil = $_POST['kelas_calon_wakil'];
        $foto_kandidat = $_FILES['foto_kandidat'];

        // Update data paslon
        $query_update = "UPDATE tabel_data_kandidat 
                        SET no_urut_kandidat = :no_urut_kandidat, 
                            nama_calon_ketua = :nama_calon_ketua, 
                            nama_calon_wakil = :nama_calon_wakil, 
                            kelas_calon_ketua = :kelas_calon_ketua, 
                            kelas_calon_wakil = :kelas_calon_wakil";
        
        // Proses upload file foto baru jika ada
        if ($foto_kandidat['error'] == 0) {
            $original_filename = $foto_kandidat['name'];
            $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
            $new_filename = "sse-" . date('Y-m-d') . "-paslon-" . $no_urut_kandidat . "." . $file_extension;
            $upload_directory = "../assets/img/foto-paslon/";
            $upload_path = $upload_directory . $new_filename;

            if (move_uploaded_file($foto_kandidat['tmp_name'], $upload_path)) {
                $query_update .= ", foto_kandidat = :foto_kandidat";
                $params[':foto_kandidat'] = $new_filename;
            } else {
                echo "Terjadi kesalahan saat mengupload foto.";
            }
        }

        $query_update .= " WHERE kode_id_kandidat = :kode_id_kandidat";
        $params = [
            ':no_urut_kandidat' => $no_urut_kandidat,
            ':nama_calon_ketua' => $nama_calon_ketua,
            ':nama_calon_wakil' => $nama_calon_wakil,
            ':kelas_calon_ketua' => $kelas_calon_ketua,
            ':kelas_calon_wakil' => $kelas_calon_wakil,
            ':kode_id_kandidat' => $kode_id_kandidat
        ];

        $stmt_update = $pdo->prepare($query_update);
        $stmt_update->execute($params);

        echo "Pasangan calon berhasil diperbarui.";
    } elseif (isset($_POST['delete'])) {
        // Hapus data paslon
        $query_delete = "DELETE FROM tabel_data_kandidat WHERE kode_id_kandidat = :kode_id_kandidat";
        $stmt_delete = $pdo->prepare($query_delete);
        $stmt_delete->execute(['kode_id_kandidat' => $kode_id_kandidat]);

        echo "Pasangan calon berhasil dihapus.";
    }
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Pasangan Calon Ketua & Wakil Ketua OSIS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Edit Pasangan Calon</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data Pasangan Calon</h3>
        </div>
        <div class="card-body">
            <form action="index.php?page=edit_paslon&id=<?php echo $kode_id_kandidat; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="no_urut_kandidat">Nomor Urut Pasangan Calon</label>
                    <input type="number" name="no_urut_kandidat" class="form-control" value="<?php echo $data_paslon['no_urut_kandidat']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_calon_ketua">Nama Calon Ketua OSIS</label>
                    <input type="text" name="nama_calon_ketua" class="form-control" value="<?php echo $data_paslon['nama_calon_ketua']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_calon_wakil">Nama Calon Wakil Ketua OSIS</label>
                    <input type="text" name="nama_calon_wakil" class="form-control" value="<?php echo $data_paslon['nama_calon_wakil']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="kelas_calon_ketua">Kelas Calon Ketua OSIS</label>
                    <select name="kelas_calon_ketua" class="form-select select2bs4" required>
                        <option value="" disabled>Pilih Kelas</option>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <option value="<?php echo $konstituensi['kode_konstituensi']; ?>" <?php if ($data_paslon['kelas_calon_ketua'] === $konstituensi['kode_konstituensi']) echo 'selected'; ?>>
                                <?php echo $konstituensi['nama_konstituensi']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelas_calon_wakil">Kelas Calon Wakil Ketua OSIS</label>
                    <select name="kelas_calon_wakil" class="form-select select2bs4" required>
                        <option value="" disabled>Pilih Kelas</option>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <option value="<?php echo $konstituensi['kode_konstituensi']; ?>" <?php if ($data_paslon['kelas_calon_wakil'] === $konstituensi['kode_konstituensi']) echo 'selected'; ?>>
                                <?php echo $konstituensi['nama_konstituensi']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="foto_kandidat">Foto Pasangan Calon</label>
                    <div class="custom-file">
                        <input type="file" name="foto_kandidat" id="foto_kandidat" accept="image/gif,image/jpeg,image/png,image/webp" class="custom-file-input" required>
                        <label class="custom-file-label" for="foto_kandidat">Pilih salah satu Berkas Foto</label>
                    </div>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Pasangan Calon</button>
            </form>
        </div>
    </div>

    <div class="card card-danger mt-3">
        <div class="card-header">
            <h3 class="card-title">Hapus Pasangan Calon</h3>
        </div>
        <div class="card-body">
            <form action="index.php?page=edit_paslon&id=<?php echo $kode_id_kandidat; ?>" method="post">
                <p>Apakah Anda yakin ingin menghapus pasangan calon ini?</p>
                <button type="submit" name="delete" class="btn btn-danger">Hapus Pasangan Calon</button>
            </form>
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