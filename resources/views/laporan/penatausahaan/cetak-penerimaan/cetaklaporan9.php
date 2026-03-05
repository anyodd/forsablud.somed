<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use Illuminate\Support\Facades\Request;
use App\Models\Tbsub;

class PDF extends fpdf
{
    const Y_LIMIT = 188;

    public $model, $bulan, $jn_spj, $tgl_laporan;

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
        $this->Cell($w[0], 24, 'KODE REKENING', 'LBT', 0, 'C');
        $this->Cell($w[1], 24, 'URAIAN', 'LBTR', 0, 'C');
        $this->Cell($w[2], 24, 'ANGGARAN', 'LBTR', 0, 'C');
        $this->Cell($w[3], 6, 's.d PERIODE LALU', 'LBTR', 0, 'C');
        $this->Cell($w[4], 6, 'PERIODE INI', 'LBTR', 0, 'C');
        $this->Cell($w[5], 6, 's.d PERIODE INI', 'LBTR', 0, 'C');
        $this->Cell($w[6], 24, 'SISA/PELAMPAUAN ANGGARAN', 'LTR', 0, 'C');
        $this->ln();
        $y = $this->GetY() - 18;
        $this->SetDash(1, 1);
        $this->SetXY($left + $w[0] + $w[1] + $w[2], $y);
        $this->Cell($w[3] + $w[4] + $w[5], 6, 'PENERIMAAN', 'B', 0, 'C');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY($left + $w[0] + $w[1] + $w[2], $y);
        $this->Cell($w[3] + $w[4] + $w[5], 6, 'PENYETORAN', 'B', 0, 'C');
        $this->ln();
        $y = $this->GetY();
        $this->SetDash();
        $this->SetXY($left + $w[0] + $w[1] + $w[2], $y);
        $this->Cell($w[3] + $w[4] + $w[5], 6, 'SISA', 'B', 0, 'C');
        $this->ln();
    }
}

