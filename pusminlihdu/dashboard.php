<?php
require '../config/config_db.php';

// Query untuk mendapatkan data pemilihan
$queryPemilihan = "SELECT nama_pemilihan, tanggal_pemilihan, jumlah_tps, jumlah_passe FROM tabel_data_pemilihan";
$stmt = $pdo->query($queryPemilihan);
$pemilihan = $stmt->fetch();

// Query untuk mendapatkan jumlah DPT
$queryDPT = "SELECT COUNT(*) as total_dpt FROM tabel_akun_pemilih";
$stmt = $pdo->query($queryDPT);
$totalDPT = $stmt->fetchColumn();

// Query untuk mendapatkan jumlah kandidat
$queryKandidat = "SELECT COUNT(*) as total_kandidat FROM tabel_data_kandidat";
$stmt = $pdo->query($queryKandidat);
$totalKandidat = $stmt->fetchColumn();

// Query untuk mendapatkan jumlah suara yang masuk
$querySuaraMasuk = "SELECT COUNT(*) as total_suara FROM tabel_data_suara";
$stmt = $pdo->query($querySuaraMasuk);
$totalSuaraMasuk = $stmt->fetchColumn();

// Query untuk mendapatkan jumlah pemilih yang belum memilih
$queryBelumMemilih = "SELECT COUNT(*) as total_belum_memilih FROM tabel_akun_pemilih WHERE status_pemilih = 'BELUM MEMILIH'";
$stmt = $pdo->query($queryBelumMemilih);
$totalBelumMemilih = $stmt->fetchColumn();
?>

<!-- Tampilan Dashboard -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Rumah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Tanggal Pemilihan -->
            <div class="col-lg-4 col-8">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= date('d/m/Y', strtotime($pemilihan['tanggal_pemilihan'])); ?></h3>
                        <p>Tanggal Pemilihan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah TPS -->
            <div class="col-lg-4 col-8">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $pemilihan['jumlah_tps']; ?> Unit</h3>
                        <p>Tempat Pemungutan Suara</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah PASSE -->
            <div class="col-lg-4 col-8">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $pemilihan['jumlah_passe']; ?> Unit</h3>
                        <p>Perangkat Akses Surat Suara Elektronik</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah DPT -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $totalDPT; ?> Orang</h3>
                        <p>Daftar Pemilih Tetap</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="index.php?page=daftar_pemilih" class="small-box-footer">
                        Daftar Pemilih <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Jumlah Kandidat -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?= $totalKandidat; ?> Paslon</h3>
                        <p>Kandidat</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="index.php?page=daftar_paslon" class="small-box-footer">
                        Daftar Calon <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Suara yang Masuk -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?= $totalSuaraMasuk; ?> Suara</h3>
                        <p>Suara yang Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                    <a href="index.php?page=hasil_pemilihan" class="small-box-footer">
                        Hasil Pemilihan <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Pemilih yang Belum Memilih -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3><?= $totalBelumMemilih; ?></h3>
                        <p>Pemilih yang Belum Memilih</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <a href="index.php?page=absen_pemilih" class="small-box-footer">
                        Absen Pemilih <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Selamat Datang di Pusat Administrasi Pemilihan Terpadu eSPPO!</b></h3>
            </div>
            <div class="card-body">
                <p>Pusminlihdu adalah salah satu aplikasi komponen dari eSPPO dan berfungsi untuk mengelola data kegiatan pemilihan secara elektronik.</p>
                <p>Disini, anda dapat mengelola kegiatan pemungutan dan penghitungan suara secara elektronik, dari data sekolah dan kegiatan pemilihan, data pemilih dan kandidat, melihat hasil perolehan suara dan absen, sampai membuat laporan kegiatan pemilihan.</p>
            </div>
        </div>
    </div>
</section>
