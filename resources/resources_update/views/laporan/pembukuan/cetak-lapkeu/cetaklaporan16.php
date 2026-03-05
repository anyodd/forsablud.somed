<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

class PDF extends fpdf
{
    const Y_LIMIT = 300;

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
        $this->SetFont('Times', 'B', 10);
        $this->SetXY($left, $this->GetY() + 4);
        $this->Cell($w[0], 5, 'URAIAN', 'LTB', 0, 'C');
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
$pdf->MultiCell(150, 4, 'LAPORAN ARUS KAS', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY());
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Per ' . $pdf->tanggalTerbilang($tgl_2, 1) . ' dan ' . (Tahun() - 1), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->MultiCell(290, 4, "", '', 'C', 0);

//content
$w = [30, 7, 262]; // Tentukan width masing-masing kolom 187
$y = $pdf->GetY() + 7;
$pdf->SetFont('Arial', '', 8);

$pdf->ln(1);
// $w = [10, 16, 43, 26, 70, 30]; // Tentukan width masing-masing kolom
$w = [115, 40, 40]; // Tentukan width masing-masing kolom
//jumlah 69 26 100 = 195

$pdf->breakPageTableHeader($left, $w);

$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$kdrek1 = $kdrek2 = $kdrek3 = $nmrek1 = $nmrek2 = null;
$i = 1;

$ysisa = $y1;

$aktivitas = null;
$uraianAktivitas = null;
$arus = null;

$arusBersihAktivitas = $arusMasuk = $arusKeluar = $arusOperasi = $arusInvestasi = $arusPendanaan = $arusTransitoris = 0;
$arusBersihAktivitasAwal = $arusMasukAwal = $arusKeluarAwal = $arusOperasiAwal = $arusInvestasiAwal = $arusPendanaanAwal = $arusTransitorisAwal = 0;


foreach ($model['data']['arusKasRinci'] as $data) {


    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->nmrek3),
        0
    );

    if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
        $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        $pdf->breakPage($x, $w, $yst, $ylst);
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $ysisa = $y1;
    }



    $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

    if ($aktivitas != $data->kd_aktivitas) {
        $y = MAX($y1, $y2, $y3);

        $yMaxAfter = max(
            $y + $pdf->GetMultiCellHeight($w[1], 5, $data->uraian_aktivitas),
            $y1,
            $y2
        );

        if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
            $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
            $pdf->breakPage($x, $w, $yst, $ylst);
            $pdf->breakPageTableHeader($left, $w);


            $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $ysisa = $y1;
        }

        if ($aktivitas != null) {
            // isi dengan total aktivitas sebelumnya

            $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

            $pdf->SetFont('Times', 'I', 9);
            $pdf->SetXY($x, $y);
            $xcurrent = $x;
            $pdf->MultiCell($w[0], 5, 'Jumlah Arus Kas ' . ($arus == 1 ? 'Masuk' : 'Keluar'), '', 'L');
            $xcurrent = $xcurrent + $w[0];
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);
            $pdf->SetFont('Times', '', 9);
            $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat(($arus == 1 ? $arusMasuk : $arusKeluar)), '', 'R');
            $xcurrent = $xcurrent + $w[1];
            $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat(($arus == 1 ? $arusMasukAwal : $arusKeluarAwal)), '', 'R');
            $xcurrent = $xcurrent + $w[2];
            $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);

            $i++; //Untuk urutan nomor
            $pdf->ln();

            $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

            $pdf->SetFont('Times', 'B', 9);
            $pdf->SetXY($x, $y);
            $xcurrent = $x;
            $pdf->MultiCell($w[0], 5, 'Arus Kas Bersih dari ' . $uraianAktivitas, '', 'L');
            $xcurrent = $xcurrent + $w[0];
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($arusBersihAktivitas), '', 'R');
            $xcurrent = $xcurrent + $w[1];
            $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($arusBersihAktivitasAwal), '', 'R');
            $xcurrent = $xcurrent + $w[2];
            $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);

            $i++; //Untuk urutan nomor
            $pdf->ln();
        }

        $y = MAX($y1, $y2, $y3);

        //code goes here
        $pdf->SetFont('Times', 'B', 9);
        //new data	
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 5, 'Arus Kas dari ' . $data->uraian_aktivitas, '', 'L');
        $xcurrent = $xcurrent + $w[0];
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $pdf->SetXY($xcurrent, $y);
        $pdf->ln();
        $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

        $arusBersihAktivitas = $arusMasuk = $arusKeluar = 0;
        $arusBersihAktivitasAwal = $arusMasukAwal = $arusKeluarAwal = 0;
        $aktivitas = null;
        $uraianAktivitas = null;
        $arus = null;
    }

    if ($arus != $data->kd_arus) {
        $y = MAX($y1, $y2, $y3);

        if ($arus != null) {
            // isi dengan total aktivitas sebelumnya

            $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

            $pdf->SetFont('Times', 'I', 9);
            $pdf->SetXY($x, $y);
            $xcurrent = $x;
            $pdf->MultiCell($w[0], 5, 'Jumlah Arus Kas ' . ($arus == 1 ? 'Masuk' : 'Keluar'), '', 'L');
            $xcurrent = $xcurrent + $w[0];
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);
            $pdf->SetFont('Times', '', 9);
            $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat(($arus == 1 ? $arusMasuk : $arusKeluar)), '', 'R');
            $xcurrent = $xcurrent + $w[1];
            $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);
            $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat(($arus == 1 ? $arusMasukAwal : $arusKeluarAwal)), '', 'R');
            $xcurrent = $xcurrent + $w[2];
            $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $pdf->SetXY($xcurrent, $y);

            $i++; //Untuk urutan nomor
            $pdf->ln();
        }

        $y = MAX($y1, $y2, $y3);

        //code goes here
        $pdf->SetFont('Times', 'I', 9);
        //new data	
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 5, 'Arus Kas ' . ($data->kd_arus == 1 ? 'Masuk' : 'Keluar'), '', 'L');
        $xcurrent = $xcurrent + $w[0];
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $pdf->SetXY($xcurrent, $y);
        $pdf->ln();
        $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);
    }




    $pdf->SetFont('Times', '', 8);
    //new data		
    $pdf->SetXY($x + 6, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0] - 6, 5, $data->nmrek3, '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($data->saldo), '', 'R');
    $xcurrent = $xcurrent + $w[1];
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($data->saldo_sa), '', 'R');
    $xcurrent = $xcurrent + $w[2];
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);

    $i++; //Untuk urutan nomor
    $pdf->ln();

    //simpan untuk cek kegiatan/program
    $aktivitas = $data->kd_aktivitas;
    $uraianAktivitas = $data->uraian_aktivitas;
    $arus = $data->kd_arus;
    $arusBersihAktivitas += ($data->kd_arus == 1 ? $data->saldo : -$data->saldo);
    $arusMasuk += ($data->kd_arus == 1 ? $data->saldo : 0);
    $arusKeluar += ($data->kd_arus == 2 ? $data->saldo : 0);
    $arusOperasi += ($data->kd_aktivitas == 1 ? ($data->kd_arus == 1 ? $data->saldo : -$data->saldo) : 0);
    $arusInvestasi += ($data->kd_aktivitas == 2 ? ($data->kd_arus == 1 ? $data->saldo : -$data->saldo) : 0);
    $arusPendanaan += ($data->kd_aktivitas == 3 ? ($data->kd_arus == 1 ? $data->saldo : -$data->saldo) : 0);
    $arusTransitoris += ($data->kd_aktivitas == 4 ? ($data->kd_arus == 1 ? $data->saldo : -$data->saldo) : 0);

    $arusBersihAktivitasAwal += ($data->kd_arus == 1 ? $data->saldo_sa : -$data->saldo_sa);
    $arusMasukAwal += ($data->kd_arus == 1 ? $data->saldo_sa : 0);
    $arusKeluarAwal += ($data->kd_arus == 2 ? $data->saldo_sa : 0);
    $arusOperasiAwal += ($data->kd_aktivitas == 1 ? ($data->kd_arus == 1 ? $data->saldo_sa : -$data->saldo_sa) : 0);
    $arusInvestasiAwal += ($data->kd_aktivitas == 2 ? ($data->kd_arus == 1 ? $data->saldo_sa : -$data->saldo_sa) : 0);
    $arusPendanaanAwal += ($data->kd_aktivitas == 3 ? ($data->kd_arus == 1 ? $data->saldo_sa : -$data->saldo_sa) : 0);
    $arusTransitorisAwal += ($data->kd_aktivitas == 4 ? ($data->kd_arus == 1 ? $data->saldo_sa : -$data->saldo_sa) : 0);
}
$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

