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

class PDF extends fpdf
{
    const Y_LIMIT = 188;

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
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($left, $this->GetY());
        $this->Cell($w[0], 24, 'KODE REKENING', 'LBT', 0, 'C');
        $this->Cell($w[1], 24, 'URAIAN', 'LBTR', 0, 'C');
        $this->Cell($w[2], 24, 'ANGGARAN', 'LBTR', 0, 'C');
        $this->Cell($w[3], 6, 's.d BULAN LALU', 'LBTR', 0, 'C');
        $this->Cell($w[4], 6, 'BULAN INI', 'LBTR', 0, 'C');
        $this->Cell($w[5], 6, 's.d BULAN INI', 'LBTR', 0, 'C');
        $this->Cell($w[6], 24, 'SPJ s.d BULAN INI', 'LBTR', 0, 'C');
        $this->Cell($w[7], 24, 'SISA ANGGARAN', 'LBTR', 0, 'C');
        $this->ln();
        $y = $this->GetY() - 18;
        $this->SetDash(1, 1);
        $this->SetXY($left + $w[0] + $w[1] + $w[2], $y);
        $this->Cell($w[3] + $w[4] + $w[5], 6, 'SPJ - LS Gaji', 'B', 0, 'C');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY($left + $w[0] + $w[1] + $w[2], $y);
        $this->Cell($w[3] + $w[4] + $w[5], 6, 'SPJ - LS Barang & Jasa', 'B', 0, 'C');
        $this->ln();
        $y = $this->GetY();
        $this->SetDash();
        $this->SetXY($left + $w[0] + $w[1] + $w[2], $y);
        $this->Cell($w[3] + $w[4] + $w[5], 6, 'SPJ - UP/GU', 'B', 0, 'C');
        $this->ln();
    }
}

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
$pdf->MultiCell(290, 4, strtoupper("LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN"), '', 'C', 0);
$pdf->SetXY(35, ($pdf->getY() + 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(290, 4, strtoupper("LPJ Belanja - " .  ($jn_spj == 1 ? 'Administratif' : 'Fungsional')), '', 'C', 0);
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->MultiCell(300, 6, '', 'B', 'C', 0);

$y = $pdf->GetY() + 4;
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 5, 'Pimpinan BLUD', '', 'L', 0);
$pdf->SetXY(75, $y);
$pdf->MultiCell(5, 5, ':', '', 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(78, $y);
$pdf->MultiCell(200, 5, ($penandatanganPimpinan ? $penandatanganPimpinan->Nm_pjb : ''), '', 'L', 0);

$y = $pdf->GetY();
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 6, 'Bendahara Pengeluaran', '', 'L', 0);
$pdf->SetXY(75, $y);
$pdf->MultiCell(5, 6, ':', '', 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(78, $y);
$pdf->MultiCell(145, 6, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'L', 0);
$yLabel = $pdf->GetY();

$y = $yLabel;
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 6, 'Bulan', '', 'L', 0);
$pdf->SetXY(75, $y);
$pdf->MultiCell(5, 6, ':', '', 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(78, $y);
$pdf->MultiCell(145, 6, $pdf->bulan($bulan), '', 'L', 0);


$w = [30, 90, 30, 30, 30, 30, 30, 30]; // Tentukan width masing-masing kolom
$pdf->breakPageTableHeader($left, $w);


$y1 = $y2 = $y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$kode = $program = $kegiatan = $subKegiatan = $kodeSpj = null;
$i = 1;

$ysisa = $y1;

$totalanggaran = $totalsdini = $totalsisa = $totalLsGajiLalu = $totalLsGajiIni = $totalLsBarangJasaLalu = $totalLsBarangJasaIni = $totalGuLalu = $totalGuIni = 0;


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
    $pdf->MultiCell($w[0], 6, KodeRekening::rekeningKodeBuilder($data->kdrek1, $data->kdrek2, $data->kdrek3, $data->kdrek4, $data->kdrek5, $data->kdrek6), 'T', 'C');
    $xcurrent = $xcurrent + $w[0];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[1], 6, $data->nmrek6, 'T', 'L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[1];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[2], 6, $pdf->accountingNumberFormat($data->anggaran), 'T', 'R');
    $xcurrent = $xcurrent + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, $pdf->accountingNumberFormat($data->nilai_ls_gaji_lalu), 'T', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, $pdf->accountingNumberFormat($data->nilai_ls_gaji_ini), 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, $pdf->accountingNumberFormat(($data->nilai_ls_gaji_ini + $data->nilai_ls_gaji_lalu)), 'T', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);
    $totalSpjIni = ($data->nilai_ls_gaji_ini + $data->nilai_ls_gaji_lalu) + ($data->nilai_ls_barang_jasa_ini + $data->nilai_ls_barang_jasa_lalu) + ($data->nilai_gu_ini + $data->nilai_gu_lalu);
    $pdf->MultiCell($w[6], 6, $pdf->accountingNumberFormat($totalSpjIni), 'T', 'R');
    $xcurrent = $xcurrent + $w[6];
    $pdf->SetXY($xcurrent, $y);
    $sisaAnggaran = $data->anggaran - $totalSpjIni;
    $pdf->MultiCell($w[7], 6, $pdf->accountingNumberFormat($sisaAnggaran), 'T', 'R');
    $xcurrent = $xcurrent + $w[7];
    $pdf->SetXY($xcurrent, $y);

    // bagian dash putus putus
    $pdf->SetDash(1, 1);
    $pdf->ln();
    $y = $pdf->GetY();
    $xcurrent = $x + $w[0] + $w[1] + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, $pdf->accountingNumberFormat($data->nilai_ls_barang_jasa_lalu), 'T', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, $pdf->accountingNumberFormat($data->nilai_ls_barang_jasa_ini), 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, $pdf->accountingNumberFormat(($data->nilai_ls_barang_jasa_ini + $data->nilai_ls_barang_jasa_lalu)), 'T', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    $pdf->ln();
    $y = $pdf->GetY();
    $xcurrent = $x + $w[0] + $w[1] + $w[2];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[3], 6, $pdf->accountingNumberFormat($data->nilai_gu_lalu), 'T', 'R');
    $xcurrent = $xcurrent + $w[3];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[4], 6, $pdf->accountingNumberFormat($data->nilai_gu_ini), 'T', 'R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent + $w[4];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w[5], 6, $pdf->accountingNumberFormat(($data->nilai_gu_ini + $data->nilai_gu_lalu)), 'T', 'R');
    $xcurrent = $xcurrent + $w[5];
    $pdf->SetXY($xcurrent, $y);

    $totalanggaran = $totalanggaran + $data->anggaran;
    $totalLsGajiLalu += $data->nilai_ls_gaji_lalu;
    $totalLsGajiIni += $data->nilai_ls_gaji_ini;
    $totalLsBarangJasaLalu += $data->nilai_ls_barang_jasa_lalu;
    $totalLsBarangJasaIni += $data->nilai_ls_barang_jasa_ini;
    $totalGuLalu += $data->nilai_gu_lalu;
    $totalGuIni += $data->nilai_gu_ini;
    $totalsdini = $totalsdini + $totalSpjIni;
    $totalsisa = $totalsisa + $sisaAnggaran;

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
$pdf->MultiCell($w[2], 6, $pdf->accountingNumberFormat($totalanggaran), 'T', 'R');
$xcurrent = $xcurrent + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 6, $pdf->accountingNumberFormat($totalLsGajiLalu), 'T', 'R');
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 6, $pdf->accountingNumberFormat($totalLsGajiIni), 'T', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 6, $pdf->accountingNumberFormat(($totalLsGajiLalu + $totalLsGajiIni)), 'T', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);
$totalSpjIni = ($totalLsGajiLalu + $totalLsGajiIni) + ($totalLsBarangJasaLalu + $totalLsBarangJasaIni) + ($totalGuLalu + $totalGuIni);
$pdf->MultiCell($w[6], 6, $pdf->accountingNumberFormat($totalSpjIni), 'T', 'R');
$xcurrent = $xcurrent + $w[6];
$pdf->SetXY($xcurrent, $y);
$sisaAnggaran = $totalanggaran - $totalSpjIni;
$pdf->MultiCell($w[7], 6, $pdf->accountingNumberFormat($sisaAnggaran), 'T', 'R');
$xcurrent = $xcurrent + $w[7];
$pdf->SetXY($xcurrent, $y);

