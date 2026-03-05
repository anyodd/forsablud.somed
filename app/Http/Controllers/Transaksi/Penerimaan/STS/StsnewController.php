<?php

namespace App\Http\Controllers\Transaksi\Penerimaan\STS;

use App\Models\Tbsts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pfbank;
use App\Models\Tbbp;
use App\Models\Tbbyr;
use App\Models\Tbstsrc;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class StsnewController extends Controller
{
    public function index()
    {
        $sts = DB::select("SELECT a.*,b.total FROM tb_sts a
        LEFT JOIN (SELECT a.id_sts,SUM(a.total) total FROM (SELECT a.id_sts,b.real_rp total FROM tb_stsrc a 
        JOIN tb_byr b ON a.No_byr = b.No_byr && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
        WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr ='".kd_unit()."'
        GROUP BY b.id_byr) a
        GROUP BY a.id_sts) b ON a.id_sts = b.id_sts
        WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."'
        ORDER BY a.dt_sts DESC");

        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."' AND b.id_pj IN (7,8,20,21) ");
        
        $bank = Pfbank::where('Ko_unitstr', kd_unit())->get();

        return view('transaksi.penerimaan.sts.index', compact('sts','bank','pegawai'));
    }

    public function v_bulan(Request $request,$id)
    {
        $bulan = $id;
        $request->session()->put('bulan', $bulan);

        $sts = DB::select("SELECT * FROM (
            SELECT a.*,b.total FROM tb_sts a
            LEFT JOIN (SELECT a.id_sts,SUM(a.total) total FROM (SELECT a.id_sts,b.real_rp total FROM tb_stsrc a 
            JOIN tb_byr b ON a.No_byr = b.No_byr && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."'
            GROUP BY b.id_byr) a
            GROUP BY a.id_sts) b ON a.id_sts = b.id_sts
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."'
            ORDER BY a.dt_sts DESC) a
            WHERE MONTH(a.dt_sts) = '".$bulan."'
            ORDER BY a.dt_sts DESC");

        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
        
        $bank = Pfbank::where('Ko_unitstr', kd_unit())->get();

        return view('transaksi.penerimaan.sts.index', compact('sts','bank','pegawai','bulan'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'Ko_unitstr'    => 'required',
            'No_sts'        => 'required',
            'dt_sts'        => 'required',
            'Ur_sts'        => 'required',
            'Nm_Ben'        => 'required',
            'NIP_Ben'       => 'required',
            'Ko_Bank'       => 'required',
        ]);

        $nip = explode("|",$request->Nm_Ben);
        $bulan = Carbon::parse($request->dt_sts)->format('m');

        try {
            Tbsts::Create([
                'Ko_Period' => Tahun(),
                'Ko_unitstr' => kd_unit(),
                'No_sts' => $request->No_sts,
                'dt_sts' => $request->dt_sts,
                'Ur_sts' => $request->Ur_sts,
                'Nm_Ben' => $nip[0],
                'NIP_Ben' => $request->NIP_Ben,
                'Ko_Bank' => $request->Ko_Bank,
                'tb_ulog' => getUser('username'),
                'Tag' => 0,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }

        Alert::success('Berhasil', "STS berhasil ditambah");

        return redirect()->route('sts.bulan',$bulan);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'No_stsedit'  => 'required',
            'dt_stsedit'  => 'required',
            'Ur_stsedit'  => 'required',
            'Nm_Benedit'  => 'required',
            'NIP_Benedit' => 'required',
            'Ko_Bankedit' => 'required',
        ]);

        $nip = explode("|",$request->Nm_Benedit);
        $bulan = Carbon::parse($request->dt_stsedit)->format('m');

        try {
            Tbsts::where('id_sts', $request->id_sts)->update([
                'No_sts'  => $request->No_stsedit,
                'dt_sts'  => $request->dt_stsedit,
                'Ur_sts'  => $request->Ur_stsedit,
                'Nm_Ben'  => $nip[0],
                'NIP_Ben' => $request->NIP_Benedit,
                'Ko_Bank' => $request->Ko_Bankedit,
                'tb_ulog' => getUser('username'),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }

        Alert::success('Berhasil', "STS $request->No_stsedit berhasil di ubah");
        return redirect()->route('sts.bulan',$bulan);
    }

    public function destroy($id)
    {
        $bulan = Session::get('bulan');
        $sts   = Tbsts::find($id);
        $stsrc = Tbstsrc::where('id_sts',$id)->first();
        if ($stsrc == null) {
            $sts->delete();
            $sts->tbstsrcs()->delete();
            Alert::success('Berhasil', "STS $sts->No_sts berhasil dihapus");
        }else{
            Alert::warning('Gagal', "Hapus Rincian $sts->No_sts dulu !");
        }

        return redirect()->route('sts.bulan',$bulan);
    }

    public function stsdetail($id) 
    {
        $stsdetail = DB::select("SELECT *,b.real_rp total FROM tb_stsrc a 
        JOIN tb_byr b ON a.No_byr = b.No_byr && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
        WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr ='".kd_unit()."' && a.id_sts= '".$id."'
        GROUP BY b.id_byr");

        $id_sts = Tbsts::where('id_sts', $id)->value('id_sts');
        $No_sts = Tbsts::find($id);

        $max = Tbstsrc::where('id_sts', $id)->max('Ko_stsrc');

        $tb_sts = Tbsts::find($id);

        $nobayar = DB::select("SELECT a.* FROM(
                        SELECT b.*,real_rp total FROM tb_bp a
                        JOIN tb_byr b ON a.No_bp = b.no_bp && LEFT(a.Ko_unit1,18) = b.Ko_unitstr && a.Ko_Period = b.Ko_Period
                        WHERE a.Ko_bp IN(1,11,42) && a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."' 
                        AND CAST(b.dt_byr AS DATE) <= CAST('".$tb_sts->dt_sts."' AS DATE)
                        GROUP BY b.id_byr
                        ) a LEFT OUTER JOIN tb_stsrc b ON a.No_byr=b.No_byr AND a.Ko_unitstr=b.Ko_unitstr
                        WHERE b.No_byr IS NULL");

        return view('transaksi.penerimaan.stsrinci.index', compact('stsdetail', 'tb_sts', 'nobayar','max','id_sts'));
    }

    public function list_realisasi()
    {
        $nobayar = DB::select("SELECT * FROM(SELECT b.*,real_rp total FROM tb_bp a
        JOIN tb_byr b ON a.No_bp = b.no_bp && LEFT(a.Ko_unit1,18) = b.Ko_unitstr && a.Ko_Period = b.Ko_Period
        WHERE a.Ko_bp IN(1,11,42) && a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."'
        GROUP BY b.id_byr) a
        WHERE NOT EXISTS(SELECT * FROM tb_stsrc b WHERE b.No_byr = a.No_byr && a.Ko_unitstr = b.Ko_unitstr && a.Ko_Period = b.Ko_Period)");
    }

    public function sts_pdf($id)
    {
        $sts = Tbsts::find($id);
        $data = DB::select('CALL SP_STS("' . $id . '")');
        $jml = collect($data)->SUM('Nilai');
        $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
        $bendahara = DB::select("SELECT a.NIP_pjb NIP_Bend, a.Nm_pjb Nm_Bend, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.id_pj = '7'");

        $pdf = PDF::loadView('transaksi.penerimaan.sts.sts_pdf', compact('data','jml','pegawai','bendahara'))->setPaper('A4', 'portrait');
        return $pdf->stream('sts : ' . $sts->No_st . '.pdf',  array("Attachment" => false));
    }
}
