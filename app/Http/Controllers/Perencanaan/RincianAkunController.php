<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Pfjnpdp;
use App\Models\Tb_ang;
use App\Models\Tb_ang_rc;
use App\Models\Tb_keg;
use App\Models\Tb_keg1;
use App\Models\Tb_keg2;
use App\Models\Tbbprc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class RincianAkunController extends Controller
{
    public function index()
    {
        //
    }

    public function r_akun($id1,$id2,$id3)
    {
        // $jp = Pfjnpdp::where('Ko_Pdp','<>','4')->get();
        $jp = Pfjnpdp::all();

        $map  = Tb_keg::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1])->first();
        $map2 = Tb_keg1::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_KegBL1' => substr($id2,1,1)])->first();
        $map3 = Tb_keg2::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_sKeg2' => $id2])->first();
        $map4 = Tb_ang::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_sKeg2' => $id2, 'Ko_Rkk' => $id3])->first();

        $dt = Tb_ang::where('Ko_sKeg1', $id1)
              ->where('Ko_sKeg2', $id2)
              ->where('Ko_Rkk', $id3)
              ->where('Ko_Period', Tahun())
              ->where('ko_unit1', kd_bidang())
              ->get();
        // dd($dt);
        $rc = Tb_ang_rc::where('Ko_sKeg1', $id1)
              ->where('Ko_sKeg2', $id2)
              ->where('Ko_Rkk', $id3)
              ->where('Ko_Period', Tahun())
              ->where('ko_unit1', kd_bidang())
              ->orderBy('Ur_Rc1','asc')
              ->get();

        $max = Tb_ang_rc::where('Ko_sKeg1', $id1)
              ->where('Ko_sKeg2', $id2)
              ->where('Ko_Rkk', $id3)
              ->where('Ko_Period', Tahun())
              ->where('ko_unit1', kd_bidang())
              ->max('Ko_Rc');

        $rp_akt = Tb_keg2::select(DB::raw('SUM(tb_ang_rc.To_Rp) As jml'))
                ->leftJoin('tb_ang', function ($join) {
                    $join->on('tb_kegs2.Ko_sKeg1', '=', 'tb_ang.Ko_sKeg1');
                    $join->on('tb_kegs2.Ko_sKeg2', '=', 'tb_ang.Ko_sKeg2');
                    $join->on('tb_kegs2.ko_unit1', '=', 'tb_ang.ko_unit1');
                    $join->on('tb_kegs2.Ko_Period', '=', 'tb_ang.Ko_Period');
                })->leftJoin('tb_ang_rc', function ($join) {
                    $join->on('tb_ang.Ko_sKeg1', '=', 'tb_ang_rc.Ko_sKeg1');
                    $join->on('tb_ang.Ko_sKeg2', '=', 'tb_ang_rc.Ko_sKeg2');
                    $join->on('tb_ang.Ko_Rkk', '=', 'tb_ang_rc.Ko_Rkk');
                    $join->on('tb_ang.ko_unit1', '=', 'tb_ang_rc.ko_unit1');
                    $join->on('tb_ang.Ko_Period', '=', 'tb_ang_rc.Ko_Period');
                })
                ->where(['tb_kegs2.Ko_Period' => Tahun(), 'tb_kegs2.ko_unit1' => kd_bidang(), 'tb_kegs2.Ko_sKeg1' => $id1, 'tb_kegs2.Ko_sKeg2' => $id2])
                ->groupBy('tb_kegs2.Ko_sKeg1')
                ->value('jml');

        $t_rc = DB::select(DB::raw("SELECT SUM(To_Rp) jml FROM tb_ang_rc WHERE Ko_sKeg1 = '".$id1."' && Ko_sKeg2 = '".$id2."' && Ko_Rkk = '".$id3."' &&
                Ko_Period = '".Tahun()."' && ko_unit1 = '".kd_bidang()."' GROUP BY Ko_sKeg1 "));

        if ($t_rc == null) {
            $rc_rp = 0;
        } else {
            $rc_rp = $t_rc[0]->jml;
        }

        return view('perencanaan.r_akun',compact('map','map2','map3','map4','dt','rc','jp','max','rp_akt','rc_rp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'Ko_Pdp'    => 'required',
          'Ko_Rc'     => 'required',
          'Ur_Rc1'    => 'required',
          'V_1'       => 'required',
          'Rp_1'      => 'required',
          'V_sat'     => 'required',
          'To_Rp'     => 'required',
      ]);

      $Rp_1  = inrupiah($request->Rp_1);
      $To_Rp = inrupiah($request->To_Rp);

  		// validate - cek apakah total transaksi melebihi total akun di rba
  		$cek = collect(DB::select('CALL SP_CekRealisasi('.$request->Ko_Period.', "'.$request->ko_unit1.'" ,"'.$request->Ko_sKeg1.'", "'.$request->Ko_sKeg2.'", "'.$request->Ko_Rkk.'" ,'.$request->Ko_Rc.' )'))->first(); // 25-07-2024 Horison

  		$Other_Rp = round($cek->Anggaran, 2);
  		$New_Rp = round($To_Rp, 2) ;
  		$Real_Rp = round($cek->Saldo, 2);
  		$Saldo_Rp = ($Other_Rp + $New_Rp ) - $Real_Rp ;

  		if ( $Saldo_Rp < 0 ) {
  			Alert::error('Gagal', "Realisasi Belanja Lebih Besar daripada Perubahan Rincian Belanja pada RBA !!");
  			return back();
  		} else  {

  			Tb_ang_rc::Create([
  				'Ko_Period' => $request->Ko_Period,
  				'ko_unit1'  => $request->ko_unit1,
  				'Ko_sKeg1'  => $request->Ko_sKeg1,
  				'Ko_sKeg2'  => $request->Ko_sKeg2,
  				'Ko_Rkk'    => $request->Ko_Rkk,
  				'Ko_Pdp'    => $request->Ko_Pdp,
  				'Ko_Rc'     => $request->Ko_Rc,
  				'Ur_Rc1'    => $request->Ur_Rc1,
  				'V_1'       => $request->V_1,
  				'Rp_1'      => $Rp_1,
  				'V_sat'     => $request->V_sat,
  				'To_Rp'     => $To_Rp,
  			]);

  		Alert::success('Berhasil', "Rincian Belanja berhasil ditambah !!");
          return redirect('kegiatan/program/subkegiatan/akun/rincian/'.$request->Ko_sKeg1.'-'.$request->Ko_sKeg2.'-'.$request->Ko_Rkk);

  		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $dt = Tb_ang_rc::find($id);

      // set variable
      // $total_transaksi = DB::select('SELECT IFNULL(SUM(To_Rp), 0) AS total_transaksi
      //                             FROM tb_bprc
      //                             WHERE Ko_Period = ? AND Ko_unit1 = ?
      //                             AND Ko_sKeg1 = ? AND Ko_sKeg2 = ? AND Ko_Rkk = ?', [
      //                             $dt->Ko_Period, $dt->ko_unit1, $dt->Ko_sKeg1, $dt->Ko_sKeg2, $dt->Ko_Rkk])[0]->total_transaksi;

      // $total_rba_exclude = DB::select('SELECT SUM(To_Rp) AS total_rba
      //                                 FROM tb_ang_rc
      //                                 WHERE Ko_Period = ? AND Ko_unit1 = ?
      //                                 AND Ko_sKeg1 = ? AND Ko_sKeg2 = ? AND Ko_Rkk = ? AND id != ?', [
      //                                 $dt->Ko_Period, $dt->ko_unit1, $dt->Ko_sKeg1, $dt->Ko_sKeg2, $dt->Ko_Rkk, $id])[0]->total_rba;

      // $total_rba_menjadi = $total_rba_exclude + $request->To_Rp;

      // validate - cek apakah total transaksi melebihi total akun di rba
      // if($total_rba_menjadi < $total_transaksi):
      //     Alert::error('Gagal', "Total transaksi melebihi total RBA");
      //     return back();
      // else:

  		$request->validate([
  			'Ko_Pdp'    => 'required',
  			'Ur_Rc1'    => 'required',
  			'V_1'       => 'required',
  			'Rp_1'      => 'required',
  			'V_sat'     => 'required',
  			'To_Rp'     => 'required',
  		]);

    	$Rp_1  = inrupiah($request->Rp_1);
  		$To_Rp = inrupiah($request->To_Rp);
  		$Vol_1 = inrupiah($request->V_1);
		$Ko_Rc = $dt->Ko_Rc;

  		// validate - cek apakah total transaksi melebihi total akun di rba
  		$cek = collect(DB::select('CALL SP_CekRealisasi('.$request->Ko_Period.', "'.$request->ko_unit1.'" ,"'.$request->Ko_sKeg1.'", "'.$request->Ko_sKeg2.'", "'.$request->Ko_Rkk.'" ,'.$Ko_Rc.' )'))->first(); // 25-07-2024 Horison

  		$Other_Rp = round($cek->Anggaran, 2);
  		$New_Rp = round($Rp_1, 2) * round($Vol_1, 2) ;
  		$Real_Rp = round($cek->Saldo, 2);
  		$Saldo_Rp = ($Other_Rp + $New_Rp ) - $Real_Rp ;

  		if ( $Saldo_Rp < 0 ) {
  			Alert::error('Gagal', "Realisasi Belanja Lebih Besar daripada Perubahan Rincian Belanja pada RBA !! Realisasi RBA sebesar Rp".number_format($cek->Saldo, 2, ',', '.')." ");
  			return back();
  		} else  {
  			Tb_ang_rc::where('id', $id)
  				->update([
  					'Ko_Pdp'    => $request->Ko_Pdp,
  					'Ur_Rc1'    => $request->Ur_Rc1,
  					'V_1'       => $request->V_1,
  					'Rp_1'      => $Rp_1,
  					'V_sat'     => $request->V_sat,
  					'To_Rp'     => $To_Rp,
  				]);

  			Alert::success('Berhasil', "Rincian Belanja pada RBA berhasil di ubah !! Sisa Anggaran RBA sebesar : Rp".number_format($Saldo_Rp, 2, ',', '.')." ");
  		}
  		return redirect('kegiatan/program/subkegiatan/akun/rincian/'.$request->Ko_sKeg1.'-'.$request->Ko_sKeg2.'-'.$request->Ko_Rkk);
  	// endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = Tb_ang_rc::find($id);

        // set variable
        // $total_transaksi = DB::select('SELECT IFNULL(SUM(To_Rp), 0) AS total_transaksi
        //                             FROM tb_bprc
        //                             WHERE Ko_Period = ? AND Ko_unit1 = ?
        //                             AND Ko_sKeg1 = ? AND Ko_sKeg2 = ? AND Ko_Rkk = ?', [
        //                             $dt->Ko_Period, $dt->ko_unit1, $dt->Ko_sKeg1, $dt->Ko_sKeg2, $dt->Ko_Rkk])[0]->total_transaksi;

        // $total_rba_semula = DB::select('SELECT SUM(To_Rp) AS total_rba
        //                                 FROM tb_ang_rc
        //                                 WHERE Ko_Period = ? AND Ko_unit1 = ?
        //                                 AND Ko_sKeg1 = ? AND Ko_sKeg2 = ? AND Ko_Rkk = ?', [
        //                                 $dt->Ko_Period, $dt->ko_unit1, $dt->Ko_sKeg1, $dt->Ko_sKeg2, $dt->Ko_Rkk])[0]->total_rba;

        // $total_rba_menjadi = $total_rba_semula - $dt->To_Rp;

        // validate - cek apakah total transaksi melebihi total akun di rba
        // if($total_rba_menjadi < $total_transaksi):
        //     Alert::error('Gagal', "Total transaksi melebihi total RBA");
        //     return back();
        // else:

        $Rp_1  = inrupiah($dt->Rp_1);
    	$Vol_1 = inrupiah($dt->V_1);
		$Ko_Period = $dt->Ko_Period;
		$ko_unit1  = $dt->ko_unit1;
		$Ko_sKeg1  = $dt->Ko_sKeg1;
		$Ko_sKeg2  = $dt->Ko_sKeg2;
		$Ko_Rkk    = $dt->Ko_Rkk;
        $Ko_Rc     = $dt->Ko_Rc;

    		// validate - cek apakah total transaksi melebihi total akun di rba
    		$cek = collect(DB::select('CALL SP_CekRealisasi('.$Ko_Period.', "'.$ko_unit1.'" ,"'.$Ko_sKeg1.'", "'.$Ko_sKeg2.'", "'.$Ko_Rkk.'" ,'.$Ko_Rc.' )'))->first(); // 25-07-2024 Horison

    		$Other_Rp = round($cek->Anggaran, 2);
    		$New_Rp = round($Rp_1, 2) * round($Vol_1, 2) ;
    		$Real_Rp = round($cek->Saldo, 2);
    		$Saldo_Rp = ($Other_Rp + $New_Rp ) - $Real_Rp ;

    		if ( $Saldo_Rp < 0 ) {
          Alert::error('Gagal', "Realisasi Belanja Lebih Besar daripada Perubahan Rincian Belanja pada RBA !! Realisasi RBA sebesar Rp".number_format($cek->Saldo, 2, ',', '.')." ");
          return back();
    		} else  {
    			$dt->delete();
                Alert::success('Berhasil', "Data Rincian Belanja pada RBA berhasil dihapus !!");
                return back();
    		}
        // endif;
    }
}
