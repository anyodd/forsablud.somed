<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use App\Models\Tbsub;

class KodeRekening
{
	public static function rekeningKodeBuilder($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6)
	{
		return $kdrek1 . '.' . $kdrek2 . '.' . $kdrek3 . '.' . substr('00' . $kdrek4, -2) . '.' . substr('00' . $kdrek5, -2) . '.' . substr('0000' . $kdrek6, -4);
	}
}

class KodeSubKegiatan
{
	 public static function programToSubkegiatanKodeBuilder($kdProgram, $kdKegiatan, $kdSubkegiatan)
    {
        return $kdProgram . '.' . $kdKegiatan . '.' . $kdSubkegiatan;
    }
}

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
    }

    function Footer()
    {
        $this->pageFooterNonTTE();
    }

    function breakPageTableHeader($left, $w)
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 12, 'No', 'LBT', 0, 'C');
        $this->Cell($w[1], 12, 'Kode Rekening', 'LBTR', 0, 'C');
        $this->Cell($w[2], 12, 'Uraian', 'LBTR', 0, 'C');
        $this->Cell($w[3], 12, 'Pagu Anggaran', 'LBTR', 0, 'C');
        $this->Cell($w[4] + $w[5], 6, 'Realisasi Kegiatan', 'LBTR', 0, 'C');
        $this->Cell($w[6], 12, 'Sisa Anggaran', 'LBTR', 0, 'C');
        $this->ln();
        $y = $this->GetY() - 6;
        $this->SetXY($left + $w[0] + $w[1] + $w[2] + $w[3], $y);
        $this->Cell($w[4], 6, 'LS', 'LBTR', 0, 'C');
        $this->Cell($w[5], 6, 'UP/GU', 'LBTR', 0, 'C');
        $this->ln();
    }
}

$pdf = new PDF('L', 'mm', [216, 330]);

