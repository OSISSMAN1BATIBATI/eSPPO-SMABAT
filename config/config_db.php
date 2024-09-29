<?php
// Pengaturan Koneksi Database
$host = 'localhost';                                // Nama host, biasanya 'localhost' atau '127.0.0.1'
$dbname = 'db_sppoe_pilketos_smabat_2024';          // Nama database yang digunakan
$username = 'db-access-sppoe';                      // Nama pengguna database
$password = 'pspo0515';                             // Kata sandi pengguna database

// Buat Koneksi dengan Database menggunakan PDO (PHP Data Objects)
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    // Membuat koneksi database
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Jika terjadi kesalahan koneksi, tampilkan pesan error
    die("Gagal terhubung ke database: " . $e->getMessage());
}

// Opsional: Function untuk menutup koneksi database
// Gunakan closeDatabaseConnection($pdo); untuk menutup koneksi ketika sudah tidak diperlukan
// function closeDatabaseConnection(&$pdo) {
//    $pdo = null;
// }

?>