<?php
// rincian_suara.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Inisialisasi variabel konstituensi yang dipilih
$selected_konstituensi = '';

// Ambil daftar konstituensi
$query_konstituensi = "SELECT kode_konstituensi, nama_konstituensi FROM tabel_data_konstituensi ORDER BY kode_konstituensi";
$stmt_konstituensi = $pdo->query($query_konstituensi);
$data_konstituensi = $stmt_konstituensi->fetchAll(PDO::FETCH_ASSOC);

// Jika konstituensi dipilih melalui form
if (isset($_POST['konstituensi'])) {
    $selected_konstituensi = $_POST['konstituensi'];

    // Query untuk mendapatkan rincian perolehan suara di konstituensi yang dipilih
    $query = "
        SELECT 
            k.no_urut_kandidat,
            k.kode_id_kandidat,
            k.nama_calon_ketua,
            k.nama_calon_wakil,
            k.foto_kandidat,
            COUNT(s.no_kandidat) AS jumlah_suara
        FROM 
            tabel_data_kandidat k
        LEFT JOIN 
            tabel_data_suara s 
        ON 
            k.no_urut_kandidat = s.no_kandidat
        WHERE 
            s.kk_pemilih = :selected_konstituensi
        GROUP BY 
            k.no_urut_kandidat, k.kode_id_kandidat, k.nama_calon_ketua, k.nama_calon_wakil, k.foto_kandidat
        ORDER BY 
            k.no_urut_kandidat";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['selected_konstituensi' => $selected_konstituensi]);
    $data_hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Jika belum ada konstituensi yang dipilih, data suara tidak akan ditampilkan
    $data_hasil = [];
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Rincian Perolehan Suara Berdasarkan Konstituensi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Rincian Perolehan Suara</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Pilih Konstituensi untuk ditampilkan</h3>
                </div>
                <form method="POST" action="index.php?page=rincian_suara">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="konstituensi">Konstituensi:</label>
                            <select name="konstituensi" id="konstituensi" class="form-select select2bs4">
                                <option value=""> Pilih Konstituensi </option>
                                <?php foreach ($data_konstituensi as $konstituensi): ?>
                                    <option value="<?php echo htmlspecialchars($konstituensi['kode_konstituensi']); ?>" 
                                    <?php echo $selected_konstituensi === $konstituensi['kode_konstituensi'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($konstituensi['nama_konstituensi']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-block">Tampilkan Rincian</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Jika ada hasil suara, tampilkan data -->
        <div class="col-md-8">
            <div class="row">
                <?php if (!empty($data_hasil)): ?>
                    <?php foreach ($data_hasil as $hasil): ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Paslon No. <?php echo htmlspecialchars($hasil['no_urut_kandidat']); ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img src="../assets/img/foto-paslon/<?php echo htmlspecialchars($hasil['foto_kandidat']); ?>" alt="Foto Paslon No. <?php echo htmlspecialchars($hasil['no_urut_kandidat']); ?>" class="img-fluid img-thumbnail" style="max-width: 160px;">
                                    </div>
                                    <hr>
                                    <p><strong>Kode ID Kandidat:</strong> <?php echo htmlspecialchars($hasil['kode_id_kandidat']); ?></p>
                                    <p><strong>Calon Ketua OSIS:</strong> <?php echo htmlspecialchars($hasil['nama_calon_ketua']); ?></p>
                                    <p><strong>Calon Wakil Ketua OSIS:</strong> <?php echo htmlspecialchars($hasil['nama_calon_wakil']); ?></p>
                                    <p><strong>Jumlah Suara:</strong> <?php echo htmlspecialchars($hasil['jumlah_suara']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($selected_konstituensi): ?>
                    <div class="col-md-12">
                        <div class="alert alert-warning" role="alert">
                            Tidak ada data suara untuk konstituensi yang dipilih.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
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