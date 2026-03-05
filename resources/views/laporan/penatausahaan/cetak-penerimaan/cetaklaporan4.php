<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use Illuminate\Support\Facades\Request;
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
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 8, 'No', 'LBT', 0, 'C');
        $this->Cell($w[1], 8, 'Tgl Setor', 'LBTR', 0, 'C');
        $this->Cell($w[2], 8, 'No STS & Bukti Penerimaan Lainnya', 'LBTR', 0, 'C');
        $this->Cell($w[3], 8, 'Periode Lalu', 'LBTR', 0, 'C');
        $this->Cell($w[4], 8, 'Periode Ini', 'LBTR', 0, 'C');
        $this->ln();
    }
}
if (!$model['data']['rincianpdpt']) die("Data tidak ditemukan");

$pdf = new PDF('P', 'mm', [216, 330]);

$border = 0;
$subKegiatan = $kegiatan = $program = $rekening = null;
//$totalbplalu = $totalbpini = $totalsetoran = 0;
foreach ($model['data']['rincianpdpt'] as $data) {
    if ($subKegiatan != $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas) {

        if ($subKegiatan !== null) {
            if ($totalbplalu + $totalbpini == 0) $sisaAnggaran = $totalsetoran;
            $y = MAX($y1, $y2, $y3);

            $ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
            // $ylst = MAX($y1, $y2, $y3);
            $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

            //Menampilkan jumlah halaman terakhir
            $pdf->setxy($x, $y);
            $pdf->SetFont('Arial', 'BU', 8);
            $pdf->Cell($w[0], 6, '', 'LB');
            $pdf->Cell($w[1], 6, '', 'B', 0, 'R');
            $pdf->Cell($w[2], 6, 'Jumlah', 'B', 0, 'R');
            $pdf->Cell($w[3], 6, number_format($totalbplalu, 2, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[4], 6, number_format($totalbpini, 2, ',', '.'), 'BLR', 0, 'R');

            if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();

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
		$pdf->Image(Tbsub::first()->getLogoImageRs(), 170, 14.5, 20, 20, '');

        $pdf->SetXY(35, 15);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
		$pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper("BUKU PEMBANTU"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper("PER RINCIAN OBYEK PENERIMAAN"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, 'Periode: ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(180, 6, '', 'B', 'C', 0);


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
		
		$pdf->SetXY($left, $y);
		$xcurrent = $left;
		$pdf->MultiCell($w[0], 4, "Kode Rekening", '', 'L', 0);
		$xcurrent = $xcurrent + $w[0];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
		$xcurrent = $xcurrent + $w[1];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, $data->Ko_Rkk, '', 'L', 0);
		$xcurrent = $xcurrent + $w[2];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, "", '', 'L', 0);
		$y = $pdf->GetY() + 1;


		$pdf->SetXY($left, $y);
		$xcurrent = $left;
		$pdf->MultiCell($w[0], 4, "Nama Rekening", '', 'L', 0);
		$xcurrent = $xcurrent + $w[0];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
		$xcurrent = $xcurrent + $w[1];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, $data->nmrek6, '', 'L', 0);
		$xcurrent = $xcurrent + $w[2];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, "", '', 'L', 0);
		$y = $pdf->GetY() + 1;


		$pdf->SetXY($left, $y);
		$xcurrent = $left;
		$pdf->MultiCell($w[0], 4, "Pagu Anggaran", '', 'L', 0);
		$xcurrent = $xcurrent + $w[0];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
		$xcurrent = $xcurrent + $w[1];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, number_format($data->anggaran, 2, ',', '.'), '', 'L', 0);
		$y = $pdf->GetY() + 1;
		$xcurrent = $xcurrent + $w[2];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, "", '', 'L', 0);

        //$pdf->ln(1);
        $w = [10, 56, 56, 30, 30]; // Tentukan width masing-masing kolom
        $pdf->breakPageTableHeader($left, $w);

        $y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $subKegiatan = $kodeSpj  = $rekening = null;
        $i = 1;

        $ysisa = $y1;

        $totalsetoran =  $totalbplalu = $totalbpini = 0;
        $totalsetoranp =  $totalbplalup = $totalbpinip = 0;

    }

    if (
        $rekening != $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas . '.' .
        $data->kdrek1 . '.' . $data->kdrek2 . '.' . $data->kdrek3 . '.' . $data->kdrek4 . '.' . $data->kdrek5 . '.' . $data->kdrek6
        && $rekening != null
    ) {
        //$setorRekeningIni = 0;
        if ($totalbplalu + $totalbpini == 0) $sisaAnggaran = $totalsetoran;
        $y = MAX($y1, $y2, $y3);

        $ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
        // $ylst = MAX($y1, $y2, $y3);
        $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

        //Menampilkan jumlah halaman terakhir
        $pdf->setxy($x, $y);
        $pdf->SetFont('Arial', 'BU', 8);
        $pdf->Cell($w[0], 6, '', 'LB');
        $pdf->Cell($w[1], 6, '', 'B', 0, 'R');
        $pdf->Cell($w[2], 6, 'Jumlah', 'B', 0, 'R');
        $pdf->Cell($w[3], 6, number_format($totalbplalu, 0, ',', '.'), 'BL', 0, 'R');
        $pdf->Cell($w[4], 6, number_format($totalbpini, 0, ',', '.'), 'BLR', 0, 'R');


        $y = $pdf->gety() + 10;

        $pdf->setxy($x, $y);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($w[0], 6, 'Jumlah periode ini', '');
        $pdf->Cell($w[1], 6, '', '', 0, 'R');
        $pdf->Cell($w[2], 6, '', '', 0, 'R');
        $pdf->Cell($w[3], 6, '', '', 0, 'R');
        $pdf->Cell($w[4], 6,  number_format($totalbpini, 2, ',', '.'), '', 0, 'R');
        $pdf->ln();
        $pdf->setxy($x, $pdf->GetY());
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($w[0], 6, 'Jumlah sampai periode lalu', '');
        $pdf->Cell($w[1], 6, '', '', 0, 'R');
        $pdf->Cell($w[2], 6, '', '', 0, 'R');
        $pdf->Cell($w[3], 6, '', '', 0, 'R');
        $pdf->Cell($w[4], 6, number_format($totalbplalu, 2, ',', '.'), '', 0, 'R');
        $pdf->ln();
        $pdf->setxy($x, $pdf->GetY());
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($w[0], 6, 'Jumlah semua sampai periode ini', '');
        $pdf->Cell($w[1], 6, '', '', 0, 'R');
        $pdf->Cell($w[2], 6, '', '', 0, 'R');
        $pdf->Cell($w[3], 6, '', 'B', 0, 'R');
        $totalSdInidb = ($totalbpini + $totalbplalu);
        $pdf->Cell($w[4], 6, number_format($totalSdInidb, 2, ',', '.'), 'B', 0, 'R');
        //$pdf->ln();

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
		$pdf->Image(Tbsub::first()->getLogoImageRs(), 175, 14.5, 20, 20, '');

        $pdf->SetXY(35, 15);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
		$pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper("BUKU PEMBANTU"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, strtoupper("PER RINCIAN OBYEK PENERIMAAN"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(150, 4, 'Periode: ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(180, 6, '', 'B', 'C', 0);

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
		
		
		$pdf->SetXY($left, $y);
		$xcurrent = $left;
		$pdf->MultiCell($w[0], 4, "Kode Rekening", '', 'L', 0);
		$xcurrent = $xcurrent + $w[0];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
		$xcurrent = $xcurrent + $w[1];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, $data->Ko_Rkk, '', 'L', 0);
		$xcurrent = $xcurrent + $w[2];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, "", '', 'L', 0);
		$y = $pdf->GetY() + 1;


		$pdf->SetXY($left, $y);
		$xcurrent = $left;
		$pdf->MultiCell($w[0], 4, "Nama Rekening", '', 'L', 0);
		$xcurrent = $xcurrent + $w[0];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
		$xcurrent = $xcurrent + $w[1];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, $data->nmrek6, '', 'L', 0);
		$xcurrent = $xcurrent + $w[2];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, "", '', 'L', 0);
		$y = $pdf->GetY() + 1;


		$pdf->SetXY($left, $y);
		$xcurrent = $left;
		$pdf->MultiCell($w[0], 4, "Pagu Anggaran", '', 'L', 0);
		$xcurrent = $xcurrent + $w[0];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[1], 4, ":", '', 'L', 0);
		$xcurrent = $xcurrent + $w[1];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, number_format($data->anggaran, 2, ',', '.'), '', 'L', 0);
		$y = $pdf->GetY() + 1;
		$xcurrent = $xcurrent + $w[2];
		$pdf->SetXY($xcurrent, $y);
		$pdf->MultiCell($w[2], 4, "", '', 'L', 0);

        $w = [10, 56, 56, 30, 30]; // Tentukan width masing-masing kolom
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $subKegiatan = $kodeSpj = null;
        $i = 1;

        $ysisa = $y1;

        $totalsetoran =  $totalbplalu = $totalbpini = 0;
        $totalsetoranp =  $totalbplalup = $totalbpinip = 0;
    }

    $y = MAX($y1, $y2, $y3);

    $yMaxAfter = max(
        $y + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->nmrek6),
        $y1,
        $y2
    );

    if ($pdf->checkIfPageExceed($yMaxAfter)) { //cek pagebreak
        // $ylst = PDF::Y_LIMIT - $yst; //207 batas margin bawah dikurang dengan y pertama
        $ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
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
	$pdf->MultiCell($w[1], 5, date('d/m/Y', strtotime($data->tgl_bukti)), '', 'C');
	$xcurrent = $xcurrent + $w[1];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w[2], 5, $data->no_bukti, '', 'L');
	$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent + $w[2];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w[3], 5, $data->kode == 1 ? number_format($data->jumlah, 0, ',', '.') : '', '', 'R');
	$xcurrent = $xcurrent + $w[3];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w[4], 5, $data->kode == 2 ? number_format($data->jumlah, 0, ',', '.') : '', '', 'R');
	$xcurrent = $xcurrent + $w[4];
	$pdf->SetXY($xcurrent, $y);
	if ($data->kode == 1) $totalbplalu += $data->jumlah;
	if ($data->kode == 2) $totalbpini += $data->jumlah;

    $totalsetoran = $data->jumlah;

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    //simpan untuk cek kegiatan/program
    $rekening = $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas . '.' .
        $data->kdrek1 . '.' . $data->kdrek2 . '.' . $data->kdrek3 . '.' . $data->kdrek4 . '.' . $data->kdrek5 . '.' . $data->kdrek6;
    $subKegiatan = $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas;
    $kegiatan = $data->kdprogram . '.' . $data->kdkegiatan;
    $program = $data->kdprogram;
}

