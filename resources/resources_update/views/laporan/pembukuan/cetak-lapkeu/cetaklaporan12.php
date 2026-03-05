<?php

use App\ExtendedClass\FpdfExtended;
use App\Models\Tbsub;

class PDF extends FpdfExtended
{
    const Y_LIMIT = 186;

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
        $this->SetXY($left, $this->getY());
        $this->Cell($w[0], 8, 'KODE', 'LT', 0, 'C');
        $this->Cell($w[1], 8, 'URAIAN', 'LTR', 0, 'C');
        $this->Cell($w[2], 8, 'SALDO ' . Tahun(), 'LTR', 0, 'C');
        $this->Cell($w[3], 8, 'SALDO ' . (Tahun() - 1), 'LTR', 0, 'C');
        $this->Cell($w[4], 8, 'KENAIKAN/PENURUNAN', 'LTR', 0, 'C');
        $this->Cell($w[5], 8, '(%)', 'LTR', 0, 'C');
        $this->ln();
    }
}

//menugaskan variabel $pdf pada function fpdf().
$pdf = new PDF('L', 'mm', [216, 330]);

$border = 0;
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage();
$pdf->SetMargins(15, 10, 15); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 10); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();

$x = 15;
$left = 15;

//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 16, 16, '');
$pdf->Image(Tbsub::first()->getLogoImageRs(), 295, 14.5, 16, 16, '');

// Kotak Full Halaman
// $pdf->Rect($x, 10, 300, 186);

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() ));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper("LAPORAN OPERASIONAL"), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() ));
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(290, 4, "Untuk tahun yang berakhir sampai dengan " . $pdf->tanggalTerbilang($tgl_2, 1) . " dan " . (Tahun() - 1), '', 'C', 0);
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

$w = [20, 164, 35, 35, 35, 11]; // Tentukan width masing-masing kolom 300

$pdf->breakPageTableHeader($left, $w);

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$i = 1;
$kdkegiatan = $kdprogram = null;
$totalSaldoAwal = $totalPenerimaan = $totalPengeluaran = 0;
$saldotahunini_pendapatanlo = $saldotahunini_beban = 0;
$saldotahunlalu_pendapatanlo = $saldotahunlalu_beban = 0;
$surdefoperasi_tahunini = $surdefoperasi_tahunlalu = $surdefoperasi_kenaikanpenurunan = 0;
$surdefnonoperasi_tahunini = $surdefnonoperasi_tahunlalu = $surdefnonoperasi_kenaikanpenurunan = 0;
$surdefpos_tahunini = $surdefpos_tahunlalu = $surdefpos_kenaikanpenurunan = 0;

$ysisa = $y1;

$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 4, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 4, 'KEGIATAN OPERASIONAL', '', 'L');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell($w[2], 4, '', '', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 4, '', '', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 4, '', '', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);

$pdf->MultiCell($w[5], 4, '', '', 'R');

$ysisa = $y;
$pdf->ln();

