<?php

use App\ExtendedClass\FpdfExtended;
use App\Models\Tbsub;

class PDF extends FpdfExtended
{
    const Y_LIMIT = 186;

    public $model, $tgl_1, $tgl_2, $tgl_laporan, $idprogram, $idkegiatan, $idsubkegiatan;

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
        $this->Cell($w[0], 8, 'KODE REKENING', 'LT', 0, 'C');
        $this->Cell($w[1], 8, 'URAIAN', 'LTR', 0, 'C');
        $this->Cell($w[2], 8, 'ANGGARAN', 'LTR', 0, 'C');
        $this->Cell($w[3] + $w[4] + $w[5], 4, 'REALISASI', 'LTR', 0, 'C');
        $this->Cell($w[6], 8, 'LEBIH / KURANG', 'LTR', 0, 'C');
        $this->cell(0, 4, '', 0, 1);

        $this->Cell($w[0] + $w[1] + $w[2], 4, '', 0, 0, 'C');
        $this->Cell($w[3], 4, 's/d PERIODE LALU', 'LTR', 0, 'C');
        $this->Cell($w[4], 4, 'PERIODE INI', 'LTR', 0, 'C');
        $this->Cell($w[5], 4, 'TOTAL', 'LTR', 0, 'C');
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
$pdf->MultiCell(290, 4, strtoupper("LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA DAERAH"), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() ));
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(290, 4, "Tahun Anggaran " . strtoupper(Tahun()), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY()));
$pdf->MultiCell(290, 4, "periode " . $pdf->tanggalTerbilang($tgl_1, 1) . " s.d. " . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
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


if ($idprogram != -1) {
    $pdf->SetXY($left, $y);
    $xcurrent = $left;
    $pdf->MultiCell($w[0], 4, "Program", '', 'L', 0);
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, $model['data']['ambilprogram'][0]->program_display, '', 'L', 0);
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, "", '', 'L', 0);
    $y = $pdf->GetY() + 1;
}



if ($idkegiatan != -1 || $idkegiatan == null ) {
    $pdf->SetXY($left, $y);
    $xcurrent = $left;
    $pdf->MultiCell($w[0], 4, "Kegiatan", '', 'L', 0);
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);;
    $pdf->MultiCell($w[2], 4, $model['data']['ambilkegiatan'][0]->kegiatan_display, '', 'L', 0);
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, "", '', 'L', 0);
    $y = $pdf->GetY() + 1;
}



if ($idsubkegiatan != -1 || $idkegiatan == null) {
    $pdf->SetXY($left, $y);
    $xcurrent = $left;
    $pdf->MultiCell($w[0], 4, "SubKegiatan", '', 'L', 0);
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, $model['data']['ambilsubkegiatan'][0]->subkegiatan_display, '', 'L', 0);
    $y = $pdf->GetY() + 1;
}

// $pdf->MultiCell($w[2], 1, "", '', 'L', 0);
// $pdf->ln(1);

$w = [28, 122, 30, 30, 30, 30, 30]; // Tentukan width masing-masing kolom 300

$pdf->breakPageTableHeader($left, $w);

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$i = 1;
$kdkegiatan = $kdprogram = null;
$totalSaldoAwal = $totalPenerimaan = $totalPengeluaran = 0;

$ysisa = $y1;

$anggaran_jumlah4 = 0;
$nilaiRealisasiperiodelalu4 = 0;
$nilaiRealisasi4 = 0;
$totalrealisasi1baris4 = 0;
$lebihkurang1baris4 = 0;

$anggaran_jumlah5 = 0;
$nilaiRealisasiperiodelalu5 = 0;
$nilaiRealisasi5 = 0;
$totalrealisasi1baris5 = 0;
$lebihkurang1baris5 = 0;

$anggaran_jumlah61 = 0;
$nilaiRealisasiperiodelalu61 = 0;
$nilaiRealisasi61 = 0;
$totalrealisasi1baris61 = 0;
$lebihkurang1baris61 = 0;

$anggaran_jumlah62 = 0;
$nilaiRealisasiperiodelalu62 = 0;
$nilaiRealisasi62 = 0;
$totalrealisasi1baris62 = 0;
$lebihkurang1baris62 = 0;

$koderekening_temp = 0;
$surplusdefisitperiodelalu_real = 0;

