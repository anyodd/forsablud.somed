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
        $this->Cell($w[0], 8, 'KODE REKENING', 'LBT', 0, 'C');
        $this->Cell($w[1], 8, 'URAIAN', 'LBTR', 0, 'C');
        $this->Cell($w[2], 8, 'TANGGAL', 'LBTR', 0, 'C');
        $this->Cell($w[3], 8, 'NO BUKTI', 'LBTR', 0, 'C');
        $this->Cell($w[4], 8, 'JUMLAH', 'LBTR', 0, 'C');
        $this->ln();
    }
}
if (!$model['data']['rekappdpt']) die("Data tidak ditemukan");

$pdf = new PDF('L', 'mm', [216, 330]);

$border = 0;
$subKegiatan = $kegiatan = $program = $lastRek = null;
$setorRekeningIni = 0;
foreach ($model['data']['rekappdpt'] as $data) {
	if ($subKegiatan != $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas) {
        //Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
        $pdf->AddPage();
        $pdf->SetMargins(25, 10, 20); //(float left, float top [, float right])
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
		$pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(290, 4, strtoupper(nm_unit()), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() + 2));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(290, 4, strtoupper("BUKU REKAP PENERIMAAN"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY()+ 2 ));
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(290, 4, 'Periode: ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(300, 6, '', 'B', 'C', 0);

        //content
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

        $pdf->ln(5);
        $w = [30, 100, 30, 90, 50]; // Tentukan width masing-masing kolom

        $pdf->breakPageTableHeader($left, $w);

        $y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $subKegiatan = $kodeSpj = null;
        $i = 1;

        $ysisa = $y1;

        $totalsetoran = $totalbp6 = 0;
        $totalsetoranp = $totalbp6p = 0;

        $setorRekeningIni = 0;
    }

    if (
        $subKegiatan != $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas
        && $subKegiatan != null
    ) {
        $setorRekeningIni = 0;
        if ($totalbp6 == 0) $sisaAnggaran = $totalsetoran;
        $y = MAX($y1, $y2, $y3);

        $ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
        // $ylst = MAX($y1, $y2, $y3);
        $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

        //Menampilkan jumlah halaman terakhir
        $pdf->setxy($x, $y);
        $pdf->SetFont('Arial', 'BU', 8);
        $pdf->Cell($w[0], 6, '', 'LB');
        $pdf->Cell($w[1], 6, '', 'B', 0, 'C');
        $pdf->Cell($w[2], 6, '', 'B', 0, 'R');
        $pdf->Cell($w[3], 6, 'TOTAL', 'B', 0, 'R');
        $pdf->Cell($w[4], 6, number_format($totalbp6, 2, ',', '.'), 'BLR', 0, 'R');


        //Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
        $pdf->AddPage();
        $pdf->SetMargins(25, 10, 20); //(float left, float top [, float right])
        $pdf->SetAutoPageBreak(true, 10); // set bottom margin (boolean auto [, float margin])
        $pdf->AliasNbPages();

        $x = 15;
        $left = 15;
        // Kotak Full Halaman
        // $pdf->Rect($x, 10, 300, 195);

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

        $w = [30, 100, 30, 90, 50]; // Tentukan width masing-masing kolom

        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $kodeSpj = null;;
        $i = 1;

        $ysisa = $y1;

        $totalsetoran = $totalbp6 = 0;
        $totalsetoranp =  $totalbp6p = 0;
    }



    $y = MAX($y1, $y2, $y3);

    $yMaxAfter = max(
        $y + $pdf->GetMultiCellHeight($w[1] - 6, 5, $data->nmrek),
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
    if ($data->kode_rekening != null) {
        $pdf->SetFont('Arial', '', 8);
        //new data
        if ($data->tgl_bukti) {
            $pdf->setDash(1, 1);
        } else {
            $pdf->setDash();
        }
        $pdf->SetXY($x, $y);
        $xcurrent = $x;
        $pdf->MultiCell($w[0], 5, $lastRek != $data->kode_rekening ? $data->kode_rekening : '', 'T', 'L');
        $xcurrent = $xcurrent + $w[0];
        if ($data->tgl_bukti) {
            $pdf->setDash(1, 1);
        } else {
            $pdf->setDash();
        }
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[1], 5, $lastRek != $data->kode_rekening ? $data->nmrek : '', 'T', 'L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[1];
        if ($data->tgl_bukti) {
            $pdf->setDash(1, 1);
        } else {
            $pdf->setDash();
        }
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[2], 5, $data->kdlevel == 6 ? date('d-m-Y', strtotime($data->tgl_bukti)) : '', 'T', 'C');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[2];
        if ($data->tgl_bukti) {
            $pdf->setDash(1, 1);
        } else {
            $pdf->setDash();
        }
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[3], 5,  $data->kdlevel == 6 ? $data->no_bukti : '', 'T', 'L');
        $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent + $w[3];
        if ($data->tgl_bukti) {
            $pdf->setDash(1, 1);
        } else {
            $pdf->setDash();
        }
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w[4], 5, number_format($data->jumlah, 2, ',', '.'), 'T', 'R');
        $pdf->setDash();
        $xcurrent = $xcurrent + $w[4];
        if ($data->kdlevel == 6) $totalbp6 += $data->jumlah;
    }

    $totalsetoran = $data->jumlah;

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $lastRek = $data->kode_rekening;
	
	//simpan untuk cek kegiatan/program
    $subKegiatan = $data->kdprogram . '.' . $data->kdkegiatan . '.' . $data->kdsubkegiatan . '.' . $data->kdaktivitas;
    $kegiatan = $data->kdprogram . '.' . $data->kdkegiatan;
    $program = $data->kdprogram;

}

if ($totalbp6 == 0) $sisaAnggaran = $totalsetoran;
$y = MAX($y1, $y2, $y3);

$ylst = $y - $yst; //207 batas margin bawah dikurang dengan y pertama
// $ylst = MAX($y1, $y2, $y3);
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'BU', 8);
$pdf->Cell($w[0], 6, '', 'LB');
$pdf->Cell($w[1], 6, '', 'B', 0, 'C');
$pdf->Cell($w[2], 6, '', 'B', 0, 'R');
$pdf->Cell($w[3], 6, 'TOTAL', 'B', 0, 'R');
$pdf->Cell($w[4], 6, number_format($totalbp6, 2, ',', '.'), 'BLR', 0, 'R');
$pdf->ln();


// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 36)) $pdf->AddPage();

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

$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$ysisa = $y1;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
