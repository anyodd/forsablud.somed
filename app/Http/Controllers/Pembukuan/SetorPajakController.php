<?php

namespace App\Http\Controllers\Pembukuan;

use App\Http\Controllers\Controller;
use App\Models\Pfbank;
use App\Models\Tbrekan;
use App\Models\Tbtax;
use App\Models\Tbtaxor;
use App\Models\Tbtaxtorc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use RealRashid\SweetAlert\Facades\Alert;
use Svg\Tag\Rect;

class SetorPajakController extends Controller
{
    // public function index()
    // {
    //     $pajak = DB::select(DB::raw("SELECT a.id_taxtor,b.rekan_nm,a.Ur_taxtor,a.dt_taxtor,a.Ko_Rkk,d.ur_rk6,c.Ur_Bank,c.No_Rek,a.No_ntpn,a.No_bill FROM tb_taxtor a 
    //     LEFT JOIN tb_rekan b ON a.id_rekan = b.id_rekan
    //     LEFT JOIN pf_bank c ON a.Ko_Bank = c.Ko_Bank && LEFT(a.Ko_unit1,18) = c.Ko_unitstr
    //     LEFT JOIN (SELECT a.rek,a.ur_rk6 FROM (SELECT CONCAT(
    //            LPAD(Ko_Rk1,2,0),'.' ,
    //            LPAD(Ko_Rk2,2,0),'.' ,
    //            LPAD(Ko_Rk3,2,0),'.' ,
    //            LPAD(Ko_Rk4,2,0),'.' ,
    //            LPAD(Ko_Rk5,3,0),'.' ,
    //            LPAD(Ko_Rk6,4,0)
    //            ) AS rek, ur_rk6
    //            FROM pf_rk6
    //            WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1') a) d
    //            ON a.Ko_Rkk = d.rek
    //     WHERE a.Ko_unit1 = '".kd_bidang()."' && a.Ko_Period = '".Tahun()."'
    //     GROUP BY a.id_taxtor"));
    //     return view('pembukuan.setorpajak.index',compact('pajak'));
    // }

    public function index()
    {
        $pajak = DB::select('SELECT a.*,b.setor FROM (
                SELECT c.id_rekan,a.Ko_Period,a.Ko_unit1,c.rekan_nm, SUM(a.tax_Rp) t_tax FROM tb_tax a 
                LEFT JOIN tb_bp b ON a.id_bp = b.id_bp
                LEFT JOIN tb_rekan c ON	b.nm_BUcontr = c.id_rekan
                WHERE b.Ko_bp IN(3,4,5,41) && b.Ko_Period = "'.tahun().'" && LEFT(b.Ko_unit1,18) = "'.kd_unit().'"
                GROUP BY b.nm_BUcontr
                ORDER BY b.id_bp ASC) a
                LEFT JOIN (SELECT a.id_rekan,SUM(b.taxtor_Rp) setor FROM tb_taxtor a
                LEFT JOIN tb_taxtorc b ON a.id_taxtor = b.id_taxtor
                WHERE a.Ko_Period = "'.tahun().'" && LEFT(a.Ko_unit1,18) = "'.kd_unit().'"
                GROUP BY a.id_rekan) b ON a.id_rekan = b.id_rekan');

        return view('pembukuan.setorpajak.index',compact('pajak'));
    }