foreach ($model['data']['rincianLO'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->uraian),
        0
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

    $pecahkode = explode(".", $data->koderekening);
    $jumlahkode = strlen($data->koderekening);
    if (($pecahkode[0] == '07') && ($jumlahkode == 2)) {
        $saldotahunini_pendapatanlo = $data->saldo_tahun_ini;
        $saldotahunlalu_pendapatanlo = $data->saldo_tahun_lalu;
    }

    if (($pecahkode[0] == '08') && ($jumlahkode == 2)) {
        $saldotahunini_beban = $data->saldo_tahun_ini;
        $saldotahunlalu_beban = $data->saldo_tahun_lalu;
    }

    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    $xcurrent = $xcurrent + $w[0];

    if ($jumlahkode == 2) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetXY($xcurrent + 2, $y);
        $pdf->MultiCell($w[1] - 2, 4, $data->uraian, '', 'L');
        $tb = 'TB';
    } else {
        if ($jumlahkode == 4) {
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetXY($xcurrent + 4, $y);
            $pdf->MultiCell($w[1] - 4, 4, $data->uraian, '', 'L');
            $tb = '';
        } else {
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetXY($xcurrent + 6, $y);
            $pdf->MultiCell($w[1] - 6, 4, $data->uraian, '', 'L');
            $tb = '';
        }
    }

    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', '', 7);
    $pdf->MultiCell($w[2], 4, number_format($data->saldo_tahun_ini, 2, ',', '.'), $tb, 'R');

    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, number_format($data->saldo_tahun_lalu, 2, ',', '.'), $tb, 'R');


    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    if ($data->kenaikan_penurunan < 0) {
        $varbuatan_kenaikan_penurunan = $data->kenaikan_penurunan * -1;
        $pdf->MultiCell($w[4], 4, '(' . number_format($varbuatan_kenaikan_penurunan, 2, ',', '.') . ')', $tb, 'R');
    } else {
        $pdf->MultiCell($w[4], 4, number_format($data->kenaikan_penurunan, 2, ',', '.'), $tb, 'R');
    }

    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);

    // $totalrealisasi1baris=0+$data->nilaiRealisasi;
    if ($data->saldo_tahun_lalu <= 0) {
        $pdf->MultiCell($w[5], 4, '0', $tb, 'R');
    } else {
        $persen = $data->kenaikan_penurunan / $data->saldo_tahun_lalu * 100;
        $pdf->MultiCell($w[5], 4, number_format($persen, 2, ',', '.'), $tb, 'R');
    }

    $ysisa = $y;

    // $totalSaldoAwal += 0;
    // $totalPenerimaan += $data->penerimaan;
    // $totalPengeluaran += $pengeluaran;
    // $koderekening_temp = $data->koderekening;

    $i++; //Untuk urutan nomor
    $pdf->ln();
}

//buat baris untuk surplus defisit operasi

$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
// $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
$pdf->MultiCell($w[0], 5, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 5, 'SURPLUS / DEFISIT DARI OPERASI', '', 'R');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$surdefoperasi_tahunini = $saldotahunini_pendapatanlo - $saldotahunini_beban;
$surdefoperasi_tahunlalu = $saldotahunlalu_pendapatanlo - $saldotahunlalu_beban;
$surdefoperasi_kenaikanpenurunan = $surdefoperasi_tahunini - $surdefoperasi_tahunlalu;

