<?php
require '../vendors/autoload.php';
require '../config/config_db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

// Fungsi untuk mendapatkan nomor pemilih selanjutnya
function getNextPemilihNumber($pdo) {
    $query = "SELECT MAX(no_pemilih) AS max_no_pemilih FROM tabel_akun_pemilih WHERE no_pemilih < 9900";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result['max_no_pemilih'] !== null) ? $result['max_no_pemilih'] + 1 : 1;
}

// Fungsi untuk mencatat kesalahan ke log
function logError($error_message, $row_data) {
    file_put_contents('error_log.txt', date('Y-m-d H:i:s') . ' - ' . $error_message . ' - ' . json_encode($row_data) . "\n", FILE_APPEND);
}

// Fungsi untuk memvalidasi ID Pemilih agar tidak duplikat
function isDuplicateID($pdo, $id_akun_pemilih) {
    $query = "SELECT COUNT(*) FROM tabel_akun_pemilih WHERE id_akun_pemilih = :id_akun_pemilih";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_akun_pemilih', $id_akun_pemilih);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Cek apakah ada file yang diunggah
if (isset($_POST['import']) && isset($_FILES['file']['name'])) {

    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/vnd.ms-excel', 
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                        'application/vnd.ms-excel.sheet.macroEnabled.12', 'text/csv');
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);
    $upload_time = date('YmdHis');

    // Folder tempat menyimpan file
    $upload_dir = '../assets/spreadsheet/dpt/';
    $file_name = 'sse-data-pemilih-' . $upload_time . '.' . $extension;
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

        if ('csv' == $extension) {
            $reader = new Csv();
        } elseif ('xls' == $extension) {
            $reader = new Xls();
        } else {
            $reader = new Xlsx();
        }

        $spreadsheet = $reader->load($file_path);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Mulai transaksi
        $pdo->beginTransaction();

        try {
            $next_no_pemilih = getNextPemilihNumber($pdo);
            $stmt = $pdo->prepare("INSERT INTO tabel_akun_pemilih (no_pemilih, nama_pemilih, jk_pemilih, kk_pemilih, 
                                   id_akun_pemilih, hash_kata_sandi_pemilih, status_pemilih) 
                                   VALUES (:no_pemilih, :nama_pemilih, :jk_pemilih, :kk_pemilih, 
                                   :id_akun_pemilih, :hash_kata_sandi_pemilih, 'BELUM MEMILIH')");

            for ($i = 4; $i < count($sheetData); $i++) {
                $row = $sheetData[$i];

                // Validasi data kosong
                if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4]) || empty($row[5])) {
                    logError("Data tidak lengkap", $row);
                    continue;
                }

                // Deklarasi variabel dari data
                $no_pemilih_spreadsheet = $row[0];
                $nama_pemilih = $row[1];
                $jk_pemilih = $row[2];
                $kk_pemilih = $row[3];
                $id_akun_pemilih = $row[4];
                $kata_sandi_pemilih = $row[5];

                // Cek duplikasi ID Pemilih
                if (isDuplicateID($pdo, $id_akun_pemilih)) {
                    logError("ID Pemilih duplikat", $row);
                    continue;
                }

                // Hash kata sandi
                $hash_kata_sandi_pemilih = password_hash($kata_sandi_pemilih, PASSWORD_BCRYPT);

                // Validasi nomor pemilih
                $no_pemilih = ($no_pemilih_spreadsheet >= 9901 && $no_pemilih_spreadsheet <= 9999) ? $no_pemilih_spreadsheet : $next_no_pemilih++;

                // Bind parameter dan eksekusi query
                $stmt->bindParam(':no_pemilih', $no_pemilih);
                $stmt->bindParam(':nama_pemilih', $nama_pemilih);
                $stmt->bindParam(':jk_pemilih', $jk_pemilih);
                $stmt->bindParam(':kk_pemilih', $kk_pemilih);
                $stmt->bindParam(':id_akun_pemilih', $id_akun_pemilih);
                $stmt->bindParam(':hash_kata_sandi_pemilih', $hash_kata_sandi_pemilih);

                $stmt->execute();
            }

            // Commit transaksi
            $pdo->commit();
            header('Location: index.php?page=tambah_pemilih&status=success');
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            logError("Transaksi gagal: " . $e->getMessage(), null);
            header('Location: index.php?page=tambah_pemilih&status=error');
            exit();
        }

    } else {
        header('Location: index.php?page=tambah_pemilih&status=error');
        exit();
    }
} else {
    header('Location: index.php?page=tambah_pemilih&status=error');
    exit();
}
?>