if ($totalbplalu + $totalbpini == 0) $sisaAnggaran = $totalsetoran;
$y = MAX($y1, $y2, $y3);

$ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
// $ylst = MAX($y1, $y2, $y3);
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'BU', 8);
$pdf->Cell($w[0], 6, '', 'B', 0, 'C');
$pdf->Cell($w[1], 6, '', 'B', 0, 'R');
$pdf->Cell($w[2], 6, 'Jumlah', 'B', 0, 'R');
$pdf->Cell($w[3], 6, number_format($totalbplalu, 0, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[4], 6, number_format($totalbpini, 0, ',', '.'), 'BLR', 0, 'R');

$y = $pdf->gety() + 10;

//Resume jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($w[0], 6, 'Jumlah periode ini', '');
$pdf->Cell($w[1], 6, '', '', 0, 'R');
$pdf->Cell($w[2], 6, '', '', 0, 'R');
$pdf->Cell($w[3], 6, '', '', 0, 'R');
$pdf->Cell($w[4], 6,  number_format($totalbpini, 2, ',', '.'), '', 0, 'R');
$pdf->ln();
$pdf->setxy($x, $pdf->GetY());
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($w[0], 6, 'Jumlah sampai periode lalu', '');
$pdf->Cell($w[1], 6, '', '', 0, 'R');
$pdf->Cell($w[2], 6, '', '', 0, 'R');
$pdf->Cell($w[3], 6, '', '', 0, 'R');
$pdf->Cell($w[4], 6, number_format($totalbplalu, 2, ',', '.'), '', 0, 'R');
$pdf->ln();
$pdf->setxy($x, $pdf->GetY());
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($w[0], 6, 'Jumlah semua sampai periode ini', '');
$pdf->Cell($w[1], 6, '', '', 0, 'R');
$pdf->Cell($w[2], 6, '', '', 0, 'R');
$pdf->Cell($w[3], 6, '', 'B', 0, 'R');
$totalSdInidb = ($totalbpini + $totalbplalu);
$pdf->Cell($w[4], 6, number_format($totalSdInidb, 2, ',', '.'), 'B', 0, 'R');

// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();

//Menampilkan tanda tangan
$y = $pdf->gety() + 12;
$pdf->SetXY(115, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
$pdf->SetXY(115, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Bendahara Penerimaan', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(115, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(115, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(115);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganBendahara ? $penandatanganBendahara->NIP_pjb : ''), '', 'C', 0);

$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$ysisa = $y1;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
