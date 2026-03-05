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

class PDF extends fpdf
{
    const Y_LIMIT = 185;

    public $model;
    public $globalSetting;

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function setGlobalSetting($globalSetting)
    {
        $this->globalSetting = $globalSetting;
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
        $this->SetXY($left, $this->GetY() + 6);
        $this->Cell($w[0], 8, 'No', 'LT', 0, 'C');
        $this->Cell($w[1], 8, 'Tgl Bukti', 'LTR', 0, 'C');
        $this->Cell($w[2], 8, 'No Bukti', 'LTR', 0, 'C');
        $this->Cell($w[3], 8, 'Uraian', 'LTR', 0, 'C');
        $this->Cell($w[4], 8, 'Pemotongan', 'LTR', 0, 'C');
        $this->Cell($w[5], 8, 'Penyetoran', 'LTR', 0, 'C');
        $this->Cell($w[6], 8, 'Saldo', 'LTR', 0, 'C');
        $this->ln();

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 5, '1', 'LTB', 0, 'C');
        $this->Cell($w[1], 5, '2', 'LTRB', 0, 'C');
        $this->Cell($w[2], 5, '3', 'LTRB', 0, 'C');
        $this->Cell($w[3], 5, '4', 'LTRB', 0, 'C');
        $this->Cell($w[4], 5, '5', 'LTRB', 0, 'C');
        $this->Cell($w[5], 5, '6', 'LTRB', 0, 'C');
        $this->Cell($w[6], 5, '7', 'LTRB', 0, 'C');
        $this->ln();
    }
}

$pdf = new PDF('P', 'mm', [216, 330]);
$border = 0;
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage('P', [216, 330]);
$pdf->SetMargins(25, 25, 25); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 25); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 20, 20, '');
$pdf->Image(Tbsub::first()->getLogoImageRs(), 175, 14.5, 20, 20, '');

$x = $left = 10;

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->MultiCell(150, 4, 'BUKU PEMBANTU PAJAK', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->MultiCell(150, 4, 'BENDAHARA PENGELUARAN', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Periode ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(195, 6, '', 'B', 'C', 0);

//content
$w = [28, 150]; // bagi menjadi 2 bagian


$pdf->ln(5);
// $w = [16, 43, 24, 52, 20, 20, 20]; // Tentukan width masing-masing kolom
$w = [12, 18, 40, 50, 25, 25, 25]; // Tentukan width masing-masing kolom

$pdf->breakPageTableHeader($left, $w);

$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$totaldb = $totalkr = $totaldbLalu = $totalkrLalu = $totalsaldo = 0;
$lastDate = $lastNoBukti = null;

foreach ($model['data']['rincianBku'] as $data) {

    $totalsaldo = $totalsaldo + ($data->debet - $data->kredit);

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->no_bukti),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $data->kode),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, $data->uraian),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 5, number_format($data->debet, 2, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[5], 5, number_format($data->kredit, 2, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[6], 5, number_format($totalsaldo, 2, ',', '.'))
    );

    $y = MAX($y1, $y2, $y3);

    // IF($y2 > 295 || $y1 + (5*(strlen($data->uraian)/35)) > 295 ){ //cek pagebreak
    if ($yMaxAfter > 295) {
        $ylst = 305 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
        $pdf->Rect($x, $yst, $w[0], $ylst);
        $pdf->Rect($x + $w[0], $yst, $w[1], $ylst);
        $pdf->Rect($x + $w[0] + $w[1], $yst, $w[2], $ylst);
        $pdf->Rect($x + $w[0] + $w[1] + $w[2], $yst, $w[3], $ylst);
        $pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3], $yst, $w[4], $ylst);
        $pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4], $yst, $w[5], $ylst);
        $pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5], $yst, $w[6], $ylst);

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
    $pdf->MultiCell($w[0], 4, $i, '', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, $lastDate != $data->tgl_bukti ? date('d-m-Y', strtotime($data->tgl_bukti)) : '', '', 'C');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, $lastNoBukti != $data->no_bukti ? $data->no_bukti : '', '', 'C'); // $data->kdrek1 != 0 ? SppSp2d::rekeningKodeBuilder($data->kdrek1, $data->kdrek2, $data->kdrek3, $data->kdrek4, $data->kdrek5, $data->kdrek6) : ''
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, $data->uraian, '', 'L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 4, $data->debet > 0 ? number_format($data->debet, 2, ',', '.') : '', '', 'R');
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 4, $data->kredit > 0 ? number_format($data->kredit, 2, ',', '.') : '', '', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 4, number_format($totalsaldo, 2, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $lastDate = $data->tgl_bukti;
    $lastNoBukti = $data->no_bukti;

    if ($data->debet > 0) {
        $totaldb = $totaldb + $data->debet;
    }
    if ($data->kredit > 0) {
        $totalkr = $totalkr + $data->kredit;
    }
    if ($data->uraian === 'Saldo Awal') {
        if ($data->debet > 0) $totaldbLalu = $data->debet;
        if ($data->debet < 0) $totaldbLalu = $data->debet;
    }
}

