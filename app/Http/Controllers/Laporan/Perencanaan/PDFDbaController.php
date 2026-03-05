<?php

namespace App\Http\Controllers\Laporan\Perencanaan;

use PDF;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PDFDbaController extends Controller
{

    public function showdba1()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();
        $dba1 = DB::select('CALL SP_DBA1(' . $tahun . ', "' . $kounit1 . '")');
        $total = collect($dba1)->sum('To_Rp');
        $gburpdp = collect($dba1)->groupBy('1')->map(function ($group) {
            return [
                'jns' => $group[0]->Ur_pdp,
                'rincian' => $group->all(),
                'subtotal' => $group->sum('To_Rp'),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();
        // dd($gburpdp);
        return view('laporan.perencanaan.dba.dba1', compact('unitstr', 'tahun', 'kounit1', 'nmunit1', 'dba1', 'total', 'gburpdp', 'footer'));
    }

    public function dbapendapatanPDF()

    {

        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();
        $dba1 = DB::select('CALL SP_DBA1(' . $tahun . ', "' . $kounit1 . '")');
        $total = collect($dba1)->sum('To_Rp');
        $gburpdp = collect($dba1)->groupBy('1')->map(function ($group) {
            return [
                'jns' => $group[0]->Ur_pdp,
                'rincian' => $group->all(),
                'subtotal' => $group->sum('To_Rp'),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        $data = [
            'unitstr' => kd_unit(),
            'tahun' => Tahun(),
            // 'tahun' => Tahun(),
            'dba1' => $dba1,
            'gburpdp' => $gburpdp,
            'footer' => $footer,
            'total' => $total,

        ];


        $pdf = PDF::loadView('laporan.perencanaan.dba.dba1pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('dba1-pendapatan.pdf');
        // return $pdf->download('dba1-pendapatan.pdf');
    }

    public function showdba2()
    {
        // $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $dba2 = DB::select('CALL qr_DBA2(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gburblj = collect($dba2)->groupBy('Ur_Rk2')->map(function ($group) {
            return [
                'rincian' => $group->groupBy('Ur_Rk4'),
                'subrincian' => $group->groupBy('Ur_Rk4')->map(function ($subrinci) {
                    return [
                        'Ur_Rk4' => $subrinci[0]->Ur_Rk4,
                        'JLTo_Rp' => $subrinci->sum('JLTo_Rp'),
                        'HbTo_Rp' => $subrinci->sum('HbTo_Rp'),
                        'KSTo_Rp' => $subrinci->sum('KSTo_Rp'),
                        'APTo_Rp' => $subrinci->sum('APTo_Rp'),
                        'BLTo_Rp' => $subrinci->sum('BLTo_Rp'),
                        'sumtotal' => $subrinci->sum('To_Rp'),
                    ];
                }),
                'subtotal' => $group->sum('To_Rp'),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where(
                'Ko_Period',
                $tahun
            )
            ->where('Ko_unitstr', $unitstr)
            ->get();
        // dd($gburblj);
        return view('laporan.perencanaan.dba.dba2', compact('tahun', 'dba2', 'gburblj', 'footer'));
    }

    public function dbabelanjaPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $dba2 = DB::select('CALL qr_DBA2(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gburblj = collect($dba2)->groupBy('Ur_Rk2')->map(function ($group) {
            return [
                'rincian' => $group->groupBy('Ur_Rk3'),
                'subrincian' => $group->groupBy('Ur_Rk4')->map(function ($subrinci) {
                    return [
                        'Ur_Rk4' => $subrinci[0]->Ur_Rk4,
                        'JLTo_Rp' => $subrinci->sum('JLTo_Rp'),
                        'HbTo_Rp' => $subrinci->sum('HbTo_Rp'),
                        'KSTo_Rp' => $subrinci->sum('KSTo_Rp'),
                        'APTo_Rp' => $subrinci->sum('APTo_Rp'),
                        'BLTo_Rp' => $subrinci->sum('BLTo_Rp'),
                        'sumtotal' => $subrinci->sum('To_Rp'),
                    ];
                }),
                'subtotal' => $group->sum('To_Rp'),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where(
                'Ko_Period',
                $tahun
            )
            ->where('Ko_unitstr', $unitstr)
            ->get();
        $data = [
            'unitstr' => kd_unit(),
            'tahun' => Tahun(),
            'dba2' => $dba2,
            'gburblj' => $gburblj,
            'footer' => $footer,
            // 'total' => $total,

        ];
        $pdf = PDF::loadView('laporan.perencanaan.dba.dba2pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('dba2-beban.pdf');
        // return $pdf->download('rba2-beban.pdf');
    }

    public function showdba3()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();;
        $dba3 = DB::select('CALL qr_DBA3(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $total = collect($dba3)->sum('To_Rp');
        $gburpb = collect($dba3)->groupBy('Ur_pdp')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subtotal' => $group->sum('sumtotal'),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        // dd($gburpb);

        return view('laporan.perencanaan.dba.dba3', compact('dba3', 'total', 'gburpb', 'footer', 'tahun'));
    }

    public function dbapembiayaanPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();;
        $dba3 = DB::select('CALL qr_DBA3(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $total = collect($dba3)->sum('To_Rp');
        $gburpb = collect($dba3)->groupBy('Ur_pdp')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subtotal' => $group->sum('sumtotal'),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();
        $data = [
            'unitstr' => kd_unit(),
            'tahun' => Tahun(),
            'dba3' => $dba3,
            'gburpb' => $gburpb,
            'footer' => $footer,
            'total' => $total,

        ];

        // dd($dba3);
        // dd($gburpb);


        $pdf = PDF::loadView('laporan.perencanaan.dba.dba3pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('dba3-pembiayaan.pdf');
        // return $pdf->download('dba3-pembiayaan.pdf');
    }

    public function showdba4()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $dba4 = DB::select('CALL qr_DBA4(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gbringrba = collect($dba4)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subtotal' => $group->last(),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        // dd($footer);
        // dd($gbringrba);
        return view('laporan.perencanaan.dba.dba4', compact('tahun', 'dba4', 'gbringrba', 'footer'));
    }

    public function dbaringkasPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $dba4 = DB::select('CALL qr_DBA4(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gbringrba = collect($dba4)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subtotal' => $group->last(),
            ];
        });
        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        // dd($footer);
        // dd($gbringrba);
        $data = [
            'unitstr' => kd_unit(),
            'tahun' => Tahun(),
            'dba4' => $dba4,
            'gbringrba' => $gbringrba,
            'footer' => $footer,
        ];

        $pdf = PDF::loadView('laporan.perencanaan.dba.dba4pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('dba4-ringkasan.pdf');
    }

    public function showdba5()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $dba5 = DB::select('CALL SP_DBA5(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???

        $gbrincirba = collect($dba5)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subrincian' => $group->groupBy('Ko_Rc'),
                'subtotal' => $group->last(),
            ];
        });

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        // dd($gbrincirba);
        return view('laporan.perencanaan.dba.dba5', compact('tahun', 'dba5', 'gbrincirba', 'footer'));
    }

    public function dbarinciPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $dba5 = DB::select('CALL SP_DBA5(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???

        $gbrincirba = collect($dba5)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subrincian' => $group->groupBy('Ko_Rc'),
                'subtotal' => $group->last(),
            ];
        });

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();
        $data = [
            'unitstr' => kd_unit(),
            'tahun' => Tahun(),
            'dba5' => $dba5,
            'gbrincirba' => $gbrincirba,
            'footer' => $footer,
        ];

        $pdf = PDF::loadView('laporan.perencanaan.dba.dba5pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('dba5-rinci.pdf');
    }
}