$pdf->SetFont('Arial', '', 7);
if ($surdefoperasi_tahunini < 0) {
    $surdefoperasi_tahunini1 = $surdefoperasi_tahunini * -1;
    $tampil_surdefoperasi_tahunini = "(" . number_format($surdefoperasi_tahunini1, 2, ',', '.') . ")";
} else {
    $tampil_surdefoperasi_tahunini = number_format($surdefoperasi_tahunini, 2, ',', '.');
}
$pdf->MultiCell($w[2], 5, $tampil_surdefoperasi_tahunini, 'TB', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
if ($surdefoperasi_tahunlalu < 0) {
    $surdefoperasi_tahunlalu1 = $surdefoperasi_tahunlalu * -1;
    $tampil_surdefoperasi_tahunlalu = "(" . number_format($surdefoperasi_tahunlalu1, 2, ',', '.') . ")";
} else {
    $tampil_surdefoperasi_tahunlalu = number_format($surdefoperasi_tahunlalu, 2, ',', '.');
}
$pdf->MultiCell($w[3], 5, $tampil_surdefoperasi_tahunlalu, 'TB', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
if ($surdefoperasi_kenaikanpenurunan < 0) {
    $surdefoperasi_kenaikanpenurunan1 = $surdefoperasi_kenaikanpenurunan * -1;
    $tampil_surdefoperasi_kenaikanpenurunan = "(" . number_format($surdefoperasi_kenaikanpenurunan1, 2, ',', '.') . ")";
} else {
    $tampil_surdefoperasi_kenaikanpenurunan = number_format($surdefoperasi_kenaikanpenurunan, 2, ',', '.');
}
$pdf->MultiCell($w[4], 5, $tampil_surdefoperasi_kenaikanpenurunan, 'TB', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
if ($surdefoperasi_tahunlalu <= 0) {
    $pdf->MultiCell($w[5], 5, '0', 'TB', 'R');
} else {
    $persen = $surdefoperasi_kenaikanpenurunan / $surdefoperasi_tahunlalu * 100;
    $pdf->MultiCell($w[5], 5, number_format($persen, 2, ',', '.'), 'TB', 'R');
}

$ysisa = $y;
$pdf->ln();

//end buat baris surplus defisit

//buat baris untuk kegiatan non operasional
$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
// $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
$pdf->MultiCell($w[0], 4, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 4, 'KEGIATAN NON OPERASIONAL', '', 'L');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell($w[2], 4, '', '', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 4, '', '', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 4, '', '', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);

$pdf->MultiCell($w[5], 4, '', '', 'R');

$ysisa = $y;
$pdf->ln();
// end baris untuk kegiatan non operasional

foreach ($model['data']['rincianLO2'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->uraian),
        0
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

    $pecahkode = explode(".", $data->koderekening);
    $jumlahkode = strlen($data->koderekening);

    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    // $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
    $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    $xcurrent = $xcurrent + $w[0];

    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($xcurrent + 6, $y);
    $pdf->MultiCell($w[1] - 6, 4, $data->uraian, '', 'L');
    $tb = '';

    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', '', 7);
    $pdf->MultiCell($w[2], 4, number_format($data->saldo_tahun_ini, 2, ',', '.'), $tb, 'R');

    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, number_format($data->saldo_tahun_lalu, 2, ',', '.'), $tb, 'R');


    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    if ($data->kenaikan_penurunan < 0) {
        $varbuatan_kenaikan_penurunan = $data->kenaikan_penurunan * -1;
        $pdf->MultiCell($w[4], 4, '(' . number_format($varbuatan_kenaikan_penurunan, 2, ',', '.') . ')', $tb, 'R');
    } else {
        $pdf->MultiCell($w[4], 4, number_format($data->kenaikan_penurunan, 2, ',', '.'), $tb, 'R');
    }

    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);

    // $totalrealisasi1baris=0+$data->nilaiRealisasi;
    if ($data->saldo_tahun_lalu <= 0) {
        $pdf->MultiCell($w[5], 4, '0', $tb, 'R');
    } else {
        $persen = $data->kenaikan_penurunan / $data->saldo_tahun_lalu * 100;
        $pdf->MultiCell($w[5], 4, number_format($persen, 2, ',', '.'), $tb, 'R');
    }

    $ysisa = $y;

    if ($pecahkode[0] == 9) {
        $data->saldo_tahun_ini = $data->saldo_tahun_ini * -1;
        $data->saldo_tahun_lalu = $data->saldo_tahun_lalu * -1;
        $data->kenaikan_penurunan = $data->kenaikan_penurunan * -1;
    }

    $surdefnonoperasi_tahunini += $data->saldo_tahun_ini;
    $surdefnonoperasi_tahunlalu += $data->saldo_tahun_lalu;
    $surdefnonoperasi_kenaikanpenurunan += $data->kenaikan_penurunan;
    $i++; //Untuk urutan nomor
    $pdf->ln();
}

//buat baris untuk surplus defisit non operasional

$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
// $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
$pdf->MultiCell($w[0], 5, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 5, 'SURPLUS/DEFISIT DARI KEGIATAN NON OPERASIONAL', '', 'R');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 7);
if ($surdefnonoperasi_tahunini < 0) {
    $surdefnonoperasi_tahunini1 = $surdefnonoperasi_tahunini * -1;
    $tampil_surdefnonoperasi_tahunini = "(" . number_format($surdefnonoperasi_tahunini1, 2, ',', '.') . ")";
} else {
    $tampil_surdefnonoperasi_tahunini = number_format($surdefnonoperasi_tahunini, 2, ',', '.');
}
$pdf->MultiCell($w[2], 5, $tampil_surdefnonoperasi_tahunini, 'TB', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
if ($surdefnonoperasi_tahunlalu < 0) {
    $surdefnonoperasi_tahunlalu1 = $surdefnonoperasi_tahunlalu * -1;
    $tampil_surdefnonoperasi_tahunlalu = "(" . number_format($surdefnonoperasi_tahunlalu1, 2, ',', '.') . ")";
} else {
    $tampil_surdefnonoperasi_tahunlalu = number_format($surdefnonoperasi_tahunlalu, 2, ',', '.');
}
$pdf->MultiCell($w[3], 5, $tampil_surdefnonoperasi_tahunlalu, 'TB', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
if ($surdefnonoperasi_kenaikanpenurunan < 0) {
    $surdefnonoperasi_kenaikanpenurunan1 = $surdefnonoperasi_kenaikanpenurunan * -1;
    $tampil_surdefnonoperasi_kenaikanpenurunan = "(" . number_format($surdefnonoperasi_kenaikanpenurunan1, 2, ',', '.') . ")";
} else {
    $tampil_surdefnonoperasi_kenaikanpenurunan = number_format($surdefnonoperasi_kenaikanpenurunan, 2, ',', '.');
}
$pdf->MultiCell($w[4], 5, $tampil_surdefnonoperasi_kenaikanpenurunan, 'TB', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
if ($surdefnonoperasi_tahunlalu <= 0) {
    $pdf->MultiCell($w[5], 5, '0', 'TB', 'R');
} else {
    $persen = $surdefnonoperasi_kenaikanpenurunan / $surdefnonoperasi_tahunlalu * 100;
    $pdf->MultiCell($w[5], 5, number_format($persen, 2, ',', '.'), 'TB', 'R');
}

$ysisa = $y;
$pdf->ln();

//end buat baris surplus defisit dari kegiatan non operasional

//buat baris untuk surplus defisit sebelum pos luar biasa

$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
// $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
$pdf->MultiCell($w[0], 5, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 5, 'SURPLUS/DEFISIT SEBELUM POS LUAR BIASA', '', 'R');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);


$surdefsebelumpos_tahunini = $surdefoperasi_tahunini + $surdefnonoperasi_tahunini;
$surdefsebelumpos_tahunlalu = $surdefoperasi_tahunlalu + $surdefnonoperasi_tahunlalu;
$surdefsebelumpos_kenaikanpenurunan = $surdefoperasi_kenaikanpenurunan + $surdefnonoperasi_kenaikanpenurunan;

$pdf->SetFont('Arial', '', 7);
if ($surdefsebelumpos_tahunini < 0) {
    $surdefsebelumpos_tahunini1 = $surdefsebelumpos_tahunini * -1;
    $tampil_surdefsebelumpos_tahunini = "(" . number_format($surdefsebelumpos_tahunini1, 2, ',', '.') . ")";
} else {
    $tampil_surdefsebelumpos_tahunini = number_format($surdefsebelumpos_tahunini, 2, ',', '.');
}
$pdf->MultiCell($w[2], 5, $tampil_surdefsebelumpos_tahunini, 'TB', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
if ($surdefsebelumpos_tahunlalu < 0) {
    $surdefsebelumpos_tahunlalu1 = $surdefsebelumpos_tahunlalu * -1;
    $tampil_surdefsebelumpos_tahunlalu = "(" . number_format($surdefsebelumpos_tahunlalu1, 2, ',', '.') . ")";
} else {
    $tampil_surdefsebelumpos_tahunlalu = number_format($surdefsebelumpos_tahunlalu, 2, ',', '.');
}
$pdf->MultiCell($w[3], 5, $tampil_surdefsebelumpos_tahunlalu, 'TB', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
if ($surdefsebelumpos_kenaikanpenurunan < 0) {
    $surdefsebelumpos_kenaikanpenurunan1 = $surdefsebelumpos_kenaikanpenurunan * -1;
    $tampil_surdefsebelumpos_kenaikanpenurunan = "(" . number_format($surdefsebelumpos_kenaikanpenurunan1, 2, ',', '.') . ")";
} else {
    $tampil_surdefsebelumpos_kenaikanpenurunan = number_format($surdefsebelumpos_kenaikanpenurunan, 2, ',', '.');
}
$pdf->MultiCell($w[4], 5, $tampil_surdefsebelumpos_kenaikanpenurunan, 'TB', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
if ($surdefsebelumpos_tahunlalu <= 0) {
    $pdf->MultiCell($w[5], 5, '0', 'TB', 'R');
} else {
    $persen = $surdefsebelumpos_kenaikanpenurunan / $surdefsebelumpos_tahunlalu * 100;
    $pdf->MultiCell($w[5], 5, number_format($persen, 2, ',', '.'), 'TB', 'R');
}

$ysisa = $y;
$pdf->ln();

//end buat baris surplus defisit sebelum pos luar biasa

//buat baris untuk POS LUAR BIASA
$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 4, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 4, 'POS LUAR BIASA', '', 'L');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell($w[2], 4, '', '', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 4, '', '', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 4, '', '', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);

$pdf->MultiCell($w[5], 4, '', '', 'R');

$ysisa = $y;
$pdf->ln();
// end baris untuk POS LUAR BIASA

foreach ($model['data']['rincianLO3'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->uraian),
        0
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

    $pecahkode = explode(".", $data->koderekening);
    $jumlahkode = strlen($data->koderekening);

    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    $xcurrent = $xcurrent + $w[0];

    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($xcurrent + 6, $y);
    $pdf->MultiCell($w[1] - 6, 4, $data->uraian, '', 'L');
    $tb = '';

    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', '', 7);
    $pdf->MultiCell($w[2], 4, number_format($data->saldo_tahun_ini, 2, ',', '.'), $tb, 'R');

    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, number_format($data->saldo_tahun_lalu, 2, ',', '.'), $tb, 'R');


    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    if ($data->kenaikan_penurunan < 0) {
        $varbuatan_kenaikan_penurunan = $data->kenaikan_penurunan * -1;
        $pdf->MultiCell($w[4], 4, '(' . number_format($varbuatan_kenaikan_penurunan, 2, ',', '.') . ')', $tb, 'R');
    } else {
        $pdf->MultiCell($w[4], 4, number_format($data->kenaikan_penurunan, 2, ',', '.'), $tb, 'R');
    }

    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);

    // $totalrealisasi1baris=0+$data->nilaiRealisasi;
    if ($data->saldo_tahun_lalu <= 0) {
        $pdf->MultiCell($w[5], 4, '0', $tb, 'R');
    } else {
        $persen = $data->kenaikan_penurunan / $data->saldo_tahun_lalu * 100;
        $pdf->MultiCell($w[5], 4, number_format($persen, 2, ',', '.'), $tb, 'R');
    }

    $ysisa = $y;

    if ($pecahkode[0] == 9) {
        $data->saldo_tahun_ini = $data->saldo_tahun_ini * -1;
        $data->saldo_tahun_lalu = $data->saldo_tahun_lalu * -1;
        $data->kenaikan_penurunan = $data->kenaikan_penurunan * -1;
    }

    $surdefpos_tahunini += $data->saldo_tahun_ini;
    $surdefpos_tahunlalu += $data->saldo_tahun_lalu;
    $surdefpos_kenaikanpenurunan += $data->kenaikan_penurunan;
    $i++; //Untuk urutan nomor
    $pdf->ln();
}

//buat baris untuk surplus defisit dari pos luar biasa

$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
// $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
$pdf->MultiCell($w[0], 5, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 5, 'SURPLUS/DEFISIT DARI POS LUAR BIASA', '', 'R');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$pdf->SetFont('Arial', '', 7);
if ($surdefpos_tahunini < 0) {
    $surdefpos_tahunini1 = $surdefpos_tahunini * -1;
    $tampil_surdefpos_tahunini = "(" . number_format($surdefpos_tahunini1, 2, ',', '.') . ")";
} else {
    $tampil_surdefpos_tahunini = number_format($surdefpos_tahunini, 2, ',', '.');
}
$pdf->MultiCell($w[2], 5, $tampil_surdefpos_tahunini, 'TB', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
if ($surdefpos_tahunlalu < 0) {
    $surdefpos_tahunlalu1 = $surdefpos_tahunlalu * -1;
    $tampil_surdefpos_tahunlalu = "(" . number_format($surdefpos_tahunlalu1, 2, ',', '.') . ")";
} else {
    $tampil_surdefpos_tahunlalu = number_format($surdefpos_tahunlalu, 2, ',', '.');
}
$pdf->MultiCell($w[3], 5, $tampil_surdefpos_tahunlalu, 'TB', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
if ($surdefpos_kenaikanpenurunan < 0) {
    $surdefpos_kenaikanpenurunan1 = $surdefpos_kenaikanpenurunan * -1;
    $tampil_surdefpos_kenaikanpenurunan = "(" . number_format($surdefpos_kenaikanpenurunan1, 2, ',', '.') . ")";
} else {
    $tampil_surdefpos_kenaikanpenurunan = number_format($surdefpos_kenaikanpenurunan, 2, ',', '.');
}
$pdf->MultiCell($w[4], 5, $tampil_surdefpos_kenaikanpenurunan, 'TB', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
if ($surdefpos_tahunlalu <= 0) {
    $pdf->MultiCell($w[5], 5, '0', 'TB', 'R');
} else {
    $persen = $surdefpos_kenaikanpenurunan / $surdefpos_tahunlalu * 100;
    $pdf->MultiCell($w[5], 5, number_format($persen, 2, ',', '.'), 'TB', 'R');
}

$ysisa = $y;
$pdf->ln();

//end buat baris surplus defisit dari pos luar biasa

//buat baris untuk surplus defisit - LO

$y = MAX($y1, $y2, $y3);
//new data
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
// $pdf->MultiCell($w[0], 4, $data->idpotspp, '', 'C');
$pdf->MultiCell($w[0], 5, '', '', 'L');
$xcurrent = $xcurrent + $w[0];

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($xcurrent + 2, $y);
$pdf->MultiCell($w[1] - 2, 5, 'SURPLUS/DEFISIT-LO', '', 'R');
$tb = '';

$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);

$surdefterakhir_tahunini = $surdefoperasi_tahunini + $surdefnonoperasi_tahunini + $surdefpos_tahunini;
$surdefterakhir_tahunlalu = $surdefoperasi_tahunlalu + $surdefnonoperasi_tahunlalu + $surdefpos_tahunlalu;
$surdefterakhir_kenaikanpenurunan = $surdefoperasi_kenaikanpenurunan + $surdefnonoperasi_kenaikanpenurunan + $surdefpos_kenaikanpenurunan;

$pdf->SetFont('Arial', '', 7);
if ($surdefterakhir_tahunini < 0) {
    $surdefterakhir_tahunini1 = $surdefterakhir_tahunini * -1;
    $tampil_surdefterakhir_tahunini = "(" . number_format($surdefterakhir_tahunini1, 2, ',', '.') . ")";
} else {
    $tampil_surdefterakhir_tahunini = number_format($surdefterakhir_tahunini, 2, ',', '.');
}
$pdf->MultiCell($w[2], 5, $tampil_surdefterakhir_tahunini, 'TB', 'R');

$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
if ($surdefterakhir_tahunlalu < 0) {
    $surdefterakhir_tahunlalu1 = $surdefterakhir_tahunlalu * -1;
    $tampil_surdefterakhir_tahunlalu = "(" . number_format($surdefterakhir_tahunlalu1, 2, ',', '.') . ")";
} else {
    $tampil_surdefterakhir_tahunlalu = number_format($surdefterakhir_tahunlalu, 2, ',', '.');
}
$pdf->MultiCell($w[3], 5, $tampil_surdefterakhir_tahunlalu, 'TB', 'R');


$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
if ($surdefterakhir_kenaikanpenurunan < 0) {
    $surdefterakhir_kenaikanpenurunan1 = $surdefterakhir_kenaikanpenurunan * -1;
    $tampil_surdefterakhir_kenaikanpenurunan = "(" . number_format($surdefterakhir_kenaikanpenurunan1, 2, ',', '.') . ")";
} else {
    $tampil_surdefterakhir_kenaikanpenurunan = number_format($surdefterakhir_kenaikanpenurunan, 2, ',', '.');
}
$pdf->MultiCell($w[4], 5, $tampil_surdefterakhir_kenaikanpenurunan, 'TB', 'R');

$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
if ($surdefterakhir_tahunlalu <= 0) {
    $pdf->MultiCell($w[5], 5, '0', 'TB', 'R');
} else {
    $persen = $surdefterakhir_kenaikanpenurunan / $surdefterakhir_tahunlalu * 100;
    $pdf->MultiCell($w[5], 5, number_format($persen, 2, ',', '.'), 'TB', 'R');
}

$ysisa = $y;
$pdf->ln();

//end buat baris surplus defisit - LO

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

$y = $yRectBegin = $y;


$pdf->SetXY($x + 3, ($pdf->getY() + 4));
$pdf->SetFont('Arial', '', 8);

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 50)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

//Menampilkan tanda tangan
$y = $pdf->gety();
$pdf->SetXY(255, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(255, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'J', 0);
$pdf->SetXY(255, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(255, 5, 'Pimpinan BLUD', '', 'j', 0);
$pdf->SetXY(255, $pdf->gety() + 15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(255, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'j', 0);
$pdf->SetX(255);
$pdf->MultiCell(255, 5, 'NIP' . ($penandatanganPimpinan ? $penandatanganPimpinan->NIP_pjb : ''), '', 'j', 0);


//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
