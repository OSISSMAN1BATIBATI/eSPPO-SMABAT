<?php
// daftar_pemilih.php

// Termasuk file koneksi database
include '../config/config_db.php';

// Ambil data pemilih dan nama konstituensi
$query = "
    SELECT 
        tp.no_pemilih, 
        tp.nama_pemilih, 
        tp.jk_pemilih, 
        tp.kk_pemilih, 
        tk.nama_konstituensi, 
        tp.id_akun_pemilih, 
        tp.status_pemilih 
    FROM 
        tabel_akun_pemilih tp 
    JOIN 
        tabel_data_konstituensi tk 
    ON 
        tp.kk_pemilih = tk.kode_konstituensi
    ORDER BY 
        tp.no_pemilih";
$stmt = $pdo->query($query);
$data_pemilih = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Lihat Daftar Pemilih</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Daftar Pemilih</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pemilih Tetap (DPT)</h3>
        </div>
        <div class="card-body">
            <table id="tabelPemilih" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nomor Urut Pemilih</th>
                        <th>Nama Pemilih</th>
                        <th>Jenis Kelamin</th>
                        <th>Konstituensi</th>
                        <th>ID Akun Pemilih</th>
                        <th>Status Pemilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_pemilih as $pemilih): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pemilih['no_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($pemilih['nama_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($pemilih['jk_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($pemilih['kk_pemilih']); ?> (<?php echo htmlspecialchars($pemilih['nama_konstituensi']); ?>)</td>
                            <td><?php echo htmlspecialchars($pemilih['id_akun_pemilih']); ?></td>
                            <td><?php echo htmlspecialchars($pemilih['status_pemilih']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#tabelPemilih').DataTable({
            "scrollX": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
    });
</script>
