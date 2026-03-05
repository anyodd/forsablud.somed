<?php

namespace App\Http\Controllers\Laporan\Pembukuan\Manajemen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BendPengeluaranController extends Controller
{
    public function showrregspm()
    {
    }

    public function regspmPDF()

    {
    }

    public function bkushow()
    {
        //e $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $bku = DB::select('CALL vqr_bkukeluar("' . $tahun . '", "' . $kounit1 . '" )'); // harus single quote???

        $total1 = collect($bku)->sum('Terima');
        $total2 = collect($bku)->sum('Keluar');
        $net = $total1 - $total2;
        // $gburpdp = collect($bku)->groupBy('Ur_pdp')->map(function ($group) {
        //     return [
        //         'rincian' => $group->all(),
        //         'subtotal' => $group->sum('To_Rp'),
        //     ];
        // });

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();


        // dd($unitstr);
        // dd($bku);
        // dd($net);
        // dd($data1);
        // dd($gburpdp);
        // dd($footer);

        return view('laporan.pembukuan.manajemen.bendpengeluaran.bku', compact('unitstr', 'tahun', 'kounit1', 'bku', 'net',  'footer'));
    }

    public function bkuPDF()

    {

        // $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = nm_bidang();
        $rba1 = DB::select('CALL SP_RBA1 (".$tahun.", 14.02.01.02.01.001)'); // harus single quote???

        $total = collect($rba1)->sum('To_Rp');
        $gburpdp = collect($rba1)->groupBy('Ur_pdp')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subtotal' => $group->sum('To_Rp'),
            ];
        });

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();


        $rba1 = DB::select('CALL SP_RBA1'); // harus single quote???
        $data = [
            'unitstr' => kd_unit(),
            'tahun' => Tahun(),
            'rba1' => $rba1,
            'gburpdp' => $gburpdp,
            'footer' => $footer,
            'total' => $total,

        ];


        $pdf = PDF::loadView('laporan\pembukuan\manajemen\bendpengeluaran\bkupdf', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('rba1-pendapatan.pdf');
    }
}
