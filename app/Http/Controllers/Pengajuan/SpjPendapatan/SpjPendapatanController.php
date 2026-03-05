<?php

namespace App\Http\Controllers\Pengajuan\SpjPendapatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use App\Models\Tbbyr;
use App\Models\Tbstsrc;
use RealRashid\SweetAlert\Facades\Alert;

class SpjPendapatanController extends Controller
{
  public function index()
  {
    $spjpendapatan = Tb_spi::select('tb_spi.*',DB::raw('SUM(tb_spirc.spirc_Rp) As jml'))
    ->leftJoin('tb_spirc', function ($join) {
      $join->on('tb_spi.Ko_Period', '=', 'tb_spirc.Ko_Period');
      $join->on('tb_spi.Ko_unitstr', '=', 'tb_spirc.Ko_unitstr');
      $join->on('tb_spi.No_SPi', '=', 'tb_spirc.No_spi');
    })
    ->where(['tb_spi.Ko_Period' => Tahun(), 'tb_spi.Ko_unitstr' => kd_unit(), 'tb_spi.Ko_SPi' => 5])
    ->groupBy('tb_spi.id')
    ->get();

    return view('pengajuan.spjpendapatan.index', compact('spjpendapatan'));
  }

  public function create()
  {
    $spjpendapatan = Tb_spi::all();
    $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

    return view('pengajuan.spjpendapatan.create', compact('spjpendapatan','pegawai'));
  }

  public function show($id)
  {
      $log = DB::select("SELECT * FROM tb_logv WHERE id_spi = '".$id."'");
      return view('pengajuan.spjpendapatan.popup.itemlog',compact('log'));
  }

