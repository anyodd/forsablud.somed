<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Http\Traits\laporanTrait;
use App\Models\Tbsts;
use App\Models\V_transts;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PenerimaanController extends Controller
{
    use laporanTrait;

    public function penerimaan_sts()
    {
        $pegawai   = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
    // dd($bendahara);
        return view('laporan.penatausahaan.bendahara.penerimaan.sts',compact('pegawai','bendahara'));
    }

    public function qr_sts()
    {
        $sts = DB::select("SELECT a.*,b.total FROM tb_sts a
        LEFT JOIN (SELECT a.id_sts,SUM(a.total) total FROM (SELECT a.id_sts,b.real_rp total FROM tb_stsrc a 
        JOIN tb_byr b ON a.No_byr = b.No_byr
        WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr ='".kd_unit()."'
        GROUP BY b.id_byr) a
        GROUP BY a.id_sts) b ON a.id_sts = b.id_sts
        WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."'
        ORDER BY a.dt_sts asc");

        return view('laporan.penatausahaan.bendahara.penerimaan.qr_sts',compact('sts'));
    }

    public function qr_sts_cetak(Request $request)
    {
        $data = DB::select('CALL qr_sts("' . Tahun() . '","' . kd_unit() . '","' . $request->No_sts . '")');
        $jml = collect($data)->SUM('Nilai');
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.qr_sts_pdf', compact('data','jml','pegawai','bendahara'))->setPaper('A4', 'portrait');
        return $pdf->stream('sts : ' . $request->No_sts . '.pdf',  array("Attachment" => false));
    }

    public function penerimaan_sts_isi(Request $request)
    {
        $data = $this->registerSts($request);

        return view('laporan.penatausahaan.bendahara.penerimaan.sts_isi', compact('data'));
    }

    public function penerimaan_sts_cetak(Request $request)
    {
        $data = $this->registerSts($request);
        $date1 = $request->date1;
        $date2 = $request->date2;
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.sts_cetak', compact('data', 'date1', 'date2','pegawai','bendahara'))->setPaper('A4', 'portrait');
        return $pdf->stream('register_sts.pdf');
    }

    public function penerimaan_bku()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.bku',compact('pegawai','bendahara'));
    }

    public function penerimaan_bku_isi(Request $request)
    {

        $data = $this->bkuPenerimaan($request);
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.bku_isi', compact('data','pegawai','bendahara'));
    }

    public function penerimaan_bku_cetak(Request $request)
    {
        $data = $this->bkuPenerimaan($request);
        $date1 = $request->date1;
        $date2 = $request->date2;
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.bku_cetak', compact('data', 'date1', 'date2','pegawai','bendahara'))->setPaper('A4', 'portrait');
        // return $pdf->download('buku_kas_umum.pdf');
        return $pdf->stream('buku_kas_umum.pdf');
    }

    public function penerimaan_bpkt()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.bpkt',compact('pegawai','bendahara'));
    }

    public function penerimaan_bpkt_isi(Request $request)
    {
        $data = $this->bpKasTunai($request);

        return view('laporan.penatausahaan.bendahara.penerimaan.bpkt_isi', compact('data'));
    }

    public function penerimaan_bpkt_cetak(Request $request)
    {
        $data = $this->bpKasTunai($request);
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.bpkt_cetak', compact('data', 'date1', 'date2','pegawai','bendahara'))->setPaper('A4', 'portrait');
        return $pdf->download('buku_pembantu_kas_tunai.pdf');
    }

    public function penerimaan_bpb()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.bpb',compact('pegawai','bendahara'));
    }

    public function penerimaan_bpb_isi(Request $request)
    {
        $data = $this->bpBank($request);

        return view('laporan.penatausahaan.bendahara.penerimaan.bpb_isi', compact('data'));
    }

    public function penerimaan_bpb_cetak(Request $request)
    {
        $data = $this->bpBank($request);
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.bpb_cetak', compact('data', 'date1', 'date2','pegawai','bendahara'))->setPaper('A4', 'portrait');
        return $pdf->download('buku_pembantu_bank.pdf');
    }

    public function penerimaan_lpj()
    {

        $data = DB::select('CALL qr_BKUpdp_LPJ("' . Tahun() . '/01/01","' . Tahun() . '/12/31","' . kd_unit() . '")');
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.lpj', compact('data','pegawai','bendahara'));
    }

    public function penerimaan_lpp()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.lpp',compact('pegawai','bendahara'));
    }

    public function penerimaan_lpp_isi(Request $request)
    {
        $data = $this->lTerimaSetor($request);

        return view('laporan.penatausahaan.bendahara.penerimaan.lpp_isi', compact('data'));
    }

    public function penerimaan_lpp_cetak(Request $request)
    {
        $data = $this->lTerimaSetor($request);
        $date1 = $request->date1;
        $date2 = $request->date2;

        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.lpp_cetak', compact('data', 'date1', 'date2','pegawai','bendahara'))->setPaper('A4', 'potrait');
        return $pdf->stream('laporan_penerimaan_dan_penyetoran.pdf');
    }

    public function regPiutang()
    {
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        return view('laporan.penatausahaan.bendahara.penerimaan.regPiutang',compact('pegawai','bendahara'));
    }

    public function regPiutangIsi(Request $request)
    {
        $regPiutang = $this->registerPiutang($request);

        return view('laporan.penatausahaan.bendahara.penerimaan.regPiutangIsi', compact('regPiutang'));
    }

    public function regPiutangCetak(Request $request)
    {
        $data = $this->registerPiutang($request);
        $date1 = $request->date1;
        $date2 = $request->date2;
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.regPiutangCetak', compact('data', 'date1', 'date2','pegawai','bendahara'))->setPaper('A4', 'landscape');
        return $pdf->stream('register_penerimaan.pdf');
    }

    public function fungsionalpenerimaan()
    {
        // $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        return view('laporan.penatausahaan.bendahara.penerimaan.fungsional');
    }

    public function fungsionalpenerimaan_isi(Request $request)
    {
        $row = DB::select('CALL qr_spjfung_pdp("'.Tahun().'","'. kd_unit().'","'.$request->bulan.'")');
        $data = collect($row)->groupBy('Ur_Rk5')->map(function ($group){
            return [
                'sub_anggaran' => $group->sum('Anggaran'),
                'sub_lalu'     => $group->sum('real_lalu'),
                'sub_ini'      => $group->sum('real_ini'),
                'sub_now'      => $group->sum('real_now'),
                'sub_sisa'     => $group->sum('sisa'),
                'rincian'      => $group->groupBy('Ur_Rk6')->map(function ($group1){
                    return [
                        'uraian'  => $group1->first(),
                    ];
                }),
            ];
        });
        return view('laporan.penatausahaan.bendahara.penerimaan.fungsional_isi',compact('data'));
    }

    public function fungsionalpenerimaan_cetak(Request $request)
    {
        $bulan = $request->bulan;
        $row = DB::select('CALL qr_spjfung_pdp("'.Tahun().'","'. kd_unit().'","'.$request->bulan.'")');
        $data = collect($row)->groupBy('Ur_Rk5')->map(function ($group){
            return [
                'sub_anggaran' => $group->sum('Anggaran'),
                'sub_lalu'     => $group->sum('real_lalu'),
                'sub_ini'      => $group->sum('real_ini'),
                'sub_now'      => $group->sum('real_now'),
                'sub_sisa'     => $group->sum('sisa'),
                'rincian'      => $group->groupBy('Ur_Rk6')->map(function ($group1){
                    return [
                        'uraian'  => $group1->first(),
                    ];
                }),
            ];
        });
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");
        $pdf = PDF::loadView('laporan.penatausahaan.bendahara.penerimaan.fungsional_cetak',compact('data','bulan','pegawai','bendahara'))->setPaper('A4', 'potrait');
        return $pdf->stream('fungsional_penerimaan.pdf');
    }
}
