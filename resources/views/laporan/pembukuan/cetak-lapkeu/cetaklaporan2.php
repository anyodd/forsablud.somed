<?php

use App\ExtendedClass\FpdfExtended;
use App\Models\Tbsub;

class PDF extends FpdfExtended
{
    const Y_LIMIT = 190;

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
        $this->SetXY($left, $this->getY());
        $this->Cell($w[0], 8, 'NO', 'LT', 0, 'C');
        $this->Cell($w[1], 8, 'TANGGAL', 'LTR', 0, 'C');
        $this->Cell($w[2], 8, 'NO. BUKTI', 'LTR', 0, 'C');
        $this->Cell($w[3], 8, 'REKENING', 'LTR', 0, 'C');
        $this->Cell($w[4], 8, 'URAIAN', 'LTR', 0, 'C');
        $this->Cell($w[5], 8, 'REF', 'LTR', 0, 'C');
        $this->Cell($w[6], 8, 'DEBET', 'LTR', 0, 'C');
        $this->Cell($w[7], 8, 'KREDIT', 'LTR', 0, 'C');

        $this->ln();
    }
}

//menugaskan variabel $pdf pada function fpdf().
$pdf = new PDF('L', 'mm', [216, 330]);
$pdf->setModel($model);

//$dataProvider = $providerReturn['data']['dataProvider'];
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini.
//P artinya potrait dan L artinya Landscape
//cara menambahkan image dalam dokumen.
//Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukuran high -
//menambahkan link bila perlu

$border = 0;
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage();
$pdf->SetMargins(15, 10, 15); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 10); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();

$x = 15;
$left = 15;
// Kotak Full Halaman
$pdf->Rect($x, 10, 300, 186);

//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
// $pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 20, 20, '');
// $pdf->Image(Tbsub::first()->getLogoImageRs(), 290, 14.5, 20, 20, '');

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, "JURNAL UMUM", '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(290, 4, 'Periode: ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->MultiCell(290, 4, "", '', 'C', 0);

//content
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



// $pdf->MultiCell($w[2], 1, "", '', 'L', 0);
// $pdf->ln(1);

$w = [10, 20, 55, 50, 95, 10, 30, 30]; // Tentukan width masing-masing kolom 300

$pdf->breakPageTableHeader($left, $w);

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$y4 = $pdf->GetY(); //untuk baris berikutnya
$y5 = $pdf->GetY(); //untuk baris berikutnya
$y6 = $pdf->GetY(); //untuk baris berikutnya
$y7 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$i = 1;

$ysisa = $y1;
$totaldebet = $totalkredit = 0;
$lastDate = $lastNoBukti = $lastKeterangan = null;
$buktinoakhir = '';
$rekeningakhir = '';
$nmrek6akhir = '';

