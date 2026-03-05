<?php

namespace App\Http\Controllers\Otorisasi;

use App\Http\Controllers\Controller;
use App\Http\Traits\laporanTrait;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Otorisasi;
use App\Models\Tboto;
use App\Models\Tb_spi;
use App\Models\Tbsp3;
use App\Models\Tblogv;
use App\Models\Tbspirc;
use App\Models\Tbbyroto;
use App\Models\Pfbank;
use App\Models\tbnpd;
use App\Models\Tbtap;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Session;
use PDF;

class OtorisasiController extends Controller
{
  use laporanTrait;
  //////////////////////////////////////////////////////////////////////////////////////////////////////////// OTORISASI
  public function index() #otorisasi
  {
    $data = DB::select(DB::raw('SELECT a.*,SUM(b.spirc_Rp) AS Jumlah FROM tb_spi a
    LEFT JOIN tb_spirc b ON a.Ko_Period = b.Ko_Period AND a.ko_unitstr = b.Ko_unitstr AND a.no_SPi = b.No_spi
    WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'" && a.Tag = 0 && a.Tag_v = 2
    GROUP BY a.No_SPi'));

    $otorisasi = collect($data);

    $rincian = Tbspirc::where(['ko_period' => Tahun(), 'Ko_unitstr' => kd_unit()])->get();

    $data = DB::select('CALL SP_Otorisasi_Usul(' . Tahun() . ', "' . kd_unit() . '")'); #mencari data otorisasi yg belum bernomor
    $otorisasi_blm_nomor = collect($data);

    $sql = DB::select("SELECT a.*, b.id_byro, SUM(c.spirc_Rp) AS Jumlah 
    FROM tb_oto a 
    LEFT JOIN tb_byroto b ON a.Ko_Period = b.Ko_Period AND a.No_oto = b.No_oto AND a.Ko_unitstr = b.Ko_unitstr
    LEFT JOIN tb_spirc c ON a.Ko_Period = c.Ko_Period AND a.No_SPi = c.No_spi AND c.Ko_unitstr = c.Ko_unitstr
    LEFT JOIN tb_spi d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_SPi = d.No_SPi
    WHERE a.Ko_Period = '".Tahun()."' AND a.Ko_unitstr = '".kd_unit()."' AND ISNULL(b.id_byro) AND d.Tag <> 0
    GROUP BY a.ko_period, a.ko_unitstr, a.no_spi");
    $otorisasi_sudah_nomor = collect($sql);

    return view('otorisasi.otorisasi.index', compact('otorisasi', 'rincian', 'otorisasi_blm_nomor', 'otorisasi_sudah_nomor'));
  }

  public function update(Request $request, $id) #otorisasi --> hanya mengupdate tb_spi, insert tb_oto di menu penomoran
  {
    $data = Tb_spi::find($id);

    $data->Tag = 1;
    $data->tb_ulog = getUser('username');
    $data->updated_at = now();
    $data->oto_ulog = getUser('username');
    $data->otodated_at = $request->Dt_oto;
    $data->save();

    Alert::success('Berhasil !!!', 'Data Usulan: Nomor ' . $data->No_SPi . ' sudah diotorisasi !!!');

    return redirect()->route("otorisasi.index");
  }

  public function bataloto(Request $request, $id)     // batalkan otorisasi yg belum bernomor 
  {
    $data = Tb_spi::find($id);

    $No_SPi = $data->No_SPi;

    $data->tb_ulog = getUser('username');
    $data->Tag = 0;
    $data->updated_at = now();
    $data->otodated_at = NULL;
    $data->save();

    Alert::success('Berhasil!', 'Otorisasi usulan: Nomor ' . $No_SPi . ' sudah dibatalkan !!!');

    return redirect()->route("otorisasi.index");
  }

  public function batalnomor(Request $request, $id)   // batalkan otorisasi yg sudah bernomor
  {
    $sql = DB::select(DB::raw("SELECT a.*, b.id_byro, SUM(c.spirc_Rp) AS Jumlah 
      FROM tb_oto a 
      LEFT JOIN tb_byroto b ON a.Ko_Period = b.Ko_Period AND a.No_oto = b.No_oto 
      LEFT JOIN tb_spirc c ON a.Ko_Period = c.Ko_Period AND a.No_SPi = c.No_spi
      WHERE a.Ko_Period = " . Tahun() . " AND a.Ko_unitstr = '" . kd_unit() . "' AND ISNULL(b.id_byro)
      GROUP BY a.ko_period, a.ko_unitstr, a.no_spi"));
    $spm = collect($sql);

    // update tp_spi tag=0
    $No_SPi = $spm[0]->No_SPi;
    $tb_spi = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'No_SPi' => $No_SPi])->first();

    $tb_spi->tb_ulog = getUser('username');
    $tb_spi->Tag = 0;
    $tb_spi->updated_at = now();
    $tb_spi->otodated_at = NULL;
    $tb_spi->save();

    // hapus tabel tb_oto
    $tb_oto = Tboto::find($spm[0]->id);
    $tb_oto->delete();

    Alert::success('Berhasil!', 'Otorisasi SPM: Nomor ' . $spm[0]->No_oto . ' sudah dibatalkan !!!');

    return redirect()->route("otorisasi.index");
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////// PENOMORAN
  public function penomoran(Request $request)
  {
    // mencari data otorisasi yg belum bernomor
    $data = DB::select(DB::raw('SELECT A.id, A.Ko_Period, A.Ko_unitstr, A.No_SPi, A.Dt_SPi, A.Ur_SPi, SUM(C.spirc_Rp) AS Jumlah, A.otodated_at
    FROM tb_spi A LEFT OUTER JOIN tb_oto B ON A.ko_period = B.ko_period AND A.ko_unitstr = B.ko_unitstr AND A.no_spi = B.no_spi 
    LEFT OUTER JOIN tb_spirc C ON A.Ko_Period = C.Ko_Period AND A.ko_unitstr = C.Ko_unitstr AND A.no_SPi = C.No_spi
    WHERE B.ko_period IS NULL AND A.ko_period = "'.Tahun().'" AND A.ko_unitstr = "'.kd_unit().'" AND A.Tag = 1
    GROUP BY A.ko_period, A.ko_unitstr, A.no_spi;'));
    $otorisasi = collect($data);

    $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
    $rekan = DB::select("SELECT * FROM tb_rekan WHERE Ko_unitstr = '".kd_unit()."'");

    return view('otorisasi.penomoran.index', compact('otorisasi','pegawai','rekan'));
  }

  public function bernomor(Request $request)
  {
    $data2 = DB::select("CALL SP_Otorisasi_Byr(" . Tahun() . ", '" . kd_unit() . "')");  
    $otorisasi2 = collect($data2);

    $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
    $rekan = DB::select("SELECT * FROM tb_rekan WHERE Ko_unitstr = '".kd_unit()."'");

    return view('otorisasi.penomoran.bernomor', compact('otorisasi2','pegawai','rekan'));
  }

  public function bernomor_bulan(Request $request,$id)
  {
    $bulan = $id;
    $request->session()->put('bulan', $bulan);

    $data2 = DB::select("CALL SP_Otorisasi_Byr(" . Tahun() . ", '" . kd_unit() . "')");  
    $dt_otorisasi2 = collect($data2)->filter(function($item) use ($bulan) { return date('m', strtotime($item->Dt_oto)) == $bulan; });
    $otorisasi2 = collect($dt_otorisasi2);

    $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
    $rekan = DB::select("SELECT * FROM tb_rekan WHERE Ko_unitstr = '".kd_unit()."'");

    return view('otorisasi.penomoran.bernomor', compact('otorisasi2','pegawai','rekan','bulan'));
  }

  public function create(Request $request) #penomoran 
  {
    // 
  }

  public function store(Request $request) #tag spi -->2 #tag oto --> 0
  {
    $No_SPi = $request->submit;
    $id_spi = $request->id_spi;

    $rules = [
      "No_oto" => "required",
      "Dt_oto" => "required", #tgl otorisasi sudah divalidasi di menu otorisasi
      "Ur_oto" => "required",
      "Trm_Nm" => "required",
      "Trm_rek" => "required",
      "Trm_bank" => "required",
      "Trm_NPWP" => "required",
      "Nm_Kuasa" => "required",
      "NIP_Kuasa" => "required",
    ];

    $messages = [
      "No_oto.required" => "Nomor Otorisasi wajib diisi.",
      "Dt_oto.required" => "Tanggal Otorisasi wajib diisi.",
      "Ur_oto.required" => "Uraian Otorisasi wajib diisi.",
      "Trm_Nm.required" => "Nama Penerima wajib diisi.",
      "Trm_rek.required" => "Nomor Rekening Penerima wajib diisi.",
      "Trm_bank.required" => "Bank Penerima wajib diisi.",
      "Trm_NPWP.required" => "NPWP wajib diisi.",
      "Nm_Kuasa.required" => "Nama Kuasa wajib diisi.",
      "NIP_Kuasa.required" => "NIP Kuasa wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      Alert::warning('GAGAL', "Penomoran usulan $No_SPi Gagal !!!");
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $data  =  explode("|",$request->Trm_Nm);
    $kuasa =  explode("|",$request->Nm_Kuasa);

    Tboto::create([
      'Ko_Period' => Tahun(),
      'Ko_unitstr' => kd_unit(),
      'id_spi'   => $id_spi,
      'No_SPi'   => $No_SPi,
      'No_oto'   => $request->No_oto,
      'Dt_oto'   => $request->Dt_oto,
      'Ur_oto'   => $request->Ur_oto,
      'Trm_Nm'   => $data[0],
      'Trm_NPWP' => $data[1],
      'Trm_bank' => $data[2],
      'Trm_rek'  => $data[3],
      'Nm_Kuasa'  => $kuasa[0],
      'NIP_Kuasa' => $kuasa[1],
      'Tag' => 0,
      'tb_ulog' => getUser('username'),
    ]);

    // update tb_spi --> tag = 2
    $spi = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'No_SPi' => $No_SPi])->first();
    $spi->Tag = 2;
    $spi->tb_ulog = getUser('username');
    $spi->updated_at = now();
    $spi->save();
    // 

    Alert::success('Berhasil', "Penomoran usulan $No_SPi berhasil !!!");

    return redirect()->route("penomoran");
  }

  public function penomoran_update(Request $request, $id)
  {
    $data = Tboto::find($id);

    $rules = [
      "Ur_oto" => "required",
      "Trm_Nm" => "required",
      "Trm_rek" => "required",
      "Trm_bank" => "required",
      "Trm_NPWP" => "required",
      "Nm_Kuasa" => "required",
      "NIP_Kuasa" => "required",
    ];

    $messages = [
      "Ur_oto.required" => "Uraian Otorisasi wajib diisi.",
      "Trm_Nm.required" => "Nama Penerima wajib diisi.",
      "Trm_rek.required" => "Nomor Rekening Penerima wajib diisi.",
      "Trm_bank.required" => "Bank Penerima wajib diisi.",
      "Trm_NPWP.required" => "NPWP wajib diisi.",
      "Nm_Kuasa.required" => "Nama Kuasa wajib diisi.",
      "NIP_Kuasa.required" => "NIP Kuasa wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      Alert::warning('GAGAL!', 'Data Otorisasi: Nomor ' . $data->No_oto . ' GAGAL dirubah !!!');
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $dt    = explode("|",$request->Trm_Nm);
    $kuasa = explode("|",$request->Nm_Kuasa);
    $bulan = Carbon::parse($request->Dt_oto)->format('m');
    
    $data->tb_ulog = getUser('username');
    $data->Ur_oto = $request->Ur_oto;
    $data->Dt_oto = $request->Dt_oto;
    $data->Trm_Nm    = $dt[0];
    $data->Trm_rek   = $dt[0];
    $data->Trm_bank  = $dt[0];
    $data->Trm_NPWP  = $dt[0];
    $data->Nm_Kuasa  = $kuasa[0];
    $data->NIP_Kuasa = $kuasa[1];
    $data->updated_at = now();
    $data->save();

    Alert::success('Berhasil', 'Data Otorisasi: Nomor ' . $data->No_oto . ' berhasil dirubah !!!');
    return redirect()->route('penomoran_bernomor.bulan',$bulan);
  }

  public function penomoran_hapus($id)
  {
    $bulan = Session::get('bulan');
    $data = Tboto::find($id);
    $No_SPi = $data->No_SPi;

    // hapus tb_oto
    $data->delete();

    // update tb_spi --> tag = 1
    $spi = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'No_SPi' => $No_SPi])->first();
    $spi->Tag = 1;
    $spi->tb_ulog = getUser('username');
    $spi->updated_at = now();
    $spi->save();

    Alert::success('Berhasil', "Penomoran $data->No_oto berhasil dihapus !!!");
    return redirect()->route('penomoran_bernomor.bulan',$bulan);
  }

  public function destroy($id)
  {
    //
  }

  public function batal(Request $request, $id)
  {
    try {
      Tblogv::create([
        'Tag_v'   => $request->Tag_vSpi,
        'id_spi'  => $request->id_spi,
        'ur_logv' => $request->ur_logv,
        'Tag'     => '0',
        'tb_ulog' => 'direktur',
        'created_at' => now(),
        'updated_at' => now()
      ]);

      Tb_spi::where('id', $id)->update([
        'Tag_v' => $request->Tag_v,
      ]);
    } catch (\Illuminate\Database\QueryException $e) {
      $e->getMessage();
    }

    Alert::success('Berhasil', 'Data berhasil dikembalikan');
    return redirect()->route('otorisasi.index');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////// LAPORAN
  public function lap_oto_index()
  {
    $sopd = Tboto::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit()])->get();
    $spd = DB::select("SELECT a.*,b.No_npd FROM tb_byroto a 
    JOIN tb_npd b ON a.id_npd = b.id_npd
    WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' GROUP BY b.id_npd");

    return view('laporan.penatausahaan.otorisasi.index', compact('sopd', 'spd'));
  }

  public function lap_oto_index_isi_spm(Request $request)
  {
    $regSpm = $this->regSOPD($request);

    return view('laporan.penatausahaan.otorisasi.register_spm_isi', compact('regSpm'));
  }

  public function lap_oto_index_cetak_spm(Request $request)
  {
    $regSpm = $this->regSOPD($request);
    $date1 = $request->date1;
    $date2 = $request->date2;

    $pdf = PDF::loadView('laporan.penatausahaan.otorisasi.register_spm_cetak', compact('regSpm', 'date1', 'date2'))->setPaper('A4', 'portrait');
    return $pdf->download('register_sopd.pdf');
  }

  public function lap_oto_index_isi_spd(Request $request)
  {
    $regSpd = $this->regSPD($request);

    return view('laporan.penatausahaan.otorisasi.register_spd_isi', compact('regSpd'));
  }

  public function lap_oto_index_cetak_spd(Request $request)
  {
    $regSpd = $this->regSPD($request);
    $date1 = $request->date1;
    $date2 = $request->date2;

    $pdf = PDF::loadView('laporan.penatausahaan.otorisasi.register_spd_cetak', compact('regSpd', 'date1', 'date2'))->setPaper('A4', 'portrait');
    return $pdf->download('register_spd.pdf');
  }

  public function sopd_pdf($id)
  {
    $data = Tboto::find($id);
   
    $dba = DB::select("SELECT * FROM tb_tap WHERE Ko_Period = '".Tahun()."' && LEFT(ko_unit1,18) = '".kd_unit()."' HAVING MAX(id_tap)");
    $qr_spm = collect(DB::select('CALL SP_S_Otorisasi("' . Tahun() . '","' . kd_unit() . '", "' . $data->No_oto . '")'));
    $qr_pot = collect(DB::select('CALL SP_Pot_Otorisasi("' . Tahun() . '","' . kd_unit() . '", "' . $data->No_oto . '")'));
    $jumlah = collect($qr_spm)->where('Nm_Kode', 'Rincian')->sum('Jumlah');
    $bankrow = DB::select("SELECT ko_bank FROM tb_byroto a WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.No_oto = '".$data->No_oto."' GROUP BY a.No_oto");
    if(empty($bankrow)) {
      $bank = 0;
    } else {
      $bank = DB::select("SELECT * FROM pf_bank a WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Bank = '".$bankrow[0]->ko_bank."'");
    }
    $pdf = PDF::loadView('otorisasi.penomoran.sopd_pdf', compact('data', 'qr_spm', 'jumlah','dba','qr_pot','bank'))->setPaper('A4', 'portrait');
    return $pdf->stream('S-OPD: ' . $data->No_oto . '.pdf',  array("Attachment" => false));
  }

  public function spd_pdf($id_byro)
  {
    $data = tbnpd::join('tb_oto', 'tb_oto.id','=','tb_npd.id_oto')->find($id_byro);
    $dba = DB::select("SELECT * FROM tb_tap WHERE Ko_Period = '".Tahun()."' && LEFT(ko_unit1,18) = '".kd_unit()."' HAVING MAX(id_tap)");
    $qr_sp2d = collect(DB::select('CALL SP_S_PencairanDana("' . Tahun() . '","' . kd_unit() . '", "' . $data->No_npd . '")')); 
    $qr_pot = collect(DB::select('CALL SP_Pot_PencairanDana("' . Tahun() . '","' . kd_unit() . '", "' . $data->No_npd . '")'));
    $jumlah = collect($qr_sp2d)->where('Nm_Kode', 'Rincian')->sum('Jumlah');
    $ttd = tbnpd::where('id_npd',$id_byro)->first();

    $pdf = PDF::loadView('laporan.penatausahaan.otorisasi.spd_pdf', compact('data', 'qr_sp2d', 'jumlah','dba','qr_pot','ttd'))->setPaper('A4', 'portrait');
    return $pdf->stream('S-PD: ' . $data->No_npd . '.pdf',  array("Attachment" => false));
  }
}