$yMaxAfter = max(
    $y + $pdf->GetMultiCellHeight($w[1], 5, $data->uraian_aktivitas),
    $y1,
    $y2
);

if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
    $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
    $pdf->breakPage($x, $w, $yst, $ylst);
    $pdf->breakPageTableHeader($left, $w);


    $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
    $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
    $ysisa = $y1;
}

if ($aktivitas != null) {
    // isi dengan total aktivitas sebelumnya

    $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

    $pdf->SetFont('Times', 'I', 9);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, 'Jumlah Arus Kas ' . ($arus == 1 ? 'Masuk' : 'Keluar'), '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat(($arus == 1 ? $arusMasuk : $arusKeluar)), '', 'R');
    $xcurrent = $xcurrent + $w[1];
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat(($arus == 1 ? $arusMasukAwal : $arusKeluarAwal)), '', 'R');
    $xcurrent = $xcurrent + $w[2];
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

    $pdf->SetFont('Times', 'B', 9);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, 'Arus Kas Bersih dari ' . $uraianAktivitas, '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($arusBersihAktivitas), '', 'R');
    $xcurrent = $xcurrent + $w[1];
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($arusBersihAktivitasAwal), '', 'R');
    $xcurrent = $xcurrent + $w[2];
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);

    $i++; //Untuk urutan nomor
    $pdf->ln();
}

