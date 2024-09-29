<?php
require '..\vendors\autoload.php';
require '..\config\config_db.php';

global $versi_esppo;
global $nama_sekolah;
global $nama_server;

$versi_esppo = '1.0.0';
$nama_server = gethostname();
$output_location = '../assets/pdf/';
$output_name = 'laporan_pemilihan.pdf';

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

// Ambil data kandidat dari database
$query_kandidat = "
    SELECT 
        k.no_urut_kandidat,
        k.nama_calon_ketua,
        k.nama_calon_wakil,
        COUNT(s.no_kandidat) AS jumlah_suara
    FROM 
        tabel_data_kandidat k
    LEFT JOIN 
        tabel_data_suara s 
    ON 
        k.no_urut_kandidat = s.no_kandidat
    GROUP BY 
        k.no_urut_kandidat
    ORDER BY 
        k.no_urut_kandidat";
$stmt_kandidat = $pdo->query($query_kandidat);
$data_hasil = $stmt_kandidat->fetchAll(PDO::FETCH_ASSOC);

// Menghitung total kandidat
$query_total_kandidat = "SELECT COUNT(*) AS total_kandidat FROM tabel_data_kandidat";
$total_kandidat = $pdo->query($query_total_kandidat)->fetchColumn();

// Menghitung jumlah pemilih
$query_total_laki_laki = "SELECT COUNT(*) AS total_laki_laki FROM tabel_akun_pemilih WHERE jk_pemilih = 'LAKI-LAKI'";
$total_laki_laki = $pdo->query($query_total_laki_laki)->fetchColumn();

$query_total_perempuan = "SELECT COUNT(*) AS total_perempuan FROM tabel_akun_pemilih WHERE jk_pemilih = 'PEREMPUAN'";
$total_perempuan = $pdo->query($query_total_perempuan)->fetchColumn();

$query_total_pemilih = "SELECT COUNT(*) AS total_pemilih FROM tabel_akun_pemilih";
$total_pemilih = $pdo->query($query_total_pemilih)->fetchColumn();

// Menghitung jumlah yang telah memilih
$query_laki_laki_memilih = "
    SELECT COUNT(*) AS laki_laki_memilih 
    FROM tabel_data_absensi a
    JOIN tabel_akun_pemilih p ON a.id_akun_pemilih = p.id_akun_pemilih
    WHERE p.jk_pemilih = 'LAKI-LAKI'";
$laki_laki_memilih = $pdo->query($query_laki_laki_memilih)->fetchColumn();

$query_perempuan_memilih = "
    SELECT COUNT(*) AS perempuan_memilih 
    FROM tabel_data_absensi a
    JOIN tabel_akun_pemilih p ON a.id_akun_pemilih = p.id_akun_pemilih
    WHERE p.jk_pemilih = 'PEREMPUAN'";
$perempuan_memilih = $pdo->query($query_perempuan_memilih)->fetchColumn();

$query_total_absensi = "SELECT COUNT(*) AS total_absensi FROM tabel_data_absensi";
$total_absensi = $pdo->query($query_total_absensi)->fetchColumn();

// Menghitung pemilih yang belum memilih
$laki_laki_belum_memilih = $total_laki_laki - $laki_laki_memilih;
$perempuan_belum_memilih = $total_perempuan - $perempuan_memilih;
$pemilih_belum_memilih = $total_pemilih - $total_absensi;

// Format tanggal
$dateformat_id = datefmt_create("id_ID", IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Asia/Makassar', IntlDateFormatter::GREGORIAN, "EEEE, dd MMMM yyyy");

// Generate PDF
class PDF extends FPDF
{
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
        $this->Line(10,38,200,38);
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetFont('Arial','I',10);
        $this->SetY(-18);
        $this->Cell(25,10,'eSPPO Versi',0,0,'L');
        $this->SetFont('','BI');
        $this->Cell(10,10,$GLOBALS['versi_esppo'],0,0,'L');
        $this->SetFont('','I');
        $this->Cell(120,10,'Server eSPPO: '.$GLOBALS['nama_server'],0,0,'C');
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }
}

// Inisiasi PDF
$pdf = new PDF();
$pdf->SetTitle('Laporan Pemungutan Suara '.$nama_sekolah);
$pdf->SetSubject($nama_pemilihan.' '.$nama_sekolah.', '.datefmt_format($dateformat_id, $tanggal_pemilihan));
$pdf->SetCreator('Pusat Administrasi Pemilihan Terpadu eSPPO');
$pdf->AliasNbPages();
$pdf->AddPage();

