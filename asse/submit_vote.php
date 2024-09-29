<?php
session_name('eSPPO-SSE');
session_start();

require '../config/config_db.php';

if (!isset($_SESSION['voter_logged_in']) || $_SESSION['voter_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_akun_pemilih = $_SESSION['id_akun_pemilih'];
    $no_urut_kandidat = $_POST['pilihan'];

    // Ambil data timestamp saat suara diterima
    $timestamp_suara_masuk = date('Y-m-d H:i:s');

    // Lakukan hashing terhadap ID Akun Pemilih
    $hash_id_pemilih = password_hash($id_akun_pemilih, PASSWORD_BCRYPT);

    // Ambil kode ID kandidat dari database
    $stmt_kandidat = $pdo->prepare("SELECT kode_id_kandidat FROM tabel_data_kandidat WHERE no_urut_kandidat = :no_urut_kandidat");
    $stmt_kandidat->execute(['no_urut_kandidat' => $no_urut_kandidat]);
    $kode_id_kandidat = $stmt_kandidat->fetchColumn();

    if (!$kode_id_kandidat) {
        die("Kesalahan: Data Kandidat tidak ditemukan.");
    }

    // Ambil kode konstituensi pemilih dari database
    $stmt_akun = $pdo->prepare("SELECT kk_pemilih FROM tabel_akun_pemilih WHERE id_akun_pemilih = :id_akun_pemilih");
    $stmt_akun->execute(['id_akun_pemilih' => $id_akun_pemilih]);
    $kk_pemilih = $stmt_akun->fetchColumn();

    // Lakukan hasing terhadap gabungan ID Pemilih dan kode ID Kandidat
    $kode_id_surat_suara = hash('sha256', $hash_id_pemilih . $kode_id_kandidat);

    // Simpan suara pemilih ke dalam database
    $stmt_suara = $pdo->prepare("
        INSERT INTO tabel_data_suara (timestamp_suara_masuk, no_kandidat, hash_id_pemilih, kk_pemilih, kode_id_surat_suara) 
        VALUES (:timestamp_suara_masuk, :no_kandidat, :hash_id_pemilih, :kk_pemilih, :kode_id_surat_suara)
    ");
    $stmt_suara->execute([
        'timestamp_suara_masuk' => $timestamp_suara_masuk,
        'no_kandidat' => $no_urut_kandidat,
        'hash_id_pemilih' => $hash_id_pemilih,
        'kk_pemilih' => $kk_pemilih,
        'kode_id_surat_suara' => $kode_id_surat_suara
    ]);

    // Perbarui status pemilih
    $stmt_update = $pdo->prepare("UPDATE tabel_akun_pemilih SET status_pemilih = 'SUDAH MEMILIH' WHERE id_akun_pemilih = :id_akun_pemilih");
    $stmt_update->execute(['id_akun_pemilih' => $id_akun_pemilih]);

    // Redirect ke halaman sukses
    header("Location: vote_success.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
