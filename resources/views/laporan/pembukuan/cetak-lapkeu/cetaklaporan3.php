<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use Illuminate\Support\Facades\Request;

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
        // if ($this->model->isDraft()) {
        //     $this->RotatedText(($this->GetPageWidth() / 2) - 30, ($this->GetPageHeight() / 2) + 30, 'DRAFT USULAN', 45);
        // }
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
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 6, 'No', 'LBT', 0, 'C');
        $this->Cell($w[1], 6, 'Tanggal', 'LBTR', 0, 'C');
        $this->Cell($w[2], 6, 'No Bukti', 'LBTR', 0, 'C');
        $this->Cell($w[3], 6, 'Kode Rek Lawan', 'LBTR', 0, 'C');
        $this->Cell($w[4], 6, 'Uraian', 'LBTR', 0, 'C');
        $this->Cell($w[5], 6, 'Debet', 'LBTR', 0, 'C');
        $this->Cell($w[6], 6, 'Kredit', 'LBTR', 0, 'C');
        $this->Cell($w[7], 6, 'Saldo', 'LBTR', 0, 'C');
        $this->ln();
    }
}
if (!$providerReturn['data']['daftarBuktiBukuBesar']) die("Data tidak ditemukan");

$pdf = new PDF('L', 'mm', [216, 330]);
// $pdf->setModel($providerReturn['data']['trnSpj']);
$pdf->setGlobalSetting($providerReturn['refPemda']);
$border = 0;
$rekening = null;
$saldo = 0;
$previousSaldoNormal = null;
$refUnit = null;
$refSubunit = null;

if ($model->userUnit) {
    $refUnit = Unit::where(['idunit' => $model->userUnit])->first();
}

if ($model->userSubunit) {
    $refSubunit = RefSubunit::where(['idsubunit' => $model->userSubunit])->first();
}