// bagian dash putus putus
$pdf->SetDash(1, 1);
$pdf->ln();
$y = $pdf->GetY();
$xcurrent = $x + $w[0] + $w[1] + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 6, $pdf->accountingNumberFormat($totalLsBarangJasaLalu), 'T', 'R');
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 6, $pdf->accountingNumberFormat($totalLsBarangJasaIni), 'T', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 6, $pdf->accountingNumberFormat(($totalLsBarangJasaLalu + $totalLsBarangJasaIni)), 'T', 'R');
$xcurrent = $xcurrent + $w[5];
$pdf->SetXY($xcurrent, $y);

$pdf->ln();
$y = $pdf->GetY();
$xcurrent = $x + $w[0] + $w[1] + $w[2];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[3], 6, $pdf->accountingNumberFormat($totalGuLalu), 'T', 'R');
$xcurrent = $xcurrent + $w[3];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[4], 6, $pdf->accountingNumberFormat($totalGuIni), 'T', 'R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent + $w[4];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w[5], 6, $pdf->accountingNumberFormat(($totalGuLalu + $totalGuIni)), 'T', 'R');
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
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 100)) $pdf->AddPage();

$y = $pdf->GetY() + 6;
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 4, 'Penerimaan', '', 'L', 0);
$totalPenerimaan = 0;
foreach ($model['data']['spjfooter'] as $data) {
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY(15, $y);
    $uraian = null;
    switch ($data->kode_summary_spj) {
        case 1:
            $uraian = 'SP2D';
            break;
        case 2:
            $uraian = 'Pajak';
            break;
		case 3:
            $uraian = 'APBD';
            break;
        case 6:
            $uraian = 'Lain-Lain';
            break;

        default:
            # code...
            break;
    }
    $pdf->MultiCell(60, 4, '-  ' . $uraian, '', 'L', 0);
    $pdf->SetXY(75, $y);
    $pdf->MultiCell(5, 4, '', '', 'L', 0);
    $pdf->SetXY(78, $y);
    $pdf->MultiCell(40, 4, $pdf->accountingNumberFormat($data->debet), '', 'R', 0);
    $totalPenerimaan += $data->debet;
}

