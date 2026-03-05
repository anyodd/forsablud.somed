<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

class PDF extends fpdf
{
    const Y_LIMIT = 185;

    public $model, $tgl_2;

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

$pdf->setModel($model);
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage('P', [216, 330]);
$pdf->SetMargins(25, 25, 25); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 25); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();

//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 16, 16, '');
$pdf->Image(Tbsub::first()->getLogoImageRs(), 180, 14.5, 16, 16, '');

$x = $left = 10;

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, 'LAPORAN PERUBAHAN SALDO ANGGARAN LEBIH', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Per ' . $pdf->tanggalTerbilang($tgl_2, 1) . ' dan ' . (Tahun() - 1), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->MultiCell(150, 4, "", '', 'C', 0);

//content
$w = [30, 7, 262]; // Tentukan width masing-masing kolom 187
$y = $pdf->GetY() + 7;
$pdf->SetFont('Arial', '', 8);

//mulai content untuk skpd sampai dengan subunit
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

$pdf->ln();
$w = [135, 30, 30]; // Tentukan width masing-masing kolom

$pdf->breakPageTableHeader($left, $w);

$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
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

$pdf->ln();

$akumulasi_grup_1_1_real = $akumulasi_grup_1_1_realx0 = $akumulasi_grup_1_2_real = $akumulasi_grup_1_2_realx0 = 0;
$akumulasi_grup_2_real = $akumulasi_grup_2_realx0  = $akumulasi_grup_3_real = $akumulasi_grup_3_realx0 = 0;
$subtotal_real = $subtotal_realX0 = $kdgrup1_sebelum = 0;

foreach ($model['data']['lpsal'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[0], 5, $data->Nm_Grup_2),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, number_format($data->Realisasi, 0, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, number_format($data->RealisasiX0, 0, ',', '.')),
    );
    $y = MAX($y1, $y2, $y3, $y + 5);

    if (($data->Kd_Grup_1 == 2) && ($kdgrup1_sebelum != $data->Kd_Grup_1)) {
        $subtotal_real = $akumulasi_grup_1_1_real - $akumulasi_grup_1_2_real;
        $subtotal_realx0 = $akumulasi_grup_1_1_realx0 - $akumulasi_grup_1_2_realx0;
        $pdf->SetFont('Arial', 'B', 8);
        //new data
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 5, '       SubTotal', 'LR', 'L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[0];

        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[1], 5, number_format($subtotal_real, 2, ',', '.'), 'LR', 'R');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];

        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[2], 5, number_format($subtotal_realx0, 2, ',', '.'), 'LR', 'R');
        $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[2];

        $pdf->SetXY($xcurrent, $y);

        $ysisa = $y;

        // $i++; //Untuk urutan nomor
        $pdf->ln();
        $y = $y + 5;
    }

    if (($data->Kd_Grup_1 == 3) && ($kdgrup1_sebelum != $data->Kd_Grup_1)) {
        $subtotal_real = $subtotal_real + $akumulasi_grup_2_real;
        $subtotal_realx0 = $subtotal_realx0 + $akumulasi_grup_2_realx0;
        $pdf->SetFont('Arial', 'B', 8);
        //new data
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 5, '       SubTotal', 'LR', 'L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[0];

        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[1], 5, number_format($subtotal_real, 2, ',', '.'), 'LR', 'R');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];

        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[2], 5, number_format($subtotal_realx0, 2, ',', '.'), 'LR', 'R');
        $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[2];

        $pdf->SetXY($xcurrent, $y);

        $ysisa = $y;

        // $i++; //Untuk urutan nomor
        $pdf->ln();
        $y = $y + 5;
    }

    $pdf->SetFont('Arial', '', 8);
    //new data
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, $data->Nm_Grup_2, 'LR', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[0];

    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, number_format($data->Realisasi, 2, ',', '.'), 'LR', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];

    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, number_format($data->RealisasiX0, 2, ',', '.'), 'LR', 'R');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];

    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    // $i++; //Untuk urutan nomor
    $pdf->ln();

    if (($data->Kd_Grup_1 == 1) && ($data->Kd_Grup_2 == 1)) {
        $akumulasi_grup_1_1_real += $data->Realisasi;
        $akumulasi_grup_1_1_realx0 += $data->RealisasiX0;
    }
    if (($data->Kd_Grup_1 == 1) && ($data->Kd_Grup_2 == 2)) {
        $akumulasi_grup_1_2_real += $data->Realisasi;
        $akumulasi_grup_1_2_realx0 += $data->RealisasiX0;
    }
    if ($data->Kd_Grup_1 == 2) {
        $akumulasi_grup_2_real += $data->Realisasi;
        $akumulasi_grup_2_realx0 += $data->RealisasiX0;
    }
    if ($data->Kd_Grup_1 == 3) {
        $akumulasi_grup_3_real += $data->Realisasi;
        $akumulasi_grup_3_realx0 += $data->RealisasiX0;
    }
    $kdgrup1_sebelum = $data->Kd_Grup_1;
}
//akhir loop

$y = $y + 5;
$subtotal_real = $subtotal_real + $akumulasi_grup_3_real;
$subtotal_realx0 = $subtotal_realx0 + $akumulasi_grup_3_realx0;
$pdf->SetFont('Arial', 'B', 8);
//new data
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 5, '       Saldo Anggaran Lebih Akhir', 'LRB', 'L');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[0];

$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 5, number_format($subtotal_real, 2, ',', '.'), 'LRB', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];

$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 5, number_format($subtotal_realx0, 2, ',', '.'), 'LRB', 'R');
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];

$pdf->SetXY($xcurrent, $y);

$ysisa = $y;

// $i++; //Untuk urutan nomor
$pdf->ln();
$y = $y + 5;

$ytandatangan = $y;
//$y = $y + 5;


// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 50)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}


// Menampilkan tanda tangan
$y = $pdf->gety() + 6;
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

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
