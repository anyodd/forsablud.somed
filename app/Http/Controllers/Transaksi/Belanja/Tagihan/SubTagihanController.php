<?php

namespace App\Http\Controllers\Transaksi\Belanja\Tagihan;

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
use App\Models\Tbbyr;
use App\Models\Tbtax;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use PhpParser\Node\Expr\AssignOp\ShiftLeft;
use RealRashid\SweetAlert\Facades\Alert;


class SubTagihanController extends Controller
{
  public function index()
    {   //
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

      return view('transaksi.belanja.subtagihan.rincian', compact('rincian', 'cek','rkk6','idbp'));
    }

    public function create($idbp)
    {
        //
    }

    public function tambah($idbp)
    {
      $data       = Tbbp::where('id_bp', $idbp)->where('Ko_Period', Tahun())->where('Ko_unit1', kd_bidang())->first();
      $PD         = 1;

      $caridata   = DB::select('call vdata_btrans(' . Tahun() . ', "' . kd_bidang() . '",' . $PD . ')');
      $datafinal  = collect($caridata);
      $max        = Tbbprc::where('Ko_Period', Tahun())
      ->where('No_bp', $data->No_bp)
      ->where('Ko_Unit1', kd_bidang())
      ->max('Ko_bprc');

      return view('transaksi.belanja.subtagihan.create', compact('data', 'max', 'datafinal'));
    }

    public function store(Request $request)
    {
      $rules = [
        "Ur_bprc" => "required",
        "rftr_bprc" => "required",
        "To_Rp" => "required",
        "Ko_Pdp" => "required",
        "Ko_sKeg1" => "required",
        "Ko_sKeg2" => "required",
        "Ko_Rkk" => "required",
      ];

      $messages = [
        "Ko_sKeg1.required" => "Uraian Program wajib diisi.",
        "Ko_sKeg2.required" => "Uraian Kegiatan Wajib Diisi",
        "Ko_Rkk.required" => "RKK wajib diisi.",
        "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
        "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
        "To_Rp.required" => "Nilai (Rp) wajib diisi.",
        "Ko_Pdp.required" => "Jenis Sumber Kegiatan Wajib Diisi",
      ];
      $validator = FacadesValidator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->all);
      }

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
        'Ko_Pdp' => $request->Ko_Pdp,
        'ko_pmed' => 0,
        'To_Rp' => inrupiah($request->To_Rp),
        'ko_kas' => $request->Ko_kas,
        'tb_ulog' => getUser('username'),
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      Alert::success('Berhasil', "Data Berhasil Ditambah");
      return redirect()->route('subtagihan.rincian', $request->id_bp);
    }

    public function show($id)
    {
      $rincian = Tbbprc::where('id', $id)->get();
      return view('transaksi.belanja.subtagihan.show', compact('rincian'));
    }

    public function edit($id)
    {
      $data = Tbbprc::where('id_bprc', $id)->first();
      $kegiatan = Tbtap::all();
      $sumber = Pfjnpdp::all();
      $sumber2 = Pfjnpdpr::all();
        // dd($data);
      $PD = 1;

      $max = Tbbprc::where('Ko_Period', Tahun())
      ->where('No_bp', $data->No_bp)
      ->where('Ko_Unit1', $data->Ko_unit1)
      ->max('Ko_bprc');

      $caridata   = DB::select('call vdata_btrans(' . Tahun() . ', "' . kd_bidang() . '",' . $PD . ')');
      $datafinal = collect($caridata);

      $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('ko_skeg1');
      $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('ko_skeg2');
      $ko_rkk = Tbbprc::where('id_bprc',$id)->value('ko_rkk');
      $dt_view = collect($caridata)->where('ko_skeg1',$ko_skeg1)->where('ko_skeg2',$ko_skeg2)->where('ko_rkk',$ko_rkk)->first();
      return view('transaksi.belanja.subtagihan.edit', compact('data', 'datafinal', 'dt_view'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
      $rules = [
        "Ur_bprc" => "required",
        "rftr_bprc" => "required",
        "To_Rp" => "required",
        "Ko_sKeg1" => "required",
        "Ko_sKeg2" => "required",
        "Ko_Rkk" => "required",
      ];

      $messages = [
        "Ko_sKeg1.required" => "Uraian Program wajib diisi.",
        "Ko_sKeg2.required" => "Uraian Kegiatan Wajib Diisi",
        "Ko_Rkk.required" => "RKK wajib diisi.",
        "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
        "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
        "To_Rp.required" => "Nilai (Rp) wajib diisi.",
      ];
      $validator = FacadesValidator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->all);
      }

      Tbbprc::where('id_bprc', $id)->update([
        'Ur_bprc' => $request->Ur_bprc,
        'rftr_bprc' => $request->rftr_bprc,
        'dt_rftrbprc' => $request->dt_rftrbprc,
        'Ko_sKeg1' => $request->Ko_sKeg1,
        'Ko_sKeg2' => $request->Ko_sKeg2,
        'Ko_Rkk' => $request->Ko_Rkk,
        'To_Rp' => inrupiah($request->To_Rp),
        'ko_kas' => $request->Ko_kas,
      ]);

      $idn = Tbbprc::where('id_bprc', $id)->value('id_bp');

      Alert::success('Berhasil', "Data Berhasil Dirubah");
      return redirect()->route('subtagihan.rincian', $idn);
    }

    public function destroy($id)
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

        return redirect()->route('subtagihan.rincian', $idbp->id_bp);
      } else {
        Alert::error('Gagal', "Data Pengajuan SPJ Telah Tersedia, tidak dapat dilakukan perubahan data");
        return back();
      }
    }
  }


