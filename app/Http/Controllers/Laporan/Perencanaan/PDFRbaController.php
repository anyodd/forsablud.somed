<?php

namespace App\Http\Controllers\Laporan\Perencanaan;

use PDF;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PDFRbaController extends Controller
{

    public function showrba1()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();
        $rba1 = DB::select('call SP_RBA1(' . $tahun . ', "' . $kounit1 . '")');
        $total = collect($rba1)->sum('To_Rp');
        $gburpdp = collect($rba1)->groupBy('1')->map(function ($group) {
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
        return view('laporan.perencanaan.rba.rba1', compact('unitstr', 'tahun', 'kounit1', 'nmunit1', 'rba1', 'total', 'gburpdp', 'footer'));
    }

    public function rbapendapatanPDF()

    {

        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();
        $rba1 = DB::select('call SP_RBA1(' . $tahun . ', "' . $kounit1 . '")');
        $total = collect($rba1)->sum('To_Rp');
        $gburpdp = collect($rba1)->groupBy('1')->map(function ($group) {
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
            'rba1' => $rba1,
            'gburpdp' => $gburpdp,
            'footer' => $footer,
            'total' => $total,

        ];


        $pdf = PDF::loadView('laporan.perencanaan.rba.rba1pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('rba1-pendapatan.pdf');
        // return $pdf->download('rba1-pendapatan.pdf');
    }

    public function showrba2()
    {
        // $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $rba2 = DB::select('CALL qr_RBA2(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gburblj = collect($rba2)->groupBy('Ur_Rk2')->map(function ($group) {
            return [
                'rincian' => $group->groupBy('Ur_Rk4'),
                'JLTo_Rp' => $group->sum('JLTo_Rp'),
                'HbTo_Rp' => $group->sum('HbTo_Rp'),
                'KSTo_Rp' => $group->sum('KSTo_Rp'),
                'APTo_Rp' => $group->sum('APTo_Rp'),
                'BLTo_Rp' => $group->sum('BLTo_Rp'),
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

        // dd($gburblj);

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where(
                'Ko_Period',
                $tahun
            )
            ->where('Ko_unitstr', $unitstr)
            ->get();
        // dd($gburblj);
        return view('laporan.perencanaan.rba.rba2', compact('tahun', 'rba2', 'gburblj', 'footer'));
    }

    public function showrba2rinci()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $rba2 = DB::select('CALL qr_RBA2_rinci(' . $tahun . ', "' . kd_unit() . '")');
        $rba2rinci = collect($rba2)->groupBy('Sumber')->map(function ($group) {
            return [
                'tot'     => $group->sum('To_Rp'),
                'total'   => $group->last(),
                'rincian' => $group->where('ur_KegBl1', '!=', '')->groupBy('ur_KegBl1')->map(function($group1) {
                    return [
                        'subtotal1' => $group1->where('ur_KegBl2', '!=', '')->sum('To_Rp'),
                        'subrincian1' => $group1->groupBy('ur_KegBl2')->map(function($group2) {
                            return [
                                'subtotal2' => $group2->where('Ur_Rk6', '!=', '')->sum('To_Rp'),
                                'subrincian2' => $group2->groupBy('Ur_Rk6')->map(function($group3) {
                                    return [
                                        'ko_rkk' => $group3['0']->Ko_Rkk,
                                        'subtotal3' => $group3->where('Ur_Rc1', '!=', '')->sum('To_Rp'),
                                        'subrincian3' => $group3->groupBy('Ur_Rc1'),
                                    ];
                                }),
                            ];
                        }),
                    ];
                }),
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
        return view('laporan.perencanaan.rba.rba2rinci', compact('tahun', 'rba2rinci', 'footer'));
    }

    public function showrba2rinciPDF()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $rba2 = DB::select('CALL qr_RBA2_rinci(' . $tahun . ', "' . kd_unit() . '")');
        $rba2rinci = collect($rba2)->groupBy('Sumber')->map(function ($group) {
            return [
                'tot'     => $group->sum('To_Rp'),
                'total'   => $group->last(),
                'rincian' => $group->where('ur_KegBl1', '!=', '')->groupBy('ur_KegBl1')->map(function($group1) {
                    return [
                        'subtotal1' => $group1->where('ur_KegBl2', '!=', '')->sum('To_Rp'),
                        'subrincian1' => $group1->groupBy('ur_KegBl2')->map(function($group2) {
                            return [
                                'subtotal2' => $group2->where('Ur_Rk6', '!=', '')->sum('To_Rp'),
                                'subrincian2' => $group2->groupBy('Ur_Rk6')->map(function($group3) {
                                    return [
                                        'ko_rkk' => $group3['0']->Ko_Rkk,
                                        'subtotal3' => $group3->where('Ur_Rc1', '!=', '')->sum('To_Rp'),
                                        'subrincian3' => $group3->groupBy('Ur_Rc1'),
                                    ];
                                }),
                            ];
                        }),
                    ];
                }),
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
            'tahun'   => Tahun(),
            // 'rba2'    => $rba2,
            'rba2rinci' => $rba2rinci,
            'footer'  => $footer,

        ];

        $pdf = PDF::loadView('laporan.perencanaan.rba.rba2rincipdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('rba2-rinci.pdf');
    }

    public function rbabelanjaPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $rba2 = DB::select('CALL qr_RBA2(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gburblj = collect($rba2)->groupBy('Ur_Rk2')->map(function ($group) {
            return [
                'rincian' => $group->groupBy('Ur_Rk3'),
                'JLTo_Rp' => $group->sum('JLTo_Rp'),
                'HbTo_Rp' => $group->sum('HbTo_Rp'),
                'KSTo_Rp' => $group->sum('KSTo_Rp'),
                'APTo_Rp' => $group->sum('APTo_Rp'),
                'BLTo_Rp' => $group->sum('BLTo_Rp'),
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
                'subtotal' => $group->sum('sumtotal'),
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
            'rba2' => $rba2,
            'gburblj' => $gburblj,
            'footer' => $footer,
            // 'total' => $total,

        ];
        $pdf = PDF::loadView('laporan.perencanaan.rba.rba2pdf', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('rba2-beban.pdf');
        // return $pdf->download('rba2-beban.pdf');
    }

    public function showrba3()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();;
        $rba3 = DB::select('CALL qr_RBA3(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $total = collect($rba3)->sum('To_Rp');
        $gburpb = collect($rba3)->groupBy('Ur_pdp')->map(function ($group) {
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

        return view('laporan.perencanaan.rba.rba3', compact('rba3', 'total', 'gburpb', 'footer', 'tahun'));
    }

    public function rbapembiayaanPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();;
        $rba3 = DB::select('CALL qr_RBA3(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $total = collect($rba3)->sum('To_Rp');
        $gburpb = collect($rba3)->groupBy('Ur_pdp')->map(function ($group) {
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
            'rba3' => $rba3,
            'gburpb' => $gburpb,
            'footer' => $footer,
            'total' => $total,

        ];

        // dd($rba3);
        // dd($gburpb);


        $pdf = PDF::loadView('laporan.perencanaan.rba.rba3pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('rba3-pembiayaan.pdf');
        // return $pdf->download('rba3-pembiayaan.pdf');
    }

    public function showrba4()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $rba4 = DB::select('CALL qr_RBA4(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gbringrba = collect($rba4)->groupBy('Ur_Rk1')->map(function ($group) {
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
        return view('laporan.perencanaan.rba.rba4', compact('tahun', 'rba4', 'gbringrba', 'footer'));
    }

    public function rbaringkasPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $rba4 = DB::select('CALL qr_RBA4(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???
        $gbringrba = collect($rba4)->groupBy('Ur_Rk1')->map(function ($group) {
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
            'rba4' => $rba4,
            'gbringrba' => $gbringrba,
            'footer' => $footer,
        ];

        $pdf = PDF::loadView('laporan.perencanaan.rba.rba4pdf', $data)->setPaper('A4', 'potrait');
        return $pdf->stream('rba4-ringkasan.pdf');
        // return $pdf->download('rba3-pembiayaan.pdf');
    }

    public function showrba5()
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $rba5 = DB::select('CALL SP_RBA5(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???

        $gbrincirba = collect($rba5)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'total' => $group->last(),
                // 'total' => $group->where('Ur_Rk2', '!=', '')->sum('To_Rp'),
                'rincian' => $group->where('Ur_Rk2', '!=', '')->groupBy('Ur_Rk2')->map(function($group1) {
                    return [
                        'subtotal' => $group1->where('Ur_Rk3', '!=', '')->sum('To_Rp'),
                        'subrincian' => $group1->groupBy('Ur_Rk3')->map(function($group2) {
                            return [
                                'subsubtotal' => $group2->where('Ur_Rc1', '!=', '')->sum('To_Rp'),
                                'subsubrincian' => $group2->groupBy('Ur_Rc1'),
                            ];
                        }),
                    ];
                }),
            ];
        });

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        // dd($gbrincirba);
        return view('laporan.perencanaan.rba.rba5', compact('tahun', 'rba5', 'gbrincirba', 'footer'));
    }

    public function rbarinciPDF()

    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $rba5 = DB::select('CALL SP_RBA5(' . $tahun . ', "' . $kounit1 . '")'); // harus single quote???

        $gbrincirba = collect($rba5)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'total' => $group->last(),
                // 'total' => $group->where('Ur_Rk2', '!=', '')->sum('To_Rp'),
                'rincian' => $group->where('Ur_Rk2', '!=', '')->groupBy('Ur_Rk2')->map(function ($group1) {
                    return [
                        'subtotal' => $group1->where('Ur_Rk3', '!=', '')->sum('To_Rp'),
                        'subrincian' => $group1->groupBy('Ur_Rk3')->map(function ($group2) {
                            return [
                                'subsubtotal' => $group2->where('Ur_Rc1', '!=', '')->sum('To_Rp'),
                                'subsubrincian' => $group2->groupBy('Ur_Rc1'),
                            ];
                        }),
                    ];
                }),
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
            'rba5' => $rba5,
            'gbrincirba' => $gbrincirba,
            'footer' => $footer,
        ];

        $pdf = PDF::loadView('laporan.perencanaan.rba.rba5pdf', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('rba5-rinci.pdf');
        // return $pdf->download('rba3-pembiayaan.pdf');
    }
}
