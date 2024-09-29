<?php
// tambah_paslon.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data konstituensi yang bertipe 'KELAS'
$query_konstituensi = "SELECT kode_konstituensi, nama_konstituensi FROM tabel_data_konstituensi WHERE tipe_konstituensi = 'KELAS'";
$stmt_konstituensi = $pdo->query($query_konstituensi);
$data_konstituensi = $stmt_konstituensi->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $no_urut_kandidat = $_POST['no_urut_kandidat'];
    $nama_calon_ketua = $_POST['nama_calon_ketua'];
    $nama_calon_wakil = $_POST['nama_calon_wakil'];
    $kelas_calon_ketua = $_POST['kelas_calon_ketua'];
    $kelas_calon_wakil = $_POST['kelas_calon_wakil'];
    $foto_kandidat = $_FILES['foto_kandidat'];

    // Buat kode_id_kandidat menggunakan SHA256
    $data_to_hash = $no_urut_kandidat . $nama_calon_ketua . $nama_calon_wakil;
    $kode_id_kandidat = hash('sha256', $data_to_hash);

    // Ambil tanggal pemilihan dari database (tanggal_pemilihan dari tabel_data_pemilihan)
    $query = "SELECT tanggal_pemilihan FROM tabel_data_pemilihan LIMIT 1";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $tanggal_pemilihan = $result['tanggal_pemilihan'];

    // Proses upload file foto
    if ($foto_kandidat['error'] == 0) {
        $original_filename = $foto_kandidat['name'];
        $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
        $new_filename = "sse-" . $tanggal_pemilihan . "-paslon-" . $no_urut_kandidat . "." . $file_extension;
        $upload_directory = "../assets/img/foto-paslon/";
        $upload_path = $upload_directory . $new_filename;

        // Pindahkan file yang diupload ke folder ../assets/img/foto-paslon
        if (move_uploaded_file($foto_kandidat['tmp_name'], $upload_path)) {
            // Simpan data ke database
            $query = "
                INSERT INTO tabel_data_kandidat (
                    no_urut_kandidat, 
                    kode_id_kandidat, 
                    nama_calon_ketua, 
                    nama_calon_wakil, 
                    kelas_calon_ketua, 
                    kelas_calon_wakil, 
                    foto_kandidat
                ) VALUES (
                    :no_urut_kandidat, 
                    :kode_id_kandidat, 
                    :nama_calon_ketua, 
                    :nama_calon_wakil, 
                    :kelas_calon_ketua, 
                    :kelas_calon_wakil, 
                    :foto_kandidat
                )";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':no_urut_kandidat' => $no_urut_kandidat,
                ':kode_id_kandidat' => $kode_id_kandidat,
                ':nama_calon_ketua' => $nama_calon_ketua,
                ':nama_calon_wakil' => $nama_calon_wakil,
                ':kelas_calon_ketua' => $kelas_calon_ketua,
                ':kelas_calon_wakil' => $kelas_calon_wakil,
                ':foto_kandidat' => $new_filename
            ]);

            echo "Pasangan calon berhasil ditambahkan.";
        } else {
            echo "Terjadi kesalahan saat mengupload foto.";
        }
    } else {
        echo "Foto tidak valid atau tidak diupload.";
    }
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Pasangan Calon Ketua & Wakil Ketua OSIS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Tambah Pasangan Calon</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Pasangan Calon</h3>
        </div>
        <div class="card-body">
            <form action="index.php?page=tambah_paslon" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="no_urut_kandidat">Nomor Urut Pasangan Calon</label>
                    <input type="number" name="no_urut_kandidat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nama_calon_ketua">Nama Calon Ketua OSIS</label>
                    <input type="text" name="nama_calon_ketua" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nama_calon_wakil">Nama Calon Wakil Ketua OSIS</label>
                    <input type="text" name="nama_calon_wakil" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kelas_calon_ketua">Kelas Calon Ketua OSIS</label>
                    <select name="kelas_calon_ketua" class="form-select select2bs4" required>
                        <option value="" disabled selected>Pilih Kelas Calon Ketua</option>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <option value="<?php echo $konstituensi['kode_konstituensi']; ?>">
                                <?php echo $konstituensi['nama_konstituensi']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelas_calon_wakil">Kelas Calon Wakil Ketua OSIS</label>
                    <select name="kelas_calon_wakil" class="form-select select2bs4" required>
                        <option value="" disabled selected>Pilih Kelas Calon Wakil Ketua</option>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <option value="<?php echo $konstituensi['kode_konstituensi']; ?>">
                                <?php echo $konstituensi['nama_konstituensi']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="foto_kandidat">Foto Pasangan Calon (JPG/JPEG, PNG, GIF)</label>
                    <div class="custom-file">
                        <input type="file" name="foto_kandidat" id="foto_kandidat" accept="image/gif,image/jpeg,image/png,image/webp" class="custom-file-input" required>
                        <label class="custom-file-label" for="foto_kandidat">Pilih salah satu Berkas Foto</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Pasangan Calon</button>
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