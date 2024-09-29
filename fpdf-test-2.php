<?php
require 'vendors\autoload.php';
require 'config\config_db.php';

$versi_esppo = '1.0.0';
$nama_server = gethostname();
$output_location = 'assets/pdf/';
$output_name = 'rekapitulasi-pemilih-dan-perolehan-suara.pdf';

// Ambil data sekolah dari database
$query_data_sekolah = "SELECT * FROM tabel_data_sekolah LIMIT 1";
$stmt_data_sekolah = $pdo->query($query_data_sekolah);
$data_sekolah = $stmt_data_sekolah->fetch(PDO::FETCH_ASSOC);
$nama_sekolah = $data_sekolah['nama_sekolah'];

// Ambil data pemilihan dari database
$query_data_pemilihan = "SELECT * FROM tabel_data_pemilihan LIMIT 1";
$stmt_data_pemilihan = $pdo->query($query_data_pemilihan);
$data_pemilihan = $stmt_data_pemilihan->fetch(PDO::FETCH_ASSOC);
$nama_pemilihan = $data_pemilihan['nama_pemilihan'];
$tanggal_pemilihan = date_create($data_pemilihan['tanggal_pemilihan']);
$jumlah_tps = $data_pemilihan['jumlah_tps'];
$jumlah_passe = $data_pemilihan['jumlah_passe'];

// Menghitung jumlah pemilih berdasarkan jenis kelamin
$query_total_laki_laki = "SELECT COUNT(*) AS total_laki_laki FROM tabel_akun_pemilih WHERE jk_pemilih = 'LAKI-LAKI'";
$total_laki_laki = $pdo->query($query_total_laki_laki)->fetchColumn();

$query_total_perempuan = "SELECT COUNT(*) AS total_perempuan FROM tabel_akun_pemilih WHERE jk_pemilih = 'PEREMPUAN'";
$total_perempuan = $pdo->query($query_total_perempuan)->fetchColumn();

$query_total_pemilih = "SELECT COUNT(*) AS total_pemilih FROM tabel_akun_pemilih";
$total_pemilih = $pdo->query($query_total_pemilih)->fetchColumn();

// Menghitung jumlah pemilih yang telah memilih
$query_laki_laki_memilih = "
    SELECT COUNT(*) AS laki_laki_memilih 
    FROM tabel_data_suara s
    JOIN tabel_akun_pemilih p
    WHERE p.jk_pemilih = 'LAKI-LAKI'";
$laki_laki_memilih = $pdo->query($query_laki_laki_memilih)->fetchColumn();

$query_perempuan_memilih = "
    SELECT COUNT(*) AS perempuan_memilih 
    FROM tabel_data_suara s
    JOIN tabel_akun_pemilih p
    WHERE p.jk_pemilih = 'PEREMPUAN'";
$perempuan_memilih = $pdo->query($query_perempuan_memilih)->fetchColumn();

$query_total_absensi = "SELECT COUNT(*) AS total_absensi FROM tabel_data_suara";
$total_absensi = $pdo->query($query_total_absensi)->fetchColumn();

// Menghitung perolehan suara keseluruhan
$query_perolehan_suara_total = "
    SELECT ka.nama_calon_ketua, ka.nama_calon_wakil, COUNT(s.no_kandidat) AS total_suara
    FROM tabel_data_suara s
    JOIN tabel_data_kandidat ka ON s.no_kandidat = ka.no_urut_kandidat
    GROUP BY ka.nama_calon_ketua, ka.nama_calon_wakil
    ORDER BY total_suara DESC";
$stmt_perolehan_suara_total = $pdo->query($query_perolehan_suara_total);
$perolehan_suara_total = $stmt_perolehan_suara_total->fetchAll(PDO::FETCH_ASSOC);

// Menghitung perolehan suara per konstituensi (kelas/kepegawaian)
$query_perolehan_suara_per_kelas = "
    SELECT k.nama_konstituensi, ka.nama_calon_ketua, ka.nama_calon_wakil, COUNT(s.kode_id_surat_suara) AS total_suara 
    FROM tabel_data_suara s
    JOIN tabel_akun_pemilih p
    JOIN tabel_data_kandidat ka ON s.no_kandidat = ka.no_urut_kandidat
    JOIN tabel_data_konstituensi k ON p.kk_pemilih = k.kode_konstituensi
    GROUP BY k.nama_konstituensi, ka.nama_calon_ketua, ka.nama_calon_wakil
    ORDER BY k.nama_konstituensi ASC
";
$stmt_perolehan_suara_per_kelas = $pdo->query($query_perolehan_suara_per_kelas);
$perolehan_suara_per_kelas = $stmt_perolehan_suara_per_kelas->fetchAll(PDO::FETCH_ASSOC);

