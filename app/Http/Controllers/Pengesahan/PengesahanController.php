<?php

namespace App\Http\Controllers\Pengesahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tbsp3; 
use App\Models\Tb_sp3rc; 
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use PDF;

class PengesahanController extends Controller
{
  public function index() 
  {
    $Ko_Period = Tahun();
    $Ko_unitstr = tb_sub('Ko_unitstr');
    $user = getUser('username');
    $data = DB::select(DB::raw("SELECT a.*, b.id_sp3rc FROM tb_sp3 a 
                                  LEFT JOIN 
                                  (SELECT * FROM tb_sp3rc 
                                    WHERE Ko_Period = $Ko_Period AND Ko_unitstr = '$Ko_unitstr' 
                                    GROUP BY id_sp3) b 
                                  ON a.id_sp3 = b.id_sp3
                                WHERE a.Ko_Period = $Ko_Period AND a.Ko_unitstr = '$Ko_unitstr'"));
    $sp3b = collect($data);
    $bulan = DB::select(DB::raw('SELECT * FROM pf_bln'));
    $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

    return view('pengesahan.sp3b.index', compact('sp3b' ,'bulan','pegawai'));
  }

  public function get_sp3b_rinci($id)
  {
    $data = DB::select("SELECT a.*, b.*, c.Dt_oto FROM tb_sp3 a
    LEFT JOIN tb_sp3rc b ON a.id_sp3 = b.id_sp3
    LEFT JOIN tb_oto c ON b.No_oto = c.No_oto && b.Ko_unitstr = c.Ko_unitstr && b.Ko_Period = c.Ko_Period
    WHERE a.id_sp3 = '".$id."' AND b.id_sp3 IS NOT NULL");
    
    return DataTables::of($data)
    ->addIndexColumn()
    ->addColumn('check', function($row){
      $params = '<input class="checklist" type="checkbox" value="'.$row->id_sp3rc.'">';
      return $params;
    })
    ->addColumn('tanggal', function($row){
      $params = date('d-m-Y', strtotime($row->Dt_oto));
      return $params;
    })
    ->addColumn('action', function($row){
      $params = '<a class="btn btn-sm btn-danger delete" data-id = "'.$row->id_sp3rc.'" data-id_sp3 = "'.$row->id_sp3.'" ><i class="far fa-trash-alt"></i></a>';
      return $params;
    })
    ->rawColumns(['check','tanggal','action'])
    ->make(true);
  }

  public function get_sp3b_list()
  {
    $data = DB::select('CALL SP_Otorisasi_Sah('.Tahun().', "'.kd_unit().'")');
    return DataTables::of($data)
    ->addIndexColumn()
    ->addColumn('tanggal', function($row){
      $params = date('d-m-Y', strtotime($row->Dt_oto));
      return $params;
    })
    ->addColumn('action', function($row){
      $params = '<input class="check" type="checkbox" value="'.$row->No_oto.'">';
      return $params;
    })
    ->rawColumns(['tanggal','action'])
    ->make(true);
  }

  public function store(Request $request)
  {
    $rules = [
      "No_sp3" => "required",
      // "Dt_sp3" => "required|before_or_equal:today", 
      "Dt_sp3" => "required", 
      "Ur_sp3" => "required",
      "bln_sp3" => "required",
      "Nm_Kuasa" => "required",
      "NIP_Kuasa" => "required",
    ];

    $messages = [
      "No_sp3.required" => "Nomor dokumen wajib diisi.",
      "Dt_sp3.required" => "Tanggal dokumen wajib diisi.",
      // "Dt_sp3.before_or_equal" => "Tanggal dokumen tidak sesuai.",
      "Ur_sp3.required" => "Uraian dokumen wajib diisi.",
      "bln_sp3.required" => "Bulan dokumen wajib diisi.",
      "Nm_Kuasa.required" => "Nama Kepala/Kuasa wajib diisi.",
      "NIP_Kuasa.required" => "NIP Kepala/Kuasa wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      Alert::warning('GAGAL', "Pengesahan SP3B Tidak Berhasil !!!");
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Alert::success('Berhasil', "Pengesahan SP3B Nomor: $request->No_sp3 berhasil !!!");

    $kuasa = explode("|",$request->Nm_Kuasa);

    Tbsp3::create([
      'tb_ulog'    => getUser('username'),
      'Ko_Period'  => Tahun(),
      'Ko_unitstr' => kd_unit(),
      'No_sp3'     => $request->No_sp3,
      'Dt_sp3'     => $request->Dt_sp3,
      'bln_sp3'    => $request->bln_sp3,
      'Ur_sp3'     => $request->Ur_sp3,
      'Nm_Kuasa'   => $kuasa[0],
      'NIP_Kuasa'  => $kuasa[1],
    ]);

    return redirect()->route("pengesahan.index");
  }

  public function show($id)
  {
    $rincian = Tb_sp3rc::where('id_sp3rc',$id)->get();
    return view('pengesahan.sp3brinci.index', compact( 'rincian' ));
  }

  public function edit($id)
  {

  }

  public function update(Request $request, $id)
  {
    $data = Tbsp3::find($id);

    $No_sp3 = $data->No_sp3;

    $rules = [
      "No_sp3" => "required",
      // "Dt_sp3" => "required|before_or_equal:today",
      "Ur_sp3" => "required",
      "Nm_Kuasa" => "required",
      "NIP_Kuasa" => "required",
    ];

    $messages = [
      "No_sp3.required" => "Nomor SP3B wajib diisi.",
      "Dt_sp3.required" => "Tanggal SP3B wajib diisi.",
      // "Dt_sp3.before_or_equal" => "Tanggal SP3B tidak sesuai.",
      "Ur_sp3.required" => "Uraian SP3B wajib diisi.",
      "Nm_Kuasa.required" => "Nama Kepala/Kuasa wajib diisi.",
      "NIP_Kuasa.required" => "NIP Kepala/Kuasa wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      Alert::warning('GAGAL', "Edit Dokumen SP3B Nomor: $No_sp3 Tidak Berhasil !!!");
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Alert::success('Berhasil', "Edit Dokumen SP3B Nomor: $No_sp3 berhasil !!!");

    $kuasa = explode("|",$request->Nm_Kuasa);

    $data->No_sp3     = $request->No_sp3;
    $data->Dt_sp3     = $request->Dt_sp3;
    $data->Ur_sp3     = $request->Ur_sp3;
    $data->bln_sp3    = $request->bln_sp3;
    $data->Nm_Kuasa   = $kuasa[0];
    $data->NIP_Kuasa  = $kuasa[1];
    $data->tb_ulog    = getUser('username');
    $data->updated_at = now();
    $data->save();

    return redirect()->route("pengesahan.index");
  }

  public function destroy($id)
  {
    $data = Tbsp3::find($id);
    $data->delete();

    Alert::success('Berhasil', "Dokumen SP3B $data->No_sp3 berhasil dihapus !!!");

    // blm validasi parent child

    return redirect()->route("pengesahan.index");
  }

  public function sp3b_store(Request $request)
  {
    $rules = [
      "No_sp3" => "required",
      "Dt_sp3" => "required",
      "Ur_sp3" => "required",
      "Nm_Kuasa" => "required",
      "NIP_Kuasa" => "required",
    ];

    $messages = [
      "No_sp3.required" => "Nomor dokumen wajib diisi.",
      "Dt_sp3.required" => "Tanggal dokumen wajib diisi.",
      "Ur_sp3.required" => "Uraian dokumen wajib diisi.",
      "Nm_Kuasa.required" => "Nama Kepala/Kuasa wajib diisi.",
      "NIP_Kuasa.required" => "NIP Kepala/Kuasa wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      Alert::warning('GAGAL', "Pengesahan SP3B Tidak Berhasil !!!");
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Alert::success('Berhasil', "Pengesahan SP3B Nomor: $request->No_sp3 berhasil !!!");

    Tbsp3::create([
      'tb_ulog' => getUser('username'),
      'Ko_Period' => Tahun(),
      'Ko_unitstr' => kd_unit(),
      'No_sp3' => $request->No_sp3,
      'Dt_sp3' => $request->Dt_sp3,
      'Ur_sp3' => $request->Ur_sp3,
      'Nm_Kuasa' => $request->Nm_Kuasa,
      'NIP_Kuasa' => $request->NIP_Kuasa,
    ]);

    return redirect()->route("pengesahan.index");
  }

  public function sp3b_rinci_store(Request $request)
  {
    $data = DB::select('CALL SP_Otorisasi_Sah('.Tahun().', "'.kd_unit().'")');
    $data = collect($data)->whereIn('No_oto',$request->data);
    foreach ($data as $key => $item) {
      $kode = Tb_sp3rc::where([ 'Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'No_sp3' => $request->no_sp3 ])->max('Ko_sp3') + 1;
      Tb_sp3rc::create([
        'Ko_Period'  => Tahun(),
        'Ko_unitstr' => kd_unit(),
        'id_sp3'     => $request->id_sp3,
        'No_sp3'     => $request->no_sp3,
        'Ko_sp3'     => $kode,
        'No_oto'     => $item->No_oto,
        'sp3rc_Rp'   => $item->jumlah,
        'tb_ulog'    => getUser('username'),
      ]);
    }
    return response()->json(['Berhasil' => 'Rincian SP3B berhasil ditambah']);
  }

  public function sp3b_rinci_destroy($id)
  {
    $data = Tb_sp3rc::find($id);
    $data->delete();
    return response()->json(['success' => 'Data berhasil dihapus']);
  }

  public function sp3b_rinci_delete(Request $request)
  {
    $data = Tb_sp3rc::whereIn('id_sp3rc', $request->data)->delete();
    return response()->json(['success' => 'Data berhasil dihapus']);
  }

  public function sp3b_pdf($id)
  {
    $sp3b = Tbsp3::find($id);
    $sp3b_saldo = DB::select('CALL SP_SP3B_Saldo('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")');
    $sp3b_saldo = collect($sp3b_saldo)->pluck('Saldo')->first();
    $qr_sp3b_0 = DB::select('CALL SP_SP3B_Saldo_Awl('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")'); 
    $qr_sp3b_1 = DB::select('CALL SP_SP3B_Koreksi('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")'); 
    $qr_sp3b_2 = DB::select('SELECT A.id_tap, A.Ko_Period, A.ko_unit1, "'.$sp3b->No_sp3.'", A.No_DPA as Dasar, A.Dt_DPA, B.nmbidang AS Urusan, 
                            CASE B.nmbidang WHEN "Bidang Kesehatan" THEN "RSUD/PKM" ELSE "BLUD" END AS Organisasi, A.ur_subunit,
                            "01.2.10.001" AS Kode_prokeg, "Pelayanan dan Penunjang Pelayanan BLUD" AS Ur_keg	
                            FROM tb_tap A, (
                            SELECT DISTINCT u.Ko_Urus AS kdurusan, u.Ur_Urus AS nmurusan, b.id_bidang AS idbidang, REPLACE(b.Ur_Bid,"Bidang ","") AS nmbidang, 
                            CONCAT(RIGHT(CONCAT("0",u.Ko_Urus),2),".",RIGHT(CONCAT("0",b.Ko_Bid),2)," ",b.Ur_Bid) AS kode_bidang
                            FROM pf_urus AS u
                            INNER JOIN pf_bid AS b ON u.Ko_Urus=b.Ko_Urus
                            WHERE CONCAT(RIGHT(CONCAT("0",u.Ko_Urus),2),".",RIGHT(CONCAT("0",b.Ko_Bid),2)) = SUBSTRING("'.kd_unit().'",7,5) 
                            ) B
                            WHERE A.id_tap = ( SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_Period = '.Tahun().' AND LEFT(Ko_unit1,18) = "'.kd_unit().'" ) AND LEFT(Ko_unit1,18) = "'.kd_unit().'" AND A.Ko_Period = '.Tahun().'
                            GROUP BY A.id_tap, A.Ko_Period, A.ko_unit1, A.No_DPA, A.Dt_DPA, A.ur_subunit, B.nmbidang;'); 

    $qr_sp3b_3 = DB::select('CALL SP_SP3B_Row('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")'); 
 	  $qr_sp3b_pdp_bel = DB::select('CALL SP_SP3B_Rinci('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")');
	
    // hitung jumlah row penerimaan pembiayaan - pengeluaran pembiayaan
    $jum_row_biaya = count(collect($qr_sp3b_3)->where('Group_RK', 3)) - count(collect($qr_sp3b_3)->where('Group_RK', 4));

    if ($jum_row_biaya >= 0) {
      $qr_sp3b_biaya = DB::select('call qr_sp3b_biaya1('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")'); 
    } else {
      $qr_sp3b_biaya = DB::select('call qr_sp3b_biaya2('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")'); 
    }

    $soawal                 = collect($qr_sp3b_0)->first()->Saldo ?? 0;
    $biaya_netto            = collect($qr_sp3b_1)->where('Group_RK', 4)->first()->Jumlah ?? 0;
    $penyesuaian            = collect($qr_sp3b_1)->where('Group_RK', 5)->first()->Jumlah ?? 0;

    $qr_sp3b_penyesuaian    = DB::select('CALL SP_SP3B_Pajak('.Tahun().', "'.kd_unit().'", "'.$sp3b->No_sp3.'")');

    $sum_penyesuaian_lebih  = collect($qr_sp3b_penyesuaian)->sum('Penerimaan_lebih'); 
    $sum_penyesuaian_kurang = collect($qr_sp3b_penyesuaian)->sum('Pengeluaran_kurang'); 
    $sum_pendapatan         = collect($qr_sp3b_pdp_bel)->sum('spirc_Rp_pdp');
    $sum_belanja            = collect($qr_sp3b_pdp_bel)->sum('spirc_Rp_bel');
    $sum_terimabiaya        = collect($qr_sp3b_biaya)->sum('spirc_Rp_pdp');
    $sum_keluarbiaya        = collect($qr_sp3b_biaya)->sum('spirc_Rp_bel');
    $soakhir                = $soawal + $sum_pendapatan - $sum_belanja + $biaya_netto + $penyesuaian ;

    $pdf = PDF::loadView('pengesahan.sp3b.sp3b_pdf', compact('sp3b','sp3b_saldo', 'qr_sp3b_0', 'qr_sp3b_2', 'qr_sp3b_pdp_bel', 'qr_sp3b_biaya', 'soawal', 'soakhir', 'biaya_netto', 'penyesuaian',
      'sum_pendapatan', 
      'sum_belanja', 
      'sum_terimabiaya',
      'sum_keluarbiaya',
      'sum_penyesuaian_lebih', 'sum_penyesuaian_kurang',
      'qr_sp3b_penyesuaian'
    ))->setPaper('A4', 'portrait');
 
    return $pdf->stream('SP3B: '.$sp3b->No_sp3.'.pdf',  array("Attachment" => false)); 
  }


  //pajak sp3b
  public function sp3b_pajak($id)
  {
    $sp3   = Tbsp3::where('id_sp3',$id)->first();
    $pajak = DB::select('call qr_daftarpajak('.Tahun().', "'.kd_unit().'", "'.$sp3->No_sp3.'")'); 

    $terima = collect($pajak)->sum('Terima');
    $setor  = collect($pajak)->sum('Setor');

    return view('pengesahan.sp3b.pajak',compact('pajak','terima','setor','sp3'));
  }

  public function sp3b_bbpajak($id)
  {
    $sp3   = Tbsp3::where('id_sp3',$id)->first();
    $pajak = DB::select('CALL SP_SP3B_TBP_Pajak('.Tahun().', "'.kd_unit().'", "'.$sp3->No_sp3.'")'); 

    $terima = collect($pajak)->sum('terima');
    $setor  = collect($pajak)->sum('Setor');

    return view('pengesahan.sp3b.bbpajak',compact('pajak','terima','setor','sp3'));
  }

  public function sp3b_detail($id)
  {
    $sp3    = Tbsp3::where('id_sp3',$id)->first();
    $detail = DB::select('CALL SP_SP3B_RinciB('.Tahun().', "'.kd_unit().'", "'.$sp3->No_sp3.'")'); 
    
    $data   = collect($detail)->groupBy('Ko_Rkk_bel')->map(function ($group){
      return [
        'total'  => $group->last(),
        'ur_rk'  => $group->values('Ur_Rk6_bel')->first(),
        'subtotal' => $group->where('Ko_Rkk_bel','!=','')->sum('spirc_Rp_bel'),
        'subrincian' => $group->where('No_bp','!=','')->groupBy('No_bp')->map(function ($group1){
          return [
            'ur_bprc' => $group1->where('No_bp','!=','')->values('Ur_bprc'),
            'total_bp' => $group1->where('No_bp','!=','')->sum('spirc_Rp_bel'),
          ];
        })
      ];
    });
    return view('pengesahan.sp3b.detail',compact('data','sp3'));
  }

}
