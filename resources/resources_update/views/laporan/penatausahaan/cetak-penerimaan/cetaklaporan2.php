<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

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
        if ($this->model->isDraft()) {
            $this->RotatedText(($this->GetPageWidth() / 2) - 30, ($this->GetPageHeight() / 2) + 30, 'DRAFT USULAN', 45);
        }
    }

    function Footer()
    {
        if ($this->printAsTte) {
            $this->pageFooterTTE();
        } else {
            $this->pageFooterNonTTE();
        }
    }

    function breakPageTableHeader($left, $w)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($left, $this->getY());
        $this->Cell($w[0], 4, 'NO', 'LTR', 0, 'C');
        $this->Cell($w[1], 4, 'KODE REKENING', 'LTR', 0, 'C');
        $this->Cell($w[2], 4, 'URAIAN RINCIAN OBYEK', 'LTR', 0, 'C');
        $this->Cell($w[3], 4, 'JUMLAH (RP)', 'LTR', 0, 'C');
        $this->ln();
    }
}

$model = $providerReturn['data']['model'];
$modelRinc = $providerReturn['data']['modelRinc'];

$pdf = new PDF('P', 'mm', [216, 330]);
$pdf->setModel($model);
$border = 0;
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage('P', [216, 330]);
$pdf->SetMargins(25, 25, 25); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 25); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->setGlobalSetting($providerReturn['refPemda']);

//border heaader lampiran
$pdf->Rect(10, 12, 195, 300, 'D');
$pdf->Rect(10, 12, 195, 21, 'D');

$pdf->Image($providerReturn['refPemda']->getRefPemda->getLogoImageUrl(), 19, 14.5, 16, 16, '');
$left = 10;

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper($providerReturn['refPemda']->pemda->nmpemda), '', 'C', 0);
$pdf->Ln(2);
$pdf->SetXY(35, $pdf->getY());
$pdf->MultiCell(150, 4, strtoupper('Surat Tanda Setoran'), '', 'C', 0);

$y = $pdf->GetY() - 2;
$pdf->SetXY(35, $y);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, '', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->MultiCell(150, 4, strtoupper('(STS)'), '', 'C', 0);
$pdf->Ln(2);

$y = $pdf->GetY() + 2;

//content
$w = 190; // Tentukan width masing-masing kolom 187

$modelSum = $modelRinc->sum('nilai');
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
$pdf->MultiCell(90, 4, 'STS No. ' . $model->no_sts, '', 'L', 0);
$pdf->SetXY($left + 92, $y);
$pdf->MultiCell(97, 4, 'Bank               : ' . $model->getRefBank()->bank_nm, '', 'L', 0);

// $pdf->SetXY($left + 2, $y);
// $pdf->MultiCell($w, 4, 'STS No. ' . $model->no_sts, '', 'L', 0);

$y = $pdf->GetY() + 1;

$modelSum = $modelRinc->sum('nilai');
// $pdf->SetFont('Arial', '', 8);
// $pdf->SetXY($left + 2, $y);
// $pdf->MultiCell($w, 4, 'Bank : ' . $model->getRefBank()->bank_nm, '', 'L', 0);
// $y = $pdf->GetY() + 1;

