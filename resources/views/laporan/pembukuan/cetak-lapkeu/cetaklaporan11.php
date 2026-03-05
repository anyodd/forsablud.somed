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
$pdf->MultiCell(290, 4, strtoupper("LAPORAN REALISASI ANGGARAN BELANJA DAN PENGELUARAN PEMBIAYAAN"), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() ));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, "BERDASARKAN KLASIFIKASI SUMBER DANA", '', 'C', 0);
$pdf->SetFont('Arial', '', 9);
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


$w = [28, 122, 30, 30, 30, 30, 30]; // Tentukan width masing-masing kolom 300

$pdf->breakPageTableHeader($left, $w);

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$i = 1;
$kdkegiatan = $kdprogram = null;

$ysisa = $y1;
$lebkur = 0;
$koderekening_temp = 0;

foreach ($model['data']['rincianLRA'] as $data) {
    $pecahkoderekening = explode(".", $data->koderekening);
    $jumlahkode = strlen($data->koderekening);

    $pecahkoderekening_temp = explode(".", $koderekening_temp);

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
    $jumlahkodeurut = strlen($data->kodeurut);
    if ($jumlahkodeurut > 3) {
        $pdf->MultiCell($w[0], 4, $data->koderekening, '', 'L');
    } else {
        $pdf->MultiCell($w[0], 5, '', 'TB', 'L');
    }
    $xcurrent = $xcurrent + $w[0];

    $jumlahkode = strlen($data->koderekening);
    if ($jumlahkode == 5 && $jumlahkodeurut > 3) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetXY($xcurrent + 4, $y);
        $pdf->MultiCell($w[1] - 4, 4, $data->uraian, '', 'L');
    } else {
        if ($jumlahkode == 8 && $jumlahkodeurut > 3) {
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetXY($xcurrent + 6, $y);
            $pdf->MultiCell($w[1] - 6, 4, $data->uraian, '', 'L');
        } else {
            if ($jumlahkode == 11 && $jumlahkodeurut > 3) {
                $pdf->SetXY($xcurrent + 8, $y);
                $pdf->MultiCell($w[1] - 8, 4, $data->uraian, '', 'L');
            } else {
                if ($jumlahkode == 15 && $jumlahkodeurut > 3) {
                    $pdf->SetXY($xcurrent + 10, $y);
                    $pdf->MultiCell($w[1] - 10, 4, $data->uraian, '', 'L');
                } else {
                    if ($jumlahkode == 20 && $jumlahkodeurut > 3) {
                        $pdf->SetXY($xcurrent + 12, $y);
                        $pdf->MultiCell($w[1] - 12, 4, $data->uraian, '', 'L');
                    } else {
                        if ($jumlahkodeurut == 3) {
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->SetXY($xcurrent, $y);
                            $pdf->MultiCell($w[1], 5, $data->uraian, 'TB', 'R');
                        } else {
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->SetXY($xcurrent + 2, $y);
                            $pdf->MultiCell($w[1] - 2, 5, $data->uraian, '', 'L');
                        }
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

    if ($jumlahkode <= 14) {
        $pdf->MultiCell($w[5], 4, number_format($data->totalrealisasi, 2, ',', '.'), 'T', 'R');
    } else {
        $pdf->MultiCell($w[5], 4, number_format($data->totalrealisasi, 2, ',', '.'), '', 'R');
    }
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    if ($data->lebkur < 0) {
        $lebkur = $data->lebkur * -1;
        $tampil_lebkur = "(" . number_format($lebkur, 2, ',', '.') . ")";
    } else {
        $tampil_lebkur = number_format($data->lebkur, 2, ',', '.');
    }
    if ($jumlahkode <= 14) {
        $pdf->MultiCell($w[6], 4, $tampil_lebkur, 'T', 'R');
    } else {
        $pdf->MultiCell($w[6], 4, $tampil_lebkur, '', 'R');
    }
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $koderekening_temp = $data->koderekening;

    $i++; //Untuk urutan nomor
    $pdf->ln();
}

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
$y = $pdf->gety() + 15;
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
