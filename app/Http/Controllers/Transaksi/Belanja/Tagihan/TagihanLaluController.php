<?php

namespace App\Http\Controllers\Transaksi\Belanja\Tagihan;

use App\Http\Controllers\Controller;
use App\Models\Tbbp;
use App\Models\Tbbprc;
use App\Models\Tbbyr;
use App\Models\Tbrekan;
use App\Models\Tbtap;
use App\Models\Tbtax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Exception;

class TagihanLaluController extends Controller
{
    public function index()
    {
        $data = DB::select(DB::raw('SELECT a.*, c.rekan_nm, b.Ko_unit1, SUM(b.To_Rp) AS jml, d.sum_tax AS t_tax
        FROM tb_bp a
        LEFT JOIN tb_bprc b
        ON a.id_bp = b.id_bp 
        LEFT JOIN tb_rekan c
        ON a.nm_BUcontr = c.id_rekan
        LEFT JOIN (SELECT d.id_bp, SUM(d.tax_Rp) AS sum_tax FROM tb_tax d GROUP BY d.id_bp) AS d
        ON a.id_bp = d.id_bp
        WHERE a.Ko_bp = 41
        AND a.Ko_Period = "'.Tahun().'" AND a.Ko_unit1 = "'.kd_bidang().'"
        GROUP BY a.id_bp ORDER BY a.dt_bp DESC, a.id_bp DESC'));
        
        $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')
        ->where('Ko_bp', '4')
        ->where('Ko_Period', Tahun())
        ->where('Ko_unit1', kd_bidang())
        ->get();

        return view('transaksi.belanja.tagihan.utang.index', compact('data', 'belanja'));
    }

    public function v_bulan(Request $request,$id)
    {
      $bulan = $id;
      $request->session()->put('bulan', $bulan);

      $data = DB::select(DB::raw('SELECT * FROM (
              SELECT a.*, c.rekan_nm, SUM(b.To_Rp) AS jml, d.sum_tax AS t_tax
              FROM tb_bp a
              LEFT JOIN tb_bprc b
              ON a.id_bp = b.id_bp 
              LEFT JOIN tb_rekan c
              ON a.nm_BUcontr = c.id_rekan
              LEFT JOIN (SELECT d.id_bp, SUM(d.tax_Rp) AS sum_tax FROM tb_tax d GROUP BY d.id_bp) AS d
              ON a.id_bp = d.id_bp
              WHERE a.Ko_bp = 41
              AND a.Ko_Period = "'.Tahun().'" AND a.Ko_unit1 = "'.kd_bidang().'"
              GROUP BY a.id_bp ORDER BY a.dt_bp DESC, a.id_bp DESC) a
              WHERE MONTH(a.dt_bp) = "'.$bulan.'"
              ORDER BY a.dt_bp'));
      
      $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')
      ->where('Ko_bp', '4')
      ->where('Ko_Period', Tahun())
      ->where('Ko_unit1', kd_bidang())
      ->get();

      return view('transaksi.belanja.tagihan.utang.index', compact('data', 'belanja','bulan'));
    }

    public function create()
    {
      $max = Tbtap::where('Ko_Period', Tahun())->where('ko_unit1', kd_bidang())->max('id_tap');
      $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();

        // $data = DB::select('SELECT a.*,b.* FROM (SELECT a.*, b.Ur_KegBL1 ur_keg, c.Ur_Rk6 ur_rkk FROM tb_souta a
        // LEFT JOIN tb_tap b ON a.Ko_sKeg1 = b.Ko_sKeg1 && a.Ko_sKeg2 = b.Ko_sKeg2
        // LEFT JOIN pf_rk6 c ON a.Ko_Rkk = c.Ko_RKK
        // WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'" && b.Ko_Tap = "'.$max.'"
        // GROUP BY a.id) a 
        // LEFT JOIN tb_bp b ON a.Ko_Period = b.Ko_Period && a.Ko_unit1 = b.Ko_unit1 && a.uta_doc = b.No_bp
        // WHERE b.id_bp IS NULL');

      $data = DB::select('SELECT a.*,b.Ur_KegBL1 ur_keg, c.Ur_Rk6 ur_rkk FROM (
              SELECT a.*,SUM(a.uta_Rp-b.total) total,b.id_bp FROM tb_souta a
              LEFT JOIN (SELECT a.*,SUM(b.To_Rp) total FROM tb_bp a
              LEFT JOIN tb_bprc b ON a.id_bp = b.id_bp
              WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'"
              GROUP BY a.id_bp) b ON a.uta_doc = b.No_bp
              WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'"
              GROUP BY a.uta_doc,b.id_bp) a
              LEFT JOIN tb_tap b ON a.Ko_sKeg1 = b.Ko_sKeg1 && a.Ko_sKeg2 = b.Ko_sKeg2 && b.Ko_Tap = "'.$max.'"
              LEFT JOIN pf_rk6 c ON a.Ko_Rkk = c.Ko_RKK
              WHERE a.total <> 0 || a.id_bp IS NULL 
              GROUP BY a.id');

        return view('transaksi.belanja.tagihan.utang.create',compact('data','rekanan'));
    }

    public function store(Request $request)
    {
      $bulan = Carbon::parse($request->DtBp)->format('m');
      $chk   = Tbbp::where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang(),'No_bp' => $request->No_bp])->first();
      if (empty($chk)) {
        Tbbp::create([
            'Ko_Period'  => Tahun(),
            'Ko_unit1'   => kd_bidang(),
            'Ko_bp'      => '41',
            'No_bp'      => $request->No_bp,
            'dt_bp'      => $request->DtBp,
            'dt_jt'      => $request->DtJt,
            'Ur_bp'      => $request->UrBp,
            'nm_BUcontr' => $request->NmBuContr,
            'Nm_input'   => getUser('username'),
            'tb_ulog'    => getUser('username'),
            'created_at' => now(),
        ]);
      }

        $dt  = Tbbp::where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang(),'No_bp' => $request->No_bp, 'nm_BUcontr' => $request->NmBuContr])->first();
        $max = Tbbprc::where('Ko_Period', Tahun())->where('ko_unit1', kd_bidang())->where('No_bp', $request->No_bp)->max('Ko_bprc');

