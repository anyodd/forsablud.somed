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
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 8, 'URAIAN', 'LTB', 0, 'C');
        $this->Cell($w[1], 8, Tahun(), 'LTRB', 0, 'C');
        $this->Cell($w[2], 8, (Tahun() - 1), 'LTRB', 0, 'C');
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
$pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->MultiCell(150, 4, 'NERACA SAP', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Per ' . $pdf->tanggalTerbilang($tgl_2, 1) . ' dan ' . (Tahun() - 1), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() + 4));
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
// $w = [10, 16, 43, 26, 70, 30]; // Tentukan width masing-masing kolom
$w = [135, 30, 30]; // Tentukan width masing-masing kolom
//jumlah 69 26 100 = 195

$pdf->breakPageTableHeader($left, $w);

$baris1 = $y1 = $pdf->GetY() + 4; // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$kdrek1 = $kdrek2 = $kdrek3 = $nmrek1 = $nmrek2 = null;
$i = 1;

$ysisa = $y1;

$totalRek1 = $totalRek2 = $totalAset = $totalKewajiban = $totalEkuitas = $totalKewajibanEkuitas = 0;
$totalRek1Awal = $totalRek2Awal = $totalAsetAwal = $totalKewajibanAwal = $totalEkuitasAwal = $totalKewajibanEkuitasAwal = 0;

foreach ($model['data']['neraca'] as $data) {

    if ($kdrek1 != $data->kdrek1) {

        $yMaxAfter = max(
            $pdf->getY() + $pdf->GetMultiCellHeight($w[0], 5, $data->nmrek1),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->nmrek1)
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

        if ($kdrek1 != null) {
            $pdf->SetFont('Arial', '', 8);
            //new data
            $xcurrent = $x;
            $pdf->SetXY($x + 5, $y);
            $pdf->MultiCell($w[0] - 4, 5, strtoupper('Jumlah ' .  $nmrek2), '', 'L');
            $xcurrent = $xcurrent + $w[0];
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalRek2), 'BT', 'R');
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $xcurrent = $xcurrent + $w[1];
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($totalRek2Awal), 'BT', 'R');
            $y2 = $pdf->GetY();
            $xcurrent = $xcurrent + $w[2];
            $pdf->SetXY($xcurrent, $y);

            $ysisa = $y;

            $i++; //Untuk urutan nomor
            $pdf->ln();

            $y = MAX($y1, $y2, $y3);


            $pdf->SetFont('Arial', 'B', 8);
            //new data
            $xcurrent = $x;
            $pdf->SetXY($x + 20, $y);
            $pdf->MultiCell($w[0] - 20, 5, strtoupper('Jumlah ' .  $nmrek1), '', 'L');
            $xcurrent = $xcurrent + $w[0];
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalRek1), 'BT', 'R');
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $xcurrent = $xcurrent + $w[1];
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($totalRek1Awal), 'BT', 'R');
            $y2 = $pdf->GetY();
            $xcurrent = $xcurrent + $w[2];
            $pdf->SetXY($xcurrent, $y);

            $ysisa = $y;

            $i++; //Untuk urutan nomor
            $pdf->ln();

            $y = MAX($y1, $y2, $y3);
        }

        $kdrek1 = $kdrek2 = $kdrek3 = $nmrek1 = $nmrek2 = null;

        $pdf->SetFont('Arial', 'B', 8);
        //new data
        $xcurrent = $x;
        $pdf->SetXY($x + 2, $y);
        $pdf->MultiCell($w[0] - 2, 5, $data->nmrek1, '', 'L');
        $xcurrent = $xcurrent + $w[0];
        $pdf->SetXY($xcurrent + 2, $y);
        $pdf->MultiCell($w[1] - 2, 5, '', '', 'L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[2], 5, '', '', 'R'); // $pdf->accountingNumberFormat($data->anggaran_program)
        $y2 = $pdf->GetY();
        $xcurrent = $xcurrent + $w[2];
        $pdf->SetXY($xcurrent, $y);

        $ysisa = $y;

        $i++; //Untuk urutan nomor
        $pdf->ln();

        $totalRek1 = $totalRek1Awal = 0;
    }

    if ($kdrek2 != $data->kdrek1 . '.' . $data->kdrek2) {

        $yMaxAfter = max(
            $pdf->getY() + $pdf->GetMultiCellHeight($w[0], 5, $data->nmrek2),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->nmrek2),
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

        if ($kdrek2 != null) {
            $pdf->SetFont('Arial', '', 8);
            //new data
            $xcurrent = $x;
            $pdf->SetXY($x + 5, $y);
            $pdf->MultiCell($w[0] - 5, 5, strtoupper('Jumlah ' .  $nmrek2), '', 'L');
            $xcurrent = $xcurrent + $w[0];
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalRek2), 'BT', 'R');
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $xcurrent = $xcurrent + $w[1];
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($totalRek2Awal), 'BT', 'R');
            $y2 = $pdf->GetY();
            $xcurrent = $xcurrent + $w[2];
            $pdf->SetXY($xcurrent, $y);

            $ysisa = $y;

            $i++; //Untuk urutan nomor
            $pdf->ln();

            $y = MAX($y1, $y2, $y3);
        }

        $pdf->SetFont('Arial', '', 8);
        //new data
        $xcurrent = $x;
        $pdf->SetXY($x + 5, $y);
        $pdf->MultiCell($w[0] - 5, 5, $data->nmrek2, '', 'L');
        $xcurrent = $xcurrent + $w[0];
        $pdf->SetXY($xcurrent + 2, $y);
        $pdf->MultiCell($w[1] - 2, 5, '', '', 'R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];
        $pdf->SetXY($xcurrent + 2, $y);
        $pdf->MultiCell($w[2] - 2, 5, '', '', 'R'); // $pdf->accountingNumberFormat($data->anggaran_kegiatan)
        $y2 = $pdf->GetY();
        $xcurrent = $xcurrent + $w[2];
        $pdf->SetXY($xcurrent, $y);

        $ysisa = $y;

        $i++; //Untuk urutan nomor
        $pdf->ln();

        $totalRek2 = $totalRek2Awal = 0;
    }

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[0], 5, $data->nmrek3),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $pdf->accountingNumberFormat($data->saldo_awal))
    );

    $y = MAX($y1, $y2, $y3);

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
    $xcurrent = $x;
    $pdf->SetXY($x + 7, $y);
    $pdf->MultiCell($w[0] - 7, 5, $data->nmrek3, '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($data->saldo_akhir), '', 'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($data->saldo_awal), '', 'R');
    $y2 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $totalRek1 += $data->saldo_akhir;
    $totalRek2 += $data->saldo_akhir;
    if ($data->kdrek1 == 1) $totalAset += $data->saldo_akhir;
    if ($data->kdrek1 == 2) {
        $totalKewajiban += $data->saldo_akhir;
        $totalKewajibanEkuitas += $data->saldo_akhir;
    }
    if ($data->kdrek1 == 3) {
        $totalEkuitas += $data->saldo_akhir;
        $totalKewajibanEkuitas += $data->saldo_akhir;
    }

    $totalRek1Awal += $data->saldo_awal;
    $totalRek2Awal += $data->saldo_awal;
    if ($data->kdrek1 == 1) $totalAsetAwal += $data->saldo_awal;
    if ($data->kdrek1 == 2) {
        $totalKewajibanAwal += $data->saldo_awal;
        $totalKewajibanEkuitasAwal += $data->saldo_awal;
    }
    if ($data->kdrek1 == 3) {
        $totalEkuitasAwal += $data->saldo_awal;
        $totalKewajibanEkuitasAwal += $data->saldo_awal;
    }

    $kdrek1 = $data->kdrek1;
    $kdrek2 = $data->kdrek1 . '.' . $data->kdrek2;
    $nmrek1 = $data->nmrek1;
    $nmrek2 = $data->nmrek2;
}