$pdf = new PDF('L', 'mm', [216, 330]);
//$pdf->setGlobalSetting($model['refPemda']);
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
$pdf->SetXY(35, ($pdf->getY() + 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() + 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper("BUKU PENDAPATAN HARIAN"), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() + 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, 'Periode ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(300, 6, '', 'B', 'C', 0);

$w = [30, 7, 262]; // Tentukan width masing-masing kolom 187
$y = $pdf->GetY() + 6;
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


// $y = $pdf->GetY();
// $pdf->SetFont('Arial', 'B', 9);
// $pdf->SetXY(15, $y);
// $pdf->MultiCell(60, 5, $model['data']['pimpinan']['jabatan'], '', 'L', 0);
// $y_jab = $pdf->GetY();

// $pdf->SetXY(75, $y);
// $pdf->MultiCell(5, 5, ':', '', 'L', 0);
// $pdf->SetFont('Arial', '', 9);
// $pdf->SetXY(78, $y);
// $pdf->MultiCell(200, 5, $model['data']['pimpinan']['nama'], '', 'L', 0);
// $y_nama = $pdf->GetY();

// $y = MAX($y_jab, $y_nama);
// $pdf->SetFont('Arial', 'B', 9);
// $pdf->SetXY(15, $y);
// $pdf->MultiCell(60, 6, 'Bendahara Penerimaan', '', 'L', 0);
// $pdf->SetXY(75, $y);
// $pdf->MultiCell(5, 6, ':', '', 'L', 0);
// $pdf->SetFont('Arial', '', 9);
// $pdf->SetXY(78, $y);
// $pdf->MultiCell(145, 6, $model['data']['penandatanganBendahara'] ? $model['data']['penandatanganBendahara']->nama : '-', '', 'L', 0);

$xcurrent = $left;
$y = $pdf->GetY() + 1;
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 4, "", '', 'L', 0);

$pdf->ln(1);
$w = [30, 90, 30, 30, 30, 30, 60]; // Tentukan width masing-masing kolom
$pdf->breakPageTableHeader($left, $w);


$y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$kode = $program = $kegiatan = $subKegiatan = $kodeSpj = null;
$i = 1;

$ysisa = $y1;

$totalanggaran = $totalsdini = $totalsisa = $totalTerima_Lalu = $totalTerima_Ini = $totalSetor_Lalu = $totalSetor_Ini = $totalSisa_Lalu = $totalSisa_Ini = 0;


foreach ($model['data']['rincianSpj'] as $data) {
    $y = MAX($y1, $y2, $y3);

    $yMaxAfter = max(
        $y + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->nmrek6),
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

    $y = MAX($y1, $y2, $y3);

    $pdf->SetFont('Arial', '', 8);
    //new data
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 6, $data->Ko_Rkk, 'T', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 6, $data->nmrek6, 'T', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 6, number_format($data->Anggaran, 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, number_format($data->Terima_Lalu, 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, number_format($data->Terima_Ini, 0, ',', '.'), 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, number_format($data->Tot_Terima, 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[6], 6, number_format($data->Sisa_Anggaran, 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);


    // bagian dash putus putus
    $pdf->SetDash(1, 1);
    $pdf->ln();
    $y = $pdf->GetY();
    $xcurrent = $x + $w[0] + $w[1] + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, number_format($data->Setor_Lalu, 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, number_format($data->Setor_Ini, 0, ',', '.'), 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, number_format(($data->Setor_Ini + $data->Setor_Lalu), 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    $pdf->ln();
    $y = $pdf->GetY();
    $xcurrent = $x + $w[0] + $w[1] + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, number_format($data->Sisa_Lalu, 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, number_format($data->Sisa_Ini, 0, ',', '.'), 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, number_format(($data->Sisa_Ini + $data->Sisa_Lalu), 0, ',', '.'), 'T', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    $totalanggaran = $totalanggaran + $data->Anggaran;
    $totalTerima_Lalu += $data->Terima_Lalu;
    $totalTerima_Ini += $data->Terima_Ini;
    $totalSetor_Lalu += $data->Setor_Lalu;
    $totalSetor_Ini += $data->Setor_Ini;
    $totalSisa_Lalu += $data->Sisa_Lalu;
    $totalSisa_Ini += $data->Sisa_Ini;
    $totalsisa += $data->Sisa_Anggaran;

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();
    $pdf->SetDash();
}
$y = max($y1, $y2);


//membuat kotak di halaman terakhir
// $y = $pdf->gety();
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);


//Menampilkan jumlah halaman terakhir
$y = MAX($y1, $y2, $y3);

$pdf->SetFont('Arial', '', 8);
//new data
$pdf->SetXY($x, $y);
$xcurrent = $x;
$pdf->MultiCell($w[0], 6, '', 'T', 'R');
$xcurrent = $xcurrent + $w[0];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[1], 6, 'Total', 'T', 'L');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[1];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[2], 6, number_format($totalanggaran, 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 6, number_format($totalTerima_Lalu, 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 6, number_format($totalTerima_Ini, 0, ',', '.'), 'T', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 6, number_format(($totalTerima_Lalu + $totalTerima_Ini), 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[6], 6, number_format($totalsisa, 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[6];
$pdf->SetXY($xcurrent, $y);

// bagian dash putus putus
$pdf->SetDash(1, 1);
$pdf->ln();
$y = $pdf->GetY();
$xcurrent = $x + $w[0] + $w[1] + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 6, number_format($totalSetor_Lalu, 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 6, number_format($totalSetor_Ini, 0, ',', '.'), 'T', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 6, number_format(($totalSetor_Lalu + $totalSetor_Ini), 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);

$pdf->ln();
$y = $pdf->GetY();
$xcurrent = $x + $w[0] + $w[1] + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 6, number_format($totalSisa_Lalu, 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 6, number_format($totalSisa_Ini, 0, ',', '.'), 'T', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 6, number_format(($totalSisa_Lalu + $totalSisa_Ini), 0, ',', '.'), 'T', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);

$i++; //Untuk urutan nomor
$pdf->ln();
$pdf->SetDash();


$y = max($y1, $y2);


//membuat kotak di halaman terakhir
// $y = $pdf->gety();
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();
//Menampilkan tanda tangan
$y = $pdf->gety() + 6;
$pdf->SetXY(255, $y);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(255, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'J', 0);
$pdf->SetXY(255, $pdf->gety());
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(255, 5, 'Bendahara Penerimaan', '', 'j', 0);
$pdf->SetXY(255, $pdf->gety() + 20);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(255, 5, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'j', 0);
$pdf->SetX(255);
$pdf->MultiCell(255, 5, 'NIP' . ($penandatanganBendahara ? $penandatanganBendahara->NIP_pjb : ''), '', 'j', 0);

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