  public function store(Request $request)
  {
    $Ko_SPi = '5';
    $Tag = '0';
    
    $rules = [
      "No_SPi" => "required",
      "Dt_SPi" => "required",
      "Ur_SPi" => "required",
      "Nm_PP" => "required",
      "NIP_PP" => "required",
      "Nm_Ben" => "required",
      "NIP_Ben" => "required",
      "Nm_Keu" => "required",
      "NIP_Keu" => "required",
    ];

    $messages = [
      "No_SPi.required" => "Nomor Bukti wajib diisi.",
      "Dt_SPi.required" => "Uraian wajib diisi.",
      "Ur_SPi.required" => "Uraian wajib diisi.",
      "Nm_PP.required" => "Nama Pengusul wajib diisi.",
      "NIP_PP.required" => "NIP Pengusul wajib diisi.",
      "Nm_Ben.required" => "Nama Bendahara wajib diisi.",
      "NIP_Ben.required" => "NIP Bendahara wajib diisi.",
      "Nm_Keu.required" => "Nama PPK wajib diisi.",
      "NIP_Keu.required" => "NIP PPK wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $PP  = explode("|",$request->Nm_PP);
    $Ben = explode("|",$request->Nm_Ben);
    $Keu = explode("|",$request->Nm_Keu);

    Tb_spi::create([          
      'Ko_Period' => Tahun(),
      'Ko_unitstr' => kd_unit(),
      'Ko_SPi'  => $Ko_SPi,
      'No_SPi'  => $request->No_SPi,
      'Dt_SPi'  => $request->Dt_SPi,
      'Ur_SPi'  => $request->Ur_SPi,
      'Nm_PP'   => $PP[0],
      'NIP_PP'  => $PP[1],
      'Nm_Ben'  => $Ben[0],
      'NIP_Ben' => $Ben[1],
      'Nm_Keu'  => $Keu[0],
      'NIP_Keu' => $Keu[1],
      'tb_ulog' => getUser('username'),
      'Tag' => $Tag,
    ]);

    Alert::success('Berhasil', "Data berhasil ditambah");
    return redirect()->route("spjpendapatan.index");
  }

  public function spjpendapatanedit($id)
  {
    $data = Tb_spi::find($id);
    $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

    return view('pengajuan.spjpendapatan.edit',compact('data','pegawai'));
  }

  public function spjpendapatanupdate(Request $request, $id)
  {
    $rules = [
      "No_SPi" => "required",
      "Dt_SPi" => "required",
      "Ur_SPi" => "required",
      "Nm_PP" => "required",
      "NIP_PP" => "required",
      "Nm_Ben" => "required",
      "NIP_Ben" => "required",
      "Nm_Keu" => "required",
      "NIP_Keu" => "required",
    ];

    $messages = [
      "No_SPi.required" => "Nomor Bukti wajib diisi.",
      "Dt_SPi.required" => "Uraian wajib diisi.",
      "Ur_SPi.required" => "Uraian wajib diisi.",
      "Nm_PP.required" => "Nama Pengusul wajib diisi.",
      "NIP_PP.required" => "NIP Pengusul wajib diisi.",
      "Nm_Ben.required" => "Nama Bendahara wajib diisi.",
      "NIP_Ben.required" => "NIP Bendahara wajib diisi.",
      "Nm_Keu.required" => "Nama PPK wajib diisi.",
      "NIP_Keu.required" => "NIP PPK wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $PP  = explode("|",$request->Nm_PP);
    $Ben = explode("|",$request->Nm_Ben);
    $Keu = explode("|",$request->Nm_Keu);

    Tb_spi::where('id', $id)->update([        
      'No_SPi' => $request->No_SPi,
      'Dt_SPi' => $request->Dt_SPi,
      'Ur_SPi' => $request->Ur_SPi,
      'Nm_PP'  => $PP[0],
      'NIP_PP' => $PP[1],
      'Nm_Ben' => $Ben[0],
      'NIP_Ben'=> $Ben[1],
      'Nm_Keu' => $Keu[0],
      'NIP_Keu'=> $Keu[1],
    ]);

    Alert::success('Berhasil', "Data berhasil dirubah");
    return redirect()->route("spjpendapatan.index");
  }

  public function rincian($id)
  {
    $spjpendapatan1 = Tb_spi::find($id);
    // $spjpendapatan = DB::select("SELECT * FROM tb_spi a
    // LEFT JOIN tb_spirc b ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
    // LEFT JOIN tb_bp c ON b.No_bp = c.No_bp && b.Ko_Period && c.Ko_Period && b.Ko_unitstr = LEFT(c.Ko_unit1,18)
    // WHERE a.id = '".$id."'
    // GROUP BY b.No_bp");
    $spjpendapatan = DB::select("SELECT * FROM tb_spi a
    LEFT JOIN tb_spirc b ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.No_SPi = b.No_spi
    INNER JOIN tb_bp c ON b.Ko_Period = c.Ko_Period && b.Ko_unitstr = LEFT(c.Ko_unit1,18) && b.No_bp = c.No_bp
    WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.id = '".$id."'");
    // dd($spjpendapatan);
    return view('pengajuan.spjpendapatan.rincian', compact('spjpendapatan','spjpendapatan1'));
  }

  public function viewtambahrincian($id)
  {
    $spjpendapatan = Tb_spi::where('id', $id)->first();
    // $spjpendapatanbukti = DB::select(DB::raw("SELECT a.No_sts, a.Ko_stsrc,c.id_sts, c.dt_sts, c.Ur_sts, SUM(b.real_rp) AS jumlah, b.* 
    //   FROM tb_stsrc a
    //   LEFT JOIN tb_byr b ON a.No_byr = b.No_byr
    //   LEFT JOIN tb_sts c ON a.id_sts = c.id_sts
    //   WHERE a.Ko_Period = ".Tahun()." AND b.Ko_Period = ".Tahun()." AND a.Ko_unitstr = '".kd_unit()."'
    //   GROUP BY a.No_sts"));

    // $spjpendapatanbukti = DB::select(DB::raw("SELECT a.*,SUM(b.real_rp) jumlah,b.*,e.*
    // FROM tb_stsrc a
    //   INNER JOIN tb_byr b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_byr = b.No_byr
    //   INNER JOIN tb_bprc c ON b.id_bprc = c.id_bprc
    //   LEFT JOIN tb_spirc d ON c.Ko_Period = d.Ko_Period AND LEFT(c.Ko_unit1,18) = d.Ko_unitstr AND c.No_bp = d.No_bp 
    //        AND c.ko_bprc = d.ko_bprc
    //   INNER JOIN tb_sts e ON a.id_sts = e.id_sts	
    // WHERE a.Ko_Period = '".Tahun()."'
    //   AND a.Ko_unitstr = '".kd_unit()."'
    //   AND d.Ko_unitstr IS NULL
    // GROUP BY a.id_sts"));

    // $spjpendapatanbukti = DB::select("SELECT a.* FROM (SELECT b.*,SUM(a.To_Rp) piutang,SUM(b.real_rp) realisasi FROM (SELECT a.*, b.id_bprc, b.To_Rp FROM tb_bp a
    // LEFT JOIN tb_bprc b ON a.id_bp = b.id_bp) a
    // LEFT JOIN tb_byr b ON a.id_bprc = b.id_bprc
    // WHERE a.Ko_bp = 1 && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_unit1,18) = '".kd_unit()."' && b.No_byr IS NOT NULL
    // GROUP BY a.id_bp ORDER BY a.dt_bp DESC)a
    // LEFT JOIN tb_spirc b ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.No_bp = b.No_bp
    // WHERE b.No_spi IS NULL
    // GROUP BY a.id_byr");

    $spjpendapatanbukti = DB::select("SELECT a.*,b.No_bp,c.id,a.real_rp realisasi FROM tb_byr a
    LEFT JOIN tb_bprc b ON a.id_bprc = b.id_bprc
    LEFT JOIN tb_spirc c ON a.No_bp = c.No_bp  && a.Ko_unitstr = c.Ko_unitstr -- && a.real_rp = c.spirc_Rp
    WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && c.id IS NULL
    GROUP BY a.id_byr
    ORDER BY a.dt_byr DESC");

    return view('pengajuan.spjpendapatan.viewtambahrincian', compact('spjpendapatanbukti', 'spjpendapatan'));
  }

  public function viewtambahrinciansts($id)
  {
    $spjpendapatan = Tb_spi::where('id', $id)->first();
    $spjpendapatanbukti = DB::select("SELECT a.*,b.total FROM tb_sts a
    LEFT JOIN (SELECT a.id_sts,SUM(a.total) total FROM (SELECT a.id_sts,b.id_byr,b.real_rp total,b.no_bp,b.real_rp,a.Ko_Period,a.Ko_unitstr FROM tb_stsrc a 
    JOIN tb_byr b ON a.No_byr = b.No_byr && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
    WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."'
    GROUP BY b.id_byr) a
    LEFT JOIN tb_spirc b ON a.No_bp = b.No_bp && a.real_rp = b.spirc_Rp && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
    WHERE b.id IS NULL
    GROUP BY a.id_sts) b ON a.id_sts = b.id_sts
    WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && b.total IS NOT NULL
    ORDER BY a.dt_sts DESC"); 
    return view('pengajuan.spjpendapatan.viewtambahrinciansts', compact('spjpendapatanbukti','spjpendapatan'));
  }

  public function tambahrincian(Request $request)
  {
    // $rules = [
    //   "No_sts" => "required",
    //   "No_byr" => "required",
    // ];

    // $messages = [
    //   "No_sts.required" => "Anda belum memilih Nomor STS.",
    //   "No_byr.required" => "Anda belum memilih Nomor Bayar.",
    // ];
    // $validator = Validator::make($request->all(), $rules, $messages);

    // if($validator->fails()){
    //   return redirect()->back()->withErrors($validator)->withInput($request->all);
    // }
    
    // $data = DB::select(DB::raw('SELECT c.Ko_Period,"'.kd_unit().'" Ko_unitstr, "'.$request->No_spi.'" No_spi,c.No_bp,c.Ko_bprc,c.Ur_bprc,c.rftr_bprc,c.dt_rftrbprc,c.No_PD,c.Ko_sKeg1,c.Ko_sKeg2,c.Ko_Rkk,c.Ko_Pdp,c.ko_pmed,b.real_rp spirc_Rp,"'.getUser('username').'" tb_ulog,"'.now().'" created_at,"'.now().'" updated_at
    // FROM tb_stsrc a
    // INNER JOIN tb_byr b ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.No_byr = b.No_byr
    // INNER JOIN tb_bprc c ON b.id_bprc = c.id_bprc
    // WHERE a.No_sts = "'.$request->No_sts.'" && a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'"'));

    $idrc = explode(',',$request->id_rc);

    $rincian = DB::select('SELECT a.id_byr, b.Ko_Period,"'.kd_unit().'" Ko_unitstr, "'.$request->No_spi.'" No_spi,b.No_bp,b.Ko_bprc,b.Ur_bprc,b.rftr_bprc,b.dt_rftrbprc,b.No_PD,b.Ko_sKeg1,b.Ko_sKeg2,b.Ko_Rkk,b.Ko_Pdp,b.ko_pmed,a.real_rp spirc_Rp,"'.getUser('username').'" tb_ulog,"'.now().'" created_at,"'.now().'" updated_at
    FROM tb_byr a
    INNER JOIN tb_bprc b ON a.id_bprc = b.id_bprc
    WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'"');
    $data = collect($rincian)->whereIn('id_byr',$idrc);
   
    $max = Tb_spirc::where(['Ko_Period' => Tahun(),'Ko_unitstr' => kd_unit(),'No_spi' => $request->No_spi])->max('Ko_spirc');
    
    if($max == null){ $max = 1; } else {$max = $max+1;}

    foreach($data as $key => $item){
      Tb_spirc::create([
        'Ko_Period'   => $item->Ko_Period,
        'Ko_unitstr'  => $item->Ko_unitstr,
        'id_spi'      => $request->id_spi,
        'No_spi'      => $item->No_spi,
        'Ko_spirc'    => $max++,
        'No_bp'       => $item->No_bp,
        'Ko_bprc'     => $item->Ko_bprc,
        'Ur_bprc'     => $item->Ur_bprc,
        'rftr_bprc'   => $item->rftr_bprc,
        'dt_rftrbprc' => $item->dt_rftrbprc,
        'No_PD'       => $item->No_PD,
        'Ko_sKeg1'    => $item->Ko_sKeg1,
        'Ko_sKeg2'    => $item->Ko_sKeg2,
        'Ko_Rkk'      => $item->Ko_Rkk,
        'Ko_Pdp'      => $item->Ko_Pdp,
        'ko_pmed'     => $item->ko_pmed,
        'spirc_Rp'    => $item->spirc_Rp,
        'tb_ulog'     => $item->tb_ulog,
        'created_at'  => $item->created_at,
        'updated_at'  => $item->updated_at,
      ]);
    }

    Alert::success('Berhasil', "Rincian SPJ Pendapatan berhasil ditambah");
    return redirect()->route('spjpendapatan.index');
    // return redirect()->route('spjpendapatan.viewtambahrincian', $request->id_spi);

    // return redirect()->route("spjpendapatan.index")->with('sukses','Data rincian spj pendapatan berhasil di tambah, silahkan cek pada menu list rincian');
  }

  public function tambahrinciansts(Request $request)
  {
    $idrc = explode(',',$request->id_rc);
    // $data = DB::select("SELECT a.id_byr, b.Ko_Period,'".kd_unit()."' Ko_unitstr, '".$request->No_spi."' No_spi,b.No_bp,b.Ko_bprc,b.Ur_bprc,b.rftr_bprc,
    // b.dt_rftrbprc,b.No_PD,b.Ko_sKeg1,b.Ko_sKeg2,b.Ko_Rkk,b.Ko_Pdp,b.ko_pmed,a.real_rp spirc_Rp,'".getUser('username')."' tb_ulog,'".now()."' created_at,'".now()."' updated_at
    // FROM tb_byr a
    // INNER JOIN tb_bprc b ON a.id_bprc = b.id_bprc
    // WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' 
    // && a.id_byr IN (SELECT a.id_byr FROM tb_byr a
    // LEFT JOIN tb_stsrc b ON a.No_Byr = b.No_byr && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
    // LEFT JOIN tb_bprc c ON a.id_bprc = c.id_bprc
    // LEFT JOIN tb_spirc d ON a.No_bp = d.No_bp && a.Ko_unitstr = d.Ko_unitstr -- && a.real_rp = d.spirc_Rp
    // WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && d.id IS NULL && b.id_sts IN ('" . implode( "', '", $idrc ) . "')
    // GROUP BY a.id_byr
    // ORDER BY a.dt_byr DESC)");

    $data = DB::select("SELECT a.id_byr, b.Ko_Period,'".kd_unit()."' Ko_unitstr, '".$request->No_spi."' No_spi,b.No_bp,b.Ko_bprc,b.Ur_bprc,b.rftr_bprc,
    b.dt_rftrbprc,b.No_PD,b.Ko_sKeg1,b.Ko_sKeg2,b.Ko_Rkk,b.Ko_Pdp,b.ko_pmed,a.real_rp spirc_Rp,'".getUser('username')."' tb_ulog,'".now()."' created_at,'".now()."' updated_at
    FROM tb_byr a
    INNER JOIN tb_bprc b ON a.id_bprc = b.id_bprc
    WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' 
    && a.id_byr IN (SELECT a.id_byr FROM tb_byr a
    LEFT JOIN tb_stsrc b ON a.No_Byr = b.No_byr && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
    LEFT JOIN tb_bprc c ON a.id_bprc = c.id_bprc
    WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && b.id_sts IN ('" . implode( "', '", $idrc ) . "')
    GROUP BY a.id_byr
    ORDER BY a.dt_byr DESC)");
    
    $max = Tb_spirc::where(['Ko_Period' => Tahun(),'Ko_unitstr' => kd_unit(),'No_spi' => $request->No_spi])->max('Ko_spirc');
    
    if($max == null){ $max = 1; } else {$max = $max+1;}

    foreach($data as $key => $item){
      Tb_spirc::create([
        'Ko_Period'   => $item->Ko_Period,
        'Ko_unitstr'  => $item->Ko_unitstr,
        'id_spi'      => $request->id_spi,
        'No_spi'      => $item->No_spi,
        'Ko_spirc'    => $max++,
        'No_bp'       => $item->No_bp,
        'Ko_bprc'     => $item->Ko_bprc,
        'Ur_bprc'     => $item->Ur_bprc,
        'rftr_bprc'   => $item->rftr_bprc,
        'dt_rftrbprc' => $item->dt_rftrbprc,
        'No_PD'       => $item->No_PD,
        'Ko_sKeg1'    => $item->Ko_sKeg1,
        'Ko_sKeg2'    => $item->Ko_sKeg2,
        'Ko_Rkk'      => $item->Ko_Rkk,
        'Ko_Pdp'      => $item->Ko_Pdp,
        'ko_pmed'     => $item->ko_pmed,
        'spirc_Rp'    => $item->spirc_Rp,
        'tb_ulog'     => $item->tb_ulog,
        'created_at'  => $item->created_at,
        'updated_at'  => $item->updated_at,
      ]);
    }

    Alert::success('Berhasil', "Rincian SPJ Pendapatan berhasil ditambah");
    return redirect()->route('spjpendapatan.index');
  }

  public function hapusrincianspjpendapatan($id)
  {
    $Tag = 0;

    $satu = DB::select(DB::raw('select a.*, b.*
      from tb_spi a
      inner join tb_spirc b 
      on a.No_SPi = b.No_spi
      where a.Tag = '.$Tag.' and b.id = '.$id));

    if(
      empty($satu)
    ){
      return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
    }else{
      $spjpendapatan = Tb_spirc::find($id);
      $spjpendapatan->delete();
      return back();
    }

        //dd($satu);   
  }

  public function destroy($id)
  {
    $Tag = 0;

    if(
      $spjpendapatan = DB::select(DB::raw('select a.* 
        from tb_spi a
        where a.Tag = '.$Tag.' and a.id = '.$id))
    ){
      $spjpendapatan = Tb_spi::find($id);
      $spjpendapatanrc = Tb_spirc::where('No_spi',$spjpendapatan)->delete();
      $spjpendapatan->delete();

      return redirect()->route("spjpendapatan.index");
    }else{
            //Alert::success('Yeay!', 'berhasil dihapus');
      return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
    }
  }

  public function verifikasi(Request $request, $id)
  {
      Tb_spi::where('id',$id)->update([
          'Tag_v' => $request->Tag_v,
      ]);

      Alert::success('Berhasil', 'Data berhasil diajukan verifikasi');
      return redirect()->route('spjpendapatan.index');
  }

}