    public function create_setor($id)
    {
        $rekanan = Tbrekan::where(['Ko_unitstr' => kd_unit(),'id_rekan' => $id])->get();
        $bank = DB::select(DB::raw('SELECT * FROM pf_bank a WHERE 
            a.Ko_Wil1 = SUBSTRING("'.kd_bidang().'",1,2) &&
            a.`Ko_Wil2` = SUBSTRING("'.kd_bidang().'",4,2) &&
            a.`Ko_Urus` = SUBSTRING("'.kd_bidang().'",7,2) &&
            a.`Ko_Bid` = SUBSTRING("'.kd_bidang().'",10,2) &&
            a.`Ko_Unit` = SUBSTRING("'.kd_bidang().'",13,2) &&
            a.`Ko_Sub` = SUBSTRING("'.kd_bidang().'",16,3)'));
        $rkk6 = DB::select(DB::raw("SELECT DISTINCT a.Ko_RKK AS RKK6, a.ur_rk6
            FROM pf_rk6 a INNER JOIN
                tb_tax b ON a.Ko_RKK=b.Ko_Rkk LEFT JOIN 
                tb_bp c ON b.id_bp = c.id_bp LEFT JOIN 
                tb_rekan d ON c.nm_BUcontr = d.id_rekan
            WHERE a.Ko_Rk1 = '2' AND  a.Ko_Rk2 = '1' AND  a.Ko_Rk3 = '1' AND LEFT(b.ko_unit1,18)='".kd_unit()."' AND d.id_rekan=".$id."  "));

        return view('pembukuan.setorpajak.create',compact('rkk6','bank','rekanan'));
    }

    public function store(Request $request)
    {
        $rules = [
            'No_ntpn'    => 'required',
            'No_bill'    => 'required',
            'id_rekan'   => 'required',
            'Ur_taxtor'  => 'required',
            'dt_taxtor'  => 'required',
            'Ko_Rkk'     => 'required',
            'Ko_Bank'    => 'required',
        ];

        $messages = [
            'No_ntpn.required'   => 'Nomor NTPN wajib diisi.',
            'No_bill.required'   => 'Kode Billing wajib diisi.',
            'id_rekan.required'  => 'Rekanan wajib diisi.',
            'dt_taxtor.required' => 'Tanggal wajib diisi.',
            'Ur_taxtor.required' => 'Uraian wajib diisi.',
            'Ko_Rkk.required'    => 'Jenis Pajak wajib diisi.',
            'Ko_Bank.required'   => 'Bank wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        try {
            Tbtaxor::create([
                'id_rekan'   => $request->id_rekan,
                'Ko_Period'  => Tahun(),
                'Ko_unit1'   => kd_bidang(),
                'Ur_taxtor'  => $request->Ur_taxtor,
                'Ko_Rkk'     => $request->Ko_Rkk,
                'Ko_Bank'    => $request->Ko_Bank,
                'dt_taxtor'  => $request->dt_taxtor,
                'No_ntpn'    => $request->No_ntpn,
                'No_bill'    => $request->No_bill,
                'Tag'        => '0',
                'tb_ulog'    => 'admin',
                'created_at' => now(),
              ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::warning('Transaksi Gagal', 'No Billing tidak boleh sama');
            return redirect()->route('setorpajak.index');
        }

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('setorpajak.show',$request->id_rekan);
    }

    // public function show($id)
    // {
    //     $id_taxtor  = Tbtaxor::where('id_taxtor',$id)->value('id_rekan');
    //     $id_taxtr   = Tbtaxor::where('id_taxtor',$id)->value('id_taxtor');
    //     $pajakrinci = DB::select(DB::raw("SELECT * FROM (SELECT * FROM tb_taxtor a 
    //     LEFT JOIN (SELECT a.id_tax,b.No_bp,b.Ur_bp,c.id_rekan idrekan,c.rekan_nm,d.ur_rk6,a.Ko_tax,a.tax_Rp, SUM(e.To_Rp) t_tag FROM tb_tax a
    //     LEFT JOIN tb_bp b ON a.id_bp = b.id_bp 
    //     LEFT JOIN tb_rekan c ON b.nm_BUcontr = c.id_rekan
    //     LEFT JOIN tb_bprc e ON b.id_bp = e.id_bp
    //     LEFT JOIN (SELECT a.rek,a.ur_rk6 FROM (SELECT CONCAT(
    //         LPAD(Ko_Rk1,2,0),'.' ,
    //         LPAD(Ko_Rk2,2,0),'.' ,
    //         LPAD(Ko_Rk3,2,0),'.' ,
    //         LPAD(Ko_Rk4,2,0),'.' ,
    //         LPAD(Ko_Rk5,3,0),'.' ,
    //         LPAD(Ko_Rk6,4,0)
    //         ) AS rek, ur_rk6
    //         FROM pf_rk6
    //         WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1') a) d
    //         ON a.Ko_Rkk = d.rek
    //     GROUP BY a.id_tax) b
    //     ON a.id_rekan = b.idrekan
    //     GROUP BY b.id_tax) a
    //     LEFT JOIN tb_taxtorc b
    //     ON a.id_tax = b.id_tax
    //     WHERE b.id_taxtor = '".$id_taxtr."' && a.Ko_unit1 = '".kd_bidang()."' && a.Ko_Period = '".Tahun()."' "));
    //     return view('pembukuan.setorpajak.detail',compact('pajakrinci','id_taxtor','id_taxtr'));
    // }

    public function show($id)
    {
        $id_taxtr   = Tbtaxor::where('id_taxtor',$id)->value('id_taxtor');
        $id_rekan = $id;
        $pajakrinci = DB::select("SELECT a.id_taxtor,a.Ko_Period,a.Ko_unit1,b.id_rekan,b.rekan_nm,a.Ur_taxtor,a.dt_taxtor,a.Ko_Rkk,d.ur_rk6,c.Ur_Bank,c.No_Rek,a.No_ntpn,a.No_bill,SUM(e.taxtor_Rp) rupiah 
                        FROM tb_taxtor a 
                        LEFT JOIN tb_rekan b ON a.id_rekan = b.id_rekan
                        LEFT JOIN pf_bank c ON a.Ko_Bank = c.Ko_Bank && LEFT(a.Ko_unit1,18) = c.Ko_unitstr
                        LEFT JOIN pf_rk6 d ON a.Ko_Rkk = d.Ko_RKK
                        LEFT JOIN tb_taxtorc e ON a.id_taxtor = e.id_taxtor
                        WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."' && a.Ko_Period = '".tahun()."' && a.id_rekan = '".$id."'
                        GROUP BY a.id_taxtor,a.Ko_Period,a.Ko_unit1,b.id_rekan,b.rekan_nm,a.Ur_taxtor,a.dt_taxtor,a.Ko_Rkk,d.ur_rk6,c.Ur_Bank,c.No_Rek,a.No_ntpn,a.No_bill");
        return view('pembukuan.setorpajak.detail',compact('pajakrinci','id_rekan'));
    }

    public function edit($id)
    {
        $pajak = Tbtaxor::where('id_taxtor',$id)->first();
        $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->get();
        $bank = DB::select("SELECT * FROM pf_bank WHERE Ko_unitstr = '".kd_unit()."'");
        $rkk6 = DB::select(DB::raw("SELECT DISTINCT a.Ko_RKK AS RKK6, a.ur_rk6
                    FROM pf_rk6 a  INNER JOIN
                        tb_tax b ON a.Ko_RKK=b.Ko_Rkk LEFT JOIN 
                        tb_bp c ON b.id_bp = c.id_bp LEFT JOIN 
                        tb_rekan d ON c.nm_BUcontr = d.id_rekan INNER JOIN 
                        tb_taxtor e ON d.id_rekan = e.id_rekan
                    WHERE a.Ko_Rk1 = '2' AND  a.Ko_Rk2 = '1' AND  a.Ko_Rk3 = '1' AND LEFT(b.ko_unit1,18)='".kd_unit()."' AND e.id_taxtor=".$id."  "));

        return view('pembukuan.setorpajak.edit',compact('pajak','rekanan','bank','rkk6'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'No_ntpn'    => 'required',
            'No_bill'    => 'required',
            'id_rekan'   => 'required',
            'dt_taxtor'  => 'required',
            'Ur_taxtor'  => 'required',
            'Ko_Rkk'     => 'required',
            'Ko_Bank'    => 'required',
        ];

        $messages = [
            'No_ntpn.required'   => 'Nomor NTPN wajib diisi.',
            'No_bill.required'   => 'Kode Billing wajib diisi.',
            'id_rekan.required'  => 'Rekanan wajib diisi.',
            'dt_taxtor.required' => 'Tanggal wajib diisi.',
            'Ur_taxtor.required' => 'Uraian wajib diisi.',
            'Ko_Rkk.required'    => 'Jenis Pajak wajib diisi.',
            'Ko_Bank.required'   => 'Bank wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        Tbtaxor::where('id_taxtor',$id)->update([
          'id_rekan'   => $request->id_rekan,
          'Ur_taxtor'  => $request->Ur_taxtor,
          'dt_taxtor'  => $request->dt_taxtor,
          'Ko_Rkk'     => $request->Ko_Rkk,
          'Ko_Bank'    => $request->Ko_Bank,
          'No_ntpn'    => $request->No_ntpn,
          'No_bill'    => $request->No_bill,
          'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil dirubah');
        return redirect()->route('setorpajak.show',$request->id_rekan);
    }

    public function destroy($id)
    {
        $data = Tbtaxor::where('id_taxtor',$id)->first();
        $data->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }

    public function listdetail($id)
    {
        $id_taxtor  = Tbtaxor::where('id_taxtor',$id)->value('id_rekan');
        $tgl_taxtor = Tbtaxor::where('id_taxtor',$id)->value('dt_taxtor');
        $id_taxtr   = Tbtaxor::where('id_taxtor',$id)->value('id_taxtor');
        $rkk_taxtor = Tbtaxor::where('id_taxtor',$id_taxtr)->value('Ko_Rkk');
        $listdetail = DB::select(DB::raw("SELECT DISTINCT a.Ko_RKK AS rek, a.ur_rk6, b.id_tax, c.No_bp, c.dt_bp, c.Ur_bp, d.id_rekan AS idrekan, d.rekan_nm, b.Ko_tax, b.tax_Rp, e.id_taxtor, e.Ur_taxtor, g.id_taxtorc,
                        SUM(f.To_Rp) t_tag, COALESCE(SUM(taxtor_Rp),0) taxtor_Rp
                        FROM pf_rk6 a INNER JOIN
                        tb_tax b ON a.Ko_RKK=b.Ko_Rkk INNER JOIN 
                        tb_bp c ON b.id_bp = c.id_bp INNER JOIN 
                        tb_rekan d ON c.nm_BUcontr = d.id_rekan INNER JOIN 
                        tb_taxtor e ON d.id_rekan = e.id_rekan INNER JOIN
                        tb_bprc f ON c.id_bp=f.id_bp INNER JOIN 
                        tb_taxtorc g ON b.id_tax = g.id_tax AND e.id_taxtor=g.id_taxtor
                        WHERE a.Ko_Rk1 = '2' AND  a.Ko_Rk2 = '1' AND  a.Ko_Rk3 = '1' AND LEFT(b.ko_unit1,18)='".kd_unit()."' 
                        AND e.id_taxtor='".$id_taxtr."' AND b.Ko_Period = '".Tahun()."' AND g.id_tax IS NOT NULL AND c.dt_bp <= '".$tgl_taxtor."'
                        AND a.Ko_RKK = '".$rkk_taxtor."'
                        GROUP BY a.Ko_Rk1,a.Ko_Rk2, a.Ko_Rk3, a.Ko_Rk4, a.Ko_Rk5, a.Ko_Rk6, a.ur_rk6, b.id_tax, c.No_bp, c.dt_bp, c.Ur_bp, 
                        d.id_rekan, d.rekan_nm, b.Ko_tax, b.tax_Rp, b.Ko_Period, e.Ur_taxtor, e.id_taxtor, g.id_taxtorc "));

        $rincian = DB::select(DB::raw("SELECT DISTINCT a.Ko_RKK AS rek, a.ur_rk6, b.id_tax AS idtax, c.No_bp, c.dt_bp, c.Ur_bp, d.id_rekan AS idrekan, d.rekan_nm, b.Ko_tax, b.tax_Rp, e.id_taxtor, e.Ur_taxtor, g.id_taxtorc,
                        SUM(f.To_Rp) t_tag, COALESCE(SUM(taxtor_Rp),0) taxtor_Rp
                        FROM pf_rk6 a INNER JOIN
                        tb_tax b ON a.Ko_RKK=b.Ko_Rkk INNER JOIN 
                        tb_bp c ON b.id_bp = c.id_bp INNER JOIN 
                        tb_rekan d ON c.nm_BUcontr = d.id_rekan INNER JOIN 
                        tb_taxtor e ON d.id_rekan = e.id_rekan INNER JOIN
                        tb_bprc f ON c.id_bp=f.id_bp LEFT JOIN 
                        tb_taxtorc g ON b.id_tax = g.id_tax 
                        WHERE a.Ko_Rk1 = '2' AND  a.Ko_Rk2 = '1' AND  a.Ko_Rk3 = '1' AND LEFT(b.ko_unit1,18)='".kd_unit()."' 
                        AND e.id_taxtor='".$id_taxtr."' AND b.Ko_Period = '".Tahun()."' AND g.id_tax IS NULL AND c.dt_bp <= '".$tgl_taxtor."'
                        AND a.Ko_RKK = '".$rkk_taxtor."'
                        GROUP BY a.Ko_Rk1,a.Ko_Rk2, a.Ko_Rk3, a.Ko_Rk4, a.Ko_Rk5, a.Ko_Rk6, a.ur_rk6, b.id_tax, c.No_bp, c.dt_bp, c.Ur_bp, 
                        d.id_rekan, d.rekan_nm, b.Ko_tax, b.tax_Rp, b.Ko_Period, e.Ur_taxtor, e.id_taxtor, g.id_taxtorc"));

        return view('pembukuan.setorpajak.listdetail',compact('listdetail','id_taxtor','id_taxtr','rincian'));
    }

    public function create_detail($id,$id2)
    {
        $id_taxtr = $id2;
        $rkk_taxtor = Tbtaxor::where('id_taxtor',$id_taxtr)->value('Ko_Rkk');
        $rincian = DB::select(DB::raw("SELECT * FROM (SELECT * FROM tb_taxtor a 
        LEFT JOIN (SELECT a.id_tax,a.id_tax idtax,a.Ko_Rkk k_rkk,b.No_bp,b.Ur_bp,c.id_rekan idrekan,c.rekan_nm,d.ur_rk6,a.Ko_tax,a.tax_Rp, SUM(e.To_Rp) t_tag FROM tb_tax a
        LEFT JOIN tb_bp b ON a.id_bp = b.id_bp
        LEFT JOIN tb_rekan c ON b.nm_BUcontr = c.id_rekan
        LEFT JOIN tb_bprc e ON b.id_bp = e.id_bp
        LEFT JOIN (SELECT a.rek,a.ur_rk6 FROM (SELECT CONCAT(
            LPAD(Ko_Rk1,2,0),'.' ,
            LPAD(Ko_Rk2,2,0),'.' ,
            LPAD(Ko_Rk3,2,0),'.' ,
            LPAD(Ko_Rk4,2,0),'.' ,
            LPAD(Ko_Rk5,3,0),'.' ,
            LPAD(Ko_Rk6,4,0)
            ) AS rek, ur_rk6
            FROM pf_rk6
            WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1') a) d
            ON a.Ko_Rkk = d.rek
        GROUP BY a.id_tax) b
        ON a.id_rekan = b.idrekan
        GROUP BY b.id_tax) a
        LEFT JOIN tb_taxtorc b
        ON a.id_tax = b.id_tax
        WHERE a.id_rekan = '".$id."' && a.k_rkk = '".$rkk_taxtor."' && a.Ko_unit1 = '".kd_bidang()."' && a.Ko_Period = '".Tahun()."' 
        && b.id_tax IS NULL"));
        // dd($rkk_taxtor);
        return view('pembukuan.setorpajak.addrinci',compact('rincian','id_taxtr'));
    }

    public function store_detail(Request $request)
    {
        // dd($request->all());
        $id_tax = explode(',',$request->id_tax);
        $tax    = Tbtax::whereIn('id_tax',$id_tax)->get();

        foreach ($tax as $key => $value) {
            Tbtaxtorc::create([
                'id_taxtor'  => $request->id_taxtor,
                'id_tax'     => $value->id_tax,
                'taxtor_Rp'  => $value->tax_Rp,
                'Tag'        => '0',
                'tb_ulog'    => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        Alert::success('Berhasil', 'Data berhasil ditambah');
        return back();
    }

    public function destroy_detail($id)
    {
        $data = Tbtaxtorc::where('id_taxtorc',$id)->first();
        $data->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}