$y = $pdf->GetY();
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 4, 'Jumlah Penerimaan', '', 'L', 0);
$pdf->SetXY(75, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(5, 4, '', '', 'L', 0);
$pdf->SetXY(78, $y);
$pdf->MultiCell(40, 4, $pdf->accountingNumberFormat($totalPenerimaan), 'B', 'R', 0);

$y = $pdf->GetY() + 6;
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 4, 'Pengeluaran', '', 'L', 0);

$totalPengeluaran = 0;
foreach ($model['data']['spjfooter'] as $data) {
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY(15, $y);
    $uraian = null;
    switch ($data->kode_summary_spj) {
        case 1:
            $uraian = 'SPJ (LS + UP/GU)';
            break;
        case 2:
            $uraian = 'Pajak';
            break;
		case 3:
            $uraian = 'APBD';
            break;
        case 6:
            $uraian = 'Lain-Lain';
            break;

        default:
            # code...
            break;
    }
    $pdf->MultiCell(60, 4, '-  ' . $uraian, '', 'L', 0);
    $pdf->SetXY(75, $y);
    $pdf->MultiCell(5, 4, '', '', 'L', 0);
    $pdf->SetXY(78, $y);
    $pdf->MultiCell(40, 4, $pdf->accountingNumberFormat($data->kredit), '', 'R', 0);
    $totalPengeluaran += $data->kredit;
}

$y = $pdf->GetY();
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 4, 'Jumlah Pengeluaran', '', 'L', 0);
$pdf->SetXY(75, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(5, 4, '', '', 'L', 0);
$pdf->SetXY(78, $y);
$pdf->MultiCell(40, 4, $pdf->accountingNumberFormat($totalPengeluaran), 'B', 'R', 0);

$y = $pdf->GetY() + 6;
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(15, $y);
$pdf->MultiCell(60, 4, 'Saldo Kas', '', 'L', 0);
$pdf->SetXY(75, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(5, 4, '', '', 'L', 0);
$pdf->SetXY(78, $y);
$pdf->MultiCell(40, 4, $pdf->accountingNumberFormat(($totalPenerimaan - $totalPengeluaran)), 'BT', 'R', 0);


// $pdf->ln();
if (($pdf->gety() + 6) >= ($pdf::Y_LIMIT - 30)) $pdf->AddPage();
//Menampilkan tanda tangan
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
$pdf->SetXY(235, $y);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 5, $ibukota . ', ' . DATE('j', strtotime($tgl_laporan)) . ' ' . $pdf->bulan(DATE('m', strtotime($tgl_laporan))) . ' ' . DATE('Y', strtotime($tgl_laporan)), '', 'C', 0);
$pdf->SetXY(235, $pdf->gety());
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'Bendahara Pengeluaran', '', 'C', 0);
$pdf->Ln(3);
$pdf->SetXY(235, $pdf->gety());
$pdf->MultiCell(90, 5, "", '', 'C', 0);
$pdf->SetXY(235, $pdf->gety() + 5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, ($penandatanganBendahara ? $penandatanganBendahara->Nm_pjb : ''), '', 'C', 0);
$pdf->SetX(235);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(90, 5, 'NIP ' . ($penandatanganBendahara ? $penandatanganBendahara->NIP_pjb : ''), '', 'C', 0);

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
