<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use Illuminate\Support\Facades\Request;
use App\Models\Tbsub;

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
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($left, $this->GetY() + 6);
        $this->Cell($w[0], 8, 'Tanggal', 'LT', 0, 'C');
        $this->Cell($w[1], 8, 'No Bukti', 'LTR', 0, 'C');
        $this->Cell($w[2], 8, 'Rekening', 'LTR', 0, 'C');
        $this->Cell($w[3], 8, 'Uraian', 'LTR', 0, 'C');
        $this->Cell($w[4], 8, 'Debet', 'LTR', 0, 'C');
        $this->Cell($w[5], 8, 'Kredit', 'LTR', 0, 'C');
        $this->Cell($w[6], 8, 'Saldo', 'LTR', 0, 'C');
        $this->ln();

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 6, '1', 'LTB', 0, 'C');
        $this->Cell($w[1], 6, '2', 'LTRB', 0, 'C');
        $this->Cell($w[2], 6, '3', 'LTRB', 0, 'C');
        $this->Cell($w[3], 6, '4', 'LTRB', 0, 'C');
        $this->Cell($w[4], 6, '5', 'LTRB', 0, 'C');
        $this->Cell($w[5], 6, '6', 'LTRB', 0, 'C');
        $this->Cell($w[6], 6, '7', 'LTRB', 0, 'C');
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
$pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->MultiCell(150, 4, 'BUKU KAS UMUM', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->MultiCell(150, 4, 'BENDAHARA PENERIMAAN', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Periode: ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(195, 6, '', 'B', 'C', 0);

//content
//$w = [28, 150]; // bagi menjadi 2 bagian


$w = [30, 7, 262]; // Tentukan width masing-masing kolom 187
$y = $pdf->GetY() + 4;
$pdf->SetFont('Arial', '', 8);


// $pdf->SetXY($left, $y);
// $xcurrent = $left;
// $pdf->MultiCell($w[0], 4, "Urusan Pemerintahan", '', 'L', 0);
// $xcurrent = $xcurrent + $w[0];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
// $xcurrent = $xcurrent + $w[1];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, $model['data']['ambilbidang'][0]->kode_bidang, '', 'L', 0);
// $xcurrent = $xcurrent + $w[2];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, "", '', 'L', 0);
// $y = $pdf->GetY() + 1;


// $pdf->SetXY($left, $y);
// $xcurrent = $left;
// $pdf->MultiCell($w[0], 4, "SKPD", '', 'L', 0);
// $xcurrent = $xcurrent + $w[0];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
// $xcurrent = $xcurrent + $w[1];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, $model['data']['ambilskpd'][0]->kode_skpd, '', 'L', 0);
// $xcurrent = $xcurrent + $w[2];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, "", '', 'L', 0);
// $y = $pdf->GetY() + 1;


// $pdf->SetXY($left, $y);
// $xcurrent = $left;
// $pdf->MultiCell($w[0], 4, "Unit Organisasi", '', 'L', 0);
// $xcurrent = $xcurrent + $w[0];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
// $xcurrent = $xcurrent + $w[1];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, $model['data']['ambilunit'][0]->kode_unit, '', 'L', 0);
// $y = $pdf->GetY() + 1;
// $xcurrent = $xcurrent + $w[2];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, "", '', 'L', 0);

//$pdf->ln(5);
$w = [16, 34, 28, 40, 25, 25, 27]; // Tentukan width masing-masing kolom
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

foreach ($model['data']['bkupdpt'] as $data) {

    $totalsaldo = $totalsaldo + ($data->debet - $data->kredit);

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->no_bukti),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $data->kode),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, $data->nmrek6),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 5, number_format($data->debet, 2, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[5], 5, number_format($data->kredit, 2, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[6], 5, number_format($totalsaldo, 2, ',', '.'))
    );

    $y = MAX($y1, $y2, $y3);

    // IF($y2 > 295 || $y1 + (5*(strlen($data->nmrek6)/35)) > 295 ){ //cek pagebreak
    if ($yMaxAfter > 290) {
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



    $pdf->SetFont('Arial', '', 7);
    //new data
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, $lastDate != $data->tgl_bukti ? date('d-m-Y', strtotime($data->tgl_bukti)) : '', '', 'R');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, $lastNoBukti != $data->no_bukti ? $data->no_bukti : '', '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, $data->kdrek1 != 0 ? $data->Ko_Rkk : '', '', 'C');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, $data->nmrek6, '', 'L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 4, $data->debet > 0 && $data->nmrek6 !== 'Saldo Awal' ? number_format($data->debet, 2, ',', '.') : '', '', 'R');
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 4, $data->kredit > 0 && $data->nmrek6 !== 'Saldo Awal' ? number_format($data->kredit, 2, ',', '.') : '', '', 'R');
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
        if ($data->nmrek6 !== 'Saldo Awal') $totaldb = $totaldb + $data->debet;
    }
    if ($data->kredit > 0) {
        if ($data->nmrek6 !== 'Saldo Awal') $totalkr = $totalkr + $data->kredit;
    }
    if ($data->nmrek6 === 'Saldo Awal') {
        if ($data->debet > 0) $totaldbLalu = $data->debet;
        if ($data->debet < 0) $totaldbLalu = $data->debet;
        if ($data->kredit > 0) $totalkrLalu = $data->kredit;
        if ($data->kredit < 0) $totalkrLalu = $data->kredit;
    }
}

