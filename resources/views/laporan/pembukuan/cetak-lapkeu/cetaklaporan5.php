<?php

use App\ExtendedClass\FpdfExtended as fpdf;
use Illuminate\Support\Facades\Request;
use App\Models\Tbsub;

class KodeRekening
{
	public static function rekeningKodeBuilder($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6)
	{
		return $kdrek1 . '.' . $kdrek2 . '.' . $kdrek3 . '.' . substr('00' . $kdrek4, -2) . '.' . substr('00' . $kdrek5, -2) . '.' . substr('0000' . $kdrek6, -4);
	}
}


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
        $this->SetXY($left, $this->GetY()+2);
        $this->Cell($w[0], 8, 'No', 'LBT', 0, 'C');
        $this->Cell($w[1], 8, 'Tanggal', 'LBTR', 0, 'C');
        $this->Cell($w[2], 8, 'No Bukti', 'LBTR', 0, 'C');
        $this->Cell($w[3], 8, 'Uraian', 'LBTR', 0, 'C');
        $this->Cell($w[4], 8, 'Debet', 'LBTR', 0, 'C');
        $this->Cell($w[5], 8, 'Kredit', 'LBTR', 0, 'C');
        $this->Cell($w[6], 8, 'Saldo', 'LBTR', 0, 'C');
        $this->ln();
    }
}
if (!$model['data']['daftarBuktiBukuBesar']) die("Data tidak ditemukan");

$pdf = new PDF('L', 'mm', [216, 330]);

$border = 0;
$rekening = null;
$saldo = 0;
$previousSaldoNormal = null;
foreach ($model['data']['daftarBuktiBukuBesar'] as $data) {
    if ($rekening != $data->kdrek1 . '.' . $data->kdrek2 . '.' . $data->kdrek3 . '.' . $data->kdrek4 . '.' . $data->kdrek5 . '.' . $data->kdrek6) {

        if ($rekening !== null) {
            if ($totalDebet + $totalKredit == 0) $sisaAnggaran = $totalanggaran;
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
            $pdf->Cell($w[3], 6, 'JUMLAH', 'BL', 0, 'R');
            $pdf->Cell($w[4], 6, number_format($totalDebet, 2, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[5], 6, number_format($totalKredit, 2, ',', '.'), 'BL', 0, 'R');
            $pdf->Cell($w[6], 6, number_format(($previousSaldoNormal == 'D' ? $saldo : -$saldo), 2, ',', '.'), 1, 0, 'R');

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

        $pdf->SetXY(35, 15);
        $pdf->SetFont('Arial', 'B', 9);
		$pdf->MultiCell(290, 4, strtoupper($model['data']['refPemda'][0]->nmpemda), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() ));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(290, 4, strtoupper(nm_unit()), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() ));
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(290, 4, strtoupper("Buku Besar Pembantu Per Bukti"), '', 'C', 0);
        $pdf->SetXY(35, ($pdf->getY() ));
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(290, 4, 'Periode: ' . $pdf->tanggalTerbilang($tgl_1, 1) . ' s.d. ' . $pdf->tanggalTerbilang($tgl_2, 1), '', 'C', 0);
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(300, 6, '', 'B', 'C', 0);


        // $y = $pdf->GetY()+ 4;
		// $pdf->SetFont('Arial', '', 8);
		// $pdf->SetXY(15, $y);
		// $pdf->MultiCell(60, 5, 'SKPD', '', 'L', 0);
		// $pdf->SetXY(75, $y);
		// $pdf->MultiCell(5, 5, ':', '', 'L', 0);
		// $pdf->SetFont('Arial', '', 8);
		// $pdf->SetXY(78, $y);
		// $pdf->MultiCell(200, 5, $model['data']['ambilskpd'][0]->kode_skpd, '', 'L', 0);


		// $y = $pdf->GetY();
		// $pdf->SetFont('Arial', '', 8);
		// $pdf->SetXY(15, $y);
		// $pdf->MultiCell(60, 5, 'Unit Organisasi', '', 'L', 0);
		// $pdf->SetXY(75, $y);
		// $pdf->MultiCell(5, 5, ':', '', 'L', 0);
		// $pdf->SetFont('Arial', '', 8);
		// $pdf->SetXY(78, $y);
		// $pdf->MultiCell(200, 5, $model['data']['ambilunit'][0]->kode_unit, '', 'L', 0);

        $y = $pdf->GetY() + 6;
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(15, $y);
        $pdf->MultiCell(60, 5, 'Rekening', '', 'L', 0);
        $pdf->SetXY(75, $y);
        $pdf->MultiCell(5, 5, ':', '', 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(78, $y);
        $pdf->MultiCell(200, 5, KodeRekening::rekeningKodeBuilder($data->kdrek1, $data->kdrek2, $data->kdrek3, $data->kdrek4, $data->kdrek5, $data->kdrek6) . ' ' . $data->nmrek6, '', 'L', 0);

        $w = [15, 25, 60, 110, 30, 30, 30]; // Tentukan width masing-masing kolom
        $pdf->breakPageTableHeader($left, $w);


        $y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $kode = $program = $kegiatan = $subKegiatan = $kodeSpj  = $rekening = null;
        $i = 1;

        $ysisa = $y1;

        $totalanggaran = $totallalu = $totalDebet = $totalKredit = $totalsdini = $totalsisa = 0;
        $totalanggaranp = $totallalup = $totalDebetp = $totalKreditp = $totalsdinip = $totalsisap = 0;
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
    $pdf->MultiCell($w[1], 5, date('d/m/Y', strtotime($data->tgl_bukti)), '', 'C');
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 5, $data->no_bukti, '', 'L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 5, $data->uraian, '', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 5, ($data->kode == 1 ? number_format($data->debet, 2, ',', '.') : ''), '', 'R');
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 5, ($data->kode == 1 ? number_format($data->kredit, 2, ',', '.') : ''), '', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $saldo = $saldo + $data->debet - $data->kredit;
    $pdf->MultiCell($w[6], 5, number_format(($data->saldo_normal == 'D' ? $saldo : -$saldo), 2, ',', '.'), '', 'R');
    $xcurrent = $xcurrent + $w[6];
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
$pdf->Cell($w[3], 6, 'JUMLAH', 'BL', 0, 'R');
$pdf->Cell($w[4], 6, number_format($totalDebet, 2, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[5], 6, number_format($totalKredit, 2, ',', '.'), 'BL', 0, 'R');
$pdf->Cell($w[6], 6, number_format(($previousSaldoNormal == 'D' ? $saldo : -$saldo), 2, ',', '.'), 1, 0, 'R');

// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();

$y1 = $y2 = $y3 = $y4 = $y5 = $y6 = $y7 = $y8 = $y9 = $y10 = $y11 = $y12 = $y13 = $pdf->GetY(); // Untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$ysisa = $y1;

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
