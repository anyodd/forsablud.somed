<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait laporanTrait
{
    public function registerKontrak(Request $request)
    {
        $kounit1 = kd_bidang();
        $tahun = Tahun();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $regKontrak  = DB::select('call qr_regkontrak("' . $tahun . '", "' . $kounit1 . '", "' . $date1 . '", "' . $date2 . '")');

        return $regKontrak;
    }

    public function registerPiutang(Request $request)
    {
        $unitstr = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $regPiutang = DB::select('call qr_piutang("' . $date1 . '", "' . $date2 . '", "' . $unitstr . '")');
        
        return $regPiutang;
    }

    public function bku_blud(Request $request)
    {
        $unitstr = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $data = DB::select('CALL qr_BKUBLU("' . $date1 . '","' . $date2 . '","' . $unitstr . '")');
        $bkublud = collect($data)->sortBy('Tgl_Bukti');

        return $bkublud;
    }

    public function registerSts(Request $request)
    {
        $unitstr = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $regSts = DB::select('CALL qr_regsts("' . $date1 . '","' . $date2 . '","' . $unitstr . '")');

        return $regSts;
    }

    public function bkuPenerimaan(Request $request)
    {
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bkuTerima = DB::select('CALL qr_BKUpdp("' . $date1 . '","' . $date2 . '","' . kd_unit() . '")');

        return $bkuTerima;
    }

    public function bpKasTunai(Request $request)
    {
        $unitstr = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bpkt = DB::select('CALL qr_BKUpdptunai("' . $date1 . '","' . $date2 . '","' . $unitstr . '")');

        return $bpkt;
    }

    public function bpBank(Request $request)
    {
        $unitstr = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bpb = DB::select('CALL qr_BKUpdpbank("' . $date1 . '","' . $date2 . '","' . $unitstr . '")');

        return $bpb;
    }

    public function lTerimaSetor(Request $request)
    {
        $unitstr = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $lpp = DB::select('CALL qr_BKUpdp_LPP("' . $date1 . '","' . $date2 . '","' . $unitstr . '")');

        return $lpp;
    }

    public function regSOPD(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $regSpm = DB::select('CALL qr_regSPM("' . $tahun . '","' . $unitstr . '", "' . $date1 . '","' . $date2 . '")');

        return $regSpm;
    }

    public function regSPD(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $regSpd = DB::select('CALL qr_regSPD("' . $tahun . '","' . $unitstr . '", "' . $date1 . '","' . $date2 . '")');

        return $regSpd;
    }

    public function regSPP(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $regspp  = DB::select('call qr_regSPP("' . $tahun . '", "' . $unitstr . '", "' . $date1 . '", "' . $date2 . '")');

        return $regspp;
    }

    public function bku(Request $request)
    {
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";
        $bku = DB::select('CALL qr_bkukeluar("'.$date1.'", "'.$date2.'", "' . kd_unit() . '")');
        return $bku;
    }

    public function bpgu(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bpgu = DB::table('vqr_bkuGU')
            ->select('*')
            ->where('Ko_Period',  $tahun)
            ->where('Ko_unitstr',  $kounit1)
            ->whereBetween('dt_oto', [$date1, $date2])
            ->get();

        $total1 = collect($bpgu)->sum('Terima');
        $total2 = collect($bpgu)->sum('Keluar');
        $net = $total1 - $total2;

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        return array($unitstr, $tahun, $kounit1, $bpgu, $net, $footer);
    }

    public function bplsNonKontrak(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bplsnon = DB::table('vqr_bkuLSnon')
        ->select('*')
            ->where('Ko_Period',  $tahun)
            ->where('Ko_unitstr',  $kounit1)
            ->where('Ko_unitstr',  $kounit1)
            ->whereBetween('dt_oto', [ $date1, $date2])
            ->get();

        $total1 = collect($bplsnon)->sum('Terima');
        $total2 = collect($bplsnon)->sum('Keluar');
        $net = $total1 - $total2;

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        return array($unitstr, $tahun, $kounit1, $bplsnon, $net, $footer);
    }

    public function bplsKontrak(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bplscontr = DB::table('vqr_bkuLScon')
        ->select('*')
            ->where('Ko_Period',  $tahun)
            ->where('Ko_unitstr',  $kounit1)
            ->whereBetween('dt_oto', [$date1, $date2])
            ->get();

        $total1 = collect($bplscontr)->sum('Terima');
        $total2 = collect($bplscontr)->sum('Keluar');
        $net = $total1 - $total2;

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        return array($unitstr, $tahun, $kounit1, $bplscontr, $net,  $footer);
    }

    public function bpPanjar(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_unit();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $bppanjar = DB::table('vqr_bkupanjar')
        ->select('*')
            ->where('Ko_Period',  $tahun)
            ->where('Ko_unitstr',  $kounit1)
            ->whereBetween('dt_oto', [$date1, $date2])
            ->get();

        $total1 = collect($bppanjar)->sum('Terima');
        $total2 = collect($bppanjar)->sum('Keluar');
        $net = $total1 - $total2;

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();
        
        return array($tahun, $bppanjar);
    }

    public function daftarTagihan(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();
        $date1 = $request->date1 ?? Tahun() . "/01/01";
        $date2 = $request->date2 ?? Tahun() . "/12/31";

        $tagih = DB::select('call qr_daftartagihrinc("' . $tahun . '", "' . $kounit1 . '", "' . $date1 . '",  "' . $date2 . '")');
        $total = collect($tagih)->sum('Total');
        $gbtagih = collect($tagih)->groupBy('No_bp')->map(function ($group) {
            return [
                'jns' => $group[0]->Ur_bp,
                'rincian' => $group->all(),
                'subtotal' => $group->sum('Total'),
            ];
        });

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();
        
        return array($unitstr, $tahun, $kounit1, $nmunit1, $tagih, $total, $gbtagih, $footer);
    }
}