$y = max($y1, $y2, $y3);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama

$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//$pdf->Rect($x, $yst, $w[0], $ylst);
//$pdf->Rect($x + $w[0], $yst, $w[1], $ylst);
//$pdf->Rect($x + $w[0] + $w[1], $yst, $w[2], $ylst);
//$pdf->Rect($x + $w[0] + $w[1] + $w[2], $yst, $w[3], $ylst);
//$pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3], $yst, $w[4], $ylst);
//$pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4], $yst, $w[5], $ylst);
//$pdf->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5], $yst, $w[6], $ylst);


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell($w[0], 4, 'Jumlah periode ini', '');
$pdf->Cell($w[1], 4, '', '', 0, 'C');
$pdf->Cell($w[2], 4, '', '', 0, 'R');
$pdf->Cell($w[3], 4, '', '', 0, 'R');
$pdf->Cell($w[4], 4, number_format($totaldb, 2, ',', '.'), '', 0, 'R');
$pdf->Cell($w[5], 4, number_format($totalkr, 2, ',', '.'), '', 0, 'R');
$pdf->Cell($w[6], 4, '', '', 0, 'R'); // number_format($totalsaldo, 2, ',', '.')
$pdf->ln();

$pdf->setxy($x, $pdf->GetY());
$pdf->SetFont('Arial', '', 7);
$pdf->Cell($w[0], 4, 'Jumlah sampai periode lalu', '');
$pdf->Cell($w[1], 4, '', '', 0, 'C');
$pdf->Cell($w[2], 4, '', '', 0, 'R');
$pdf->Cell($w[3], 4, '', '', 0, 'R');
$pdf->Cell($w[4], 4, number_format($totaldbLalu, 2, ',', '.'), '', 0, 'R');
$pdf->Cell($w[5], 4, number_format($totalkrLalu, 2, ',', '.'), '', 0, 'R');
$pdf->Cell($w[6], 4, '', '', 0, 'R'); // number_format($totalsaldo, 2, ',', '.')
$pdf->ln();

$pdf->setxy($x, $pdf->GetY());
$pdf->SetFont('Arial', '', 7);
$pdf->Cell($w[0], 4, 'Jumlah semua sampai periode ini', '');
$pdf->Cell($w[1], 4, '', '', 0, 'C');
$pdf->Cell($w[2], 4, '', '', 0, 'R');
$pdf->Cell($w[3], 4, '', '', 0, 'R');
$totalSdInidb = ($totaldb + $totaldbLalu);
$pdf->Cell($w[4], 4, number_format($totalSdInidb, 2, ',', '.'), 'B', 0, 'R');
$totalSdInikr = ($totalkr + $totalkrLalu);
$pdf->Cell($w[5], 4, number_format($totalSdInikr, 2, ',', '.'), 'B', 0, 'R');
$pdf->Cell($w[6], 4, '', '', 0, 'R'); // number_format($totalsaldo, 2, ',', '.')
$pdf->ln();


$pdf->setxy($x, $pdf->GetY());
$pdf->SetFont('Arial', '', 7);
$pdf->Cell($w[0], 4, 'Sisa Kas', '');
$pdf->Cell($w[1], 4, '', '', 0, 'C');
$pdf->Cell($w[2], 4, '', '', 0, 'R');
$pdf->Cell($w[3], 4, '', '', 0, 'R');
$pdf->Cell($w[4], 4, '', '', 0, 'R');
$pdf->Cell($w[5], 4, '', '', 0, 'R');
$pdf->Cell($w[6], 4, number_format($totalsaldo, 2, ',', '.'), '', 0, 'R');
$pdf->ln();


$ysisa = $y;
$i++;

$pdf->ln();

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($pdf->GetY() > ($pdf->GetPageHeight() - 70)) {
    $pdf->AddPage();
}

// //Menampilkan tanda tangan
$pdf->SetXY($x, $pdf->GetY());
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(150, 5, 'Pada hari ini tanggal ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'L', 0);
$pdf->SetXY($x, $pdf->GetY());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(150, 5, 'Saldo Kas di Bendahara Penerimaan/Bendahara Penerimaan Pembantu adalah Rp ' . number_format($totalsaldo, 2, ',', '.'), '', 'L', 0);
$pdf->SetXY($x, $pdf->GetY());
$pdf->SetFont('Arial', 'I', 8);
$pdf->MultiCell(150, 5, '(' . $pdf->terbilang($totalsaldo) . " rupiah)", '', 'L', 0);
$pdf->SetXY($x, $pdf->GetY());

//Menampilkan tanda tangan
$y = $pdf->gety() + 6;
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
$pdf->MultiCell(90, 5, 'Bendahara Penerimaan', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(115, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(115, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(115);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganBendahara ? $penandatanganBendahara->NIP_pjb : ''), '', 'C', 0);


// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($pdf->GetY() > ($pdf->GetPageHeight() - 30)) {
    $pdf->AddPage();
}

$y = $pdf->GetY();

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