// Judul laporan
$pdf->SetFont('Helvetica','B',18);
$pdf->Cell(190,7,'LAPORAN PELAKSANAAN KEGIATAN PEMUNGUTAN SUARA',0,0,'C');
$pdf->Ln(9);
$pdf->Cell(190,7,'DAN HASIL PEROLEHAN SUARA',0,0,'C');
$pdf->Ln(9);
$pdf->MultiCell(190,7,$nama_pemilihan,0,'C');
$pdf->Ln(2);
$pdf->Cell(190,7,datefmt_format($dateformat_id, $tanggal_pemilihan),0,0,'C');
$pdf->Ln(20);

// Isi laporan
$pdf->SetFont('','',12);
$pdf->MultiCell(0,7,'Pada hari ini, '.datefmt_format($dateformat_id, $tanggal_pemilihan).
    ', telah dilaksanakan kegiatan Pemungutan dan Penghitungan Suara secara elektronik, dalam rangka pelaksanaan '.
    $nama_pemilihan.' di '.$nama_sekolah.'. Kegiatan Pemungutan dan Penghitungan Suara ini dilaksanakan di '.
    $jumlah_tps.' lokasi Tempat Pemungutan Suara (TPS) dengan total Perangkat Akses Surat Suara Elektronik (PASSE) sebanyak '.
    $jumlah_passe.' unit.',0,'J');
$pdf->Ln(5);

// Statistik Pemilih
$pdf->SetFont('Helvetica','B',14);
$pdf->Cell(190,10,'Statistik Pemilih',0,0,'C');
$pdf->Ln(12);
$pdf->SetFont('','',13);

// Tabel untuk pemilih terdaftar
$pdf->Cell(90,8,'Uraian',1,0,'C');
$pdf->Cell(33,8,'Laki-Laki',1,0,'C');
$pdf->Cell(33,8,'Perempuan',1,0,'C');
$pdf->Cell(33,8,'Jumlah',1,1,'C');

// Tabel untuk pemilih terdaftar
$pdf->Cell(90,8,'Daftar Pemilih Tetap',1,0,'C');
$pdf->Cell(33,8,$total_laki_laki.' orang',1,0,'C');
$pdf->Cell(33,8,$total_perempuan.' orang',1,0,'C');
$pdf->Cell(33,8,$total_pemilih.' orang',1,1,'C');

// Tabel untuk pemilih yang sudah memilih
$pdf->Cell(90,8,'Pemilih yang Hadir dan Sudah Memilih',1,0,'C');
$pdf->Cell(33,8,$laki_laki_memilih.' orang',1,0,'C');
$pdf->Cell(33,8,$perempuan_memilih.' orang',1,0,'C');
$pdf->Cell(33,8,$total_absensi.' orang',1,1,'C');

// Tabel untuk pemilih yang belum memilih
$pdf->Cell(90,8,'Pemilih yang tidak Hadir/Belum Memilih',1,0,'C');
$pdf->Cell(33,8,$laki_laki_belum_memilih.' orang',1,0,'C');
$pdf->Cell(33,8,$perempuan_belum_memilih.' orang',1,0,'C');
$pdf->Cell(33,8,$pemilih_belum_memilih.' orang',1,0,'C');
$pdf->Ln(15);

// Tabel Hasil Perolehan Suara
$pdf->SetFont('Helvetica','B',14);
$pdf->Cell(190,10,'Hasil Perolehan Suara Keseluruhan',0,0,'C');
$pdf->Ln(12);
$pdf->SetFont('','',12);
$pdf->Cell(20,8,'No',1,0,'C');
$pdf->Cell(60,8,'Calon Ketua',1,0,'C');
$pdf->Cell(60,8,'Calon Wakil Ketua',1,0,'C');
$pdf->Cell(50,8,'Perolehan Suara',1,1,'C');

foreach($data_hasil as $row) {
    $pdf->Cell(20,8,$row['no_urut_kandidat'],1,0,'C');
    $pdf->Cell(60,8,$row['nama_calon_ketua'],1,0,'C');
    $pdf->Cell(60,8,$row['nama_calon_wakil'],1,0,'C');
    $pdf->Cell(50,8,$row['jumlah_suara'].' suara',1,1,'C');
}

// Output PDF
$pdf->Output('F', $output_location.$output_name);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Pelaksanaan Kegiatan Pemilihan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Rumah</a></li>
                    <li class="breadcrumb-item active">Laporan Kegiatan Pemilihan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <iframe src="<?php echo $output_location.$output_name; ?>" height="800" width="600" allowfullscreen></iframe>
            </div>
            <div class="card-footer">
                <a href="<?php echo $output_location.$output_name; ?>"><button name="download_template" class="btn btn-info"><i class="fas fa-file-download"></i> Unduh Laporan Kegiatan Pemilihan (PDF)</button></a>
            </div>
        </div>
    </div>
</section>