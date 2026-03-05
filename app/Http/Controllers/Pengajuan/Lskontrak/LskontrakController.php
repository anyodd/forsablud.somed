<?php

namespace App\Http\Controllers\Pengajuan\Lskontrak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use App\Models\Pfbank;
use App\Models\Tblogv;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class LskontrakController extends Controller
{
  public function index()
  {
      $lskontrak = Tb_spi::select('tb_spi.*',DB::raw('SUM(tb_spirc.spirc_Rp) As jml'))
      ->leftJoin('tb_spirc', function ($join) {
          $join->on('tb_spi.Ko_Period', '=', 'tb_spirc.Ko_Period');
          $join->on('tb_spi.Ko_unitstr', '=', 'tb_spirc.Ko_unitstr');
          $join->on('tb_spi.No_SPi', '=', 'tb_spirc.No_spi');
      })
      ->where(['tb_spi.Ko_Period' => Tahun(), 'tb_spi.Ko_unitstr' => kd_unit(), 'tb_spi.Ko_SPi' => 3])
      ->groupBy('tb_spi.id')
      ->orderBy('tb_spi.Dt_SPi','DESC')
      ->get();
      return view('pengajuan.lskontrak.index', compact('lskontrak'));
  }

  public function create()
  {
      $lskontrak = Tb_spi::all();
      $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
      $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
      $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                  LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                  WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

      return view('pengajuan.lskontrak.create', compact('lskontrak','ko_bank','bank_rekan','pegawai'));
  }

  public function store(Request $request)
  {
      $bank_rekan = explode('||',$request->rekan_bank);
      $Ko_SPi = '3';
      $Tag = '0';
  
      $rules = [
          "No_SPi"  => "required|unique:tb_spi",
          "Dt_SPi"  => "required",
          "Ur_SPi"  => "required",
          "Nm_PP"   => "required",
          "NIP_PP"  => "required",
          "Nm_Ben"  => "required",
          "NIP_Ben" => "required",
          "Nm_Keu"  => "required",
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
          "No_SPi.unique"    => "Nomor Pengajuan yang dimasukan telah ada",
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $PP  = explode("|",$request->Nm_PP);
        $Ben = explode("|",$request->Nm_Ben);
        $Keu = explode("|",$request->Nm_Keu);

      Tb_spi::create([          
          'Ko_Period'  => Tahun(),
          'Ko_unitstr' => kd_unit(),
          'Ko_SPi'     => $Ko_SPi,
          'No_SPi'     => $request->No_SPi,
          'Dt_SPi'     => $request->Dt_SPi,
          'Ur_SPi'     => $request->Ur_SPi,
          'Ko_Bank'    => $request->Ko_Bank,
          'Nm_PP'      => $PP[0],
          'NIP_PP'     => $PP[1],
          'Nm_Ben'     => $Ben[0],
          'NIP_Ben'    => $Ben[1],
          'Nm_Keu'     => $Keu[0],
          'NIP_Keu'    => $Keu[1],
          'trm_bank'   => $bank_rekan[1],
          'trm_rek'    => $bank_rekan[0],
          'tb_ulog'    => getUser('username'),
          'Tag'        => $Tag,
      ]);

      Alert::success('Berhasil', "Data berhasil ditambah");
      return redirect()->route("lskontrak.index");
  }

  public function show($id)
  {
      $log = DB::select("SELECT * FROM tb_logv WHERE id_spi = '".$id."'");
      return view('pengajuan.lskontrak.popup.itemlog',compact('log'));
  }

  public Function lskontrakedit($id)
  {
    $spi = Tb_spi::where(['id' => $id, 'Tag' => '0'])->first();
    if ($spi != NULL) {
      $data       = Tb_spi::find($id);
      $ko_bank    = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
      $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
      $pegawai    = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a LEFT JOIN pf_pj b ON a.id_pj = b.id_pj WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
    } else {
      Alert::warning('', 'Data telah diverifikasi, tidak dapat dilakukan perubahan data');
      return back();
    }
    return view('pengajuan.lskontrak.edit', compact('data','ko_bank','bank_rekan','pegawai'));
  }

  public function lskontrakupdate(Request $request, $id)
  {
    $bank_rekan = explode('||',$request->rekan_bank);
    $rules = [
        "No_SPi" => "required|unique:tb_spi",
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
        "No_SPi.unique"    => "Nomor Pengajuan yang dimasukan telah ada",
      ];
  
      $validator = Validator::make($request->all(), $rules, $messages);
  
      if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput($request->all);
      }

      $PP  = explode("|",$request->Nm_PP);
      $Ben = explode("|",$request->Nm_Ben);
      $Keu = explode("|",$request->Nm_Keu);
    Tb_spi::where('id', $id)->update([          
        'No_SPi'   => $request->No_SPi,
        'Dt_SPi'   => $request->Dt_SPi,
        'Ur_SPi'   => $request->Ur_SPi,
        'Ko_Bank'  => $request->Ko_Bank,
        'Nm_PP'    => $PP[0],
        'NIP_PP'   => $PP[1],
        'Nm_Ben'   => $Ben[0],
        'NIP_Ben'  => $Ben[1],
        'Nm_Keu'   => $Keu[0],
        'NIP_Keu'  => $Keu[1],
        'trm_bank' => $bank_rekan[1],
        'trm_rek'  => $bank_rekan[0],
    ]);

    Alert::success('Berhasil', "Data berhasil dirubah");
    return redirect()->route("lskontrak.index");
  }
  
  public function rincian($id)
  {
    $data = DB::select("SELECT a.*, b.Tag FROM tb_spirc a LEFT JOIN tb_spi b ON a.id_spi = b.id WHERE a.id_spi = '".$id."'");
    return DataTables::of($data)
    ->addIndexColumn()
    ->addColumn('check', function($row){
      if ($row->Tag == '0') {
        $params = '<input class="checklist" type="checkbox" value="'.$row->id.'">';
      } else {
        $params = '<input class="checklist" type="checkbox" disabled>';
      }
      return $params;
    })
    ->addColumn('tanggal', function($row){
      $params = date('d M Y', strtotime($row->dt_rftrbprc));
      return $params;
    })
    ->addColumn('action', function($row){
      if ($row->Tag == '0') {
        $params = '<a class="btn btn-sm btn-danger delete" data-id = "'.$row->id.'" data-no_bp = "'.$row->No_bp.'"><i class="far fa-trash-alt"></i></a>';
      } else {
        $params = '<a class="btn btn-sm btn-danger disabled"><i class="far fa-trash-alt"></i></a>';
      }
      return $params;
    })
    ->rawColumns(['check','tanggal','action'])
    ->make(true);
  }

  public function tambahrincian(Request $request)
  {
    $data = DB::select("SELECT A.ko_period, LEFT(A.ko_unit1, 18) AS ko_unit1, B.id_bp, B.id_bprc, A.ko_bp, A.no_bp, A.dt_bp, A.dt_jt, 
    A.nm_bucontr, B.ko_bprc, B.ur_bprc, B.rftr_bprc, B.dt_rftrbprc, B.ko_skeg1, B.ko_skeg2, B.ko_rkk, B.ko_pdp, B.ko_pmed, B.to_rp FROM tb_bp A 
    INNER JOIN tb_bprc B ON A.id_bp = B.id_bp 
    LEFT OUTER JOIN tb_byr C ON B.id_bprc = C.id_bprc 
    LEFT OUTER JOIN tb_spirc D ON B.id_bprc  = D.id_bprc				
    WHERE A.ko_bp = 3 AND C.ko_period IS NULL AND D.ko_period IS NULL AND A.Ko_Period = '".Tahun()."' AND LEFT(A.ko_unit1, 18) LIKE  '".kd_unit()."'
    GROUP BY A.ko_period, A.ko_unit1, A.ko_bp, A.no_bp, A.dt_bp, A.dt_jt, A.nm_bucontr, 
    B.ko_bprc, B.ur_bprc, B.rftr_bprc, B.dt_rftrbprc, B.ko_skeg1, B.ko_skeg2, B.ko_rkk, B.ko_pdp, B.ko_pmed, B.to_rp
    ORDER BY A.dt_bp ASC, A.no_bp ASC");

    $data = collect($data)->whereIn('id_bprc', $request->data);
    foreach ($data as $key => $item) {
      $kode = Tb_spirc::where('id_spi',$request->id_spi)->max('Ko_spirc') + 1;
      Tb_spirc::create([          
        'Ko_Period'  => Tahun(),
        'Ko_unitstr' => kd_bidang(),
        'id_spi'     => $request->id_spi,
        'No_spi'     => $request->no_spi,
        'Ko_spirc'   => $kode,     
        'id_bprc'    => $item->id_bprc,
        'No_bp'      => $item->no_bp,
        'Ko_bprc'    => $item->ko_bprc,
        'Ko_Rkk'     => $item->ko_rkk,
        'Ko_Pdp'     => $item->ko_pdp,
        'ko_pmed'    => $item->ko_pmed,
        'rftr_bprc'  => $item->rftr_bprc,
        'dt_rftrbprc'=> $item->dt_rftrbprc,
        'Ko_sKeg1'   => $item->ko_skeg1,
        'Ko_sKeg2'   => $item->ko_skeg2,
        'Ur_bprc'    => $item->ur_bprc,
        'spirc_Rp'   => $item->to_rp,
        'tb_ulog'    => getUser('username')
      ]);
    }
    return response()->json(['Berhasil' => 'Rincian berhasil ditambah']);
  }

  public function list_tagihan($id)
  {
    $data = DB::select("SELECT A.ko_period, LEFT(A.ko_unit1, 18) AS ko_unit1, B.id_bp, B.id_bprc, A.ko_bp, A.no_bp, A.dt_bp, A.dt_jt, 
    A.nm_bucontr, B.ko_bprc, B.ur_bprc, B.rftr_bprc, B.dt_rftrbprc, B.ko_skeg1, B.ko_skeg2, B.ko_rkk, B.ko_pdp, B.ko_pmed, B.to_rp FROM tb_bp A 
    INNER JOIN tb_bprc B ON A.id_bp = B.id_bp 
    LEFT OUTER JOIN tb_byr C ON B.id_bprc = C.id_bprc 
    LEFT OUTER JOIN tb_spirc D ON B.id_bprc  = D.id_bprc				
    WHERE A.ko_bp = 3 AND C.ko_period IS NULL AND D.ko_period IS NULL AND A.Ko_Period = '".$id."' AND LEFT(A.ko_unit1, 18) LIKE  '".kd_unit()."'
    GROUP BY A.ko_period, A.ko_unit1, A.ko_bp, A.no_bp, A.dt_bp, A.dt_jt, A.nm_bucontr, 
    B.ko_bprc, B.ur_bprc, B.rftr_bprc, B.dt_rftrbprc, B.ko_skeg1, B.ko_skeg2, B.ko_rkk, B.ko_pdp, B.ko_pmed, B.to_rp
    ORDER BY A.dt_bp ASC, A.no_bp ASC");
    return DataTables::of($data)
    ->addIndexColumn()
    ->addColumn('tgl_bp', function($row){
      $params = date('d M Y', strtotime($row->dt_bp));
      return $params;
    })
    ->addColumn('tgl_jt', function($row){
      $params = date('d M Y', strtotime($row->dt_jt));
      return $params;
    })
    ->addColumn('rekanan', function($row){
      $params = nm_rekan($row->nm_bucontr);
      return $params;
    })
    ->addColumn('check', function($row){
      $params = '<input class="ceklist" type="checkbox" value="'.$row->id_bprc.'">';
      return $params;
    })
    ->rawColumns(['dt_bp','dt_jt','rekanan','check'])
    ->make(true);
  }

  public function viewtambahrincian($id)
  {
    $spi   = Tb_spi::where(['id' => $id])->first();
    return view('pengajuan.lskontrak.viewtambahrincian',compact('spi'));
  }
  
  public function hapusrinciankontrak($id)
  {
    $data = Tb_spirc::find($id);
    $data->delete();

    return response()->json(['success' => 'Data berhasil dihapus']);
  }

  public function hapusrincian(Request $request)
  {
    $data = Tb_spirc::whereIn('id', $request->data)->delete();

    return response()->json(['success' => 'Data berhasil dihapus']);
  }

  public function destroy($id)
  {
    $spi = Tb_spi::where(['id' => $id, 'Tag' => '0'])->first();
    if ($spi != NULL) {
      $lskontrak = Tb_spi::find($id);
      $lskontrakrc = Tb_spirc::where('No_spi',$lskontrak)->delete();
      $lskontrak->delete();

      Alert::success('Berhasil', 'Data berhasil dihapus');
      return redirect()->route("lskontrak.index");
    }else{
      Alert::warning('', 'Data telah diverifikasi, tidak dapat dilakukan perubahan data');
      return back();
    }
  }

  public function verifikasi(Request $request, $id)
  {
      Tb_spi::where('id',$id)->update([
          'Tag_v' => $request->Tag_v,
      ]);

      Alert::success('Berhasil', 'Data berhasil diajukan verifikasi');
      return redirect()->route('lskontrak.index');
  }

  public function history($id)
  {
      $data = Tblogv::where('id_logv',$id)->get();
      return json_encode([
          'response'=> $data
      ]);
  }

  // public function viewtambahrincian($id)
  // {
  //     $Tag =0;

  //     if(
  //         $lskontrak = DB::select(DB::raw('select a.* 
  //         from tb_spi a
  //         where a.Tag = '.$Tag.' and a.id = '.$id))
  //     ){              
  //         $Ko_Period = Tahun();
  //         $Ko_unitstr = kd_unit();
      
  //         $data = DB::select('call vdata_lskon('.$Ko_Period.', "'.$Ko_unitstr.'")');
  //         $buktilskontrak = collect($data);
                  
  //         $lskontrak = Tb_spi::find($id);

  //         $lskontrak1 = DB::select(DB::raw('SELECT a.*, b.* 
  //         FROM tb_spi a
  //         JOIN tb_spirc b 
  //         ON a.No_SPi = b.No_spi 
  //         WHERE a.id = '.$id));

  //         $lskontrak2 = array_column($lskontrak1, 'Ko_spirc');

  //         if(empty($lskontrak2)){
  //             $lskontrak2 = 0;
  //             $lskontrak3 = $lskontrak2;
  //         }else{
  //             $lskontrak2 = $lskontrak2;
  //             $lskontrak3 = max($lskontrak2);
  //             $norincian = $lskontrak3 + 1;  
  //         }
  //         $norincian = $lskontrak3 + 1;          
  //         //dd($lskontrakbukti);

  //         return view('pengajuan.lskontrak.viewtambahrincian', compact('lskontrak','buktilskontrak','norincian'));
  //     }else{
  //         return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
  //     }
  // }

  // public function rincian($id)
  // {
  //     $lskontrak1 = Tb_spi::find($id);
  //     $lskontrak = DB::select(DB::raw('SELECT a.*, b.*, c.* 
  //         FROM tb_spi a
  //             INNER JOIN tb_spirc b 
  //             ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
  //             INNER JOIN tb_bp c
  //             ON b.No_bp = c.No_bp  && b.Ko_Period = c.Ko_Period && b.Ko_unitstr = LEFT(c.Ko_unit1,18)
  //             where a.id = '.$id));
  //     // dd($lskontrak);
  //     return view('pengajuan.lskontrak.rincian', compact('lskontrak','lskontrak1'));
  // }

  // public function tambahrincian(Request $request)
  // {
  //     $Ko_Period = Tahun();
  //     $Ko_unitstr = kd_unit();
  //     $tb_ulog = 'user';

  //     $rules = [
  //         "No_bp" => "required",
  //         "Ko_bprc" => "required",
  //         "Ko_sKeg1" => "required",
  //         "Ko_sKeg2" => "required",
  //         "Ko_Rkk" => "required",
  //         "Ko_Pdp" => "required",
  //         "ko_pmed" => "required",
  //         "rftr_bprc" => "required",
  //         "dt_rftrbprc" => "required",
  //         "Ur_bprc" => "required",
  //         "spirc_Rp" => "required",
  //       ];
    
  //       $messages = [
  //         "No_bp.required" => "Bukti wajib diisi.",
  //         "Ko_bprc.required" => "Bukti wajib diisi.",
  //         "Ko_sKeg1.required" => "Kegiatan wajib diisi.",
  //         "Ko_sKeg2.required" => "Kegiatan wajib diisi.",
  //         "Ko_Rkk.required" => "Kode Akun wajib diisi.",
  //         "Ko_Pdp.required" => "Jenis Sumber wajib diisi.",
  //         "ko_pmed.required" => "Sumber wajib diisi.",
  //         "rftr_bprc.required" => "No. Ref Bukti wajib diisi.",
  //         "dt_rftrbprc.required" => "Tgl. Ref Bukti wajib diisi.",
  //         "Ur_bprc.required" => "Uraian Bukti wajib diisi.",
  //         "spirc_Rp.required" => "Nilai (Rp) wajib diisi.",
  //       ];
  //       $validator = Validator::make($request->all(), $rules, $messages);
    
  //       if($validator->fails()){
  //         return redirect()->back()->withErrors($validator)->withInput($request->all);
  //       }

  //     Tb_spirc::create([          
  //         'Ko_Period' => $Ko_Period,
  //         'Ko_unitstr' => $Ko_unitstr,
  //         'No_spi' => $request->No_spi,   
  //         'Ko_spirc' => $request->Ko_spirc,     
  //         'No_bp' => $request->No_bp,
  //         'Ko_bprc' => $request->Ko_bprc,
  //         'Ko_Rkk' => $request->Ko_Rkk,
  //         'Ko_Pdp' => $request->Ko_Pdp,
  //         'ko_pmed' => $request->ko_pmed,
  //         'rftr_bprc' => $request->rftr_bprc,
  //         'dt_rftrbprc' => $request->dt_rftrbprc,
  //         'Ko_sKeg1' => $request->Ko_sKeg1,
  //         'Ko_sKeg2' => $request->Ko_sKeg2,
  //         'Ur_bprc' => $request->Ur_bprc,
  //         'spirc_Rp' => $request->spirc_Rp,
  //         'tb_ulog' => $tb_ulog,
  //     ]);
  //     return redirect()->route("lskontrak.index")->with('sukses','Data rincian ls kontrak berhasil di tambah, silahkan cek pada menu list rincian');
  // }

  // public function hapusrinciankontrak($id)
  // {
  //     $Tag = 0;

  //     $satu = DB::select(DB::raw('select a.*, b.*
  //     from tb_spi a
  //     inner join tb_spirc b 
  //     on a.No_SPi = b.No_spi
  //     where a.Tag = '.$Tag.' and b.id = '.$id));

  //     if(
  //         empty($satu)
  //     ){
  //         return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
  //     }else{
  //         $lskontrak = Tb_spirc::find($id);
  //         $lskontrak->delete();
  //         return back();
  //     }
      
  //     //dd($satu);  
  // }
  
  public function sppdls_pdf($id)
  {
      $spi = Tb_spi::find($id);

      $Ko_Wil1 = intval(substr(kd_unit(), 0, 2));
      $Ko_Wil2 = intval(substr(kd_unit(), 3, 2));
      $Ko_Urus = intval(substr(kd_unit(), 6, 2));
      $Ko_Bid = intval(substr(kd_unit(), 9, 2));
      $Ko_Unit = intval(substr(kd_unit(), 12, 2));
      $Ko_Sub = intval(substr(kd_unit(), 15, 3));

      $bank = Pfbank::where(['Ko_wil1' => $Ko_Wil1, 'Ko_Wil2' => $Ko_Wil2, 'Ko_Urus' => $Ko_Urus, 'Ko_Bid' => $Ko_Bid, 'Ko_Unit' => $Ko_Unit, 'Ko_Sub' => $Ko_Sub, 'Tag' => 1])->first();

      $qr_spp = DB::select("CALL SP_SPPD(" . Tahun() . ", '" . kd_unit() . "', '" . $spi->No_SPi . "')");
      $qr_spp1 = DB::select("CALL SP_SPPD1(" . Tahun() . ", '" . kd_unit() . "', '" . $spi->No_SPi . "')");
      $qr_spp2 = DB::select("CALL SP_SPPD2(" . Tahun() . ", '" . kd_unit() . "', '" . $spi->No_SPi . "')");
      $skas = collect($qr_spp1)->where('Anggaran',4)->sum('Total');

      $title = $spi->No_SPi;
      $pdf = PDF::loadView('pengajuan.lskontrak.sppd_ls_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','qr_spp2','skas','title'))->setPaper('A4', 'portrait');
      return $pdf->stream('S-PPD LS: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
      
  }
}