$modelSum = $modelRinc->sum('nilai');
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 92, $y);
$pdf->MultiCell($w, 4, 'No. Rekening : ' . $model->getRefBank()->bank_rek, '', 'L', 0);
$y = $pdf->GetY() + 1;

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
// $pdf->MultiCell($w, 4, "Harap diterima uang sebesar Rp " . number_format($modelSum, 2, ',', '.'), '', 'L', 0);
$pdf->MultiCell(39, 4, "Harap diterima uang sebesar ", '', 'L', 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY($left + 41, $y);
$pdf->MultiCell(148, 4, "Rp " . number_format($modelSum, 2, ',', '.'), '', 'L', 0);

$y = $pdf->GetY() + 1;

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
// $pdf->MultiCell($w, 4, "(dengan huruf) " . $pdf->terbilang($modelSum), '', 'L', 0);
$pdf->MultiCell(39, 4, "(dengan huruf) ", '', 'L', 0);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetXY($left + 41, $y);
$pdf->MultiCell(148, 4, $pdf->terbilang($modelSum).' rupiah', '', 'L', 0);

$y = $pdf->GetY() + 1;

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
$pdf->MultiCell($w, 4, "Dengan rincian penerimaan sebagai berikut: ", '', 'L', 0);
$y = $pdf->GetY() + 1;

$pdf->ln(5);

$w = [10, 38, 117, 30]; // Tentukan width masing-masing kolom 300

$pdf->breakPageTableHeader($left, $w);

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 10;
$i = 1;

$ysisa = $y1;

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

$y = $yRectBegin = $y;

foreach ($modelRinc as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->entity_code),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $data->nama_rekening)
    );

    $y = MAX($y1, $y2, $y3);

    if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
        $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        $pdf->breakPage($x, $w, $yst, $ylst);
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $ysisa = $y1;
    }

    $y = MAX($y1, $y2, $y3);

    //new data
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY($x, $y);
    $xCurrent = $x;
    $pdf->MultiCell($w[0], 4, $i, '', 'C');
    $xCurrent = $xCurrent + $w[0];
    $pdf->SetXY($xCurrent, $y);
    $pdf->MultiCell($w[1], 4, $data->entity_code, '', 'C');
    $y2 = $pdf->GetY();
    $xCurrent = $xCurrent + $w[1];
    $pdf->SetXY($xCurrent + 6, $y);
    $pdf->MultiCell($w[2] - 6, 4, $data->nama_rekening, '', 'L');
    $y3 = $pdf->GetY();
    $xCurrent = $xCurrent + $w[2];
    $pdf->SetXY($xCurrent, $y);
    $pdf->MultiCell($w[3], 4, number_format($data->nilai, 2, ',', '.'), '', 'R');

    // $jumlahSpm += $data->nilai;

    $ysisa = $y;
    $i++;

    $pdf->ln();
}

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

$y = $yRectBegin = $y;

// $y = $pdf->GetY();

//new data
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 4, '', 'LB', 'C');
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, '', 'B', 'C');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, 'JUMLAH', 'BR', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 4, number_format($modelSum, 2, ',', '.'), 'BR', 'R');
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];

// //Menampilkan tanda tangan
$pdf->SetXY($x, $y3 + 3);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->MultiCell(150, 5, 'JUMLAH : Rp ' . number_format($modelSum, 2, ',', '.'), '', 'R', 0);
// $pdf->Ln(2);
$pdf->SetX($x);
$pdf->SetFont('Arial', '', 8);
// $pdf->MultiCell(0, 5, 'Uang tersebut diterima pada tanggal : ' . date_indo($model->tgl_sts), '', 'C', 0);
$pdf->MultiCell(99, 5, 'Uang tersebut diterima pada tanggal : ', '', 'R', 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY($x + 96, $pdf->gety() - 5);
$pdf->MultiCell(98, 5, date_indo($model->tgl_sts), '', 'L', 0);
$y = $pdf->GetY() + 3;

$pdf->SetXY(15, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, "Mengetahui,", '', 'C', 0);
$pdf->SetXY(15, $pdf->gety());
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $model->jbt_penandatangan, '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(25, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(15, $pdf->gety() + 5);
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(25, $pdf->gety());
$pdf->MultiCell(70, 5, $model->nm_penandatangan, 'B', 'C', 0);
$pdf->SetX(15);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, 'NIP. ' . $model->nip_penandatangan, '', 'C', 0);
$pdf->SetXY(115, $y);
$pdf->MultiCell(90, 5, '', '', 'C', 0);
$pdf->SetXY(115, $pdf->gety());
$pdf->MultiCell(90, 5, 'Pembayar / Penyetor', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(115, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(125, $pdf->gety() + 5);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(70, 5, '', 'B', 'C', 0);
$pdf->SetX(115);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, 'NIP. ', '', 'C', 0);
$pdf->SetX(115);

$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, '', '', 'C', 0);
$y = $pdf->GetY() + 6;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
