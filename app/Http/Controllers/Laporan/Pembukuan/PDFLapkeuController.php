<?php

namespace App\Http\Controllers\Laporan\Pembukuan;

use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;

class PDFLapkeuController extends Controller
{
    public function index()
    {
        return view('laporan.pembukuan.lapkeu.index');
    }

    public function lapkeu_pdf(Request $request)
    {
        // dd($request->all());

        $tahun_lalu = Tahun() - 1;

        $data['tgl_lap'] = $request->tgl_lap;

        // Menentukan bulan transaksi
        if ($request->jns_periode == 'tahun') {
            $bulan = 12;
        } elseif (substr($request->jns_periode, 0, 5) == 'bulan') {
            $bulan = substr($request->jns_periode, 5, 2);
        } elseif (substr($request->jns_periode, 0, 4) == 'sem1') {
            $bulan = 6;
        } elseif (substr($request->jns_periode, 0, 4) == 'sem2') {
            $bulan = 12;
        } else {
            // code ...
        }

        switch ($request->jns_lap) {

                // LRA ----------------------------------------------------------------------------------v

            case 'lra':
                $sp_lra = DB::select("call sp_lra(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");

                // Rincian
                $lra_pendapatan = collect($sp_lra)->where('jns_lap', 1);
                $lra_belanja_operasi = collect($sp_lra)->where('jns_lap', 2);
                $lra_belanja_modal = collect($sp_lra)->where('jns_lap', 3);
                $lra_terima_biaya = collect($sp_lra)->where('jns_lap', 4);
                $lra_keluar_biaya = collect($sp_lra)->where('jns_lap', 5);

                // Jumlah Anggaran
                $data['jum_lra_pendapatan_ang'] = collect($sp_lra)->where('jns_lap', 1)->sum('ang_kini');
                $data['jum_lra_belanja_operasi_ang'] = collect($sp_lra)->where('jns_lap', 2)->sum('ang_kini');
                $data['jum_lra_belanja_modal_ang'] = collect($sp_lra)->where('jns_lap', 3)->sum('ang_kini');
                $data['jum_lra_belanja_ang'] = $data['jum_lra_belanja_operasi_ang'] + $data['jum_lra_belanja_modal_ang'];
                $data['jum_lra_terima_biaya_ang'] = collect($sp_lra)->where('jns_lap', 4)->sum('ang_kini');
                $data['jum_lra_keluar_biaya_ang'] = collect($sp_lra)->where('jns_lap', 5)->sum('ang_kini');

                // Jumlah LRA kini
                $data['jum_lra_pendapatan_kini'] = collect($sp_lra)->where('jns_lap', 1)->sum('lra_kini');
                $data['jum_lra_belanja_operasi_kini'] = collect($sp_lra)->where('jns_lap', 2)->sum('lra_kini');
                $data['jum_lra_belanja_modal_kini'] = collect($sp_lra)->where('jns_lap', 3)->sum('lra_kini');
                $data['jum_lra_belanja_kini'] = $data['jum_lra_belanja_operasi_kini'] + $data['jum_lra_belanja_modal_kini'];
                $data['jum_lra_terima_biaya_kini'] = collect($sp_lra)->where('jns_lap', 4)->sum('lra_kini');
                $data['jum_lra_keluar_biaya_kini'] = collect($sp_lra)->where('jns_lap', 5)->sum('lra_kini');

                // Jumlah LRA lalu
                $data['jum_lra_pendapatan_lalu'] = collect($sp_lra)->where('jns_lap', 1)->sum('lra_lalu');
                $data['jum_lra_belanja_operasi_lalu'] = collect($sp_lra)->where('jns_lap', 2)->sum('lra_lalu');
                $data['jum_lra_belanja_modal_lalu'] = collect($sp_lra)->where('jns_lap', 3)->sum('lra_lalu');
                $data['jum_lra_belanja_lalu'] = $data['jum_lra_belanja_operasi_lalu'] + $data['jum_lra_belanja_modal_lalu'];
                $data['jum_lra_terima_biaya_lalu'] = collect($sp_lra)->where('jns_lap', 4)->sum('lra_lalu');
                $data['jum_lra_keluar_biaya_lalu'] = collect($sp_lra)->where('jns_lap', 5)->sum('lra_lalu');

                // Surplus / (Defisit)
                $data['surplus_ang'] = $data['jum_lra_pendapatan_ang'] - $data['jum_lra_belanja_operasi_ang'] - $data['jum_lra_belanja_modal_ang'];
                $data['surplus_kini'] = $data['jum_lra_pendapatan_kini'] - $data['jum_lra_belanja_operasi_kini'] - $data['jum_lra_belanja_modal_kini'];
                $data['surplus_lalu'] = $data['jum_lra_pendapatan_lalu'] - $data['jum_lra_belanja_operasi_lalu'] - $data['jum_lra_belanja_modal_lalu'];

                // Pembiayaan netto
                $data['biaya_netto_ang'] = $data['jum_lra_terima_biaya_ang'] - $data['jum_lra_keluar_biaya_ang'];
                $data['biaya_netto_kini'] = $data['jum_lra_terima_biaya_kini'] - $data['jum_lra_keluar_biaya_kini'];
                $data['biaya_netto_lalu'] = $data['jum_lra_terima_biaya_lalu'] - $data['jum_lra_keluar_biaya_lalu'];

                // SILPA
                $data['silpa_ang'] = $data['surplus_ang'] + $data['biaya_netto_ang'];
                $data['silpa_kini'] = $data['surplus_kini'] + $data['biaya_netto_kini'];
                $data['silpa_lalu'] = $data['surplus_lalu'] + $data['biaya_netto_lalu'];

                // % realisasi
                $data['persen_pendapatan'] = $data['jum_lra_pendapatan_ang'] == 0 ? 0 : $data['jum_lra_pendapatan_kini'] / $data['jum_lra_pendapatan_ang'] * 100;
                $data['persen_belanja_operasi'] = $data['jum_lra_belanja_operasi_ang'] == 0 ? 0 : $data['jum_lra_belanja_operasi_kini'] / $data['jum_lra_belanja_operasi_ang'] * 100;
                $data['persen_belanja_modal'] = $data['jum_lra_belanja_modal_ang'] == 0 ? 0 : $data['jum_lra_belanja_modal_kini'] / $data['jum_lra_belanja_modal_ang'] * 100;
                $data['persen_belanja'] = $data['jum_lra_belanja_ang'] == 0 ? 0 : $data['jum_lra_belanja_kini'] / $data['jum_lra_belanja_ang'] * 100;
                if ($data['surplus_ang'] == 0 || $data['surplus_kini'] == 0) {
                    $data['persen_surplus'] = 0;
                } else {
                    $data['persen_surplus'] = $data['surplus_ang'] < 0 ? ($data['surplus_kini'] - $data['surplus_ang']) / $data['surplus_ang'] * -1 * 100 : $data['surplus_kini'] / $data['surplus_ang'] * 100;
                }
                $data['persen_terima_biaya'] = $data['jum_lra_terima_biaya_ang'] == 0 ? 0 : $data['jum_lra_terima_biaya_kini'] / $data['jum_lra_terima_biaya_ang'] * 100;
                $data['persen_keluar_biaya'] = $data['jum_lra_keluar_biaya_ang'] == 0 ? 0 : $data['jum_lra_keluar_biaya_kini'] / $data['jum_lra_keluar_biaya_ang'] * 100;
                $data['persen_biaya_netto'] = $data['biaya_netto_ang'] == 0 ? 0 : $data['biaya_netto_kini'] / $data['biaya_netto_ang'] * 100;

                if ($data['silpa_ang'] < 0) {
                    $data['persen_silpa'] = ($data['silpa_kini'] - $data['silpa_ang']) / $data['silpa_ang'] * -1 * 100;
                } elseif ($data['silpa_ang'] == 0) {
                    $data['persen_silpa'] = 0;
                } else {
                    $data['persen_silpa'] = $data['silpa_kini'] / $data['silpa_ang'] * 100;
                }

                // Judul Periode Laporan
                if ($request->jns_periode == 'bulan01') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan02') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan03') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                } elseif ($request->jns_periode == 'bulan04') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                } elseif ($request->jns_periode == 'bulan05') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                } elseif ($request->jns_periode == 'bulan07') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                } elseif ($request->jns_periode == 'bulan08') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                } elseif ($request->jns_periode == 'bulan09') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                } elseif ($request->jns_periode == 'bulan10') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                } elseif ($request->jns_periode == 'bulan11') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                } else {
                    $data['judul_periode'] = 'Untuk Tahun yang Berakhir 31 Desember ' . $tahun_lalu . ' dan ' . Tahun(); //ini tahunan
                }

                $title = 'LRA';
                $pdf = PDF::loadView('laporan.pembukuan.lapkeu.lra_pdf', $data, compact('lra_pendapatan', 'lra_belanja_operasi', 'lra_belanja_modal', 'lra_terima_biaya', 'lra_keluar_biaya', 'title'))->setPaper('A4', 'portrait');
                return $pdf->stream('LRA ' . Tahun() . '.pdf',  array("Attachment" => false));

                break;

                // LPSAL ---------------------------------------------------------------------------------v

            case 'lpsal':
                $sp_lra = DB::select("call sp_lra(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");

                $lra_terima_biaya = collect($sp_lra)->where('jns_lap', 4);
                $lra_kini = collect($lra_terima_biaya)->sum('kredit_kini');
                $lain_kini = collect($lra_terima_biaya)->sum('debet_kini');

                $data['jum_lra_pendapatan_kini'] = collect($sp_lra)->where('jns_lap', 1)->sum('lra_kini');
                $data['jum_lra_pendapatan_lalu'] = collect($sp_lra)->where('jns_lap', 1)->sum('lra_lalu');

                $data['jum_lra_belanja_operasi_kini'] = collect($sp_lra)->where('jns_lap', 2)->sum('lra_kini');
                $data['jum_lra_belanja_operasi_lalu'] = collect($sp_lra)->where('jns_lap', 2)->sum('lra_lalu');

                $data['jum_lra_belanja_modal_kini'] = collect($sp_lra)->where('jns_lap', 3)->sum('lra_kini');
                $data['jum_lra_belanja_modal_lalu'] = collect($sp_lra)->where('jns_lap', 3)->sum('lra_lalu');

                $data['jum_lra_belanja_kini'] = $data['jum_lra_belanja_operasi_kini'] + $data['jum_lra_belanja_modal_kini'];
                $data['jum_lra_belanja_lalu'] = $data['jum_lra_belanja_operasi_lalu'] + $data['jum_lra_belanja_modal_lalu'];

                $data['jum_lra_terima_biaya_kini'] = collect($sp_lra)->where('jns_lap', 4)->sum('lra_kini');
                $data['jum_lra_terima_biaya_lalu'] = collect($sp_lra)->where('jns_lap', 4)->sum('lra_lalu');

                $data['jum_lra_keluar_biaya_kini'] = collect($sp_lra)->where('jns_lap', 5)->sum('lra_kini');
                $data['jum_lra_keluar_biaya_lalu'] = collect($sp_lra)->where('jns_lap', 5)->sum('lra_lalu');

                $data['surplus_kini'] = $data['jum_lra_pendapatan_kini'] - $data['jum_lra_belanja_operasi_kini'] - $data['jum_lra_belanja_modal_kini'];
                $data['surplus_lalu'] = $data['jum_lra_pendapatan_lalu'] - $data['jum_lra_belanja_operasi_lalu'] - $data['jum_lra_belanja_modal_lalu'];

                $data['biaya_netto_kini'] = $data['jum_lra_terima_biaya_kini'] - $data['jum_lra_keluar_biaya_kini'];
                $data['biaya_netto_lalu'] = $data['jum_lra_terima_biaya_lalu'] - $data['jum_lra_keluar_biaya_lalu'];

                $data['silpa_kini'] = $data['surplus_kini'] + $data['biaya_netto_kini'];
                $data['silpa_lalu'] = $data['surplus_lalu'] + $data['biaya_netto_lalu'];

                //saldo awal
                $dt = DB::select("SELECT Ko_id,soaw_Rp FROM tb_soawlp a WHERE a.Ko_Period = '" . Tahun() . "' && Ko_unitstr = '" . kd_unit() . "' && a.Ko_lp = 1");
                $lpsal_1 = collect($dt)->where('Ko_id', 1)->first();
                $lpsal_2 = collect($dt)->where('Ko_id', 2)->first();
                $lpsal_3 = collect($dt)->where('Ko_id', 3)->first();
                $lpsal_3 = collect($dt)->where('Ko_id', 3)->first();
                $lpsal_4 = collect($dt)->where('Ko_id', 4)->first();
                $lpsal_5 = collect($dt)->where('Ko_id', 5)->first();

                // Judul Periode Laporan
                if ($request->jns_periode == 'bulan01') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan02') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan03') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                } elseif ($request->jns_periode == 'bulan04') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                } elseif ($request->jns_periode == 'bulan05') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                } elseif ($request->jns_periode == 'bulan07') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                } elseif ($request->jns_periode == 'bulan08') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                } elseif ($request->jns_periode == 'bulan09') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                } elseif ($request->jns_periode == 'bulan10') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                } elseif ($request->jns_periode == 'bulan11') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                } else {
                    $data['judul_periode'] = 'Untuk Tahun yang Berakhir 31 Desember ' . $tahun_lalu . ' dan ' . Tahun(); //ini tahunan
                }

                $title = 'LP SAL';
                $pdf = PDF::loadView('laporan.pembukuan.lapkeu.lpsal_th_pdf', $data, compact('title', 'lra_kini', 'lain_kini', 'lpsal_1', 'lpsal_2', 'lpsal_3', 'lpsal_4', 'lpsal_5'))->setPaper('A4', 'portrait');
                return $pdf->stream('LPSAL ' . Tahun() . '.pdf',  array("Attachment" => false));
                break;

                // NERACA ----------------------------------------------------------------------------------v

            case 'nrc':
                switch ($request->jns_periode) {
                    case 'tahun':
                        $neraca = DB::select("call sp_neraca_th(" . Tahun() . ", '" . kd_unit() . "' )");

                        $neraca_aktiva = collect($neraca)->where('jns', '1');
                        $neraca_pasiva = collect($neraca)->where('jns', '2');

                        $jum_kewajiban = collect($neraca)->where('kode', '02.99')->first();
                        $jum_ekuitas = collect($neraca)->where('kode', '03.99')->first();
                        // dd($jum_kewajiban);



                        if (!is_null($jum_kewajiban)) {
                            $data['jum_kewajiban_ekuitas_kini'] = ($jum_kewajiban->soakhir)  + ($jum_ekuitas->soakhir);
                        } else {
                            $data['jum_kewajiban_ekuitas_kini'] = 0;
                        };

                        if (!is_null($jum_kewajiban)) {
                            $data['jum_kewajiban_ekuitas_lalu'] = ($jum_kewajiban->soawal)  + ($jum_ekuitas->soawal);
                        } else {
                            $data['jum_kewajiban_ekuitas_lalu'] = 0;
                        };
                        // $data['jum_kewajiban_ekuitas_lalu'] = $jum_kewajiban->soawal + $jum_ekuitas->soawal;

                        $title = 'NERACA';
                        $pdf = PDF::loadView('laporan.pembukuan.lapkeu.neraca_th_pdf', $data, compact('neraca', 'neraca_aktiva', 'neraca_pasiva', 'title'))->setPaper('A4', 'portrait');

                        return $pdf->stream('Nerac_Tahun ' . Tahun() . '.pdf',  array("Attachment" => false));
                        break;

                    default:
                        $neraca = DB::select("call sp_neraca(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");

                        $neraca_aktiva = collect($neraca)->where('jns', '1');
                        $neraca_pasiva = collect($neraca)->where('jns', '2');

                        $jum_kewajiban = collect($neraca)->where('kode', '02.99')->first();
                        $jum_ekuitas = collect($neraca)->where('kode', '03.99')->first();

                        $data['jum_kewajiban_ekuitas_kini'] = $jum_kewajiban->soakhir + $jum_ekuitas->soakhir;
                        $data['jum_kewajiban_ekuitas_lalu'] = $jum_kewajiban->soawal + $jum_ekuitas->soawal;

                        $title = 'NERACA';

                        // Judul Periode Laporan
                        if ($request->jns_periode == 'bulan01') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan02') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan03') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan04') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan05') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan07') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan08') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan09') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan10') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan11') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                        } else {
                            $data['judul_periode'] = 'Per 31 Desember ' . $tahun_lalu . ' dan ' . Tahun(); //ini tahunan
                        }

                        $pdf = PDF::loadView('laporan.pembukuan.lapkeu.neraca_bln_pdf', $data, compact('neraca', 'neraca_aktiva', 'neraca_pasiva', 'title'))->setPaper('A4', 'portrait');
                        return $pdf->stream('Neraca Tahun ' . Tahun() . '.pdf',  array("Attachment" => false));

                        break;
                }

                break;

                // LAPORAN OPERASIONAL ----------------------------------------------------------------------------------------v
            case 'lo':
                $sp_lo = DB::select("call sp_lo(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");

                // rincian
                $lo_th_1 = collect($sp_lo)->where('jns_lap', 1); // pendapatan opr
                $lo_th_2 = collect($sp_lo)->where('jns_lap', 2); // beban opr
                $lo_th_3 = collect($sp_lo)->where('jns_lap', 3); // non opr
                $lo_th_4 = collect($sp_lo)->where('jns_lap', 4); // pos luar biasa

                $data['jum_pdp_opr_lalu'] = collect($sp_lo)->where('jns_lap', 1)->sum('lo_lalu');
                $data['jum_pdp_opr_kini'] = collect($sp_lo)->where('jns_lap', 1)->sum('lo_kini');
                $data['delta_pdp_opr']    = $data['jum_pdp_opr_kini'] - $data['jum_pdp_opr_lalu'];

                $data['jum_beban_opr_lalu'] = collect($sp_lo)->where('jns_lap', 2)->sum('lo_lalu');
                $data['jum_beban_opr_kini'] = collect($sp_lo)->where('jns_lap', 2)->sum('lo_kini');
                $data['delta_beban_opr']    = $data['jum_beban_opr_kini'] - $data['jum_beban_opr_lalu'];

                $data['surplus_opr_lalu'] = $data['jum_pdp_opr_lalu'] - $data['jum_beban_opr_lalu'];
                $data['surplus_opr_kini'] = $data['jum_pdp_opr_kini'] - $data['jum_beban_opr_kini'];
                $data['delta_surplus_opr'] = $data['surplus_opr_kini'] - $data['surplus_opr_lalu'];

                $data['surplus_non_opr_lalu']   = collect($sp_lo)->where('jns_lap', 3)->sum('lo_lalu');
                $data['surplus_non_opr_kini']   = collect($sp_lo)->where('jns_lap', 3)->sum('lo_kini');
                $data['delta_surplus_non_opr']  = $data['surplus_non_opr_kini'] - $data['surplus_non_opr_lalu'];

                $data['surplus_before_lb_lalu'] = $data['surplus_opr_lalu'] + $data['surplus_non_opr_lalu'];
                $data['surplus_before_lb_kini'] = $data['surplus_opr_kini'] + $data['surplus_non_opr_kini'];
                $data['delta_surplus_before_lb'] = $data['surplus_before_lb_kini'] - $data['surplus_before_lb_lalu'];

                $data['jum_pos_lb_lalu']  = collect($sp_lo)->where('jns_lap', 4)->sum('lo_lalu');
                $data['jum_pos_lb_kini']  = collect($sp_lo)->where('jns_lap', 4)->sum('lo_kini');
                $data['delta_pos_lb']     = $data['jum_pos_lb_kini'] - $data['jum_pos_lb_lalu'];

                $data['surplus_lo_lalu']  = $data['surplus_before_lb_lalu'] + $data['jum_pos_lb_lalu'];
                $data['surplus_lo_kini']  = $data['surplus_before_lb_kini'] + $data['jum_pos_lb_kini'];
                $data['delta_surplus_lo'] = $data['surplus_lo_kini'] - $data['surplus_lo_lalu'];

                // Judul Periode Laporan
                if ($request->jns_periode == 'bulan01') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan02') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan03') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                } elseif ($request->jns_periode == 'bulan04') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                } elseif ($request->jns_periode == 'bulan05') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                } elseif ($request->jns_periode == 'bulan07') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                } elseif ($request->jns_periode == 'bulan08') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                } elseif ($request->jns_periode == 'bulan09') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                } elseif ($request->jns_periode == 'bulan10') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                } elseif ($request->jns_periode == 'bulan11') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                } else {
                    $data['judul_periode'] = 'Untuk Tahun yang Berakhir 31 Desember ' . $tahun_lalu . ' dan ' . Tahun();
                }
                $title = 'LO';
                $pdf = PDF::loadView('laporan.pembukuan.lapkeu.lo_pdf', $data, compact('lo_th_1', 'lo_th_2', 'lo_th_3', 'lo_th_4', 'title'))
                    ->setPaper('A4', 'portrait');

                return $pdf->stream('Laporan Operasional ' . Tahun() . '.pdf',  array("Attachment" => false));

                break;

                // LAPORAN ARUS KAS -------------------------------------------------------------------------------------------v
            case 'lak':
                $sp_lak13 = DB::select("call sp_lak13(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");
                $sp_lak2 = DB::select("call sp_lak2(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");
                $sp_lak456 = DB::select("call sp_lak456(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");
                $sp_lak78 = DB::select("call sp_lak78(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");

                // Rincian
                $lak_masuk_operasi = collect($sp_lak13)->where('ko_lak', 1);
                $lak_keluar_operasi = collect($sp_lak2)->where('ko_lak', 2);
                $lak_masuk_investasi = collect($sp_lak13)->where('ko_lak', 3);
                $lak_keluar_investasi = collect($sp_lak456)->where('ko_lak', 4);
                $lak_masuk_pendanaan = collect($sp_lak456)->where('ko_lak', 5);
                $lak_keluar_pendanaan = collect($sp_lak456)->where('ko_lak', 6);
                $lak_transitori = collect($sp_lak78); //debet-> keluar, kredit-> masuk

                // Jumlah Arus Kas Masuk Operasi
                $data['jum_lak_masuk_operasi_kini'] = collect($sp_lak13)->where('ko_lak', 1)->sum('lak_kini');
                $data['jum_lak_masuk_operasi_lalu'] = collect($sp_lak13)->where('ko_lak', 1)->sum('lak_lalu');

                // Jumlah Arus Kas Keluar Operasi
                $data['jum_lak_keluar_operasi_kini'] = collect($sp_lak2)->where('ko_lak', 2)->sum('lak_kini');
                $data['jum_lak_keluar_operasi_lalu'] = collect($sp_lak2)->where('ko_lak', 2)->sum('lak_lalu');

                // Jumlah Arus Kas Bersih Operasi
                $data['jum_lak_bersih_operasi_kini'] = $data['jum_lak_masuk_operasi_kini'] - $data['jum_lak_keluar_operasi_kini'];
                $data['jum_lak_bersih_operasi_lalu'] = $data['jum_lak_masuk_operasi_lalu'] - $data['jum_lak_keluar_operasi_lalu'];

                // Jumlah Arus Kas Masuk Investasi
                $data['jum_lak_masuk_investasi_kini'] = collect($sp_lak13)->where('ko_lak', 3)->sum('lak_kini');
                $data['jum_lak_masuk_investasi_lalu'] = collect($sp_lak13)->where('ko_lak', 3)->sum('lak_lalu');

                // Jumlah Arus Kas Keluar Investasi
                $data['jum_lak_keluar_investasi_kini'] = collect($sp_lak456)->where('ko_lak', 4)->sum('lak_kini');
                $data['jum_lak_keluar_investasi_lalu'] = collect($sp_lak456)->where('ko_lak', 4)->sum('lak_lalu');

                // Jumlah Arus Kas Bersih Investasi
                $data['jum_lak_bersih_investasi_kini'] = $data['jum_lak_masuk_investasi_kini'] - $data['jum_lak_keluar_investasi_kini'];
                $data['jum_lak_bersih_investasi_lalu'] = $data['jum_lak_masuk_investasi_lalu'] - $data['jum_lak_keluar_investasi_lalu'];

                // Jumlah Arus Kas Masuk Pendanaan
                $data['jum_lak_masuk_pendanaan_kini'] = collect($sp_lak456)->where('ko_lak', 5)->sum('lak_kini');
                $data['jum_lak_masuk_pendanaan_lalu'] = collect($sp_lak456)->where('ko_lak', 5)->sum('lak_lalu');

                // Jumlah Arus Kas Keluar Pendanaan
                $data['jum_lak_keluar_pendanaan_kini'] = collect($sp_lak456)->where('ko_lak', 6)->sum('lak_kini');
                $data['jum_lak_keluar_pendanaan_lalu'] = collect($sp_lak456)->where('ko_lak', 6)->sum('lak_lalu');

                // Jumlah Arus Kas Bersih Pendanaan
                $data['jum_lak_bersih_pendanaan_kini'] = $data['jum_lak_masuk_pendanaan_kini'] - $data['jum_lak_keluar_pendanaan_kini'];
                $data['jum_lak_bersih_pendanaan_lalu'] = $data['jum_lak_masuk_pendanaan_lalu'] - $data['jum_lak_keluar_pendanaan_lalu'];

                // Transitoris
                $data['masuk_pfk_kini'] = empty($lak_transitori[0]) ? 0 : $lak_transitori[0]->kredit_kini;
                $data['keluar_pfk_kini'] = empty($lak_transitori[0]) ? 0 : $lak_transitori[0]->debet_kini;
                $data['masuk_pfk_lalu'] = empty($lak_transitori[0]) ? 0 : $lak_transitori[0]->kredit_lalu;
                $data['keluar_pfk_lalu'] = empty($lak_transitori[0]) ? 0 : $lak_transitori[0]->debet_lalu;

                // dd($data['keluar_pfk_kini']);

                // Jumlah Arus Kas Bersih Transitoris
                $data['jum_lak_bersih_trans_kini'] = $data['masuk_pfk_kini'] - $data['keluar_pfk_kini'];
                $data['jum_lak_bersih_trans_lalu'] = $data['masuk_pfk_lalu'] - $data['keluar_pfk_lalu'];

                // Kenaikan/Penurunan Kas
                $data['delta_kas_kini'] = $data['jum_lak_bersih_operasi_kini'] + $data['jum_lak_bersih_investasi_kini'] + $data['jum_lak_bersih_pendanaan_kini'] + $data['jum_lak_bersih_trans_kini'];
                $data['delta_kas_lalu'] = $data['jum_lak_bersih_operasi_lalu'] + $data['jum_lak_bersih_investasi_lalu'] + $data['jum_lak_bersih_pendanaan_lalu'] + $data['jum_lak_bersih_trans_lalu'];

                // Saldo Awal Kas
                $neraca = DB::select("call sp_neraca(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");
                $data['awal_kas_kini'] = collect($neraca)->where('kode', '01.01.01')->first()->soawal;

                // Saldo awal kas tahun lalu --> manual
                if (Tahun() == 2022 && kd_unit() == '33.05.01.02.01.001') {
                    $data['awal_kas_lalu'] = 42520446365;
                } else {
                    $data['awal_kas_lalu'] = 0;
                }

                // Saldo Akhir Kas
                $data['akhir_kas_kini'] = $data['awal_kas_kini'] + $data['delta_kas_kini'];

                // Judul Periode Laporan
                if ($request->jns_periode == 'bulan01') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan02') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan03') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                } elseif ($request->jns_periode == 'bulan04') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                } elseif ($request->jns_periode == 'bulan05') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                } elseif ($request->jns_periode == 'bulan07') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                } elseif ($request->jns_periode == 'bulan08') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                } elseif ($request->jns_periode == 'bulan09') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                } elseif ($request->jns_periode == 'bulan10') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                } elseif ($request->jns_periode == 'bulan11') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                } else {
                    $data['judul_periode'] = 'Untuk Tahun yang Berakhir 31 Desember ' . $tahun_lalu . ' dan ' . Tahun();
                }

                $title = 'LAK';
                $pdf = PDF::loadView('laporan.pembukuan.lapkeu.lak_pdf', $data, compact('title', 'lak_masuk_operasi', 'lak_keluar_operasi', 'lak_masuk_investasi', 'lak_keluar_investasi', 'lak_masuk_pendanaan', 'lak_keluar_pendanaan', 'lak_transitori'))
                    ->setPaper('A4', 'portrait');
                return $pdf->stream('LAK ' . Tahun() . '.pdf',  array("Attachment" => false));
                break;

                // LAPORAN PERUBAHAN EKUITAS ----------------------------------------------------------------------------------v
            case 'lpe':
                $neraca = DB::select("call sp_neraca_th(" . Tahun() . ", '" . kd_unit() . "' )");
                $sp_lo = DB::select("call sp_lo(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");
                //jml ekuitas tahun ini ,EKUITAS AWAL
                $neraca_pasiva = collect($neraca)->where('jns', '2');
                //surplus/defisit LO
                $data['jum_pdp_opr_kini'] = collect($sp_lo)->where('jns_lap', 1)->sum('lo_kini');
                $data['jum_beban_opr_kini'] = collect($sp_lo)->where('jns_lap', 2)->sum('lo_kini');
                $data['surplus_opr_kini'] = $data['jum_pdp_opr_kini'] - $data['jum_beban_opr_kini'];
                $data['surplus_non_opr_kini']   = collect($sp_lo)->where('jns_lap', 3)->sum('lo_kini');
                $data['surplus_before_lb_kini'] = $data['surplus_opr_kini'] + $data['surplus_non_opr_kini'];
                $data['jum_pos_lb_kini']  = collect($sp_lo)->where('jns_lap', 4)->sum('lo_kini');
                $data['surplus_lo_kini']  = $data['surplus_before_lb_kini'] + $data['jum_pos_lb_kini'];

                //lain-lain tahun berjalan
                // $lain = DB::select("SELECT SUM(a.Rp_K-a.Rp_D) total FROM jr_sesuai a
                // LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
                // WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.Ko_Rkk,15) = '03.01.01.02.002' && MONTH(dt_sesuai) <= '".$bulan."'");
                $lain = DB::select("SELECT SUM(a.Rp_K-a.Rp_D) total FROM jr_sesuai a WHERE a.Ko_unitstr = '" . kd_unit() . "' && a.Ko_Period = '" . Tahun() . "' && LEFT(a.Ko_Rkk,15) = '03.01.01.01.002'");

                //saldo awal
                $dte = DB::select("SELECT Ko_id,soaw_Rp FROM tb_soawlp a WHERE a.Ko_Period = '" . Tahun() . "' && Ko_unitstr = '" . kd_unit() . "' && a.Ko_lp = 2");
                $lpe_1 = collect($dte)->where('Ko_id', 1)->first();
                $lpe_2 = collect($dte)->where('Ko_id', 2)->first();
                $lpe_3 = collect($dte)->where('Ko_id', 3)->first();
                $lpe_3 = collect($dte)->where('Ko_id', 3)->first();
                $lpe_4 = collect($dte)->where('Ko_id', 4)->first();
                $lpe_5 = collect($dte)->where('Ko_id', 5)->first();

                // Judul Periode Laporan
                if ($request->jns_periode == 'bulan01') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan02') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                } elseif ($request->jns_periode == 'bulan03') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                } elseif ($request->jns_periode == 'bulan04') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                } elseif ($request->jns_periode == 'bulan05') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                } elseif ($request->jns_periode == 'bulan07') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                } elseif ($request->jns_periode == 'bulan08') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                } elseif ($request->jns_periode == 'bulan09') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                } elseif ($request->jns_periode == 'bulan10') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                } elseif ($request->jns_periode == 'bulan11') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                    $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                } else {
                    $data['judul_periode'] = 'Untuk Tahun yang Berakhir 31 Desember ' . $tahun_lalu . ' dan ' . Tahun(); //ini tahunan
                }

                $title = 'LPE';
                $pdf = PDF::loadView('laporan.pembukuan.lapkeu.lpe_th_pdf', $data, compact('title', 'neraca_pasiva', 'lain', 'lpe_1', 'lpe_2', 'lpe_3', 'lpe_4', 'lpe_5'))->setPaper('A4', 'portrait');
                return $pdf->stream('LPE ' . Tahun() . '.pdf',  array("Attachment" => false));
                break;

                // NERACA SALDO -----------------------------------------------------------------------------------------------v
            case 'nrcsaldo':
                switch ($request->jns_periode) {
                    case 'tahun':
                        $sp_neraca_th = DB::select("call sp_neraca_th(" . Tahun() . ", '" . kd_unit() . "' )");

                        $nrcsaldo_rek3 = collect($sp_neraca_th)->where('jns_rek', 'rek3');

                        $data['jum_debet'] = collect($nrcsaldo_rek3)->sum('mutasi_d');
                        $data['jum_kredit'] = collect($nrcsaldo_rek3)->sum('mutasi_k');
                        $title = 'NERACA SALDO';

                        $pdf = PDF::loadView('laporan.pembukuan.lapkeu.nrcsaldo_th_pdf', $data, compact('nrcsaldo_rek3', 'title'))->setPaper('A4', 'portrait');

                        return $pdf->stream('Neraca Saldo ' . Tahun() . '.pdf',  array("Attachment" => false));
                        break;

                    default:
                        $sp_neraca = DB::select("call sp_neraca(" . Tahun() . ", '" . kd_unit() . "', " . $bulan . " )");

                        $nrcsaldo_rek3 = collect($sp_neraca)->where('jns_rek', 'rek3');

                        $data['jum_debet'] = collect($nrcsaldo_rek3)->sum('mutasi_d');
                        $data['jum_kredit'] = collect($nrcsaldo_rek3)->sum('mutasi_k');

                        // Judul Periode Laporan
                        if ($request->jns_periode == 'bulan01') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Januari ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan02') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 28 Februari ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan03') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Maret ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan04') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 April ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan05') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Mei ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan06' || $request->jns_periode == 'sem1') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 Juni ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan07') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Juli ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan08') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Agustus ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan09') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 September ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan10') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Oktober ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan11') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 30 November ' . Tahun();
                        } elseif ($request->jns_periode == 'bulan12' || $request->jns_periode == 'sem2') {
                            $data['judul_periode'] = 'Untuk Periode yang Berakhir 31 Desember ' . $tahun_lalu . ' dan 31 Desember ' . Tahun();
                        } else {
                            $data['judul_periode'] = 'Untuk Tahun yang Berakhir 31 Desember ' . $tahun_lalu . ' dan ' . Tahun();
                        }

                        $title = 'NERACA SALDO';
                        $pdf = PDF::loadView('laporan.pembukuan.lapkeu.nrcsaldo_bln_pdf', $data, compact('nrcsaldo_rek3', 'title'))->setPaper('A4', 'portrait');

                        return $pdf->stream('Neraca Saldo ' . Tahun() . '.pdf',  array("Attachment" => false));

                        break;
                }

                break;
        }
    }
}
