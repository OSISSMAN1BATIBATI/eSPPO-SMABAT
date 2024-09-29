<?php
// absen_pemilih.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data absensi pemilih, nama pemilih, dan nama konstituensi
$query = "
    SELECT 
        ab.urutan_absen_pemilih, 
        ab.timestamp_absen_pemilih, 
        tp.nama_pemilih, 
        tk.nama_konstituensi
    FROM 
        tabel_data_absensi ab
    LEFT JOIN 
        tabel_akun_pemilih tp 
    ON 
        ab.id_akun_pemilih = tp.id_akun_pemilih
    LEFT JOIN 
        tabel_data_konstituensi tk 
    ON 
        ab.kk_pemilih = tk.kode_konstituensi
    ORDER BY 
        ab.timestamp_absen_pemilih DESC";

$stmt = $pdo->query($query);
$data_absensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Absensi Pemilih</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Absensi Pemilih</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kehadiran Pemilih</h3>
        </div>
        <div class="card-body">
            <table id="tabelAbsen" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Urutan Absensi</th>
                        <th>Waktu Absen (Login) Pemilih</th>
                        <th>Nama Pemilih</th>
                        <th>Konstituensi Pemilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_absensi as $absensi): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($absensi['urutan_absen_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($absensi['timestamp_absen_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($absensi['nama_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($absensi['nama_konstituensi']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#tabelAbsen').DataTable({
            "scrollX": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
    });
</script>
