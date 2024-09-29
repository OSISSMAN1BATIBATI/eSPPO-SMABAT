<?php
// hasil_pemilihan.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data perolehan suara setiap pasangan calon
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
    GROUP BY 
        k.no_urut_kandidat, k.kode_id_kandidat, k.nama_calon_ketua, k.nama_calon_wakil, k.foto_kandidat
    ORDER BY 
        k.no_urut_kandidat";
$stmt = $pdo->query($query);
$data_hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query untuk menghitung jumlah pemilih (DPT)
$query_total_pemilih = "SELECT COUNT(*) AS total_pemilih FROM tabel_akun_pemilih";
$stmt_total_pemilih = $pdo->query($query_total_pemilih);
$total_pemilih = $stmt_total_pemilih->fetchColumn();

// Query untuk menghitung total suara yang masuk
$query_total_suara = "SELECT COUNT(*) AS total_suara FROM tabel_data_suara";
$stmt_total_suara = $pdo->query($query_total_suara);
$total_suara = $stmt_total_suara->fetchColumn();

// Query untuk menghitung total pemilih yang sudah melakukan login (absen)
$query_total_absensi = "SELECT COUNT(*) AS total_absensi FROM tabel_data_absensi";
$stmt_total_absensi = $pdo->query($query_total_absensi);
$total_absensi = $stmt_total_absensi->fetchColumn();

// Hitung jumlah pemilih yang belum memilih
$pemilih_belum_memilih = $total_pemilih - $total_absensi;
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Hasil Pemilihan Ketua & Wakil Ketua OSIS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Hasil Pemilihan</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="row">
        <div class="col-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jumlah DPT</span>
                    <span class="info-box-number"><?php echo htmlspecialchars($total_pemilih); ?> Pemilih</span>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Suara Pemilih yang Masuk</span>
                    <span class="info-box-number"><?php echo htmlspecialchars($total_suara); ?> Suara</span>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-user-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pemilih yang Belum Memilih</span>
                    <span class="info-box-number"><?php echo htmlspecialchars($pemilih_belum_memilih); ?> Pemilih</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php foreach ($data_hasil as $hasil): ?>
            <div class="col-md-4">
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
    </div>
</div>
