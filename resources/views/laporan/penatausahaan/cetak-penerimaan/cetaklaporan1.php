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
        //Lampiran
        // $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(12, -45);
        $xcurrent = 12;
        $this->SetXY($xcurrent, -35);
        $this->MultiCell(20, 4, "Lembar Asli", '', 'L', 0);
        $this->SetXY($xcurrent, -35);
        $this->SetFont('Arial', '', 8);
        $xcurrent = $xcurrent + 16;
        $this->SetXY($xcurrent, -35);
        $this->MultiCell(5, 4, " : ", '', 'L', 0);
        $this->SetXY($xcurrent, -35);
        $xcurrent = $xcurrent + 2;
        $this->SetXY($xcurrent, -35);
        $this->MultiCell(152, 4, "Untuk pembayar / penyetor / pihak ketiga", '', 'L', 0);
        $this->SetXY($xcurrent, -35);

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(12, -30);
        $xcurrent = 12;
        $this->SetXY($xcurrent, -30);
        $this->MultiCell(15, 4, "Salinan 1", '', 'L', 0);
        $this->SetXY($xcurrent, -30);
        $this->SetFont('Arial', '', 8);
        $xcurrent = $xcurrent + 16;
        $this->SetXY($xcurrent, -30);
        $this->MultiCell(5, 4, " : ", '', 'L', 0);
        $this->SetXY($xcurrent, -30);
        $xcurrent = $xcurrent + 2;
        $this->SetXY($xcurrent, -30);
        $this->MultiCell(152, 4, "Untuk Bendahara Penerimaan / Bendahara Penerimaan Pembantu", '', 'L', 0);
        $this->SetXY($xcurrent, -30);

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(12, -25);
        $xcurrent = 12;
        $this->SetXY($xcurrent, -25);
        $this->MultiCell(15, 4, "Salinan 2", '', 'L', 0);
        $this->SetXY($xcurrent, -25);
        $this->SetFont('Arial', '', 8);
        $xcurrent = $xcurrent + 16;
        $this->SetXY($xcurrent, -25);
        $this->MultiCell(5, 4, " : ", '', 'L', 0);
        $this->SetXY($xcurrent, -25);
        $xcurrent = $xcurrent + 2;
        $this->SetXY($xcurrent, -25);
        $this->MultiCell(152, 4, "Arsip", '', 'L', 0);
        $this->SetXY($xcurrent, -25);

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
$pdf->SetAutoPageBreak(true, 43); // set bottom margin (boolean auto [, float margin])
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
$pdf->MultiCell(150, 4, strtoupper('Tanda Bukti Pembayaran'), '', 'C', 0);

$y = $pdf->GetY() - 2;
$pdf->SetXY(35, $y);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, '', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->MultiCell(150, 4, strtoupper('Nomor Bukti ') . $model->no_bp, '', 'C', 0);
$pdf->Ln(2);

$y = $pdf->GetY() + 2;

//content
$w = 195; // Tentukan width masing-masing kolom 187

$modelSum = $modelRinc->sum('nilai');
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
$pdf->MultiCell($w, 4, $model->jbt_penandatangan . ' ' . $model->getRefSubunit()->nmsubunit . ' ' . $model->nm_penandatangan, '', 'L', 0);
$y = $pdf->GetY() + 1;

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
// $pdf->MultiCell($w, 4, "Telah menerima uang sebesar Rp " . number_format($modelSum, 2, ',', '.'), '', 'L', 0);
$pdf->MultiCell(41, 4, "Telah menerima uang sebesar ", '', 'L', 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY($left + 43, $y);
$pdf->MultiCell(146, 4, "Rp " . number_format($modelSum, 2, ',', '.'), '', 'L', 0);
$y = $pdf->GetY() + 1;

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
// $pdf->MultiCell($w, 4, "(dengan huruf) " . $pdf->terbilang($modelSum), '', 'L', 0);
$pdf->MultiCell(41, 4, "(dengan huruf) ", '', 'L', 0);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetXY($left + 43, $y);
$pdf->MultiCell(146, 4, $pdf->terbilang($modelSum).' rupiah', '', 'L', 0);
$y = $pdf->GetY() + 1;

$w = [35, 5, 152]; // Tentukan width masing-masing kolom 187

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "dari Nama", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, $model->nama, '', 'L', 0);
$y = $pdf->GetY() + 1;
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, "", '', 'L', 0);

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 7, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0] - 5, 4, "Alamat", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, $model->alamat, '', 'L', 0);
$y = $pdf->GetY() + 1;
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, "", '', 'L', 0);

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left + 2, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "Sebagai pembayaran", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, $model->ketetapan_uraian, '', 'L', 0);
$y = $pdf->GetY() + 1;
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, "", '', 'L', 0);

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
$pdf->SetXY($x, $y3 + 1);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->MultiCell(150, 5, 'TOTAL : Rp ' . number_format($modelSum, 2, ',', '.'), '', 'R', 0);
// $pdf->Ln(2);
$pdf->SetX($x);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 5, 'Tanggal diterima uang : ' . date_indo($model->tgl_bp), '', 'L', 0);
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
$pdf->MultiCell(70, 5, $model->nama, 'B', 'C', 0);
$pdf->SetX(115);

$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, '', '', 'C', 0);
$y = $pdf->GetY() + 6;

//Lampiran
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->SetXY($left, $y + 55);
// $xcurrent = $left;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell(20, 4, "Lembar Asli", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $pdf->SetFont('Arial', '', 8);
// $xcurrent = $xcurrent + 16;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell(5, 4, " : ", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $xcurrent = $xcurrent + 2;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, "Untuk pembayar / penyetor / pihak ketiga", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $y = $pdf->GetY() + 4;

// $pdf->SetFont('Arial', 'B', 8);
// $pdf->SetXY($left, $y + 55);
// $xcurrent = $left;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell(15, 4, "Salinan 1", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $pdf->SetFont('Arial', '', 8);
// $xcurrent = $xcurrent + 12;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell(5, 4, " : ", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $xcurrent = $xcurrent + 2;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, "Untuk Bendahara Penerimaan / Bendahara Penerimaan Pembantu", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $y = $pdf->GetY() + 4;

// $pdf->SetFont('Arial', 'B', 8);
// $pdf->SetXY($left, $y + 55);
// $xcurrent = $left;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell(15, 4, "Salinan 2", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $pdf->SetFont('Arial', '', 8);
// $xcurrent = $xcurrent + 12;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell(5, 4, " : ", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $xcurrent = $xcurrent + 2;
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w[2], 4, "Arsip", '', 'L', 0);
// $pdf->SetXY($xcurrent, $y);
// $y = $pdf->GetY() + 4;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output

//cuma untuk cek paling bawah
// $pdf->SetXY(15, 282);
// $pdf->SetFont('Arial', '', 8);
// $pdf->MultiCell(90, 5, "Mengetahui,", '', 'L', 0);

$pdf->Output();
exit;
