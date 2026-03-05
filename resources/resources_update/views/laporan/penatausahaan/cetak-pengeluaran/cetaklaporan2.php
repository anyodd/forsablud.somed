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
        $this->SetXY($left, $this->GetY() + 5);
        $this->Cell($w[0], 8, 'No', 'LTB', 0, 'C');
        $this->Cell($w[1], 8, 'Tanggal', 'LTRB', 0, 'C');
        $this->Cell($w[2], 8, 'No S-OPD', 'LTRB', 0, 'C');
        $this->Cell($w[3], 8, 'Jenis SPP', 'LTRB', 0, 'C');
        $this->Cell($w[4], 8, 'Uraian', 'LTRB', 0, 'C');
        $this->Cell($w[5], 8, 'Nilai', 'LTRB', 0, 'C');
        $this->ln();
    }
}

$pdf = new PDF('P', 'mm', [216, 330]);
$border = 0;
//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage('P', [216, 330]);
$pdf->SetMargins(25, 25, 25); //(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 25); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu
$pdf->Image(Tbsub::first()->getLogoImagePemda(), 19, 14.5, 20, 20, '');
$pdf->Image(Tbsub::first()->getLogoImageRs(), 175, 14.5, 20, 20, '');

$x = $left = 10;

$pdf->SetXY(35, 15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, strtoupper(nm_unit()), '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(150, 4, 'REGISTER SURAT OTORISASI PENCAIRAN DANA (S-OPD)', '', 'C', 0);
$pdf->SetXY(35, $pdf->getY() + 2);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 4, 'Periode ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(195, 6, '', 'B', 'C', 0);


$pdf->ln(1);
$w = [10, 26, 43, 16, 70, 30]; // Tentukan width masing-masing kolom


$pdf->breakPageTableHeader($left, $w);

$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$total = 0;
$lastDate = $lastNoBukti = null;

foreach ($model['data']['registerSpm'] as $data) {

    $yMaxAfter = max(
        $pdf->getY() + $pdf->GetMultiCellHeight($w[1], 5, $data->spm_tgl),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[2], 5, $data->spm_no),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[3], 5, $data->spp_jn),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[4], 5, $data->uraian),
        $pdf->getY() + $pdf->GetMultiCellHeight($w[5], 5, number_format($data->nilai, 0, ',', '.')),
    );

    $y = MAX($y1, $y2, $y3);

    // IF($y2 > 295 || $y1 + (5*(strlen($data->uraian)/35)) > 295 ){ //cek pagebreak
    if ($yMaxAfter > 290) {
        $ylst = 305 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
        $pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AliasNbPages();
        $left = 10;

        $pdf->breakPageTableHeader($left, $w);

        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = $left;
        $ysisa = $y1;
        $y = MAX($y1, $y2, $y3);
    }



    $pdf->SetFont('Arial', '', 8);
    //new data		
    $pdf->SetXY($x, $y);
    $xcurrent = $x;
    $pdf->MultiCell($w[0], 5, $i, '', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 4, $lastDate != $data->spm_tgl ? date('d-m-Y', strtotime($data->spm_tgl)) : '', '', 'L');
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 4, $data->spm_no, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 4, $data->spp_jn, '', 'C');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 4, $data->uraian, '', 'L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 4, number_format($data->nilai, 0, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    $lastDate = $data->spm_tgl;
    $lastNoBukti = $data->spm_no;
    $total += $data->nilai;
}

$y = max($y1, $y2, $y3);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->createBreakPageColumnLine($x, $w, $yst, $ylst);

//Menampilkan jumlah halaman terakhir
$pdf->setxy($x, $y);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell($w[0], 8, '', 'LB');
$pdf->Cell($w[1], 8, '', 'B', 0, 'C');
$pdf->Cell($w[2], 8, '', 'B', 0, 'R');
$pdf->Cell($w[3], 8, '', 'B', 0, 'R');
$pdf->Cell($w[4], 8, 'Total', 'BR', 0, 'R');
$pdf->Cell($w[5], 8, number_format($total, 0, ',', '.'), 'BR', 0, 'R');
$pdf->ln();


// jika page melebihi -70 y maka pindahkan ke halaman baru
if ($y > ($pdf->GetPageHeight() - 52)) {
    $pdf->AddPage();
    $pdf->SetY(15);
    $y=15;
}

/////PENANDATANGAN
$y = $pdf->gety() + 6;
$pdf->SetXY(15, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, "Mengetahui/Menyetujui:", '', 'C', 0); 
$pdf->SetXY(15, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Pimpinan BLUD', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(15, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(15, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganPimpinan ? $penandatanganPimpinan->NIP_pjb : ''), '', 'C', 0);
$pdf->SetXY(115, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
$pdf->SetXY(115, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Bendahara Pengeluaran', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(115, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(115, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(115);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganBendahara ? $penandatanganBendahara->NIP_pjb : ''), '', 'C', 0);
$y = $pdf->GetY() + 6;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