foreach ($model['data']['rincianJurnal'] as $data) {

    //untuk nambah last keterangan saat bukti nomor berbeda
    if (($i > 1) && ($lastNoBukti != $data->bukti_no)) {
        $yMaxAfter = max(
            $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 4, $data->bukti_no),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 4, $data->rekening),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 4, $data->nmrek6),
        );


        $y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);

        if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
            $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
            $pdf->breakPage($x, $w, $yst, $ylst);
            $pdf->breakPageTableHeader($left, $w);


            $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $ysisa = $y1;
        }

        $y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);



        //new data
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 4, '', '', 'C');

        $xcurrent = $xcurrent + $w[0];
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[1], 4, '', '', 'C');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[1];
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[2], 4, '', '', 'L');


        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[2];
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[3], 4, '', '', 'L');
        $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[3];
        $pdf->SetFont('Arial', 'I', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[4], 4, '(' . $lastKeterangan . ')', '', 'L');

        $y4 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[4];
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[5], 4, '', '', 'L');
        $y5 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[5];
        $pdf->SetXY($xcurrent, $y);

        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell($w[6], 4, '', '', 'R');
        $y6 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        ///
        $xcurrent = $xcurrent + $w[6];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[7], 4, '', '', 'R');
        $y7 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        ///

        $xcurrent = $xcurrent + $w[7];
        $pdf->SetXY($xcurrent, $y);

        $ysisa = $y;

        // $i++; //Untuk urutan nomor
        $pdf->ln();

        $yMaxAfter = max(
            $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 4, $data->bukti_no),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 4, $data->rekening),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 4, '(' . $lastKeterangan . ')'),
        );
    } else {
        $yMaxAfter = max(
            $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 4, $data->bukti_no),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 4, $data->rekening),
            $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 4, $data->nmrek6),
        );
    }

    //end untuk nambah last keterangan

    $y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);

    if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
        $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        $pdf->breakPage($x, $w, $yst, $ylst);
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $ysisa = $y1;
    }

    $y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);



    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 4, $i, '', 'C');

    $xcurrent = $xcurrent + $w[0];
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, $lastDate != $data->bukti_tgl ? date('d-m-Y', strtotime($data->bukti_tgl)) : '', '', 'C');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

    $xcurrent = $xcurrent + $w[1];
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($xcurrent, $y);
    if ($lastNoBukti == $data->bukti_no) {
        $pdf->MultiCell($w[2], 4, '', '', 'L');
    } else {
        $pdf->MultiCell($w[2], 4, $data->bukti_no, '', 'L');
    }

    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan


    $pdf->SetTextColor(0, 0, 0);



    $xcurrent = $xcurrent + $w[2];
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, $data->rekening, '', 'L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

    $xcurrent = $xcurrent + $w[3];
    $pdf->SetFont('Arial', '', 7);
    if ($data->debet != 0) {
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[4], 4, $data->nmrek6, '', 'L');

        $pdf->SetTextColor(0, 0, 0);

        $y4 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[4];
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[5], 4, '', '', 'L');
        $y5 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[5];
        $pdf->SetXY($xcurrent, $y);

        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell($w[6], 4, number_format($data->debet, 2, ',', '.'), '', 'R');
        $y6 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        ///
        $xcurrent = $xcurrent + $w[6];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[7], 4, '', '', 'R');
        $y7 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        ///
    } else {
        $xcurrent = $xcurrent + 5;
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[4] - 5, 4, $data->nmrek6, '', 'L');
        $xcurrent = $xcurrent - 5;

        $pdf->SetTextColor(0, 0, 0);

        $y4 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[4];
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[5], 4, '', '', 'L');
        $y5 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        $xcurrent = $xcurrent + $w[5];
        $pdf->SetXY($xcurrent, $y);

        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell($w[6], 4, '', '', 'R');
        $y6 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

        ///
        $xcurrent = $xcurrent + $w[6];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[7], 4, number_format($data->kredit, 2, ',', '.'), '', 'R');
        $y7 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        ///
    }

    $xcurrent = $xcurrent + $w[7];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();
    $lastDate = $data->bukti_tgl;
    $lastNoBukti = $data->bukti_no;
    $lastKeterangan = $data->keterangan;
    $totaldebet += $data->debet;
    $totalkredit += $data->kredit;

    $buktinoakhir = $data->bukti_no;
    $rekeningakhir = $data->rekening;
    $nmrek6akhir = $data->nmrek6;
}

// data keterangan loop terakhir
$yMaxAfter = max(
    $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 4, $buktinoakhir),
    $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 4, $rekeningakhir),
    $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 4, $nmrek6akhir),
);


$y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);

if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
    $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
    $pdf->breakPage($x, $w, $yst, $ylst);
    $pdf->breakPageTableHeader($left, $w);


    $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
    $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
    $ysisa = $y1;
}

$y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);



//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 4, '', '', 'C');

$xcurrent = $xcurrent + $w[0];
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 4, '', '', 'C');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

$xcurrent = $xcurrent + $w[1];
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, '', '', 'L');


$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

$xcurrent = $xcurrent + $w[2];
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 4, '', '', 'L');
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

$xcurrent = $xcurrent + $w[3];
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 4, '(' . $lastKeterangan . ')', '', 'L');

$y4 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

$xcurrent = $xcurrent + $w[4];
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 4, '', '', 'L');
$y5 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell($w[6], 4, '', '', 'R');
$y6 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan

///
$xcurrent = $xcurrent + $w[6];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[7], 4, '', '', 'R');
$y7 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
///

$xcurrent = $xcurrent + $w[7];
$pdf->SetXY($xcurrent, $y);

$ysisa = $y;

// $i++; //Untuk urutan nomor
$pdf->ln();
// end loop terakhir

$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3, $y4, $y5, $y6, $y7);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell($w[0], 5, '', 'LB');
$pdf->Cell($w[1], 5, '', 'B', 0, 'C');
$pdf->Cell($w[2], 5, '', 'B', 0, 'R');
$pdf->Cell($w[3], 5, '', 'B', 0, 'R');
$pdf->Cell($w[4], 5, '', 'B', 0, 'R');
$pdf->Cell($w[5], 5, 'JUMLAH', 'BR', 0, 'R');
$pdf->Cell($w[6], 5, number_format($totaldebet, 2, ',', '.'), 'BR', 0, 'R');
$pdf->Cell($w[7], 5, number_format($totalkredit, 2, ',', '.'), 'BR', 0, 'R');
$pdf->ln();

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
