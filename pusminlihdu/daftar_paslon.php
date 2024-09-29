<?php
// daftar_paslon.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data pasangan calon dan nama konstituensi
$query = "
    SELECT 
        k.no_urut_kandidat, 
        k.kode_id_kandidat, 
        k.nama_calon_ketua, 
        k.nama_calon_wakil, 
        k.kelas_calon_ketua, 
        k.kelas_calon_wakil, 
        k.foto_kandidat,
        ck.nama_konstituensi AS nama_konstituensi_ketua,
        cw.nama_konstituensi AS nama_konstituensi_wakil
    FROM 
        tabel_data_kandidat k
    JOIN 
        tabel_data_konstituensi ck 
    ON 
        k.kelas_calon_ketua = ck.kode_konstituensi
    JOIN 
        tabel_data_konstituensi cw 
    ON 
        k.kelas_calon_wakil = cw.kode_konstituensi
    ORDER BY 
        k.no_urut_kandidat";
$stmt = $pdo->query($query);
$data_paslon = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daftar Pasangan Calon Ketua & Wakil Ketua OSIS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Daftar Pasangan Calon</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="row">
        <?php foreach ($data_paslon as $paslon): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Paslon No. <?php echo htmlspecialchars($paslon['no_urut_kandidat']); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../assets/img/foto-paslon/<?php echo htmlspecialchars($hasil['foto_kandidat']); ?>" alt="Foto Paslon No. <?php echo htmlspecialchars($paslon['no_urut_kandidat']); ?>" class="img-fluid img-thumbnail" style="max-width: 160px;">
                        </div>
                        <hr>
                        <p><strong>Kode ID Kandidat:</strong> <?php echo htmlspecialchars($paslon['kode_id_kandidat']); ?></p>
                        <p><strong>Calon Ketua OSIS:</strong> <?php echo htmlspecialchars($paslon['nama_calon_ketua']); ?> (<?php echo htmlspecialchars($paslon['nama_konstituensi_ketua']); ?>)</p>
                        <p><strong>Calon Wakil Ketua OSIS:</strong> <?php echo htmlspecialchars($paslon['nama_calon_wakil']); ?> (<?php echo htmlspecialchars($paslon['nama_konstituensi_wakil']); ?>)</p>
                        <a href="index.php?page=edit_paslon&id=<?php echo htmlspecialchars($paslon['kode_id_kandidat']); ?>"><button type="submit" class="btn btn-warning" name="edit_paslon">Edit Data Paslon</button></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