$border = 0;
$subKegiatan = $kegiatan = $program = null;
foreach ($model['data']['rincianSubkegiatan'] as $data) {
    if ($subKegiatan != $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan) {

        if ($subKegiatan !== null) {

            $y = MAX($y1, $y2, $y3);

            $ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
            // $ylst = MAX($y1, $y2, $y3);
            $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

            //Menampilkan jumlah halaman terakhir
            $pdf->setxy($x, $y);
            $pdf->SetFont('Arial', 'BU', 8);
            $pdf->Cell($w[0], 6, '', 'LB');
            $pdf->Cell($w[1], 6, '', 'B', 0, 'C');
            $pdf->Cell($w[2], 6, 'TOTAL', 'B', 0, 'R');
            $pdf->Cell($w[3], 6, number_format($totalanggaran, 0, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[4], 6, number_format($totaliniLs, 0, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[5], 6, number_format($totaliniGu, 0, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[6], 6, number_format($totalanggaran - ($totaliniLs + $totaliniGu), 0, ',', '.'), 1, 0, 'R');

            // $pdf->ln();
            if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();
           //Menampilkan tanda tangan
			$y = $pdf->gety() + 10;
			$pdf->SetXY(235, $y);
			$pdf->SetFont('Arial', '', 8);
			$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
			$pdf->SetXY(235, $pdf->gety());
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->MultiCell(90, 5, 'Pejabat Pelaksana Teknis Kegiatan', '', 'C', 0);
			$pdf->Ln(3);
			$pdf->SetXY(235, $pdf->gety());
			$pdf->MultiCell(90, 5, "", '', 'C', 0);
			$pdf->SetXY(235, $pdf->gety() + 15);
			$pdf->SetFont('Arial', 'U', 8);
			$pdf->MultiCell(90, 5, '                                              ', '', 'C', 0);
			$pdf->SetX(235);
			$pdf->SetFont('Arial', '', 9);
			$pdf->SetX(255);
			$pdf->MultiCell(255, 5, '', '', 'j', 0);



            $y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $ysisa = $y1;
        }


        //Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
        $pdf->AddPage();
        $pdf->SetMargins(15, 10, 15); //(float left, float top [, float right])
        $pdf->SetAutoPageBreak(true, 10); // set bottom margin (boolean auto [, float margin])
        $pdf->AliasNbPages();

        $x = 15;
        $left = 15;
		
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
        $pdf->MultiCell(290, 4, strtoupper("LAPORAN KARTU KENDALI KEGIATAN"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(290, 4, 'per ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(300, 6, '', 'B', 'C', 0);


        $y = $pdf->GetY() + 2;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(15, $y);
        $pdf->MultiCell(60, 5, 'Program', '', 'L', 0);
        $pdf->SetXY(75, $y);
        $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(78, $y);
        $pdf->MultiCell(200, 5, $data->kdprogram . ' ' . $data->nmprogram, '', 'L', 0);

        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(15, $y);
        $pdf->MultiCell(60, 5, 'Kegiatan', '', 'L', 0);
        $pdf->SetXY(75, $y);
        $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(78, $y);
        $pdf->MultiCell(200, 5, $data->kdprogram . '.' . $data->kdkegiatan . ' ' . $data->nmkegiatan, '', 'L', 0);

        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(15, $y);
        $pdf->MultiCell(60, 5, 'Subkegiatan', '', 'L', 0);
        $pdf->SetXY(75, $y);
        $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(78, $y);
        $pdf->MultiCell(200, 5, KodeSubKegiatan::programToSubkegiatanKodeBuilder($data->kdprogram, $data->kdkegiatan, $data->kdsubkegiatan) . ' ' . $data->nmsubkegiatan, '', 'L', 0);
		$y = $pdf->GetY() + 2;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(15, $y);
		
		
        $w = [15, 40, 125, 30, 30, 30, 30]; // Tentukan width masing-masing kolom
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $subKegiatan = $kodeSpj = null;
        $i = 1;

        $ysisa = $y1;

        $totalanggaran = $totallalu = $totaliniLs = $totaliniGu = $totalsdini = $totalsisa = 0;
        $totalanggaranp = $totallalup = $totaliniLsp = $totaliniGup = $totalsdinip = $totalsisap = 0;

    }

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
    $pdf->MultiCell($w[0], 5, $i, '', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 5, KodeRekening::rekeningKodeBuilder($data->kdrek1, $data->kdrek2, $data->kdrek3, $data->kdrek4, $data->kdrek5, $data->kdrek6), '', 'C');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent + 5, $y);
    $pdf->MultiCell($w[2] - 5, 5, $data->nmrek6, '', 'L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 5, number_format($data->anggaran, 0, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 5, number_format($data->nilai_ls_ini, 0, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 5, number_format($data->nilai_gu_ini, 0, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $totalSpjIni = $data->nilai_gu_ini + $data->nilai_ls_ini;
    $pdf->MultiCell($w[6], 5, number_format(($data->anggaran - $totalSpjIni), 0, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);

    $totalanggaran = $totalanggaran + $data->anggaran;
    $totaliniLs = $totaliniLs + $data->nilai_ls_ini;
    $totaliniGu = $totaliniGu + $data->nilai_gu_ini;

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    //simpan untuk cek kegiatan/program
    $subKegiatan = $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan;
    $kegiatan = $data->kdprogram . '.' . $data->kdkegiatan;
    $program = $data->kdprogram;
}


$y = MAX($y1, $y2, $y3);

$ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
// $ylst = MAX($y1, $y2, $y3);
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $pdf->GetY());
$pdf->SetFont('Arial', 'BU', 8);
$pdf->Cell($w[0], 6, '', 'LB');
$pdf->Cell($w[1], 6, '', 'B', 0, 'C');
$pdf->Cell($w[2], 6, 'TOTAL', 'B', 0, 'R');
$pdf->Cell($w[3], 6, number_format($totalanggaran, 0, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[4], 6, number_format($totaliniLs, 0, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[5], 6, number_format($totaliniGu, 0, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[6], 6, number_format($totalanggaran - ($totaliniLs + $totaliniGu), 0, ',', '.'), 1, 0, 'R');

// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();
//Menampilkan tanda tangan
$y = $pdf->gety() + 10;
$pdf->SetXY(235, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
$pdf->SetXY(235, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Pejabat Pelaksana Teknis Kegiatan', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(235, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(235, $pdf->gety() + 15);
$pdf->SetFont('Arial', 'U', 8);
$pdf->MultiCell(90, 5, '                                              ', '', 'C', 0);
$pdf->SetX(235);
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(255);
$pdf->MultiCell(255, 5, '', '', 'j', 0);


$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$ysisa = $y1;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
