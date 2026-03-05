<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

class PDF extends fpdf
{
    const Y_LIMIT = 185;

    public $model;
 
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
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY($left, $this->GetY() + 4);
        $this->Cell($w[0], 5, 'KODE PERKIRAAN', 'LTB', 0, 'C');
        $this->Cell($w[1], 5, 'DESKRIPSI PERKIRAAN', 'LTB', 0, 'C');
        $this->Cell($w[2], 5, 'DEBET', 'LTRB', 0, 'C');
        $this->Cell($w[3], 5, 'KREDIT', 'LTRB', 0, 'C');
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
$pdf->MultiCell(150, 4, 'MEMO JURNAL', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Tahun Anggaran ' . Tahun(), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->MultiCell(290, 4, "", '', 'C', 0);

//content
$w = [20, 7, 272]; // Tentukan width masing-masing kolom 187
$y = $pdf->GetY() + 7;
$pdf->SetFont('Arial', 'B', 8);

$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "Nomor", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, $model['data']['bukti_no'], '', 'L', 0);
$y = $pdf->GetY();
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "Tanggal", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, $pdf->tanggalTerbilang($model['data']['bukti_tgl'], 1), '', 'L', 0);
$y = $pdf->GetY();
$pdf->SetXY($xcurrent, $y);


$pdf->ln(1);
$w = [45, 90, 30, 30]; // Tentukan width masing-masing kolom
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

foreach ($model['data']['memo_jurnal'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[0], 5, $data->koderekening),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->nmrek6),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, number_format($data->debet, 0, ',', '.')),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, number_format($data->kredit, 0, ',', '.')),
    );

    $y = MAX($y1, $y2, $y3, $y4);

    // IF($y2 > 295 || $y1 + (5*(strlen($data->uraian)/35)) > 295 ){ //cek pagebreak
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
        $y = MAX($y1, $y2, $y3, $y4);
    }

    $pdf->SetFont('Arial', '', 8);
    //new data
    $pdf->SetXY($x, $y);
    $xcurrent = $x;

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[0];

    if ($data->debet != 0) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[1], 4, $data->nmrek6, '', 'L');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];
    } else {
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($xcurrent + 3, $y);
        $pdf->MultiCell($w[1] - 3, 4, $data->nmrek6, '', 'L');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];
    }

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, number_format($data->debet, 2, ',', '.'), '', 'R');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, number_format($data->kredit, 2, ',', '.'), '', 'R');
    $y4 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];


    $pdf->SetXY($xcurrent, $y);
    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();
}

$y = max($y1, $y2, $y3, $y4);

//membuat kotak di halaman terakhir
$y = max($y1, $y2, $y3, $y4);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 52)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

//content
$w = [20, 7, 168]; // Tentukan width masing-masing kolom 187
// $y=$pdf->GetY()+7;
$ystartpersegi = $y;
$y = $y + 1;

$pdf->SetFont('Arial', '', 8);

$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "Keterangan", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, $model['data']['keterangan'], '', 'L', 0);
$y = $pdf->GetY();
// $xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);

//buat persegi untuk konten di atas
$y = $y + 10;
$ylastpersegi = $y - $ystartpersegi;
$wpinggiranhalaman = [195];
// $wpinggiranhalaman = [20, 7, 168]; // Tentukan width masing-masing kolom 187

$pdf->createBreakPageColumnLine($x, $wpinggiranhalaman, $ystartpersegi, $ylastpersegi);


// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 52)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

//content
$w = [125, 35, 35]; // Tentukan width masing-masing kolom 187
// $y=$pdf->GetY()+7;
$ystartpersegi = $y;
$y = $y + 1;

$pdf->SetFont('Arial', '', 8);

$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "Bukti Pendukung :", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, "Nomor", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, 'Tanggal', '', 'L', 0);
$y = $pdf->GetY();
// $xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "1.", '', 'L', 0);
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "2.", '', 'L', 0);
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "3.", '', 'L', 0);
$y = $pdf->GetY();

//buat persegi untuk konten di atas
$y = $y + 10;
$ylastpersegi = $y - $ystartpersegi;
$wpinggiranhalaman = [195];
$pdf->createBreakPageColumnLine($x, $wpinggiranhalaman, $ystartpersegi, $ylastpersegi);

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 52)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

//content
$w = [105, 45, 45]; // Tentukan width masing-masing kolom 187
// $y=$pdf->GetY()+7;
$ystartpersegi = $y;
$y = $y + 1;

$pdf->SetFont('Arial', '', 8);

$pdf->SetXY($left, $y);
$xcurrent = $left;
$pdf->MultiCell($w[0], 4, "Dicatat Oleh :", '', 'L', 0);
$xcurrent = $xcurrent + $w[0];
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, "Disetujui :", '', 'L', 0);
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, 'Auditor :', '', 'L', 0);
$y = $pdf->GetY();
// $xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);

//buat persegi untuk konten di atas
$y = $y + 20;
$ylastpersegi = $y - $ystartpersegi;
$wpinggiranhalaman = [195];
$pdf->createBreakPageColumnLine($x, $wpinggiranhalaman, $ystartpersegi, $ylastpersegi);


$y = $pdf->GetY();

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
