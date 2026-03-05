<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use PDF;
use App\Models\Tbbp;
use App\Models\Tb_spi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\laporanTrait;
use App\Models\Tbtap;

class PDFBelanjaController extends Controller
{
    use laporanTrait;

    public function showtagihan()
    {
        return view('laporan.penatausahaan.belanja.tagihan');
    }

    public function showtagihan_isi(Request $request)
    {
        $unitstr = $this->daftarTagihan($request)[0];
        $tahun = $this->daftarTagihan($request)[1];
        $kounit1 = $this->daftarTagihan($request)[2];
        $nmunit1 = $this->daftarTagihan($request)[3];
        $tagih = $this->daftarTagihan($request)[4];
        $total = $this->daftarTagihan($request)[5];
        $gbtagih = $this->daftarTagihan($request)[6];
        $footer  = $this->daftarTagihan($request)[7];

        return view('laporan.penatausahaan.belanja.tagihan_isi', compact('unitstr', 'tahun', 'kounit1', 'nmunit1', 'tagih', 'total', 'gbtagih', 'footer'));
    }

    public function showtagihan_cetak(Request $request)
    {
        $unitstr = $this->daftarTagihan($request)[0];
        $tahun = $this->daftarTagihan($request)[1];
        $kounit1 = $this->daftarTagihan($request)[2];
        $nmunit1 = $this->daftarTagihan($request)[3];
        $tagih = $this->daftarTagihan($request)[4];
        $total = $this->daftarTagihan($request)[5];
        $gbtagih = $this->daftarTagihan($request)[6];
        $footer  = $this->daftarTagihan($request)[7];
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.tagihan_cetak', compact('unitstr', 'tahun', 'kounit1', 'nmunit1', 'tagih', 'total', 'gbtagih', 'footer', 'date1', 'date2'))->setPaper('A4', 'landscape');
        return $pdf->download('daftar_tagihan.pdf');
    }

    function fetch_data(Request $request)
    {
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();
        $fromdate = $request->from_date;
        $todate = $request->to_date;

        $tagih = DB::select('call qr_daftartagihrinc(?, ?)', ["' . $tahun . '", "' . $kounit1 . '"]);

        if ($request->ajax()) {
            if ($request->from_date != '' && $request->from_date != '') {
                $total = collect($tagih)->whereBetween('dt_bp', [$fromdate, $todate])->sum('Total');
                // $tagih = DB::select('call qr_daftartagihrinc(' . $tahun . ', "' . $kounit1 . '" , ' . "2022-12-31" . ', ' . "2022-01-01" . ' )');
                $gbtagih = collect($tagih)->whereBetween('dt_bp', [$fromdate, $todate])->groupBy('No_bp')->map(function ($group) {
                    return [
                        'jns' => $group[0]->Ur_bp,
                        'rincian' => $group->all(),
                        'subtotal' => $group->sum('Total'),
                    ];
                });
            } else {
                $total = collect($tagih)->sum('Total');
                // $tagih = DB::select('call qr_daftartagihrinc(' . $tahun . ', "' . $kounit1 . '" , ' . "2022-12-31" . ', ' . "2022-01-01" . ' )');
                $gbtagih = collect($tagih)->groupBy('No_bp')->map(function ($group) {
                    return [
                        'jns' => $group[0]->Ur_bp,
                        'rincian' => $group->all(),
                        'subtotal' => $group->sum('Total'),
                    ];
                });
            }
        }
        return view('laporan.penatausahaan.belanja.cetak_tagihan', compact('unitstr', 'tahun', 'gbtagih', 'footer'));
    }


    public function prtagihan(Request $request)
    {

        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nmunit1 = nm_bidang();

        $footer  = DB::table('tb_sub')
            ->select('*')
            ->where('Ko_Period', $tahun)
            ->where('Ko_unitstr', $unitstr)
            ->get();

        return view('laporan.penatausahaan.belanja.cetak_tagihan', compact('unitstr', 'tahun', 'gbtagih', 'footer'));
    }
    public function npd()
    {
        $tahun = Tahun();
        $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')
            ->where('Ko_bp', '4')
            ->where('Ko_Period', Tahun())
            ->where('Ko_unit1', kd_bidang())
            ->get();

        return view('laporan.penatausahaan.belanja.npd', compact('tahun', 'belanja'));
    }