$y = max($y1, $y2);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->Rect($x, $yst, $w[0], $ylst);
$pdf->Rect($x + $w[0], $yst, $w[1], $ylst);
$pdf->Rect($x + $w[0] + $w[1], $yst, $w[2], $ylst);
$pdf->Rect($x + $w[0] + $w[1] + $w[2], $yst, $w[3], $ylst);
$pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3], $yst, $w[4], $ylst);
$pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4], $yst, $w[5], $ylst);
$pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5], $yst, $w[6], $ylst);


$yMaxAfter = max(
    $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 5, number_format($data->debet, 2, ',', '.')),
    $pdf->getY() + $pdf->GetMultiCellHeight($w[5], 5, number_format($data->kredit, 2, ',', '.')),
    $pdf->getY() + $pdf->GetMultiCellHeight($w[6], 5, number_format($totalsaldo, 2, ',', '.'))
);

$y = MAX($y1, $y2, $y3);

// IF($y2 > 295 || $y1 + (5*(strlen($data->uraian)/35)) > 295 ){ //cek pagebreak
if ($yMaxAfter > 295) {
    $ylst = 305 - $yst; //207 batas margin bawah dikurang dengan y pertama
    //setiap selesai page maka buat rectangle
    $pdf->Rect($x, $yst, $w[0], $ylst);
    $pdf->Rect($x + $w[0], $yst, $w[1], $ylst);
    $pdf->Rect($x + $w[0] + $w[1], $yst, $w[2], $ylst);
    $pdf->Rect($x + $w[0] + $w[1] + $w[2], $yst, $w[3], $ylst);
    $pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3], $yst, $w[4], $ylst);
    $pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4], $yst, $w[5], $ylst);
    $pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5], $yst, $w[6], $ylst);

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



$pdf->SetFont('Arial', 'B', 8);
//new data		
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 5, '', 'LB', 'C');
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 5, '', 'B', 'C');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 5, '', 'B', 'C'); // $data->kdrek1 != 0 ? SppSp2d::rekeningKodeBuilder($data->kdrek1, $data->kdrek2, $data->kdrek3, $data->kdrek4, $data->kdrek5, $data->kdrek6) : ''
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 5, '', 'BR', 'L');
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 5, number_format($totaldb, 2, ',', '.'), 'BR', 'R');
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 5, number_format($totalkr, 2, ',', '.'), 'BR', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[6], 5, number_format($totaldb - $totalkr, 2, ',', '.'), 'BR', 'R');
$xcurrent = $xcurrent + $w[6];
$pdf->SetXY($xcurrent, $y);

$ysisa = $y;

$i++; //Untuk urutan nomor
$pdf->ln();

$pdf->ln();

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($pdf->GetY() > ($pdf->GetPageHeight() - 70)) {
    $pdf->AddPage();
}

/////PENANDATANGAN
$y = $pdf->gety() + 2;
$pdf->SetXY(15, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, "Mengetahui/Menyetujui:", '', 'C', 0); 
$pdf->SetXY(15, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Pimpinan BLUD', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(15, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(15, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganPimpinan ? $penandatanganPimpinan->NIP_pjb : ''), '', 'C', 0);
$pdf->SetXY(115, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
$pdf->SetXY(115, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Bendahara Pengeluaran', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(115, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(115, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(115);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganBendahara ? $penandatanganBendahara->NIP_pjb : ''), '', 'C', 0);
$y = $pdf->GetY() + 6;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