// Format tanggal Indonesia
$dateformat_id = datefmt_create("id_ID", IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Asia/Makassar', IntlDateFormatter::GREGORIAN, "EEEE, dd MMMM yyyy");

class PDF extends FPDF
{
    // Header Halaman
    function Header()
    {
        $this->SetFont('Helvetica','B',13);
        $this->Cell(0,6,'PUSAT ADMINISTRASI PEMILIHAN TERPADU (PUSMINLIHDU)',0,0,'C');
        $this->Ln(7);
        $this->SetFontSize(15);
        $this->Cell(0,8,'SISTEM PENYELENGGARAAN PEMILIHAN OSIS ELEKTRONIK (eSPPO)',0,0,'C');
        $this->Ln(9);
        $this->SetFontSize(20);
        $this->Cell(0,10,$GLOBALS['nama_sekolah'],0,0,'C');
        $this->Line(15,38,315,38);
        $this->Ln(15);
    }

    // Footer Halaman
    function Footer()
    {
        $this->SetFont('Arial','I',10);
        $this->SetY(-15);
        $this->Cell(25,10,'eSPPO Versi',0,0,'L');
        $this->SetFont('','BI');
        $this->Cell(10,10,$GLOBALS['versi_esppo'],0,0,'L');
        $this->SetFont('','I');
        $this->Cell(210,10,'Server eSPPO: '.$GLOBALS['nama_server'],0,0,'C');
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }

    // Halaman pertama: Rekapitulasi keseluruhan
    function RekapitulasiKeseluruhan($total_pemilih, $total_laki_laki, $total_perempuan, $total_absensi, $laki_laki_memilih, $perempuan_memilih, $perolehan_suara_total)
    {
        $this->SetFont('Helvetica','B',14);
        $this->Cell(0,15,'Rekapitulasi Keseluruhan Pemilih dan Perolehan Suara',0,1,'C');

        $this->SetFont('Helvetica','B',12);
        $this->Cell(0,15,'Rekapitulasi Pemilih',0,1,'C');

        $this->Cell(90,8,'Uraian',1,0,'C');
        $this->Cell(60,8,'Laki-Laki',1,0,'C');
        $this->Cell(60,8,'Perempuan',1,0,'C');
        $this->Cell(60,8,'Jumlah',1,1,'C');

        // Total pemilih
        $this->SetFont('Helvetica','',12);
        $this->Cell(90,10,'Jumlah Pemilih',1,0,'C');
        $this->Cell(60,10,$total_laki_laki,1,0,'C');
        $this->Cell(60,10,$total_perempuan,1,0,'C');
        $this->Cell(60,10,$total_pemilih,1,1,'C');

        // Total yang sudah memilih
        $this->Cell(90,10,'Pemilih yang Sudah Memilih',1,0,'C');
        $this->Cell(60,10,$laki_laki_memilih,1,0,'C');
        $this->Cell(60,10,$perempuan_memilih,1,0,'C');
        $this->Cell(60,10,$total_absensi,1,1,'C');

        // Total yang belum memilih
        $this->Cell(90,10,'Pemilih yang Belum Memilih',1,0,'C');
        $this->Cell(60,10,$total_laki_laki-$laki_laki_memilih,1,0,'C');
        $this->Cell(60,10,$total_perempuan-$perempuan_memilih,1,0,'C');
        $this->Cell(60,10,$total_pemilih-$total_absensi,1,1,'C');

        // Persentase partisipasi
        $this->Cell(90,10,'Tingkat Partisipasi',1,0,'C');
        $this->Cell(60,10,number_format(($laki_laki_memilih / $total_laki_laki * 100), 2).'%',1,0,'C');
        $this->Cell(60,10,number_format(($perempuan_memilih / $total_perempuan * 100), 2).'%',1,0,'C');
        $this->Cell(60,10,number_format(($total_absensi / $total_pemilih * 100), 2).'%',1,1,'C');

        // Perolehan suara keseluruhan
        $this->Ln(10);
        $this->SetFont('Helvetica','B',12);
        $this->Cell(0,10,'Rekapitulasi Perolehan Suara',0,1,'C');
        $this->Ln(5);

        foreach ($perolehan_suara_total as $suara) {
            $this->Cell(60,10,$suara['nama_calon_ketua'].' & '.$suara['nama_calon_wakil'],1,0,'C');
            $this->Cell(60,10,$suara['total_suara'],1,1,'C');
        }
    }

    // Halaman untuk setiap konstituensi
    function RekapitulasiPerKelas($perolehan_suara_per_kelas)
    {
        $current_konstituensi = '';
        foreach ($perolehan_suara_per_kelas as $suara) {
            if ($current_konstituensi !== $suara['nama_konstituensi']) {
                if ($current_konstituensi !== '') {
                    $this->AddPage();
                }
                $current_konstituensi = $suara['nama_konstituensi'];
                $this->SetFont('Helvetica','B',14);
                $this->Cell(0,10,'Rekapitulasi Suara Konstituensi: '.$current_konstituensi,0,1,'C');
                $this->Ln(5);
            }
            $this->SetFont('Helvetica','',12);
            $this->Cell(60,10,$suara['nama_calon_ketua'].' & '.$suara['nama_calon_wakil'],1,0,'C');
            $this->Cell(60,10,$suara['total_suara'],1,1,'C');
        }
    }
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

// Halaman 1: Rekapitulasi keseluruhan
$pdf->RekapitulasiKeseluruhan($total_pemilih, $total_laki_laki, $total_perempuan, $total_absensi, $laki_laki_memilih, $perempuan_memilih, $perolehan_suara_total);

// Halaman berikutnya: Rekapitulasi per konstituensi
$pdf->RekapitulasiPerKelas($perolehan_suara_per_kelas);

$pdf->Output($output_location.$output_name,'F');
?>

<html>
<body>
    <iframe style="text-align:center;border:none;" src="vendors/viewerjs-0.5.8-dist/#<?php echo '../../'.$output_location.$output_name; ?>" width="100%" height="100%" allowfullscreen></iframe>
</body>
</html>