foreach ($model['data']['rincianLRA'] as $data) {
    $pecahkoderekening = explode(".", $data->koderekening);
    $jumlahkode = strlen($data->koderekening);
    if (($pecahkoderekening[0] == '04') && ($jumlahkode == 2)) {
        $anggaran_jumlah4 = $data->temp_jumlah;
        if (isset($data->nilaiRealisasiperiodelalu)) {
            $nilaiRealisasiperiodelalu4 = $data->nilaiRealisasiperiodelalu;
        }

        $nilaiRealisasi4 = $data->nilaiRealisasi;
        $totalrealisasi1baris4 = $nilaiRealisasiperiodelalu4 + $data->nilaiRealisasi;
        $lebihkurang1baris4 = $totalrealisasi1baris4 - $data->temp_jumlah;
    }

    if ($data->koderekening == '06.01') {
        $anggaran_jumlah61 = $data->temp_jumlah;
        if (isset($data->nilaiRealisasiperiodelalu)) {
            $nilaiRealisasiperiodelalu61 = $data->nilaiRealisasiperiodelalu;
        }

        $nilaiRealisasi61 = $data->nilaiRealisasi;
        $totalrealisasi1baris61 = $nilaiRealisasiperiodelalu61 + $data->nilaiRealisasi;
        $lebihkurang1baris61 = $totalrealisasi1baris61 - $data->temp_jumlah;
    }

    if ($data->koderekening == '06.02') {
        $anggaran_jumlah62 = $data->temp_jumlah;
        if (isset($data->nilaiRealisasiperiodelalu)) {
            $nilaiRealisasiperiodelalu62 = $data->nilaiRealisasiperiodelalu;
        }

        $nilaiRealisasi62 = $data->nilaiRealisasi;
        $totalrealisasi1baris62 = $nilaiRealisasiperiodelalu62 + $data->nilaiRealisasi;
        $lebihkurang1baris62 = $totalrealisasi1baris62 - $data->temp_jumlah;
    }

    if (($pecahkoderekening[0] == '05') && ($jumlahkode == 2)) {
        $anggaran_jumlah5 = $data->temp_jumlah;
        if (isset($data->nilaiRealisasiperiodelalu)) {
            $nilaiRealisasiperiodelalu5 = $data->nilaiRealisasiperiodelalu;
        }

        $nilaiRealisasi5 = $data->nilaiRealisasi;
        $totalrealisasi1baris5 = $nilaiRealisasiperiodelalu5 + $data->nilaiRealisasi;
        $lebihkurang1baris5 = $totalrealisasi1baris5 - $data->temp_jumlah;
    }

    if ($data->koderekening == '06') {
        continue;
    }

    $pecahkoderekening_temp = explode(".", $koderekening_temp);

    if ((($data->koderekening == '06.01') || ($data->koderekening == '06.02')) && ($pecahkoderekening_temp[0] == '05')) {
        $surplusdefisit_ang = $anggaran_jumlah4 - $anggaran_jumlah5;
        $surplusdefisitperiodelalu_real = $nilaiRealisasiperiodelalu4 - $nilaiRealisasiperiodelalu5;
        $surplusdefisit_real = $nilaiRealisasi4 - $nilaiRealisasi5;
        $surplusdefisit_realtot = $totalrealisasi1baris4 - $totalrealisasi1baris5;
        $surplusdefisit_lebkur = $lebihkurang1baris4 - $lebihkurang1baris5;

        if ($surplusdefisit_ang < 0) {
            $surplusdefisit_ang1 = $surplusdefisit_ang * -1;
            $tampil_ang1 = "(" . number_format($surplusdefisit_ang1, 2, ',', '.') . ")";
        } else {
            $tampil_ang1 = number_format($surplusdefisit_ang, 2, ',', '.');
        }

        if ($surplusdefisitperiodelalu_real < 0) {
            $surplusdefisitperiodelalu_real1 = $surplusdefisitperiodelalu_real * -1;
            $tampil_periodelalureal1 = "(" . number_format($surplusdefisitperiodelalu_real1, 2, ',', '.') . ")";
        } else {
            $tampil_periodelalureal1 = number_format($surplusdefisitperiodelalu_real, 2, ',', '.');
        }
		
        if ($surplusdefisit_real < 0) {
            $surplusdefisit_real1 = $surplusdefisit_real * -1;
            $tampil_real1 = "(" . number_format($surplusdefisit_real1, 2, ',', '.') . ")";
        } else {
            $tampil_real1 = number_format($surplusdefisit_real, 2, ',', '.');
        }

        if ($surplusdefisit_realtot < 0) {
            $surplusdefisit_realtot1 = $surplusdefisit_realtot * -1;
            $tampil_realtot1 = "(" . number_format($surplusdefisit_realtot1, 2, ',', '.') . ")";
        } else {
            $tampil_realtot1 = number_format($surplusdefisit_realtot, 2, ',', '.');
        }

        if ($surplusdefisit_lebkur < 0) {
            $surplusdefisit_lebkur1 = $surplusdefisit_lebkur * -1;
            $tampil_lebkur1 = "(" . number_format($surplusdefisit_lebkur1, 2, ',', '.') . ")";
        } else {
            $tampil_lebkur1 = number_format($surplusdefisit_lebkur, 2, ',', '.');
        }

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

        //new data
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 5, '', 'BT', 'L');
        $xcurrent = $xcurrent + $w[0];

        $pdf->SetXY($xcurrent, $y);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell($w[1], 5, 'SURPLUS / DEFISIT', 'BT', 'R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];
        $pdf->SetXY($xcurrent, $y);

        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell($w[2], 5, $tampil_ang1, 'T', 'R');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[2];
        $pdf->SetXY($xcurrent, $y);
		
        if ($tampil_periodelalureal1) {
            $pdf->MultiCell($w[3], 5, $tampil_periodelalureal1, 'T', 'R');
        } else {
            $pdf->MultiCell($w[3], 5, number_format(0, 2, ',', '.'), 'T', 'R');
        }

        $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[3];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[4], 5, $tampil_real1, 'T', 'R');

        $xcurrent = $xcurrent + $w[4];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[5], 5, $tampil_realtot1, 'T', 'R');

        $xcurrent = $xcurrent + $w[5];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[6], 5, $tampil_lebkur1, 'T', 'R');

        $xcurrent = $xcurrent + $w[6];
        $pdf->SetXY($xcurrent, $y);

        $ysisa = $y;

        $pdf->ln();
    }

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



    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    $xcurrent = $xcurrent + $w[0];

    $jumlahkode = strlen($data->koderekening);
    if ($jumlahkode == 5) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetXY($xcurrent + 4, $y);
        $pdf->MultiCell($w[1] - 4, 4, $data->uraian, '', 'L');
    } else {
        if ($jumlahkode == 8) {
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetXY($xcurrent + 6, $y);
            $pdf->MultiCell($w[1] - 6, 4, $data->uraian, '', 'L');
        } else {
            if ($jumlahkode == 11) {
                $pdf->SetXY($xcurrent + 8, $y);
                $pdf->MultiCell($w[1] - 8, 4, $data->uraian, '', 'L');
            } else {
                if ($jumlahkode == 15) {
                    $pdf->SetXY($xcurrent + 10, $y);
                    $pdf->MultiCell($w[1] - 10, 4, $data->uraian, '', 'L');
                } else {
                    if ($jumlahkode == 20) {
                        $pdf->SetXY($xcurrent + 12, $y);
                        $pdf->MultiCell($w[1] - 12, 4, $data->uraian, '', 'L');
                    } else {
                        $pdf->SetFont('Arial', 'B', 7);
                        $pdf->SetXY($xcurrent + 2, $y);
                        $pdf->MultiCell($w[1] - 2, 4, $data->uraian, '', 'L');
                    }
                }
            }
        }
    }


    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', '', 7);
    if ($jumlahkode <= 14) {
        $pdf->MultiCell($w[2], 4, number_format($data->temp_jumlah, 2, ',', '.'), 'T', 'R');
    } else {
        $pdf->MultiCell($w[2], 4, number_format($data->temp_jumlah, 2, ',', '.'), '', 'R');
    }
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    if (isset($data->nilaiRealisasiperiodelalu)) {
        if ($jumlahkode <= 14) {
            $pdf->MultiCell($w[3], 4, number_format($data->nilaiRealisasiperiodelalu, 2, ',', '.'), 'T', 'R');
        } else {
            $pdf->MultiCell($w[3], 4, number_format($data->nilaiRealisasiperiodelalu, 2, ',', '.'), '', 'R');
        }
    } else {
        if ($jumlahkode <= 14) {
            $pdf->MultiCell($w[3], 4, number_format(0, 2, ',', '.'), 'T', 'R');
        } else {
            $pdf->MultiCell($w[3], 4, number_format(0, 2, ',', '.'), '', 'R');
        }
    }

    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    if ($jumlahkode <= 14) {
        $pdf->MultiCell($w[4], 4, number_format($data->nilaiRealisasi, 2, ',', '.'), 'T', 'R');
    } else {
        $pdf->MultiCell($w[4], 4, number_format($data->nilaiRealisasi, 2, ',', '.'), '', 'R');
    }
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);

    if (isset($data->nilaiRealisasiperiodelalu)) {
        $totalrealisasi1baris = $data->nilaiRealisasiperiodelalu + $data->nilaiRealisasi;
    } else {
        $totalrealisasi1baris = 0 + $data->nilaiRealisasi;
    }
    if ($jumlahkode <= 14) {
        $pdf->MultiCell($w[5], 4, number_format($totalrealisasi1baris, 2, ',', '.'), 'T', 'R');
    } else {
        $pdf->MultiCell($w[5], 4, number_format($totalrealisasi1baris, 2, ',', '.'), '', 'R');
    }
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    $lebihkurang1baris = $totalrealisasi1baris - $data->temp_jumlah;
    $tampillebkur = number_format($lebihkurang1baris, 2, ',', '.');
    if ($lebihkurang1baris < 0) {
        $lebihkurang1baris = $lebihkurang1baris * -1;
        $tampillebkur = "(" . number_format($lebihkurang1baris, 2, ',', '.') . ")";
    }
    if ($jumlahkode <= 14) {
        $pdf->MultiCell($w[6], 4, $tampillebkur, 'T', 'R');
    } else {
        $pdf->MultiCell($w[6], 4, $tampillebkur, '', 'R');
    }
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $koderekening_temp = $data->koderekening;

    $i++; //Untuk urutan nomor
    $pdf->ln();
}