        Tbbprc::create([
            'id_bp'       => $dt->id_bp,
            'Ko_Period'   => Tahun(),
            'Ko_unit1'    => kd_bidang(),
            'No_bp'       => $request->No_bp,
            'Ko_bprc'     => $max+1,
            'Ur_bprc'     => $request->UrBp,
            'rftr_bprc'   => $request->No_bp,
            'dt_rftrbprc' => $request->DtBp,
            'No_PD'       => '1',
            'Ko_sKeg1'    => $request->Ko_sKeg1,
            'Ko_sKeg2'    => $request->Ko_sKeg2,
            'Ko_Rkk'      => $request->Ko_Rkk,
            'Ko_Pdp'      => '',
            'ko_pmed'     => 0,
            'To_Rp'       => inrupiah($request->To_Rp),
            'ko_kas'      => $request->Ko_kas,
            'tb_ulog'     => getUser('username'),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        Alert::success('Berhasil', "Data Berhasil Ditambah");
        return redirect()->route('tagihanlalu.index');
        // return redirect()->route('tagihanlalu.bulan',$bulan);
    }

    public function rincian($id_bp)
    {
      $cek      = Tbbyr::where('id_bprc', $id_bp)->first();
      $idbp     = $id_bp;
      $rincian  = DB::select("SELECT a.*, b.*
      FROM tb_bp a
      JOIN tb_bprc b
      ON a.id_bp = b.id_bp
      WHERE a.id_bp = '".$id_bp."'");

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

      return view('transaksi.belanja.tagihan.utang.rincian', compact('rincian', 'cek','rkk6','idbp'));
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
        //
    }

    public function destroy($id)
    {
        $bulan = Session::get('bulan');
        $No_bp = Tbbp::where('id_bp', $id)->first();
        $cek = DB::select('SELECT * FROM tb_bprc a
        JOIN tb_spirc b ON a.No_bp = b.No_bp && a.Ko_Period = b.Ko_Period && LEFT(a.Ko_unit1,18) = b.Ko_unitstr
        WHERE a.Ko_Period = "'.Tahun().'" && LEFT(a.Ko_unit1,18) = "'.kd_unit().'" && a.No_bp = "'.$No_bp->No_bp.'"');
    
        if (empty($cek)) {
          $data = Tbbp::where('id_bp', $id);
          $data->delete();
    
          Alert::success('Selamat', "Data berhasil dihapus");
          return redirect()->route('tagihanlalu.index');
          // return redirect()->route('tagihanlalu.bulan',$bulan);
        } else {
          Alert::error('Terdapat Rincian', "Data Tidak Dapat Dihapus");
          return back();
        }
    }

    public function hapus($id)
    {
      $tahun = Tahun();
      $kounitstr = kd_unit();
      
      $idbp = Tbbprc::select('id_bp')->where('id_bprc', $id)->first();

      $data = DB::select('select No_bp, Ko_bprc from tb_bprc where id_bprc = ?', [$id]);

      $bprc = DB::select(DB::raw('select a.*
        from tb_bprc a
        join tb_spirc b
        ON a.Ko_Period = b.Ko_Period and LEFT(a.Ko_unit1,18) = b.Ko_unitstr 
				AND a.No_bp = b.No_bp AND a.Ko_bprc = b.Ko_bprc
        where b.Ko_Period = ? and b.Ko_unitstr = ? and b.No_bp = ? and b.Ko_bprc = ?'), [$tahun, $kounitstr, $data[0]->No_bp, $data[0]->Ko_bprc]);
      
      if (empty($bprc)) {
        $bprc = Tbbprc::where('id_bprc', $id)->delete();

        Alert::success('Berhasil', "Data Rincian Belanja berhasil Dihapus");

        return redirect()->route('tagihanlalu.rincian', $idbp->id_bp);
      } else {
        Alert::error('Gagal', "Data Pengajuan SPJ Telah Tersedia, tidak dapat dilakukan perubahan data");
        return back();
      }
    }

    //Pajak
    public function pajak($id)
    {
      $tagihan = Tbbp::where('id_bp',$id)->first();
      $pajak   = DB::select(DB::raw("SELECT *,c.ur_rk6 FROM tb_tax a 
        LEFT JOIN tb_bp b 
        ON a.id_bp=b.id_bp
        LEFT JOIN (SELECT CONCAT(
        LPAD(Ko_Rk1,2,0),'.' ,
        LPAD(Ko_Rk2,2,0),'.' ,
        LPAD(Ko_Rk3,2,0),'.' ,
        LPAD(Ko_Rk4,2,0),'.' ,
        LPAD(Ko_Rk5,3,0),'.' ,
        LPAD(Ko_Rk6,4,0)
        ) AS rkk, ur_rk6
        FROM pf_rk6
        WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1') c
        ON a.Ko_Rkk = c.rkk
        WHERE b.id_bp = '".$id."'"));
  
      $rkk6    = DB::select(DB::raw("SELECT CONCAT(
        LPAD(Ko_Rk1,2,0),'.' ,
        LPAD(Ko_Rk2,2,0),'.' ,
        LPAD(Ko_Rk3,2,0),'.' ,
        LPAD(Ko_Rk4,2,0),'.' ,
        LPAD(Ko_Rk5,3,0),'.' ,
        LPAD(Ko_Rk6,4,0)
        ) AS RKK6, ur_rk6
        FROM pf_rk6
        WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1'"));
      return view('transaksi.belanja.tagihan.utang.pajak.index',compact('tagihan','pajak','rkk6'));
    }
  
    public function potongpajak(Request $request)
    {
      $request->validate([
        'id_bp'          => 'required',
        'Ko_Period'      => 'required',
        'Ko_unit1'       => 'required',
        'No_bp'          => 'required',
        'Ko_tax'         => 'required',
        'Ko_Rkk'         => 'required',
        'tax_Rp'         => 'required',
      ]);
  
      try {
        Tbtax::Create([
          'id_bp'     => $request->id_bp,
          'Ko_Period' => $request->Ko_Period,
          'Ko_unit1'  => $request->Ko_unit1,
          'No_bp'     => $request->No_bp,
          'Ko_tax'    => $request->Ko_tax,
          'Ko_Rkk'    => $request->Ko_Rkk,
          'tax_Rp'    => $request->tax_Rp,
          'Tag'       => 0,
          'tb_ulog'   => getUser('username'),
          'created_at' => now()
        ]);
        Alert::success('Berhasil', "Pajak berhasil ditambah");
        return back();
      } catch (Exception $e) {
        Alert::warning('Gagal', "Uraian pajak sudah ada");
        return back();
      }
    }
  
    public function editpotongpajak(Request $request,$id)
    {
      $request->validate([
        'Ko_tax'         => 'required',
        'Ko_Rkk'         => 'required',
        'tax_Rp'         => 'required',
      ]);
  
      try {
        Tbtax::where('id_tax',$id)->update([
          'Ko_tax'    => $request->Ko_tax,
          'Ko_Rkk'    => $request->Ko_Rkk,
          'tax_Rp'    => $request->tax_Rp,
          'updated_at'=> now()
  
        ]);
        Alert::success('Berhasil', "Pajak berhasil dirubah");
        return back();
      } catch (Exception $e) {
        Alert::warning('Gagal', "Uraian pajak sudah ada");
        return back();
      }
    }
  
    public function destroyPajak($id)
    {
      $data = Tbtax::where('id_tax',$id)->first();
      $data->delete();
  
      Alert::success('Berhasil', "Pajak berhasil dihapus");
      return back();
    }
}
