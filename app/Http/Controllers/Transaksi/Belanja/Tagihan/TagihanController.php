<?php

namespace App\Http\Controllers\Transaksi\Belanja\Tagihan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tbbp;
use App\Models\Tbbprc;
use App\Models\Tbbyr;
use App\Models\Pfjnpdp;
use App\Models\Pfjnpdpr;
use App\Models\Tbrekan;
use App\Models\Tbtap;
use App\Models\Tbtax;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Exception;


class TagihanController extends Controller
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
      WHERE a.Ko_bp = 4
      AND a.Ko_Period = "'.Tahun().'" AND a.Ko_unit1 = "'.kd_bidang().'"
      GROUP BY a.id_bp ORDER BY a.dt_bp DESC, a.id_bp DESC'));
    
    $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')
    ->where('Ko_bp', '4')
    ->where('Ko_Period', Tahun())
    ->where('Ko_unit1', kd_bidang())
    ->get();

    return view('transaksi.belanja.tagihan.index', compact('data', 'belanja'));
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
            WHERE a.Ko_bp = 4
            AND a.Ko_Period = "'.Tahun().'" AND a.Ko_unit1 = "'.kd_bidang().'"
            GROUP BY a.id_bp ORDER BY a.dt_bp DESC, a.id_bp DESC) a
            WHERE MONTH(a.dt_bp) = "'.$bulan.'"
            ORDER BY a.dt_bp DESC'));
  
    $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')
    ->where('Ko_bp', '4')
    ->where('Ko_Period', Tahun())
    ->where('Ko_unit1', kd_bidang())
    ->get();

    return view('transaksi.belanja.tagihan.index', compact('data', 'belanja','bulan'));
  }

  public function rincian($id_bp)
  {
    $Period     = Tahun();
    $unit       = kd_unit();
    $bidang     = kd_bidang();
    $kegiatan = Tbtap::all();
    $sumber = Pfjnpdp::all();
    $sumber2 = Pfjnpdpr::all();

    $rincian = Tbbprc::orderBy('id_bp')
    ->where('Ko_Period', $Period)
    ->where('Ko_unit1', $bidang)
    ->where('id_bp', $id_bp)
    ->get();


    return view('transaksi.belanja.subtagihan.rincian', compact('rincian', 'sumber', 'sumber2', 'kegiatan'));
  }

  public function create()
  {
    $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
    return view('transaksi.belanja.tagihan.create',compact('rekanan'));
  }

  public function store(Request $request)
  {
    $No_bp = $request->No_bp;
    $Ko_Period = Tahun(); // utk cek unique??
    $Ko_unit1 = kd_bidang(); // utk cek unique??

    $rules = [
      "No_bp" => [
        'required',
        Rule::unique('tb_bp')->where(function ($query) use($Ko_Period, $Ko_unit1, $No_bp) {
          return $query->where([ 'Ko_Period'=>Tahun(), 'Ko_unit1'=>kd_bidang(), 'No_bp'=>$No_bp ]);
        }),
      ],
      'DtBp'      => 'required',
      'DtJt'      => 'required',
      'UrBp'      => 'required',
      'NmBuContr' => 'required',
      
    ];

    $messages = [
      'No_bp.unique'      => 'Nomor Dokumen sudah ada.',
      'No_bp.required'      => 'Nomor Tagihan/Faktur wajib diisi.',
      'DtBp.required'      => 'Tanggal Tagihan wajib diisi.',
      'DtJt.required'      => 'Tanggal Jatuh Tempo wajib diisi.',
      'UrBp.required'      => 'Uraian wajib diisi.',
      'NmBuContr.required' => 'Nama Rekanan wajib diisi.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $bulan = Carbon::parse($request->DtBp)->format('m');

    Tbbp::create([
      'Ko_Period'  => Tahun(),
      'Ko_unit1'   => kd_bidang(),
      'Ko_bp'      => '4',
      'No_bp'      => $request->No_bp,
      'dt_bp'      => $request->DtBp,
      'dt_jt'      => $request->DtJt,
      'Ur_bp'      => $request->UrBp,
      'nm_BUcontr' => $request->NmBuContr,
      'Nm_input'   => getUser('username'),
      'tb_ulog'    => getUser('username'),
      'created_at' => now(),
    ]);

    Alert::success('Berhasil', 'Data berhasil ditambah');
    return redirect()->route('tagihan.bulan',$bulan);
  }

  public function show($id_bp)
  {
    $kegiatan = Tbtap::all();
    $sumber = Pfjnpdp::all();
    $sumber2 = Pfjnpdpr::all();

    $rincian = DB::select(DB::raw('select a.*, b.*
      from tb_bp a
      join tb_bprc b
      on a.No_bp = b.No_bp
      where a.id_bp = ' . $id_bp));
    return view('transaksi.belanja.tagihan.show', compact('rincian', 'sumber', 'sumber2', 'kegiatan'));
  }

  public function edit($id_bp)
  {
    $data = Tbbp::where('id_bp', $id_bp)->first();
    $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
    return view('transaksi.belanja.tagihan.edit', compact('data','rekanan'));
  }

  public function update(Request $request, $id)
  {
    $rules = [
      'NoBp'      => 'required',
      'DtBp'      => 'required',
      'DtJt'      => 'required',
      'UrBp'      => 'required',
      'NmBuContr' => 'required',
    ];

    $messages = [
      'NoBp.required'      => 'Nomor Bukti wajib diisi.',
      'DtBp.required'      => 'Tanggal wajib diisi.',
      'DtJt.required'      => 'Tanggal wajib diisi.',
      'UrBp.required'      => 'Uraian wajib diisi.',
      'NmBuContr.required' => 'Nama Rekanan wajib diisi.',
    ];

    $bulan = Carbon::parse($request->DtBp)->format('m');

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Tbbp::where('id_bp', $id)->update([
      'No_bp'      => $request->NoBp,
      'dt_bp'      => $request->DtBp,
      'dt_jt'      => $request->DtJt,
      'Ur_bp'      => $request->UrBp,
      'nm_BUcontr' => $request->NmBuContr,
      'updated_at' => now(),
    ]);

    Alert::success('Berhasil', 'Data berhasil dirubah');
    return redirect()->route('tagihan.bulan',$bulan);
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
      return redirect()->route('tagihan.bulan',$bulan);
    } else {
      Alert::error('Terdapat Rincian', "Data Tidak Dapat Dihapus");
      return back();
    }
  }

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
                    // dd($pajak);
    return view('transaksi.belanja.tagihan.pajak.index',compact('tagihan','pajak','rkk6'));
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
        // dd($request->all());
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

  //Utang

  public function tagihanlalu()
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
    ->where('Ko_bp', '41')
    ->where('Ko_Period', Tahun())
    ->where('Ko_unit1', kd_bidang())
    ->get();

    return view('transaksi.belanja.tagihan.utang.index', compact('data', 'belanja')); 
  }
}