$surplusdefisit_ang = $anggaran_jumlah4 - $anggaran_jumlah5;
$surplusdefisitperiodelalu_real = $nilaiRealisasiperiodelalu4 - $nilaiRealisasiperiodelalu5;
$surplusdefisit_real = $nilaiRealisasi4 - $nilaiRealisasi5;
$surplusdefisit_realtot = $totalrealisasi1baris4 - $totalrealisasi1baris5;
$surplusdefisit_lebkur = $lebihkurang1baris4 - $lebihkurang1baris5;

$pecahkoderekening = explode(".", $koderekening_temp);
if ($pecahkoderekening[0] == '05') {

    if ($surplusdefisit_ang < 0) {
        $surplusdefisit_ang1 = $surplusdefisit_ang * -1;
        $tampil_ang1 = "(" . number_format($surplusdefisit_ang1, 2, ',', '.') . ")";
    } else {
        $tampil_ang1 = number_format($surplusdefisit_ang, 2, ',', '.');
    }

    if ($surplusdefisitperiodelalu_real < 0) {
        $surplusdefisitperiodelalu_real1 = $surplusdefisitperiodelalu_real * -1;
        $tampil_periodelalureal1 = "(" . number_format($surplusdefisitperiodelalu_real1, 2, ',', '.') . ")";
    } else {
        $tampil_periodelalureal1 = number_format($surplusdefisitperiodelalu_real, 2, ',', '.');
    }
		
    if ($surplusdefisit_real < 0) {
        $surplusdefisit_real1 = $surplusdefisit_real * -1;
        $tampil_real1 = "(" . number_format($surplusdefisit_real1, 2, ',', '.') . ")";
    } else {
        $tampil_real1 = number_format($surplusdefisit_real, 2, ',', '.');
    }
	
    if ($surplusdefisit_realtot < 0) {
        $surplusdefisit_realtot1 = $surplusdefisit_realtot * -1;
        $tampil_realtot1 = "(" . number_format($surplusdefisit_realtot1, 2, ',', '.') . ")";
    } else {
        $tampil_realtot1 = number_format($surplusdefisit_realtot, 2, ',', '.');
    }

    if ($surplusdefisit_lebkur < 0) {
        $surplusdefisit_lebkur1 = $surplusdefisit_lebkur * -1;
        $tampil_lebkur1 = "(" . number_format($surplusdefisit_lebkur1, 2, ',', '.') . ")";
    } else {
        $tampil_lebkur1 = number_format($surplusdefisit_lebkur, 2, ',', '.');
    }

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

    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, '', 'T', 'L');
    $xcurrent = $xcurrent + $w[0];

    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->MultiCell($w[1], 5, 'SURPLUS / DEFISIT', 'T', 'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', '', 7);
    $pdf->MultiCell($w[2], 5, $tampil_ang1, 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);

    if ($tampil_periodelalureal1) {
        $pdf->MultiCell($w[3], 5, $tampil_periodelalureal1, 'T', 'R');
    } else {
        $pdf->MultiCell($w[3], 5, number_format(0, 2, ',', '.'), 'T', 'R');
    }

    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 5, $tampil_real1, 'T', 'R');

    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 5, $tampil_realtot1, 'T', 'R');

    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 5, $tampil_lebkur1, 'T', 'R');

    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $pdf->ln();
}