$y = MAX($y1, $y2, $y3) + 5;

//code goes here
if ($pdf->checkIfPageExceed($y + 30)) { //cek pagebreak
    $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
    $pdf->breakPage($x, $w, $yst, $ylst);
    $pdf->breakPageTableHeader($left, $w);


    $y = $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
    $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
    $ysisa = $y1;
}

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY($x + 6, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0] - 6, 5, 'Kenaikan / (Penurunan) Kas', '', 'L');
$xcurrent = $xcurrent + $w[0];
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$totalArusKas = $arusOperasi + $arusInvestasi + $arusPendanaan + $arusTransitoris;
$pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($totalArusKas), '', 'R');
$xcurrent = $xcurrent + $w[1];
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$totalArusKasAwal = $arusOperasiAwal + $arusInvestasiAwal + $arusPendanaanAwal + $arusTransitorisAwal;
$pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($totalArusKasAwal), '', 'R');
$xcurrent = $xcurrent + $w[2];
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);

$i++; //Untuk urutan nomor
$pdf->ln();
$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY($x + 6, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0] - 6, 5, 'Saldo Awal Kas', '', 'L');
$xcurrent = $xcurrent + $w[0];
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($providerReturn['data']['saldoKasRkud']->saldo_sa), '', 'R');
$xcurrent = $xcurrent + $w[1];
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($providerReturn['data']['saldoKasRkud']->saldo_sa - $totalArusKasAwal), '', 'R');
$xcurrent = $xcurrent + $w[2];
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);

$i++; //Untuk urutan nomor
$pdf->ln();
$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY($x + 6, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0] - 6, 5, 'Saldo Akhir Kas', '', 'L');
$xcurrent = $xcurrent + $w[0];
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($providerReturn['data']['saldoKasRkud']->saldo), '', 'R');
$xcurrent = $xcurrent + $w[1];
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($providerReturn['data']['saldoKasRkud']->saldo_sa), '', 'R');
$xcurrent = $xcurrent + $w[2];
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);

$pdf->ln(10);
$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY($x + 6, $y + 4);
$xcurrent = $x;
$pdf->MultiCell($w[0] - 6, 5, 'Saldo Akhir Kas Terdiri Dari:', '', 'L');
$xcurrent = $xcurrent + $w[0];
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);

$pdf->ln(10);
$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);


$kasLainnyaAwal = $kasLainnya = 0;
foreach ($model['data']['saldoKasLainnya'] as $data) {


    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->nmrek4),
        0
    );

    if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
        $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        $pdf->breakPage($x, $w, $yst, $ylst);
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $ysisa = $y1;
    }



    $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);


    $pdf->SetFont('Times', '', 8);
    //new data		
    $pdf->SetXY($x + 6, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0] - 6, 5, $data->nmrek4, '', 'L');
    $xcurrent = $xcurrent + $w[0];
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, $pdf->accountingNumberFormat($data->saldo), '', 'R');
    $xcurrent = $xcurrent + $w[1];
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5,  $pdf->accountingNumberFormat($data->saldo_sa), '', 'R');
    $xcurrent = $xcurrent + $w[2];
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $kasLainnya += $data->saldo;
    $kasLainnyaAwal += $data->saldo_sa;
}
$y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7, $y8, $y9, $y10, $y11, $y12, $y13);


//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

$y = $y + 6;

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
