<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

class PDF extends fpdf
{
    const Y_LIMIT = 185;

    public $model, $tgl_1, $tgl_2;

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
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 8, 'KODE REKENING', 'LTB', 0, 'C');
        $this->Cell($w[1], 8, 'URAIAN', 'LTB', 0, 'C');
        $this->Cell($w[2], 8, 'DEBET', 'LTB', 0, 'C');
        $this->Cell($w[3], 8, 'KREDIT', 'LTRB', 0, 'C');
        $this->ln();
    }
}

$pdf = new PDF('P', 'mm', [216, 330]);
$border = 0;
//$pdf->setModel($model);
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage('P', [216, 330]);
$pdf->SetMargins(25, 25, 25); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 25); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();

$x = $left = 10;

//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 16, 16, '');
$pdf->Image(Tbsub::first()->getLogoImageRs(), 180, 14.5, 16, 16, '');

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, 'DAFTAR SALDO BUKU BESAR', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Periode ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->MultiCell(290, 4, "", '', 'C', 0);

//content
$w = [30, 7, 262]; // Tentukan width masing-masing kolom 187
$y = $pdf->GetY() + 7;
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


$pdf->ln(1);
$w = [32, 103, 30, 30]; // Tentukan width masing-masing kolom
//jumlah 69 26 100 = 195

$pdf->breakPageTableHeader($left, $w);

$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$y4 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$total = 0;
$lastDate = $lastNoBukti = null;
$totaldebet = $totalkredit = 0;

foreach ($model['data']['daftarsaldobukubesar'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[0], 5, $data->koderekening),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->uraian),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, number_format($data->debet, 0, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, number_format($data->kredit, 0, ',', '.')),
    );

    $y = MAX($y1, $y2, $y3, $y4);

    if ($yMaxAfter > 290) {
        $ylst = 305 - $yst; //207 batas margin bawah dikurang dengan y pertama
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
        $y4 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = $left;
        $ysisa = $y1;
        $y = MAX($y1, $y2, $y3);
    }

    //new data
    $pdf->SetXY($x, $y);
    $xcurrent = $x;

    $pdf->SetFont('Arial', '', 7);

    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[0];

    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, $data->uraian, '', 'L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];

    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell(($data->debet < 0 ? $w[2] + 0.5 : $w[2]), 4, $pdf->accountingNumberFormat($data->debet), '', 'R');
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell(($data->kredit < 0 ? $w[3] + 0.5 : $w[3]), 4, $pdf->accountingNumberFormat($data->kredit), '', 'R');
    $xcurrent = $xcurrent + $w[3];

    $pdf->SetXY($xcurrent, $y);
    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $totaldebet += $data->debet;
    $totalkredit += $data->kredit;
}

$y = max($y1, $y2, $y3);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell($w[0], 5, '', 'LB');
$pdf->Cell($w[1], 5, 'JUMLAH', 'BR', 0, 'R');
$pdf->Cell($w[2], 5, number_format($totaldebet, 2, ',', '.'), 'BR', 0, 'R');
$pdf->Cell($w[3], 5, number_format($totalkredit, 2, ',', '.'), 'BR', 0, 'R');
$pdf->ln();

$y = $y + 6;

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 50)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

// // Menampilkan tanda tangan
// $y = $pdf->gety() + 6;
// $pdf->SetXY(125, $y);
// $pdf->SetFont('Arial', '', 8);
// $pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
// $pdf->SetXY(125, $pdf->gety());
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->MultiCell(90, 5, 'Pimpinan BLUD', '', 'C', 0);
// $pdf->Ln(3);
// $pdf->SetXY(125, $pdf->gety());
// $pdf->MultiCell(90, 5, "", '', 'C', 0);
// $pdf->SetXY(125, $pdf->gety() + 5);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->MultiCell(90, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'C', 0);
// $pdf->SetX(125);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganPimpinan ? $penandatanganPimpinan->NIP_pjb : ''), '', 'C', 0);

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
