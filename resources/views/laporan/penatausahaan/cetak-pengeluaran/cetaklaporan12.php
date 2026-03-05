<?php

use App\ExtendedClass\FpdfExtended as fpdf;
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
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 12, 'NO', 'LBT', 0, 'C');
        $this->Cell($w[1] + $w[2] + $w[3], 6, 'S-PPD', 'LBTR', 0, 'C');
        $this->Cell($w[4] + $w[5], 6, 'S-OPD', 'LBTR', 0, 'C');
        $this->Cell($w[6] + $w[7], 6, 'S-PD', 'LBTR', 0, 'C');

        $this->ln();
        $this->SetXY($left + $w[0], $this->GetY());
        $this->Cell($w[1], 6, 'TANGGAL', 'LBTR', 0, 'C');
        $this->Cell($w[2], 6, 'NOMOR', 'LBTR', 0, 'C');
        $this->Cell($w[3], 6, 'JUMLAH', 'LBTR', 0, 'C');
        $this->Cell($w[4], 6, 'TANGGAL', 'LBTR', 0, 'C');
        $this->Cell($w[5], 6, 'NOMOR', 'LBTR', 0, 'C');
        $this->Cell($w[6], 6, 'TANGGAL', 'LBTR', 0, 'C');
        $this->Cell($w[7], 6, 'NOMOR', 'LBTR', 0, 'C');
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
$pdf->MultiCell(290, 4, "REGISTER S-PPD s.d S-PD (UP, GU, LS)", '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(290, 4, 'Periode ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(300, 6, '', 'B', 'C', 0);

//content
$w = [28, 150]; // bagi menjadi 2 bagian

$pdf->ln(5);
$w = [15, 18, 67, 30, 18, 67, 18, 67]; // Tentukan width masing-masing kolom
$pdf->breakPageTableHeader($left, $w);


$y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;
$total = 0;
$lastDate = $lastNoBukti = null;

foreach ($model['data']['registerSp2d'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->spp_tgl),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $data->spp_no),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, number_format($data->nilai, 0, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 5, $data->spm_tgl),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[5], 5, $data->spm_no),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[6], 5, $data->sp2d_tgl),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[7], 5, $data->sp2d_no)
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
    $pdf->SetTextColor(0, 0, 0);

    if ($data->kode != 3) $pdf->SetTextColor(194, 8, 8);
    //new data		
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 4, $i, '', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, $lastDate != $data->spp_tgl ? date('d-m-Y', strtotime($data->spp_tgl)) : '', '', 'C');
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, $data->spp_no, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, number_format($data->nilai, 0, ',', '.'), '', 'R');
    $y2 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 4, $data->spm_tgl ? date('d-m-Y', strtotime($data->spm_tgl)) : '', '', 'C');
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 4, $data->spm_no, '', 'L');
    $y3 = $pdf->GetY();
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 4, $data->sp2d_tgl ? date('d-m-Y', strtotime($data->sp2d_tgl)) : '', '', 'C');
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[7], 4, $data->sp2d_no, '', 'L');
    $xcurrent = $xcurrent + $w[7];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $lastDate = $data->spp_tgl;
    $lastNoBukti = $data->spp_no;
    $total += $data->nilai;
}
$y = max($y1, $y2);


//membuat kotak di halaman terakhir
// $y = $pdf->gety();
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell($w[0], 6, '', 'LB');
$pdf->Cell($w[1], 6, '', 'LB', 0, 'C');
$pdf->Cell($w[2], 6, 'TOTAL', 'BL', 0, 'R');
$pdf->Cell($w[3], 6, number_format($total, 0, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[4], 6, '', 'BL', 0, 'R');
$pdf->Cell($w[5], 6, '', 'BL', 0, 'R');
$pdf->Cell($w[6], 6, '', 1, 0, 'R');
$pdf->Cell($w[7], 6, '', 1, 0, 'R');

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
