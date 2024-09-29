<?php
// data_konstituensi.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data konstituensi
$query = "SELECT * FROM tabel_data_konstituensi ORDER BY kode_konstituensi";
$stmt = $pdo->query($query);
$data_konstituensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Lihat Data Konstituensi Pemilih</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Data Konstituensi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="card">
        <div class="card-body">
            <table id="tabelKonstituensi" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%;">Kode Konstituensi</th>
                        <th scope="col" style="width: 50%;">Nama Konstituensi</th>
                        <th scope="col" style="width: 30%;">Tipe Konstituensi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($data_konstituensi) > 0): ?>
                        <?php foreach ($data_konstituensi as $konstituensi): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($konstituensi['kode_konstituensi']); ?></td>
                                <td><?php echo htmlspecialchars($konstituensi['nama_konstituensi']); ?></td>
                                <td><?php echo htmlspecialchars($konstituensi['tipe_konstituensi']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data konstituensi yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#tabelKonstituensi').DataTable({
            "scrollX": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
    });
</script>
