<?php

namespace App\Http\Controllers\Transaksi\Belanja\termin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr; 
use App\Models\Tbtap;
use App\Models\Tbcontrc;
use App\Models\Tbtax;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use RealRashid\SweetAlert\Facades\Alert;


class SubTerminController extends Controller
{
    public function index()
    {
        $termin = Tbbprc::all();
        return view('transaksi.belanja.subtermin.index', compact('termin'));
    }

    public function rincian($id_bp)
    {
        // $kegiatan = Tbtap::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();
        $idbp     = $id_bp;

        $rincian = DB::select(DB::raw('select a.*, b.* 
            from tb_bp a
            join tb_bprc b 
            on a.No_bp = b.No_bp && a.Ko_unit1 = b.Ko_unit1
            where a.id_bp = "'.$id_bp.'" AND a.Ko_Period = "'.Tahun().'" AND a.Ko_unit1 = "'.kd_bidang().'"'));
        
        $rkk6 = DB::select(DB::raw("SELECT CONCAT(
            LPAD(Ko_Rk1,2,0),'.' ,
            LPAD(Ko_Rk2,2,0),'.' ,
            LPAD(Ko_Rk3,2,0),'.' ,
            LPAD(Ko_Rk4,2,0),'.' ,
            LPAD(Ko_Rk5,3,0),'.' ,
            LPAD(Ko_Rk6,4,0)
            ) AS RKK6, ur_rk6
            FROM pf_rk6
            WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1'"));

        return view('transaksi.belanja.subtermin.rincian', compact( 'rincian','sumber','sumber2','rkk6','idbp'));
    }

    public function create($id)
    {
        $data = Tbbp::find($id);
        $Ko_Unit = Session::get('ko_unit1');
        $Period = Session::get('Ko_Period');
        $penerimaan = Tbbprc::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();
        $tahun = 2020;
        $kounit1 = '14.02.01.02.01.001.001';
        $PD = 2;

        $sumberkegiatan2 = DB::select(DB::raw('select a.*, 
                                                b.ko_unit1, b.Ko_Period, b.Ko_sKeg1, b.Ur_Rk6, b.Ur_KegBL1, b.Ur_KegBL2, b.Ko_sKeg2, b.Ko_Rkk, SUM(a.To_Rp) AS Total 
                                                , c.id_contr, c.No_contr, c.dt_contr
                                                from tb_contrc a
                                                left join tb_tap b
                                                on a.Ko_unit1 = b.ko_unit1
                                                and a.Ko_Period = b.Ko_Period
                                                and a.Ko_sKeg1 = b.Ko_sKeg1
                                                and a.Ko_sKeg2 = b.Ko_sKeg2
                                                and a.Ko_Rkk = b.Ko_Rkk 
                                                INNER JOIN
                                                tb_contr c
                                                ON a.id_contr = c.id_contr 
                                                where a.Ko_unit1 = b.ko_unit1
                                                GROUP BY a.id_contr'));

        $datafinal = Tbcontrc::where('Ko_Period',$tahun)->where('Ko_unit1',$kounit1)->get();
        $max = Tbbprc::where('Ko_Period', '2020')
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_bprc');

        // belum ada filter jika Ko_Wil1 dan 2 sudah ada
        return view('transaksi.belanja.subtermin.create', compact('penerimaan', 'sumberkegiatan', 'data', 'Ko_Unit', 'sumber', 'sumber2', 'Period', 'max','datafinal'));
    }

    public function tambah($id)
    {
        $data = Tbbp::find($id);
        // dd($data);
        $Ko_Unit = Session::get('ko_unit1');
        $Period = Session::get('Ko_Period');
        $penerimaan = Tbbprc::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();

        $sumberkegiatan = DB::select(DB::raw('select a.*, a.To_Rp AS TotalRincian, b.*, c.*
                                                from tb_contrc a
                                                left join tb_contr b
                                                ON a.id_contr = b.id_contr
                                                left join tb_tap c
                                                on a.Ko_unit1 = c.ko_unit1
                                                and a.Ko_Period = c.Ko_Period
                                                and a.Ko_sKeg1 = c.Ko_sKeg1
                                                and a.Ko_sKeg2 = c.Ko_sKeg2
                                                and a.Ko_Rkk = c.Ko_Rkk 
                                                WHERE a.Ko_Period = "'.Tahun().'" AND a.Ko_unit1 = "'.kd_bidang().'"
                                                GROUP BY a.id_contrc'));
        
        
        $sumberkegiatan2 = DB::select(DB::raw('select a.*, 
                                                b.ko_unit1, b.Ko_Period, b.Ko_sKeg1, b.Ur_Rk6, b.Ur_KegBL1, b.Ur_KegBL2, b.Ko_sKeg2, b.Ko_Rkk, SUM(b.To_Rp) AS Total 
                                                , c.id_contr, c.No_contr, c.dt_contr
                                                from tb_contrc a
                                                left join tb_tap b
                                                on a.Ko_unit1 = b.ko_unit1
                                                and a.Ko_Period = b.Ko_Period
                                                and a.Ko_sKeg1 = b.Ko_sKeg1
                                                and a.Ko_sKeg2 = b.Ko_sKeg2
                                                and a.Ko_Rkk = b.Ko_Rkk 
                                                INNER JOIN
                                                tb_contr c
                                                ON a.id_contr = c.id_contr 
                                                where a.Ko_unit1 = b.ko_unit1
                                                GROUP BY a.Ko_Rkk'));

        $datafinal = Tbcontrc::where('Ko_Period',Tahun())->where('Ko_unit1',kd_bidang())->get();
        $max = Tbbprc::where('Ko_Period', Tahun())
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_bprc');

        // belum ada filter jika Ko_Wil1 dan 2 sudah ada
        return view('transaksi.belanja.subtermin.create', compact('penerimaan', 'sumberkegiatan', 'data', 'Ko_Unit', 'sumber', 'sumber2', 'Period', 'max','datafinal'));
    }

    public function store(Request $request)
    {
        $created_at = NOW();
        $updated_at = NOW();
        $rules = [
            "Ur_bprc" => "required",
            "rftr_bprc" => "required",
            "To_Rp" => "required",
          ];
      
          $messages = [
            "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
            "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
            "To_Rp.required" => "Nilai (Rp) wajib diisi.",

          ];
          $validator = FacadesValidator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
		
		$To_Rp = inrupiah($request->To_Rp);
		$data = Tbbp::find($request->id_bp);
		$no_contr = $data->No_contr;
		$period = $data->Ko_Period;
		$ko_unit = $data->Ko_unit1;
        //dd($To_Rp);
		
		// validate - cek apakah total transaksi melebihi total Nilai Kontrak
  		$cek = collect(DB::select('CALL SP_CekKontrak('.$period.', "'.$ko_unit.'" ,"'.$no_contr.'" )'))->first(); // 01-08-2024 Lor In

  		$Other_Rp = round($cek->Pagu, 2);
  		$New_Rp = round($To_Rp, 2) ;
  		$Real_Rp = round($cek->Realisasi, 2);
  		$Saldo_Rp = ($Other_Rp - ( $New_Rp + $Real_Rp ));
		$Sisa_Rp = ($Other_Rp - $Real_Rp );
		
		if ( $Saldo_Rp < 0 ) {
  			Alert::error('Gagal', "Pengajuan Termin Lebih Besar daripada Nilai Kontrak !! Realisasi Kontrak sampai dengan saat ini sebesar Rp".number_format($cek->Realisasi, 2, ',', '.').". Sisa Kontrak Rp".number_format($Sisa_Rp, 2, ',', '.').". ");
  			return back();
  		} else  {
			Tbbprc::create([          
				'id_bp' => $request->id_bp,
				'Ko_Period' => Tahun(),
				'Ko_unit1' => kd_bidang(),      
				'No_bp' => $request->No_bp,
				'Ko_bprc' => $request->Ko_bprc,
				'Ur_bprc' => $request->Ur_bprc,
				'rftr_bprc' => $request->rftr_bprc,
				'dt_rftrbprc' => $request->dt_rftrbprc,
				'No_PD' => $request->No_PD,
				'Ko_sKeg1' => $request->Ko_sKeg1,
				'Ko_sKeg2' => $request->Ko_sKeg2,
				'Ko_Rkk' => $request->Ko_Rkk,
				'Ko_Pdp' => 1,
				'ko_pmed' => 99,
				'To_Rp' => inrupiah($request->To_Rp),
				'ko_kas' => $request->Ko_kas,
				'tb_ulog' => getUser('username'),
				'created_at' => $created_at,
				'updated_at' => $updated_at,
			]);
			
			Alert::success('Berhasil', "Data Berhasil Ditambah");
			return redirect()->route('subtermin.rincian', $request->id_bp);
		}
    }

    public function show($id)
    {

        $rincian = Tbbprc::where('id',$id)->get();
        return view('transaksi.belanja.subtermin.show', compact('rincian'));
    }

    public function edit($id)
    {
        $sumberkegiatan = DB::select(DB::raw('select a.*, a.To_Rp AS TotalRincian, b.*, c.*
                                                from tb_contrc a
                                                left join tb_contr b
                                                ON a.id_contr = b.id_contr
                                                left join tb_tap c
                                                on a.Ko_unit1 = c.ko_unit1
                                                and a.Ko_Period = c.Ko_Period
                                                and a.Ko_sKeg1 = c.Ko_sKeg1
                                                and a.Ko_sKeg2 = c.Ko_sKeg2
                                                and a.Ko_Rkk = c.Ko_Rkk 
                                                GROUP BY a.id_contrc'));

        $sumber = DB::table('tb_contrc')->select('tb_contrc.*', 'tb_tap.*')
                    ->leftJoin('tb_tap', function($join){
                        $join->on('tb_contrc.Ko_Period','=','tb_tap.Ko_Period');
                        $join->on('tb_contrc.Ko_sKeg1','=','tb_tap.Ko_sKeg1');
                        $join->on('tb_contrc.Ko_sKeg2','=','tb_tap.Ko_sKeg2');
                        $join->on('tb_contrc.Ko_Rkk','=','tb_tap.Ko_Rkk');
                    })
                    ->groupBy('tb_contrc.id_contrc')
                    ->get()->toArray();

        $datafinal = Tbcontrc::where('Ko_Period',Tahun())->where('Ko_unit1',kd_bidang())->get();
        $data = Tbbprc::join('tb_bp','tb_bprc.id_bp','=','tb_bp.id_bp')->where('tb_bprc.id_bprc', $id)->first();
        
        $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('ko_skeg1');
        $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('ko_skeg2');
        $ko_rkk = Tbbprc::where('id_bprc',$id)->value('ko_rkk');
        $caridt = DB::select('call vdata_btrans('.Tahun().', "'.kd_bidang().'",2)');
        $dt_view = collect($sumber)->where('Ko_sKeg1', $ko_skeg1)->where('Ko_sKeg2', $ko_skeg2)->where('Ko_Rkk', $ko_rkk)->first();
        // dd($dt_view);
        return view('transaksi.belanja.subtermin.edit', compact('data','sumberkegiatan','datafinal','dt_view'));
    }

    public function update(Request $request, $id)
    {
		
		$To_Rp = inrupiah($request->To_Rp);
		$data = Tbbp::find($request->id_bp);
		$no_contr = $data->No_contr;
		$period = $data->Ko_Period;
		$ko_unit = $data->Ko_unit1;
		
		// validate - cek apakah total transaksi melebihi total Nilai Kontrak
  		$cek = collect(DB::select('CALL SP_CekKontrak('.$period.', "'.$ko_unit.'" ,"'.$no_contr.'" )'))->first(); // 01-08-2024 Lor In

  		$Other_Rp = round($cek->Pagu, 2);
  		$New_Rp = round($To_Rp, 2) ;
  		$Real_Rp = round($cek->Realisasi, 2);
  		$Saldo_Rp = ($Other_Rp - ( $New_Rp + $Real_Rp ));
		
		if ( $Saldo_Rp < 0 ) {
  			Alert::error('Gagal', "Pengajuan Termin Lebih Besar daripada Nilai Kontrak !! Realisasi Kontrak sampai dengan saat ini sebesar Rp".number_format($cek->Realisasi, 2, ',', '.')." ");
  			return back();
  		} else  {
			Tbbprc::where('id_bprc', $id)->update([         
				'No_bp' => $request->No_bp,
				'Ko_bprc' => $request->Ko_bprc,
				'Ur_bprc' => $request->Ur_bprc,
				'rftr_bprc' => $request->rftr_bprc,
				'dt_rftrbprc' => $request->dt_rftrbprc,
				'No_PD' => $request->No_PD,
				'Ko_sKeg1' => $request->Ko_sKeg1,
				'Ko_sKeg2' => $request->Ko_sKeg2,
				'Ko_Rkk' => $request->Ko_Rkk,
				'Ko_Pdp' => 1,
				'ko_pmed' => 99,
				'To_Rp' => inrupiah($request->To_Rp),
				'ko_kas' => $request->Ko_kas,
			]);
			Alert::success('Berhasil', "Data berhasil Diubah");
			$idn = Tbbprc::where('id_bprc', $id)->value('id_bp');
			// dd($id);
			return redirect()->route('subtermin.rincian', $idn);
		}
    }

    public function destroy($id)
    {
        $idbp = Tbbprc::select('id_bp')->where('id_bprc',$id)->first();
        $bprc = DB::select(DB::raw('select a.* 
                                    from tb_bprc a
                                    join tb_spirc b
                                    ON a.No_bp = b.No_bp && a.Ko_bprc = b.Ko_bprc && a.Ko_Period = b.Ko_Period && LEFT(a.Ko_unit1,18) = b.Ko_unitstr
                                    where a.id_bprc ='.$id));  
        if(empty($bprc)){
            $bprc = Tbbprc::where('id_bprc',$id);
            $bprc->delete();
            Alert::success('Berhasil', "Data Rincian Termin berhasil Dihapus");

            return redirect()->route('subtermin.rincian', $idbp->id_bp);
        }else{
            //Alert::success('Yeay!', 'berhasil dihapus');
            return back()->with('alert','Data Pengajuan SPJ Telah Tersedia, tidak dapat dilakukan perubahan data.');
            //return back();
            }
        }

}