$y = max($y1, $y2, $y3);

if ($kdrek1 != null) {
    $pdf->SetFont('Arial', '', 8);
    //new data
    $xcurrent = $x;
    $pdf->SetXY($x + 5, $y);
    $pdf->MultiCell($w[0] - 5, 5, strtoupper('Jumlah ' .  $nmrek2), '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalRek2), 'BT', 'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($totalRek2Awal), 'BT', 'R');
    $y2 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $y = MAX($y1, $y2, $y3);


    $pdf->SetFont('Arial', 'B', 8);
    //new data
    $xcurrent = $x;
    $pdf->SetXY($x + 20, $y);
    $pdf->MultiCell($w[0] - 20, 5, strtoupper('Jumlah ' .  $nmrek1), '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalRek1), 'BT', 'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($totalRek1Awal), 'BT', 'R');
    $y2 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $y = MAX($y1, $y2, $y3);
}

if ($kdrek1 != 1) {

    $pdf->SetFont('Arial', 'B', 8);
    //new data
    $xcurrent = $x;
    $pdf->SetXY($x + 20, $y);
    $pdf->MultiCell($w[0] - 20, 5, strtoupper('Jumlah Kewajiban dan Ekuitas'), '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalKewajibanEkuitas), 'BT', 'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, $pdf->accountingNumberFormat($totalKewajibanEkuitasAwal), 'BT', 'R');
    $y2 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $y = MAX($y1, $y2, $y3);
}

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);


$y = $y + 6;


// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 52)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

// Menampilkan tanda tangan
$y = $pdf->gety()+6;
$pdf->SetXY(125, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
$pdf->SetXY(125, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Pimpinan BLUD', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(125, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(125, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(125);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganPimpinan ? $penandatanganPimpinan->NIP_pjb : ''), '', 'C', 0);


$y = $pdf->GetY();

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