    public function d_npd($id)
    {
        $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')->where('Ko_bp', '4')->where('id_bp', $id)->first();

        $rincian = DB::select(DB::raw("SELECT a.*, b.*, c.Ur_Rk6
            FROM tb_bp a JOIN tb_bprc b ON a.No_bp = b.No_bp
            INNER JOIN pf_rk6 c ON
            CONCAT(
            LPAD(c.Ko_Rk1,2,0),'.',
            LPAD(c.Ko_Rk2,2,0),'.',
            LPAD(c.Ko_Rk3,2,0),'.',
            LPAD(c.Ko_Rk4,2,0),'.',
            LPAD(c.Ko_Rk5,3,0),'.',
            LPAD(c.Ko_Rk6,3,0)) = b.ko_rkk
            WHERE a.id_bp = " . $id));

        $total = DB::select(DB::raw('SELECT SUM(b.To_Rp) AS jml
                    FROM tb_bp a
                    JOIN tb_bprc b
                    ON a.No_bp = b.No_bp
                    WHERE a.Ko_Period = ' . Tahun() . ' AND a.id_bp = ' . $id));

        return response()->json([
            'belanja' => $belanja,
            'total' => $total,
            'rincian' => $rincian,
        ]);
    }

    public function print_npd($id)
    {
        $belanja = Tbbp::orderBy('id_bp')->where('Ko_bp', '4')->where('id_bp', $id)->orderBy('Ko_Period')->first();

        $rincian = DB::select(DB::raw("SELECT a.*, b.*, c.Ur_Rk6
            FROM tb_bp a JOIN tb_bprc b ON a.No_bp = b.No_bp
            INNER JOIN pf_rk6 c ON
            CONCAT(
            LPAD(c.Ko_Rk1,2,0),'.',
            LPAD(c.Ko_Rk2,2,0),'.',
            LPAD(c.Ko_Rk3,2,0),'.',
            LPAD(c.Ko_Rk4,2,0),'.',
            LPAD(c.Ko_Rk5,3,0),'.',
            LPAD(c.Ko_Rk6,3,0)) = b.ko_rkk
            WHERE a.id_bp = " . $id));

        $total = DB::select(DB::raw('SELECT SUM(b.To_Rp) AS jml
                    FROM tb_bp a
                    JOIN tb_bprc b
                    ON a.No_bp = b.No_bp
                    WHERE a.id_bp = ' . $id));
        $data = [
            'belanja' => $belanja,
            'rincian' => $rincian,
            'total' => $total,
        ];

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.cetak_npd', $data);
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream();
    }
    public function showkontrak()
    {
    }

    public function prkontrak()
    {
    }
    public function showsp2d()
    {
    }

    public function prsp2d()
    {
    }

    public function pump()
    {
        $tahun = Tahun();
        $panjar = Tbbp::where('Ko_Period', Tahun())
            ->where('Ko_unit1', kd_bidang())
            ->where('Ko_bp', '9')
            ->orderBy('id_bp')
            ->get();
        return view('laporan.penatausahaan.belanja.pump', compact('tahun', 'panjar'));
    }

    public function d_pump($id)
    {
        $panjar = Tbbp::where('Ko_Period', Tahun())->where('id_bp', $id)->where('Ko_bp', '9')->first();

        $rincian = DB::select(DB::raw("SELECT a.*, b.*, c.Ur_Rk6
        FROM tb_bp a JOIN tb_bprc b ON a.No_bp = b.No_bp
        INNER JOIN pf_rk6 c ON
        CONCAT(
        LPAD(c.Ko_Rk1,2,0),'.',
        LPAD(c.Ko_Rk2,2,0),'.',
        LPAD(c.Ko_Rk3,2,0),'.',
        LPAD(c.Ko_Rk4,2,0),'.',
        LPAD(c.Ko_Rk5,3,0),'.',
        LPAD(c.Ko_Rk6,3,0)) = b.ko_rkk
        WHERE a.id_bp = " . $id));

        $total = DB::select(DB::raw('SELECT SUM(b.To_Rp) AS jml
        FROM tb_bp a
        JOIN tb_bprc b
        ON a.No_bp = b.No_bp
        WHERE a.id_bp = ' . $id));

        $kegiatan = DB::select(DB::raw('SELECT b.Ur_KegBL2 FROM tb_bprc a
        JOIN tb_kegs2 b ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_sKeg2=b.Ko_sKeg2
        WHERE a.id_bp = ' . $id . ' GROUP BY b.Ur_KegBL2'));

        return response()->json([
            'panjar' => $panjar,
            'rincian' => $rincian,
            'total' => $total,
            'kegiatan' => $kegiatan,
        ]);
    }

    public function print_pump($id)
    {
        $panjar = Tbbp::where('Ko_Period', Tahun())->where('id_bp', $id)->where('Ko_bp', '9')->first();

        $rincian = DB::select(DB::raw("SELECT a.*, b.*, c.Ur_Rk6
        FROM tb_bp a JOIN tb_bprc b ON a.No_bp = b.No_bp
        INNER JOIN pf_rk6 c ON
        CONCAT(
        LPAD(c.Ko_Rk1,2,0),'.',
        LPAD(c.Ko_Rk2,2,0),'.',
        LPAD(c.Ko_Rk3,2,0),'.',
        LPAD(c.Ko_Rk4,2,0),'.',
        LPAD(c.Ko_Rk5,3,0),'.',
        LPAD(c.Ko_Rk6,3,0)) = b.ko_rkk
        WHERE a.id_bp = " . $id));

        $total = DB::select(DB::raw('SELECT SUM(b.To_Rp) AS jml
        FROM tb_bp a
        JOIN tb_bprc b
        ON a.No_bp = b.No_bp
        WHERE a.id_bp = ' . $id));

        $kegiatan = DB::select(DB::raw('SELECT b.Ur_KegBL2 FROM tb_bprc a
        JOIN tb_kegs2 b ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_sKeg2=b.Ko_sKeg2
        WHERE a.id_bp = ' . $id . ' GROUP BY b.Ur_KegBL2'));

        $data = [
            'panjar' => $panjar,
            'rincian' => $rincian,
            'total' => $total,
            'kegiatan' => $kegiatan,
        ];

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.cetak_pump', $data);
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream();
    }

    public function kump()
    {
        $tahun = Tahun();
        $panjar = Tbbp::where('Ko_Period', Tahun())
            ->where('Ko_unit1', kd_bidang())
            ->where('Ko_bp', '9')
            ->orderBy('id_bp')
            ->get();
        return view('laporan.penatausahaan.belanja.kump', compact('tahun', 'panjar'));
    }

    public function d_kump($id)
    {
        $panjar = Tbbp::where('Ko_Period', Tahun())->where('id_bp', $id)->where('Ko_bp', '9')->first();

        $total = DB::select(DB::raw('SELECT SUM(b.To_Rp) AS jml
        FROM tb_bp a
        JOIN tb_bprc b
        ON a.No_bp = b.No_bp
        WHERE a.id_bp = ' . $id));

        $kegiatan = DB::select(DB::raw('SELECT b.Ur_KegBL2 FROM tb_bprc a
        JOIN tb_kegs2 b ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_sKeg2=b.Ko_sKeg2
        WHERE a.id_bp = ' . $id . ' GROUP BY b.Ur_KegBL2'));

        return response()->json([
            'panjar' => $panjar,
            'total' => $total,
            'kegiatan' => $kegiatan,
        ]);
    }

    public function print_kump($id)
    {
        $panjar = Tbbp::where('Ko_Period', Tahun())->where('id_bp', $id)->where('Ko_bp', '9')->first();

        $total = DB::select(DB::raw('SELECT SUM(b.To_Rp) AS jml
        FROM tb_bp a
        JOIN tb_bprc b
        ON a.No_bp = b.No_bp
        WHERE a.id_bp = ' . $id));

        $kegiatan = DB::select(DB::raw('SELECT b.Ur_KegBL2 FROM tb_bprc a
        JOIN tb_kegs2 b ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_sKeg2=b.Ko_sKeg2
        WHERE a.id_bp = ' . $id . ' GROUP BY b.Ur_KegBL2'));

        $data = [
            'panjar' => $panjar,
            'total' => $total,
            'kegiatan' => $kegiatan,
        ];

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.cetak_kump', $data);
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream();
    }


    public function bkushow()
    {
        return view('laporan.penatausahaan.belanja.bku');
    }

    public function bkushow_isi(Request $request)
    {
        $data = $this->bku($request);
        $bku = collect($data)->sortBy('Tgl_Bukti');
        return view('laporan.penatausahaan.belanja.bku_isi', compact('bku'));
    }

    public function bkushow_cetak(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $data = DB::select('CALL qr_bkukeluar("'.$date1.'", "'.$date2.'", "' . kd_unit() . '")');
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        
        $pdf = PDF::loadView('laporan.penatausahaan.belanja.bku_cetak', compact('data', 'date1', 'date2','pegawai'))->setPaper('A4', 'portrait');
        return $pdf->stream('buku_kas_umum.pdf');
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
        $pdf = PDF::loadView('laporan\penatausahaan\belanja\bkupdf', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('rba1-pendapatan.pdf');
    }

    public function bpgushow(Request $request)
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.belanja.bpgu',compact('pegawai'));
    }

    public function bpgushow_isi(Request $request)
    {
        $unitstr = $this->bpgu($request)[0];
        $tahun = $this->bpgu($request)[1];
        $kounit1 = $this->bpgu($request)[2];
        $bpgu = $this->bpgu($request)[3];
        $net = $this->bpgu($request)[4];
        $footer = $this->bpgu($request)[5];

        return view('laporan.penatausahaan.belanja.bpgu_isi', compact('unitstr', 'tahun', 'kounit1', 'bpgu', 'net',  'footer'));
    }

    public function bpgushow_cetak(Request $request)
    {
        $unitstr = $this->bpgu($request)[0];
        $tahun = $this->bpgu($request)[1];
        $kounit1 = $this->bpgu($request)[2];
        $bpgu = $this->bpgu($request)[3];
        $net = $this->bpgu($request)[4];
        $footer = $this->bpgu($request)[5];
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.bpgu_cetak', compact('unitstr', 'tahun', 'kounit1', 'bpgu', 'net',  'footer', 'date1', 'date2'))->setPaper('A4', 'portrait');
        return $pdf->stream('buku_bantu_gu.pdf');
    }

    public function bpguPDF()
    {

        // $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = nm_bidang();
        $rba1 = DB::select('CALL SP_RBA1(".$tahun.", 14.02.01.02.01.001)'); // harus single quote???

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
        $pdf = PDF::loadView('laporan\penatausahaan\belanja\bpgupdf', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('rba1-pendapatan.pdf');
    }

    public function bplsnonshow()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.belanja.bplsnon',compact('pegawai'));
    }

    public function bplsnonshow_isi(Request $request)
    {
        // $unitstr = $this->bplsNonKontrak()[0];
        // $tahun = $this->bplsNonKontrak()[1];
        // $kounit1 = $this->bplsNonKontrak()[2];
        // $bplsnon = $this->bplsNonKontrak()[3];
        // $net = $this->bplsNonKontrak()[4];
        // $footer  = $this->bplsNonKontrak()[5];
        // return view('laporan.penatausahaan.belanja.bplsnon_isi', compact('unitstr', 'tahun', 'kounit1', 'bplsnon', 'net',  'footer'));
        $date1 = $request->date1;
        $date2 = $request->date2;

        $data = DB::table('vqr_bkuLSnon')
        ->select('*')
            ->where('Ko_Period', Tahun())
            ->where('Ko_unitstr', kd_unit())
            ->whereBetween('dt_oto', [$date1,$date2])
            ->get();

        return view('laporan.penatausahaan.belanja.bplsnon_isi',compact('data'));
    }

    public function bplsnonshow_cetak(Request $request)
    {
        // $unitstr = $this->bplsNonKontrak()[0];
        // $tahun = $this->bplsNonKontrak()[1];
        // $kounit1 = $this->bplsNonKontrak()[2];
        // $bplsnon = $this->bplsNonKontrak()[3];
        // $net = $this->bplsNonKontrak()[4];
        // $footer  = $this->bplsNonKontrak()[5];
        // $date1 = $request->date1;
        // $date2 = $request->date2;

        // $pdf = PDF::loadView('laporan.penatausahaan.belanja.bplsnon_cetak', compact('unitstr', 'tahun', 'kounit1', 'bplsnon', 'net',  'footer', 'date1', 'date2'))->setPaper('A4', 'landscape');

        $date1 = $request->date1;
        $date2 = $request->date2;

        $data = DB::table('vqr_bkuLSnon')
        ->select('*')
            ->where('Ko_Period', Tahun())
            ->where('Ko_unitstr', kd_unit())
            ->whereBetween('dt_oto', [$date1,$date2])
            ->get();

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.bplsnon_cetak', compact('data','date1','date2'))->setPaper('A4', 'potrait');
        return $pdf->stream('buku_bantu_ls_non_kontrak.pdf');
    }

    public function bplsnonPDF()
    {

        // $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = nm_bidang();
        $rba1 = DB::select('CALL SP_RBA1(".$tahun.", 14.02.01.02.01.001)'); // harus single quote???

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
        $pdf = PDF::loadView('laporan\penatausahaan\belanja\bplsnonpdf', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('rba1-pendapatan.pdf');
    }

    public function bplscontrshow()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.belanja.bplscontr',compact('pegawai'));
    }

    public function bplscontrshow_isi(Request $request)
    {
        // $unitstr = $this->bplsKontrak()[0];;
        // $tahun = $this->bplsKontrak()[1];
        // $kounit1 = $this->bplsKontrak()[2];
        // $bplscontr = $this->bplsKontrak()[3];
        // $net = $this->bplsKontrak()[4];
        // $footer  = $this->bplsKontrak()[5];

        // return view('laporan.penatausahaan.belanja.bplscontr_isi', compact('unitstr', 'tahun', 'kounit1', 'bplscontr', 'net',  'footer'));

        $date1 = $request->date1;
        $date2 = $request->date2;

        $data = DB::table('vqr_bkuLScon')
        ->select('*')
            ->where('Ko_Period',  Tahun())
            ->where('Ko_unitstr',  kd_unit())
            ->whereBetween('dt_oto', [$date1, $date2])
            ->get();

        return view('laporan.penatausahaan.belanja.bplscontr_isi', compact('data'));
    }

    public function bplscontrshow_cetak(Request $request)
    {
        // $unitstr = $this->bplsKontrak()[0];;
        // $tahun = $this->bplsKontrak()[1];
        // $kounit1 = $this->bplsKontrak()[2];
        // $bplscontr = $this->bplsKontrak()[3];
        // $net = $this->bplsKontrak()[4];
        // $footer  = $this->bplsKontrak()[5];
        // $date1 = $request->date1;
        // $date2 = $request->date2;

        // $pdf = PDF::loadView('laporan.penatausahaan.belanja.bplscontr_cetak', compact('unitstr', 'tahun', 'kounit1', 'bplscontr', 'net',  'footer', 'date1', 'date2'))->setPaper('A4', 'landscape');
        $date1 = $request->date1;
        $date2 = $request->date2;

        $data = DB::table('vqr_bkuLScon')
        ->select('*')
            ->where('Ko_Period',  Tahun())
            ->where('Ko_unitstr',  kd_unit())
            ->whereBetween('dt_oto', [$date1, $date2])
            ->get();
        
        $pdf = PDF::loadView('laporan.penatausahaan.belanja.bplscontr_cetak', compact('data', 'date1', 'date2'))->setPaper('A4', 'potrait');
        return $pdf->stream('buku_bantu_ls_kontrak.pdf');
    }

    public function bplscontrPDF()
    {

        // $unitstr = Session::get('Ko_unitstr');
        $unitstr = kd_unit();
        $tahun = Tahun();
        $kounit1 = nm_bidang();
        $rba1 = DB::select('CALL SP_RBA1(".$tahun.", 14.02.01.02.01.001)'); // harus single quote???

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
        $pdf = PDF::loadView('laporan\penatausahaan\belanja\bplscontrpdf', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('rba1-pendapatan.pdf');
    }

    public function bppj()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.belanja.bppj',compact('pegawai'));
    }

    public function bppj_isi(Request $request)
    {
        $tahun = $this->bpPanjar()[0];
        $bppanjar = $this->bpPanjar()[1];

        return view('laporan.penatausahaan.belanja.bppj_isi', compact('tahun', 'bppanjar'));
    }

    public function bppj_cetak(Request $request)
    {
        $tahun = $this->bpPanjar()[0];
        $bppanjar = $this->bpPanjar()[1];
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.bppj_cetak', compact('tahun', 'bppanjar', 'date1', 'date2'))->setPaper('A4', 'landscape');
        return $pdf->download('buku_bantu_panjar.pdf');
    }

    public function bppajak()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.belanja.bppajak',compact('pegawai'));
    }

    public function bppajak_isi(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pajak = DB::select('CALL qr_BPtax("'.kd_unit().'","'.$date1.'","'.$date2.'")');
        return view('laporan.penatausahaan.belanja.bppajak_isi', compact('pajak'));
    }

    public function bppajak_cetak(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $pajak = DB::select('CALL qr_BPtax("'.kd_unit().'","'.$date1.'","'.$date2.'")');
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        
        $pdf = PDF::loadView('laporan.penatausahaan.belanja.bppajak_cetak', compact('pajak', 'date1', 'date2','pegawai'))->setPaper('A4', 'portrait');
        return $pdf->stream('buku_pembantu_pajak.pdf');
    }

    public function regKontrak()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.belanja.regKontrak',compact('pegawai'));
    }

    public function regKontrak_isi(Request $request)
    {
        $regKontrak = $this->registerKontrak($request);

        return view('laporan.penatausahaan.belanja.regKontrak_isi', compact('regKontrak'));
    }

    public function regKontrak_cetak(Request $request)
    {
        $regKontrak = $this->registerKontrak($request);
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pdf = PDF::loadView('laporan.penatausahaan.belanja.regKontrak_cetak', compact('regKontrak', 'date1', 'date2'))->setPaper('A4', 'landscape');
        return $pdf->stream('register_kontrak.pdf');
    }

    public function bpobjek()
    {
        $max  = DB::select('SELECT MAX(Ko_Tap) tap FROM tb_tap WHERE Ko_Period = "'.Tahun().'" && LEFT(ko_unit1,18) = "'.kd_unit().'"');
        $akun = DB::select('SELECT * FROM tb_tap
        WHERE Ko_Period = "'.Tahun().'" && LEFT(ko_unit1,18) = "'.kd_unit().'" && Ko_Tap = "'.$max['0']->tap.'" && LEFT(Ko_Rkk,2) = 05 GROUP BY Ko_Rkk');
        return view('laporan.penatausahaan.belanja.bpobjek',compact('akun'));
    }

    public function bpobjek_isi(Request $request)
    {
        $data = DB::select('CALL qr_bbro_blj("'.Tahun().'","'. kd_unit().'","'.$request->rkk.'","'.$request->bulan.'")');
        return view('laporan.penatausahaan.belanja.bpobjek_isi',compact('data'));
    }

    public function bpobjek_cetak(Request $request)
    {
        $data = DB::select('CALL qr_bbro_blj("'.Tahun().'","'. kd_unit().'","'.$request->ko_rkk.'","'.$request->periode.'")');
        $pdf  = PDF::loadView('laporan.penatausahaan.belanja.bpobjek_cetak', compact('data'))->setPaper('A4', 'potrait');
        return $pdf->stream('objek.pdf');
    }

    public function fungsionalpengeluaran()
    {
        return view('laporan.penatausahaan.belanja.fungsional');
    }

    public function fungsionalpengeluaran_isi(Request $request)
    {
        $row = DB::select('CALL qr_spjfung_blj("'.Tahun().'","'. kd_unit().'","'.$request->bulan.'")');
        // $data = collect($row)->groupBy('Ur_Rk5')->map(function ($group){
        //     return [
        //         'sub_anggaran' => $group->sum('Anggaran'),
        //         'sub_lalu'     => $group->sum('real_lalu'),
        //         'sub_ls'       => $group->sum('real_LS'),
        //         'sub_gu'       => $group->sum('real_GU'),
        //         'sub_now'      => $group->sum('real_now'),
        //         'sub_sisa'     => $group->sum('sisa'),
        //         'rincian'      => $group->groupBy('Ur_Rk6')->map(function ($group1){
        //             return [
        //                 'uraian'  => $group1->first(),
        //             ];
        //         }),
        //     ];
        // });

        $data = collect($row)->groupBy('Ur_KegBL1')->map(function ($group){
            return [
                't_ang'    => $group->sum('Anggaran'),
                'rincian1' => $group->groupBy('Ur_KegBL2')->map(function ($group1){
                    return [
                        't_ang'    => $group1->sum('Anggaran'),
                        'rincian2' => $group1->groupBy('Ur_Rk5')->map(function ($group3){
                            return [
                            't_ang'    => $group3->sum('Anggaran'),
                            'rincian3' => $group3->groupBy('Ur_Rk6')->map(function ($group4){
                                    return [
                                        't_ang'    => $group4->sum('Anggaran'),
                                        'sub_lalu' => $group4->sum('real_lalu'),
                                        'sub_ls'   => $group4->sum('real_LS'),
                                        'sub_gu'   => $group4->sum('real_GU'),
                                        'sub_now'  => $group4->sum('real_now'),
                                        'sub_sisa' => $group4->sum('sisa'),
                                        'uraian'   => $group4->first(),
                                    ];
                                }),
                            ];
                        }),
                    ];
                }),
            ];
        });

        return view('laporan.penatausahaan.belanja.fungsional_isi',compact('data'));
    }

    public function fungsionalpengeluaran_cetak(Request $request)
    {
        $bulan = $request->bulan;
        $row = DB::select('CALL qr_spjfung_blj("'.Tahun().'","'. kd_unit().'","'.$request->bulan.'")');
        // $data = collect($row)->groupBy('Ur_Rk5')->map(function ($group){
        //     return [
        //         'sub_anggaran' => $group->sum('Anggaran'),
        //         'sub_lalu'     => $group->sum('real_lalu'),
        //         'sub_ls'       => $group->sum('real_LS'),
        //         'sub_gu'       => $group->sum('real_GU'),
        //         'sub_now'      => $group->sum('real_now'),
        //         'sub_sisa'     => $group->sum('sisa'),
        //         'rincian'      => $group->groupBy('Ur_Rk6')->map(function ($group1){
        //             return [
        //                 'uraian'  => $group1->first(),
        //             ];
        //         }),
        //     ];
        // });
        $data = collect($row)->groupBy('Ur_KegBL1')->map(function ($group){
            return [
                't_ang'    => $group->sum('Anggaran'),
                'rincian1' => $group->groupBy('Ur_KegBL2')->map(function ($group1){
                    return [
                        't_ang'    => $group1->sum('Anggaran'),
                        'rincian2' => $group1->groupBy('Ur_Rk5')->map(function ($group3){
                            return [
                            't_ang'    => $group3->sum('Anggaran'),
                            'rincian3' => $group3->groupBy('Ur_Rk6')->map(function ($group4){
                                    return [
                                        't_ang'    => $group4->sum('Anggaran'),
                                        'sub_lalu' => $group4->sum('real_lalu'),
                                        'sub_ls'   => $group4->sum('real_LS'),
                                        'sub_gu'   => $group4->sum('real_GU'),
                                        'sub_now'  => $group4->sum('real_now'),
                                        'sub_sisa' => $group4->sum('sisa'),
                                        'uraian'   => $group4->first(),
                                    ];
                                }),
                            ];
                        }),
                    ];
                }),
            ];
        });
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $pdf = PDF::loadView('laporan.penatausahaan.belanja.fungsional_cetak',compact('data','bulan','pegawai'))->setPaper('A4', 'potrait');
        return $pdf->stream('fungsional_pengeluaran.pdf');
    }
}
