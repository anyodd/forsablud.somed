<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

class KodeRekening
{
	public static function rekeningKodeBuilder($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6)
	{
		return $kdrek1 . '.' . $kdrek2 . '.' . $kdrek3 . '.' . substr('00' . $kdrek4, -2) . '.' . substr('00' . $kdrek5, -2) . '.' . substr('0000' . $kdrek6, -4);
	}
}

class KodeSubKegiatan
{
	 public static function kegiatanToSubkegiatanKodeBuilder($kdKegiatan, $kdSubkegiatan)
    {
        return $kdKegiatan . '.' . $kdSubkegiatan;
    }
}

class PDF extends fpdf
{
    const Y_LIMIT = 185;

    public $model, $tgl_1, $tgl_2, $tgl_laporan;

    public function setModel($model)
    {
        $this->model = $model;
    }

    function Header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(163, 163, 163);
    }

    function Footer()
    {
        $this->pageFooterNonTTE();
    }

    function breakPageTableHeader($left, $w)
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 12, 'NO', 'LBT', 0, 'C');
        $this->Cell($w[1], 12, 'KODE KEG.', 'LBT', 0, 'C');
		$this->Cell($w[2], 12, 'KEGIATAN', 'LBTR', 0, 'C');
        $this->Cell($w[3], 12, 'NAMA & ALAMAT PELAKSANA', 'LBT', 0, 'C');
        $this->Cell($w[4], 12, 'NO KONTRAK/SPK', 'LBTR', 0, 'C');
		$this->Cell($w[5], 12, 'TANGGAL', 'LBTR', 0, 'C');
		$this->Cell($w[6], 12, 'REKENING', 'LBTR', 0, 'C');
        $this->Cell($w[7], 12, 'NAMA REKENING', 'LBTR', 0, 'C');
        $this->Cell($w[8], 12, 'NILAI', 'LTR', 0, 'C');
        $this->ln();
    }
}

$pdf = new PDF('L', 'mm', [216, 330]);
$border = 0;
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage();
$pdf->SetMargins(15, 10, 15); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 10); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();

$x = 15;
$left = 15;
// Kotak Full Halaman
// $pdf->Rect($x, 10, 300, 195);

//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 20, 20, '');
$pdf->Image(Tbsub::first()->getLogoImageRs(), 290, 14.5, 20, 20, '');

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() + 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper("REGISTER KONTRAK / SPK"), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(290, 4, 'Periode ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(300, 6, '', 'B', 'C', 0);

//content
$w = [28, 150]; // bagi menjadi 2 bagian

$w = [10, 28, 28, 52, 52, 18, 30, 54, 28]; // Tentukan width masing-masing kolom
$pdf->breakPageTableHeader($left, $w);


$y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;
$totalNilaiKontrak = $totalNilai = 0;

foreach ($model['data']['registerKontrak'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, KodeSubKegiatan::kegiatanToSubkegiatanKodeBuilder($data->kdkegiatan, $data->kdsubkegiatan)),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $data->nmsubkegiatan),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, $data->penerima_nm . ', ' . $data->penerima_alamat),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 5, $data->kontrak_no),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[5], 5, $data->kontrak_tgl),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[6], 5, $data->Ko_Rkk),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[7], 5, $data->Ur_Rk6),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[8], 5, number_format($data->nilai, 2, ',', '.')),
    );

    $y = MAX($y1, $y2, $y3);

    // IF($y2 > 295 || $y1 + (5*(strlen($data->uraian)/35)) > 295 ){ //cek pagebreak
    if ($pdf->checkIfPageExceed($yMaxAfter)) {
        $ylst = $pdf::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
        $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AliasNbPages();
        $left = 10;

        $pdf->breakPageTableHeader($left, $w);

        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = $left;
        $ysisa = $y1;
        $y = MAX($y1, $y2, $y3);
    }



    $pdf->SetFont('Arial', '', 8);
    //new data		
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 6, $i, '', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 6, KodeSubKegiatan::kegiatanToSubkegiatanKodeBuilder($data->kdkegiatan, $data->kdsubkegiatan), '', 'C');
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 6, $data->nmsubkegiatan, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, $data->penerima_nm . ', ' . $data->penerima_alamat, '', 'L');
    $y2 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, $data->kontrak_no, '', 'L');
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, date('d-m-Y', strtotime($data->kontrak_tgl)), '', 'C');
    $y3 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 6, $data->Ko_Rkk, '', 'L');
    $xcurrent = $xcurrent + $w[6];
	$pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[7], 6, $data->Ur_Rk6 , '', 'L');
    $xcurrent = $xcurrent + $w[7];
    $pdf->SetXY($xcurrent, $y);
	$pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell($w[8], 6, $data->nilai ? number_format($data->nilai, 2, ',', '.') : 0, '', 'R');
    $xcurrent = $xcurrent + $w[8];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $totalNilaiKontrak += $data->nilai;
}
$y = max($y1, $y2);


//membuat kotak di halaman terakhir
// $y = $pdf->gety();
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'BU', 8);
$pdf->Cell($w[0], 6, '', 'LB');
$pdf->Cell($w[1], 6, '', 'LB', 0, 'C');
$pdf->Cell($w[2], 6, '', 'BL', 0, 'R');
$pdf->Cell($w[3], 6, '', 'BL', 0, 'R');
$pdf->Cell($w[4], 6, '', 'BL', 0, 'R');
$pdf->Cell($w[5], 6, '', 'BL', 0, 'R');
$pdf->Cell($w[6], 6, '', 1, 0, 'R');
$pdf->Cell($w[7], 6, 'TOTAL', 'BL', 0, 'R');
$pdf->Cell($w[8], 6, number_format($totalNilaiKontrak, 2, ',', '.'), 1, 0, 'R');

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