foreach ($providerReturn['data']['daftarBuktiBukuBesar'] as $data) {
    if ($rekening != $data->kdrek1 . '.' . $data->kdrek2 . '.' . $data->kdrek3 . '.' . $data->kdrek4 . '.' . $data->kdrek5 . '.' . $data->kdrek6) {

        if ($rekening !== null) {
            if ($totalDebet + $totalKredit == 0) $sisaAnggaran = $totalanggaran;
            $y = MAX($y1, $y2, $y3, $y4);

            $ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
            // $ylst = MAX($y1, $y2, $y3);
            $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

            //Menampilkan jumlah halaman terakhir
            $pdf->setxy($x, $y);
            $pdf->SetFont('Arial', 'BU', 8);
            $pdf->Cell($w[0], 6, '', 'LB');
            $pdf->Cell($w[1], 6, '', 'B', 0, 'C');
            $pdf->Cell($w[2], 6, '', 'B', 0, 'R');
            $pdf->Cell($w[3], 6, '', 'B', 0, 'R');
            $pdf->Cell($w[4], 6, 'TOTAL', 'BL', 0, 'R');
            $pdf->Cell($w[5], 6, number_format($totalDebet, 2, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[6], 6, number_format($totalKredit, 2, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[7], 6, number_format(($previousSaldoNormal == 'D' ? $saldo : -$saldo), 2, ',', '.'), 1, 0, 'R');

            // // $pdf->ln();
            // if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();
            // //Menampilkan tanda tangan
            // $y = $pdf->gety() + 10;
            // $pdf->SetXY(255, $y);
            // $pdf->SetFont('Times', '', 9);
            // $pdf->MultiCell(255, 5, $providerReturn['refPemda']->pemda->ibukota . ', ' . DATE('j', strtotime($model->tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($model->tgl_laporan))) . ' ' . DATE('Y', strtotime($model->tgl_laporan)), '', 'J', 0);
            // $pdf->SetXY(255, $pdf->gety());
            // $pdf->SetFont('Times', 'B', 9);
            // $pdf->MultiCell(255, 5, 'Pejabat Pelaksana Teknis Kegiatan', '', 'j', 0);
            // $pdf->SetXY(255, $pdf->gety() + 20);
            // $pdf->SetFont('Times', 'U', 9);
            // $pdf->MultiCell(255, 5, '                                              ', '', 'j', 0);
            // $pdf->SetFont('Times', '', 9);
            // $pdf->SetX(255);
            // $pdf->MultiCell(255, 5, '', '', 'j', 0);



            $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $ysisa = $y1;

            $saldo = 0;
        }


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
        $pdf->Image($providerReturn['refPemda']->getRefPemda->getLogoImageUrl(), 19, 14.5, 16, 16, '');
        // $pdf->Rect(15, 15, 20 ,16);

        $pdf->SetXY(35, 15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(290, 4, strtoupper($providerReturn['refPemda']->pemda->nmpemda), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->MultiCell(290, 4, strtoupper("Buku Besar"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(290, 4, 'Periode: ' . $pdf->tanggalTerbilang($model->tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($model->tgl_2, 1), '', 'C', 0);
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(300, 6, '', 'B', 'C', 0);

        // $y = $pdf->GetY() + 6;
        // $pdf->SetFont('Arial', 'B', 9);
        // $pdf->SetXY(15, $y);
        // $pdf->MultiCell(60, 5, 'Urusan Pemerintahan', '', 'L', 0);
        // $pdf->SetXY(75, $y);
        // $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        // $pdf->SetFont('Arial', '', 9);
        // $pdf->SetXY(78, $y);
        // $pdf->MultiCell(200, 5, $trnSpj->getRefSubunit->getRefUnit->skpd->bidang->entity_name_with_code, '', 'L', 0);

        if ($refUnit) {
            $y = $pdf->GetY();
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetXY(15, $y);
            $pdf->MultiCell(60, 5, 'Unit Organisasi', '', 'L', 0);
            $pdf->SetXY(75, $y);
            $pdf->MultiCell(5, 5, ':', '', 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(78, $y);
            $pdf->MultiCell(200, 5, $refUnit->entity_name_with_code, '', 'L', 0);
        }

        if ($refSubunit) {
            $y = $pdf->GetY();
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetXY(15, $y);
            $pdf->MultiCell(60, 5, 'Sub Unit Organisasi', '', 'L', 0);
            $pdf->SetXY(75, $y);
            $pdf->MultiCell(5, 5, ':', '', 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(78, $y);
            $pdf->MultiCell(200, 5, $refSubunit->entity_name_with_code, '', 'L', 0);
        }

        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(15, $y);
        $pdf->MultiCell(60, 5, 'Rekening', '', 'L', 0);
        $pdf->SetXY(75, $y);
        $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(78, $y);
        $pdf->MultiCell(200, 5, SppSp2d::rekeningKodeBuilder($data->kdrek1, $data->kdrek2, $data->kdrek3, $data->kdrek4, $data->kdrek5, $data->kdrek6) . ' ' . $data->nmrek6, '', 'L', 0);

        // $y = $pdf->GetY();
        // $pdf->SetFont('Arial', 'B', 9);
        // $pdf->SetXY(15, $y);
        // $pdf->MultiCell(60, 5, 'Pagu Anggaran', '', 'L', 0);
        // $pdf->SetXY(75, $y);
        // $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        // $pdf->SetFont('Arial', '', 9);
        // $pdf->SetXY(78, $y);
        // $pdf->MultiCell(80, 5, number_format($data->anggaran, 2, ',', '.'), '', 'R', 0);

        // $w = [15, 25, 60, 110, 30, 30, 30]; // Tentukan width masing-masing kolom
        $w = [15, 20, 45, 27, 103, 30, 30, 30]; // Tentukan width masing-masing kolom
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $y4 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $subKegiatan = $kodeSpj  = $rekening = null;
        $i = 1;

        $ysisa = $y1;

        $totalanggaran = $totallalu = $totalDebet = $totalKredit = $totalsdini = $totalsisa = 0;
        $totalanggaranp = $totallalup = $totalDebetp = $totalKreditp = $totalsdinip = $totalsisap = 0;
    }

    $y = MAX($y1, $y2, $y3, $y4);

    $yMaxAfter = max(
        $y + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->nmrek6),
        $y1,
        $y2,
        $y3,
        $y4
    );

    if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
        $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        $pdf->breakPage($x, $w, $yst, $ylst);
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $ysisa = $y1;
    }


    $y = MAX($y1, $y2, $y3, $y4);

    $pdf->SetFont('Arial', '', 8);
    //new data
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, $i, '', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, date('d/m/Y', strtotime($data->tgl_bukti)), '', 'C');
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, $data->no_bukti, '', 'L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 5, $data->koderekening_lawan, '', 'C');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 5, $data->uraian_lawan, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 5, ($data->kode == 1 ? number_format($data->debet, 2, ',', '.') : ''), '', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 5, ($data->kode == 1 ? number_format($data->kredit, 2, ',', '.') : ''), '', 'R');
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);
    $saldo = $saldo + $data->debet - $data->kredit;
    $pdf->MultiCell($w[7], 5, number_format(($data->saldo_normal == 'D' ? $saldo : -$saldo), 2, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[7];
    $pdf->SetXY($xcurrent, $y);

    // $totalanggaran = $data->anggaran;
    if ($data->kode == 1) {
        $totalDebet = $totalDebet + $data->debet;
        $totalKredit = $totalKredit + $data->kredit;
    }

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    //simpan untuk cek kegiatan/program
    $rekening = $data->kdrek1 . '.' . $data->kdrek2 . '.' . $data->kdrek3 . '.' . $data->kdrek4 . '.' . $data->kdrek5 . '.' . $data->kdrek6;
    $previousSaldoNormal = $data->saldo_normal;
}


// if ($totalDebet + $totalKredit == 0) $sisaAnggaran = $totalanggaran;
$y = MAX($y1, $y2, $y3, $y4);

$ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
// $ylst = MAX($y1, $y2, $y3);
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
// $pdf->setxy($x, $pdf->GetY());
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'BU', 8);
$pdf->Cell($w[0], 6, '', 'LB');
$pdf->Cell($w[1], 6, '', 'B', 0, 'C');
$pdf->Cell($w[2], 6, '', 'B', 0, 'R');
$pdf->Cell($w[3], 6, '', 'B', 0, 'R');
$pdf->Cell($w[4], 6, 'TOTAL', 'BL', 0, 'R');
$pdf->Cell($w[5], 6, number_format($totalDebet, 2, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[6], 6, number_format($totalKredit, 2, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[7], 6, number_format(($previousSaldoNormal == 'D' ? $saldo : -$saldo), 2, ',', '.'), 1, 0, 'R');

// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();
//Menampilkan tanda tangan
// $y = $pdf->gety() + 10;
// $pdf->SetXY(255, $y);
// $pdf->SetFont('Times', '', 9);
// $pdf->MultiCell(255, 5, $providerReturn['refPemda']->pemda->ibukota . ', ' . DATE('j', strtotime($model->tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($model->tgl_laporan))) . ' ' . DATE('Y', strtotime($model->tgl_laporan)), '', 'J', 0);
// $pdf->SetXY(255, $pdf->gety());
// $pdf->SetFont('Times', 'B', 9);
// $pdf->MultiCell(255, 5, 'Pejabat Pelaksana Teknis Kegiatan', '', 'j', 0);
// $pdf->SetXY(255, $pdf->gety() + 20);
// $pdf->SetFont('Times', 'U', 9);
// $pdf->MultiCell(255, 5, '                                              ', '', 'j', 0);
// $pdf->SetFont('Times', '', 9);
// $pdf->SetX(255);
// $pdf->MultiCell(255, 5, '', '', 'j', 0);



$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$ysisa = $y1;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
