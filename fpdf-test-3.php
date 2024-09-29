<?php
require 'vendors\autoload.php';
require 'config\config_db.php';

$versi_esppo = '1.0.0';
$nama_server = gethostname();
$output_location = 'assets/pdf/';
$output_name = 'pdftest-3.pdf';

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

// Ambil data kandidat dari database
$stmt_kandidat = $pdo->prepare("SELECT no_urut_kandidat, foto_kandidat, nama_calon_ketua, nama_calon_wakil FROM tabel_data_kandidat");
$stmt_kandidat->execute();
$kandidat = $stmt_kandidat->fetchAll();

// Query untuk menghitung kandidat
$query_total_kandidat = "SELECT COUNT(*) AS total_kandidat FROM tabel_data_kandidat";
$stmt_total_kandidat = $pdo->query($query_total_kandidat);
$total_kandidat = $stmt_total_kandidat->fetchColumn();

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
        $this->Cell(240,10,'Server eSPPO: '.$GLOBALS['nama_server'],0,0,'C');
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }

    function Circle($x, $y, $r, $style='D')
    {
        $this->Ellipse($x,$y,$r,$r,$style);
    }

    function Ellipse($x, $y, $rx, $ry, $style='D')
    {
        if($style=='F'){
            $op='f';
        }elseif($style=='FD' || $style=='DF'){
            $op='B';
        }else{
            $op='S';
        }

        $lx=4/3*(M_SQRT2-1)*$rx;
        $ly=4/3*(M_SQRT2-1)*$ry;
        $k=$this->k;
        $h=$this->h;
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x+$rx)*$k,($h-$y)*$k,
            ($x+$rx)*$k,($h-($y-$ly))*$k,
            ($x+$lx)*$k,($h-($y-$ry))*$k,
            $x*$k,($h-($y-$ry))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$lx)*$k,($h-($y-$ry))*$k,
            ($x-$rx)*$k,($h-($y-$ly))*$k,
            ($x-$rx)*$k,($h-$y)*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$rx)*$k,($h-($y+$ly))*$k,
            ($x-$lx)*$k,($h-($y+$ry))*$k,
            $x*$k,($h-($y+$ry))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x+$lx)*$k,($h-($y+$ry))*$k,
            ($x+$rx)*$k,($h-($y+$ly))*$k,
            ($x+$rx)*$k,($h-$y)*$k,
            $op));
    }
}

$pdf = new PDF('L','mm',array(330,215));
$pdf->SetTitle('Laporan Pelaksanaan Pemungutan Suara '.$nama_sekolah);
$pdf->SetSubject($nama_pemilihan.' '.$nama_sekolah.', '.datefmt_format($dateformat_id, $tanggal_pemilihan));
$pdf->SetCreator('Pusat Administrasi Pemilihan Terpadu eSPPO');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Helvetica','B',15);
$pdf->Cell(0,6,'SURAT SUARA ELEKTRONIK FISIK OMR (Optical Mark Recognition)',0,0,'C');
$pdf->Ln(7);
$pdf->MultiCell(0,6,$nama_pemilihan,0,'C');
$pdf->Ln(2);
$pdf->Cell(0,6,datefmt_format($dateformat_id, $tanggal_pemilihan),0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('','B',14);

foreach ($kandidat as $k){
    $kpds = 330 / $total_kandidat;
    $tengah_kpds = $kpds / 2;
    $pdf->Circle((($kpds * $k['no_urut_kandidat']) - $tengah_kpds),75,5);
    $pdf->SetXY((($kpds * $k['no_urut_kandidat']) - $tengah_kpds - 5),85);
    $pdf->Cell(10,10,$k['no_urut_kandidat'],0,1,'C');
    $pdf->SetXY((($kpds * $k['no_urut_kandidat']) - $tengah_kpds - 5),145);
    $pdf->Cell(10,10,$k['nama_calon_ketua'],0,1,'C');
    $pdf->SetX((($kpds * $k['no_urut_kandidat']) - $tengah_kpds - 5));
    $pdf->Cell(10,10,$k['nama_calon_wakil'],0,0,'C');
}

$pdf->Output('F',$output_location.$output_name);
?>

<html>
    <body>
        <iframe style="text-align:center;border:none;" src="vendors/viewerjs-0.5.8-dist/#<?php echo '../../'.$output_location.$output_name; ?>" width="100%" height="100%" allowfullscreen webkitallowfullscreen></iframe>
    </body>
</html>