if ($pecahkoderekening[0] == '06') {

    $PEMBIAYAAN_ANG = $anggaran_jumlah61 - $anggaran_jumlah62;
    $PEMBIAYAAN_periodelaluREAL = $nilaiRealisasiperiodelalu61 - $nilaiRealisasiperiodelalu62;
    $PEMBIAYAAN_REAL = $nilaiRealisasi61 - $nilaiRealisasi62;
    $PEMBIAYAAN_REALTOT = $totalrealisasi1baris61 - $totalrealisasi1baris62;
    $PEMBIAYAAN_LEBKUR = $lebihkurang1baris61 - $lebihkurang1baris62;

    if ($PEMBIAYAAN_ANG < 0) {
        $PEMBIAYAAN_ANG1 = $PEMBIAYAAN_ANG * -1;
        $tampil_PEMBIAYAAN_ANG1 = "(" . number_format($PEMBIAYAAN_ANG1, 2, ',', '.') . ")";
    } else {
        $tampil_PEMBIAYAAN_ANG1 = number_format($PEMBIAYAAN_ANG, 2, ',', '.');
    }

    if ($PEMBIAYAAN_periodelaluREAL < 0) {
        $PEMBIAYAAN_periodelaluREAL1 = $PEMBIAYAAN_periodelaluREAL * -1;
        $tampil_PEMBIAYAAN_periodelaluREAL1 = "(" . number_format($PEMBIAYAAN_periodelaluREAL1, 2, ',', '.') . ")";
    } else {
        $tampil_PEMBIAYAAN_periodelaluREAL1 = number_format($PEMBIAYAAN_periodelaluREAL, 2, ',', '.');
    }

    if ($PEMBIAYAAN_REAL < 0) {
        $PEMBIAYAAN_REAL1 = $PEMBIAYAAN_REAL * -1;
        $tampil_PEMBIAYAAN_REAL1 = "(" . number_format($PEMBIAYAAN_REAL1, 2, ',', '.') . ")";
    } else {
        $tampil_PEMBIAYAAN_REAL1 = number_format($PEMBIAYAAN_REAL, 2, ',', '.');
    }

    if ($PEMBIAYAAN_REALTOT < 0) {
        $PEMBIAYAAN_REALTOT1 = $PEMBIAYAAN_REALTOT * -1;
        $tampil_PEMBIAYAAN_REALTOT1 = "(" . number_format($PEMBIAYAAN_REALTOT1, 2, ',', '.') . ")";
    } else {
        $tampil_PEMBIAYAAN_REALTOT1 = number_format($PEMBIAYAAN_REALTOT, 2, ',', '.');
    }

    if ($PEMBIAYAAN_LEBKUR < 0) {
        $PEMBIAYAAN_LEBKUR1 = $PEMBIAYAAN_LEBKUR * -1;
        $tampil_PEMBIAYAAN_LEBKUR1 = "(" . number_format($PEMBIAYAAN_LEBKUR1, 2, ',', '.') . ")";
    } else {
        $tampil_PEMBIAYAAN_LEBKUR1 = number_format($PEMBIAYAAN_LEBKUR, 2, ',', '.');
    }

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

    //new data
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, '', 'T', 'L');
    $xcurrent = $xcurrent + $w[0];

    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->MultiCell($w[1], 5, 'PEMBIAYAAN NETTO', 'T', 'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);

    $pdf->SetFont('Arial', '', 7);
  
    $pdf->MultiCell($w[2], 5, $tampil_PEMBIAYAAN_ANG1, 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    if ($tampil_PEMBIAYAAN_periodelaluREAL1) {
        $pdf->MultiCell($w[3], 5, $tampil_PEMBIAYAAN_periodelaluREAL1, 'T', 'R');
    } else {
        $pdf->MultiCell($w[3], 5, number_format(0, 2, ',', '.'), 'T', 'R');
    }

    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 5, $tampil_PEMBIAYAAN_REAL1, 'T', 'R');

    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 5, $tampil_PEMBIAYAAN_REALTOT1, 'T', 'R');

    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 5, $tampil_PEMBIAYAAN_LEBKUR1, 'T', 'R');

    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $pdf->ln();
}

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

