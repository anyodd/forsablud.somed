<?php

namespace App\Http\Controllers\Setting\Kegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tb_keg; 
use App\Models\Pfskeg;
use App\Models\Tb_keg1;
use App\Models\Tbsub1;

class SetKegiatanController extends Controller
{
  public function index() 
  {
    if (getUser('user_level') == 1) {
      $ko_unit1 = kd_unit(); //admin bisa lihat semua data
    } else {
      $ko_unit1 = kd_bidang(); //non admin hanya bisa lihat data di bidangnya saja
    }
    
    $data = DB::select(DB::raw("SELECT a.*, c.ur_subunit1 FROM tb_keg a 
            LEFT JOIN (
            SELECT Ko_sKeg1, ko_unit1, SUBSTRING(ko_unit1,7,2) AS Ko_Urus, SUBSTRING(ko_unit1,10,2) AS Ko_bid,
            CASE WHEN SUBSTRING(ko_unit1,4,2)=0 THEN 1 ELSE 2 END jnspemda
            FROM tb_kegs1 
            WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".kd_bidang()."' 
            GROUP BY Ko_sKeg1, ko_unit1
            ) AS b 
            ON a.ko_unit1 = b.ko_unit1 AND a.Ko_sKeg1 = b.Ko_sKeg1
            LEFT JOIN tb_sub1 c ON b.ko_unit1 = c.ko_unit1 
            WHERE a.Ko_Period = ".Tahun()." AND a.ko_unit1 like '".$ko_unit1."%'
            ORDER BY a.ko_unit1, a.Ko_sKeg1"));
    $keg = collect($data);

    $skeg = DB::select(DB::raw("SELECT a.* FROM (
            SELECT a.*, e.jns_pemda FROM pf_skeg a 
            INNER JOIN pf_keg b ON a.id_keg=b.id_keg
            INNER JOIN pf_prg c ON b.id_prog=c.id_prog
            INNER JOIN pf_bid d ON c.id_bidang=d.id_bidang
            INNER JOIN pf_urus e ON d.id_urus=e.id_urus
            WHERE a.id_keg <> 0 AND a.Ko_Prg=1 
            AND e.jns_pemda=CASE WHEN SUBSTRING('".kd_bidang()."',4,2)=0 THEN 1 ELSE 2 END
            ) a
            LEFT JOIN (
            SELECT Ko_sKeg1, ko_unit1, SUBSTRING(ko_unit1,7,2) AS Ko_Urus, SUBSTRING(ko_unit1,10,2) AS Ko_bid,
            CASE WHEN SUBSTRING(ko_unit1,4,2)=0 THEN 1 ELSE 2 END jns_pemda
            FROM tb_keg
            WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".kd_bidang()."' 
            GROUP BY Ko_sKeg1, ko_unit1
            ) AS b ON a.Ko_sKeg1=b.Ko_sKeg1 AND a.Ko_Urus=0 AND a.Ko_bid=0  AND a.jns_pemda=b.jns_pemda
            WHERE a.id_keg <> 0 AND a.Ko_Prg=1 AND ISNULL(b.Ko_sKeg1) 
            UNION ALL
            SELECT a.* FROM (
            SELECT a.*, e.jns_pemda FROM pf_skeg a 
            INNER JOIN pf_keg b ON a.id_keg=b.id_keg
            INNER JOIN pf_prg c ON b.id_prog=c.id_prog
            INNER JOIN pf_bid d ON c.id_bidang=d.id_bidang
            INNER JOIN pf_urus e ON d.id_urus=e.id_urus
            WHERE a.id_keg <> 0 AND a.Ko_Prg<>1 
            AND e.Ko_Urus=SUBSTRING('".kd_bidang()."',7,2) 
            AND d.Ko_bid=SUBSTRING('".kd_bidang()."',10,2)
            AND e.jns_pemda=CASE WHEN SUBSTRING('".kd_bidang()."',4,2)=0 THEN 1 ELSE 2 END
            ) a
            LEFT JOIN (
            SELECT Ko_sKeg1, ko_unit1, SUBSTRING(ko_unit1,7,2) AS Ko_Urus, SUBSTRING(ko_unit1,10,2) AS Ko_bid,
            CASE WHEN SUBSTRING(ko_unit1,4,2)=0 THEN 1 ELSE 2 END jns_pemda
            FROM tb_keg
            WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".kd_bidang()."' 
            GROUP BY Ko_sKeg1, ko_unit1
            ) AS b ON a.Ko_sKeg1=b.Ko_sKeg1 AND a.Ko_Urus=b.Ko_Urus AND a.Ko_bid=b.Ko_bid  AND a.jns_pemda=b.jns_pemda
            WHERE a.id_keg <> 0 AND a.Ko_Prg<>1 AND ISNULL(b.Ko_sKeg1)"));

    return view('setting.kegiatan.keg.index', compact('keg', 'skeg'));
  }

  public function create()
  {
    $skeg = DB::select(DB::raw("SELECT a.* FROM (
          SELECT a.*, e.jns_pemda FROM pf_skeg a 
          INNER JOIN pf_keg b ON a.id_keg=b.id_keg
          INNER JOIN pf_prg c ON b.id_prog=c.id_prog
          INNER JOIN pf_bid d ON c.id_bidang=d.id_bidang
          INNER JOIN pf_urus e ON d.id_urus=e.id_urus
          WHERE a.id_keg <> 0 AND a.Ko_Prg=1 
          AND e.jns_pemda=CASE WHEN SUBSTRING('".kd_bidang()."',4,2)=0 THEN 1 ELSE 2 END
          ) a
          LEFT JOIN (
          SELECT Ko_sKeg1, ko_unit1, SUBSTRING(ko_unit1,7,2) AS Ko_Urus, SUBSTRING(ko_unit1,10,2) AS Ko_bid,
          CASE WHEN SUBSTRING(ko_unit1,4,2)=0 THEN 1 ELSE 2 END jns_pemda
          FROM tb_keg
          WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".kd_bidang()."' 
          GROUP BY Ko_sKeg1, ko_unit1
          ) AS b ON a.Ko_sKeg1=b.Ko_sKeg1 AND a.Ko_Urus=0 AND a.Ko_bid=0  AND a.jns_pemda=b.jns_pemda
          WHERE a.id_keg <> 0 AND a.Ko_Prg=1 AND ISNULL(b.Ko_sKeg1) 
          UNION ALL
          SELECT a.* FROM (
          SELECT a.*, e.jns_pemda FROM pf_skeg a 
          INNER JOIN pf_keg b ON a.id_keg=b.id_keg
          INNER JOIN pf_prg c ON b.id_prog=c.id_prog
          INNER JOIN pf_bid d ON c.id_bidang=d.id_bidang
          INNER JOIN pf_urus e ON d.id_urus=e.id_urus
          WHERE a.id_keg <> 0 AND a.Ko_Prg<>1 
          AND e.Ko_Urus=SUBSTRING('".kd_bidang()."',7,2) 
          AND d.Ko_bid=SUBSTRING('".kd_bidang()."',10,2)
          AND e.jns_pemda=CASE WHEN SUBSTRING('".kd_bidang()."',4,2)=0 THEN 1 ELSE 2 END
          ) a
          LEFT JOIN (
          SELECT Ko_sKeg1, ko_unit1, SUBSTRING(ko_unit1,7,2) AS Ko_Urus, SUBSTRING(ko_unit1,10,2) AS Ko_bid,
          CASE WHEN SUBSTRING(ko_unit1,4,2)=0 THEN 1 ELSE 2 END jns_pemda
          FROM tb_keg
          WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".kd_bidang()."' 
          GROUP BY Ko_sKeg1, ko_unit1
          ) AS b ON a.Ko_sKeg1=b.Ko_sKeg1 AND a.Ko_Urus=b.Ko_Urus AND a.Ko_bid=b.Ko_bid  AND a.jns_pemda=b.jns_pemda
          WHERE a.id_keg <> 0 AND a.Ko_Prg<>1 AND ISNULL(b.Ko_sKeg1)"));

    $bidang = Tbsub1::where('Ko_Period', Tahun())->where('ko_unit1', 'like', kd_unit()."%")->get();

    return view('setting.kegiatan.keg.create', compact('skeg', 'bidang'));
  }

  public function store(Request $request)
  {

    $result = explode(',', $request->Ko_sKeg1);

    $Ko_Period = Tahun();
    $ko_unit1 = $request->ko_unit1;
    $Ko_sKeg1 = $result[0];
    $ko_dana = $request->ko_dana;

    $rules = [
      "ko_unit1" => "required",
      "Ko_sKeg1" => "required",
      "ko_dana" => [
        'required',
        Rule::unique('tb_keg')->where(function ($query) use($Ko_Period, $ko_unit1, $Ko_sKeg1, $ko_dana) {
              // return $query->where([ 'Ko_Period'=>$Ko_Period, 'ko_unit1'=>$ko_unit1, 'Ko_sKeg1'=>$Ko_sKeg1, 'ko_dana'=>$ko_dana ]);
          return $query->where('Ko_Period', $Ko_Period)
          ->where('ko_unit1', $ko_unit1)
          ->where('Ko_sKeg1', $Ko_sKeg1)
          ->where('ko_dana', $ko_dana);
        }),
      ],
    ];

    $messages = [
      "ko_unit1.required" => "Bidang wajib dipilih.",
      "ko_dana.unique" => "Kode Kegiatan sudah pernah diisi.",
      "Ko_sKeg1.required" => "Kegiatan wajib dipilih.",
      "ko_dana.required" => "Sumber dana wajib dipilih.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Tb_keg::create([
      'Ko_Period' => Tahun(),
      'ko_unit1' => $request->ko_unit1,
      'id_sub_keg' => $result[2],
      'Ko_sKeg1' => $result[0],
      'Ur_sKeg' => $result[1],
      'tb_ulog' => getUser('username'),
      'ko_dana' => $request->ko_dana,
    ]);

    Alert::success('BERHASIL !!!', 'Data Kegiatan Nomor ' . $result[0] . ' - ' . $result[1] . ' berhasil dibuat !!!');

    return redirect()->route('setkegiatan.index');
  }

  public function show($id)
  {
    $kegiatan = Tb_keg::find($id);

    $keg = Tb_keg1::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>kd_bidang(), 'Ko_sKeg1'=>$id ])->orderBy('Ko_KegBL1')->get();

    $col1 = "Kode Program BLUD";
    $col2 = "Uraian Program BLUD";

    return view('setting.kegiatan.index', compact('keg', 'col1', 'col2'));
  }

  public function edit($id)
  {
    $data = Tb_keg::where('id',$id)->first();
    $skeg = Pfskeg::where('Ko_sKeg1',$data->Ko_sKeg1)->get();
    // dd($skeg);
    $bidang = Tbsub1::where('Ko_Period', Tahun())->where('ko_unit1', 'like', kd_unit()."%")->get();
    return view('setting.kegiatan.keg.edit',compact('skeg','bidang','data'));
  }

  public function update(Request $request, $id)
  {
    Tb_keg::where('id',$id)->update([
      'ko_unit1' => $request->ko_unit1,
      'ko_dana' => $request->ko_dana,
    ]);

    Alert::success('BERHASIL !!!', 'Data Kegiatan Nomor ' . $request->Ko_sKeg1 . ' berhasil diupdate !!!');

    return redirect()->route('setkegiatan.index');
  }

  public function destroy($id)
  {
    $keg = Tb_keg::find($id);
    $keg->delete();

    return redirect()->route("setkegiatan.index");
  }
}