$y = $yRectBegin = $y;

$y = $pdf->GetY();

$TOTAL_ANG = $surplusdefisit_ang + ($anggaran_jumlah61 - $anggaran_jumlah62);
$TOTAL_periodelaluREAL = $surplusdefisitperiodelalu_real + ($nilaiRealisasiperiodelalu61 - $nilaiRealisasiperiodelalu62);
$TOTAL_REAL = $surplusdefisit_real + ($nilaiRealisasi61 - $nilaiRealisasi62);
$TOTAL_REALTOT = $surplusdefisit_realtot + ($totalrealisasi1baris61 - $totalrealisasi1baris62);
$TOTAL_LEBKUR = $surplusdefisit_lebkur + ($lebihkurang1baris61 - $lebihkurang1baris62);

if ($TOTAL_ANG < 0) {
    $TOTAL_ANG1 = $TOTAL_ANG * -1;
    $tampil_TOTAL_ANG1 = "(" . number_format($TOTAL_ANG1, 2, ',', '.') . ")";
} else {
    $tampil_TOTAL_ANG1 = number_format($TOTAL_ANG, 2, ',', '.');
}

if ($TOTAL_periodelaluREAL < 0) {
    $TOTAL_periodelaluREAL1 = $TOTAL_periodelaluREAL * -1;
    $tampil_TOTAL_periodelaluREAL1 = "(" . number_format($TOTAL_periodelaluREAL1, 2, ',', '.') . ")";
} else {
    $tampil_TOTAL_periodelaluREAL1 = number_format($TOTAL_periodelaluREAL, 2, ',', '.');
}

if ($TOTAL_REAL < 0) {
    $TOTAL_REAL1 = $TOTAL_REAL * -1;
    $tampil_TOTAL_REAL1 = "(" . number_format($TOTAL_REAL1, 2, ',', '.') . ")";
} else {
    $tampil_TOTAL_REAL1 = number_format($TOTAL_REAL, 2, ',', '.');
}

if ($TOTAL_REALTOT < 0) {
    $TOTAL_REALTOT1 = $TOTAL_REALTOT * -1;
    $tampil_TOTAL_REALTOT1 = "(" . number_format($TOTAL_REALTOT1, 2, ',', '.') . ")";
} else {
    $tampil_TOTAL_REALTOT1 = number_format($TOTAL_REALTOT, 2, ',', '.');
}

if ($TOTAL_LEBKUR < 0) {
    $TOTAL_LEBKUR1 = $TOTAL_LEBKUR * -1;
    $tampil_TOTAL_LEBKUR1 = "(" . number_format($TOTAL_LEBKUR1, 2, ',', '.') . ")";
} else {
    $tampil_TOTAL_LEBKUR1 = number_format($TOTAL_LEBKUR, 2, ',', '.');
}

//new data
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 5, '', 'LB', 'C');
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 5, 'SISA LEBIH / KURANG PEMBIAYAAN TAHUN BERKENAAN', 'BR', 'C');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 5, $tampil_TOTAL_ANG1, 'BR', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
if ($tampil_TOTAL_periodelaluREAL1) {
    $pdf->MultiCell($w[3], 5, $tampil_TOTAL_periodelaluREAL1, 'BR', 'R');
} else {
    $pdf->MultiCell($w[3], 5, number_format(0, 2, ',', '.'), 'BR', 'R');
}
$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 5, $tampil_TOTAL_REAL1, 'BR', 'R');
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 5, $tampil_TOTAL_REALTOT1, 'BR', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[6], 5, $tampil_TOTAL_LEBKUR1, 'BR', 'R');
$xcurrent = $xcurrent + $w[6];
$pdf->SetXY($xcurrent, $y);

// membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 50)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y = 15;
}

//Menampilkan tanda tangan
$y = $pdf->gety() + 10;
$pdf->SetXY(255, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(255, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'J', 0);
$pdf->SetXY(255, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(255, 5, 'Pimpinan BLUD', '', 'j', 0);
$pdf->SetXY(255, $pdf->gety() + 10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(255, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'j', 0);
$pdf->SetX(255);
$pdf->MultiCell(255, 5, 'NIP' . ($penandatanganPimpinan ? $penandatanganPimpinan->NIP_pjb : ''), '', 'j', 0);

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
