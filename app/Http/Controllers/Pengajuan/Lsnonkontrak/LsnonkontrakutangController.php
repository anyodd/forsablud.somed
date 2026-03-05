<?php

namespace App\Http\Controllers\Pengajuan\Lsnonkontrak;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use App\Models\Pfbank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class LsnonkontrakutangController extends Controller
{
    public function index()
    {
        $lsnonkontrakutang = Tb_spi::select('tb_spi.*',DB::raw('SUM(tb_spirc.spirc_Rp) As jml'))
            ->leftJoin('tb_spirc', function ($join) {
                $join->on('tb_spi.Ko_Period', '=', 'tb_spirc.Ko_Period');
                $join->on('tb_spi.Ko_unitstr', '=', 'tb_spirc.Ko_unitstr');
                $join->on('tb_spi.No_SPi', '=', 'tb_spirc.No_spi');
            })
            ->where(['tb_spi.Ko_Period' => Tahun(), 'tb_spi.Ko_unitstr' => kd_unit(), 'tb_spi.Ko_SPi' => 9])
            ->groupBy('tb_spi.id')
            ->orderBy('tb_spi.Dt_SPi', 'DESC')
            ->orderBy('tb_spi.id', 'asc')
            ->get();

        return view('pengajuan.lsnonkontrakutang.index', compact('lsnonkontrakutang'));
    }

    public function create()
    {
        $lsnonkontrakutang = Tb_spi::all();
        $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
        $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

        return view('pengajuan.lsnonkontrakutang.create', compact('lsnonkontrakutang','ko_bank','bank_rekan','pegawai'));
    }

    public function store(Request $request)
    {
        $bank_rekan = explode('||',$request->rekan_bank);
        $Ko_SPi = '9';
        $Tag = '0';
    
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
            "No_SPi.unique" => "Nomor Bukti yang dimasukan telah ada",
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

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('lsnonkontrakutang.index');
    }

    public function viewtambahrincian($id)
    {
        $Tag =0;

        if(
            $lsnonkontrakutang = DB::select(DB::raw('select a.* 
            from tb_spi a
            where a.Tag = '.$Tag.' and a.id = '.$id))
        ){
            $Ko_Period = Tahun();
            $Ko_unitstr = kd_unit();

            $data = DB::select("SELECT * FROM (
                SELECT a.*,b.Ur_KegBL2 kegiatan,c.Ur_Rk6 ur_rkk FROM tb_souta a 
                LEFT JOIN tb_kegs2 b
                ON a.Ko_Period = b.Ko_Period
                && a.Ko_unit1 = b.ko_unit1
                && a.Ko_sKeg1 = b.Ko_sKeg1
                && a.Ko_sKeg2 = b.Ko_sKeg2
                LEFT JOIN pf_rk6 c
                ON a.Ko_Rkk = c.Ko_RKK
                WHERE a.Ko_unit1 = '".kd_bidang()."' && a.Ko_Period = '".Tahun()."'
                GROUP BY a.id ) a
                WHERE NOT EXISTS(SELECT * FROM tb_spirc e WHERE a.uta_doc = e.No_bp && LEFT(a.Ko_unit1,18) = e.Ko_unitstr && a.Ko_Period = e.Ko_Period)");

            $lsnonkontrakutangbukti= collect($data);

            $lsnonkontrakutang = Tb_spi::find($id);

            $lsnonkontrakutang1 = DB::select(DB::raw('SELECT a.*, b.* 
            FROM tb_spi a
            JOIN tb_spirc b 
            ON a.No_SPi = b.No_spi 
            WHERE a.id = '.$id));

            $lsnonkontrakutang2 = array_column($lsnonkontrakutang1, 'Ko_spirc');

            if(empty($lsnonkontrakutang2)){
                $lsnonkontrakutang2 = 0;
                $lsnonkontrakutang3 = $lsnonkontrakutang2;
            }else{
                $lsnonkontrakutang2 = $lsnonkontrakutang2;
                $lsnonkontrakutang3 = max($lsnonkontrakutang2);
                $lsnonkontrakutang4 = $lsnonkontrakutang3 + 1;  
            }
            $norincian = $lsnonkontrakutang3 + 1;  
            
            return view('pengajuan.lsnonkontrakutang.viewtambahrincian', compact('lsnonkontrakutang','lsnonkontrakutangbukti','norincian'));
        }else{
            return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
        }
    }

    public function tambahrincian(Request $request)
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $tb_ulog = 'user';

        $rules = [
            "No_bp"     => "required",
            "Ko_sKeg1"  => "required",
            "Ko_sKeg2"  => "required",
            "Ko_Rkk"    => "required",
            "Ur_bprc"   => "required",
            "spirc_Rp"  => "required",
          ];
      
          $messages = [
            "No_bp.required"    => "Bukti wajib diisi.",
            "Ko_sKeg1.required" => "Kegiatan wajib diisi.",
            "Ko_sKeg2.required" => "Kegiatan wajib diisi.",
            "Ko_Rkk.required"   => "Kode Akun wajib diisi.",
            "Ur_bprc.required"  => "Uraian Bukti wajib diisi.",
            "spirc_Rp.required" => "Nilai (Rp) wajib diisi.",
          ];
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

        Tb_spirc::create([          
            'Ko_Period'  => $Ko_Period,
            'Ko_unitstr' => $Ko_unitstr,
            'No_spi'     => $request->No_spi,   
            'Ko_spirc'   => $request->Ko_spirc,     
            'No_bp'      => $request->No_bp,
            'Ko_Rkk'     => $request->Ko_Rkk,
            'Ko_sKeg1'   => $request->Ko_sKeg1,
            'Ko_sKeg2'   => $request->Ko_sKeg2,
            'Ur_bprc'    => $request->Ur_bprc,
            'spirc_Rp'   => $request->spirc_Rp,
            'tb_ulog'    => $tb_ulog,
        ]);
        return redirect()->route("lsnonkontrakutang.index")->with('sukses','Data rincian ls tagihan berhasil di tambah, silahkan cek pada menu list rincian');
    }

    public function rincian($id)
    {
        $lsnonkontrakutang1 = Tb_spi::find($id);
        $no_spi = Tb_spi::where('id',$id)->value('No_SPi');
        $lsnonkontrakutang = Tb_spirc::where(['Ko_unitstr' => kd_unit(),'Ko_Period' => Tahun(), 'No_spi' => $no_spi])->get();

        return view('pengajuan.lsnonkontrakutang.rincian', compact('lsnonkontrakutang','lsnonkontrakutang1'));
    }

    public function hapusrinciantagihanutang($id)
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
            $lsnonkontrak = Tb_spirc::find($id);
            $lsnonkontrak->delete();
            return back();
        }

    }

    public function show($id)
    {
        $log = DB::select("SELECT * FROM tb_logv WHERE id_spi = '".$id."'");
        return view('pengajuan.lsnonkontrakutang.popup.itemlog',compact('log'));
    }

    public function edit($id)
    {
        //
    }

    public function lsnonkontrakutangedit($id)
    {
        $data = Tb_spi::find($id);
        $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
        $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

        return view('pengajuan.lsnonkontrakutang.edit', compact('data','ko_bank','bank_rekan','pegawai'));
    }

    public function lsnonkotrakutangupdate(Request $request, $id)
    {
        $bank_rekan = explode('||',$request->rekan_bank);
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
            "No_SPi.unique" => "Nomor Bukti yang dimasukan telah ada",
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
        return redirect()->route("lsnonkontrakutang.index");
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        $Tag = 0;

        if(
            $lsnonkontrakutang = DB::select(DB::raw('select a.* 
            from tb_spi a
            where a.Tag = '.$Tag.' and a.id = '.$id))
        ){
            $lsnonkontrakutang = Tb_spi::find($id);
            $lsnonkontrakutangrc = Tb_spirc::where('No_spi',$lsnonkontrakutang)->delete();
            $lsnonkontrakutang->delete();
            $lsnonkontrakutangrc->delete();
    
            return redirect()->route("lsnonkontrakutang.index");
        }else{
            //Alert::success('Yeay!', 'berhasil dihapus');
            return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
            //return back();
        }
    }

    public function verifikasi(Request $request, $id)
    {
        Tb_spi::where('id',$id)->update([
            'Tag_v' => $request->Tag_v,
        ]);

        Alert::success('Berhasil', 'Data berhasil diajukan verifikasi');
        return redirect()->route('lsnonkontrakutang.index');
    }

    public function sppdlsnonutang_pdf($id)
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
        $pdf = PDF::loadView('pengajuan.lsnonkontrakutang.sppd_lsutang_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','qr_spp2','skas','title'))->setPaper('A4', 'portrait');
        return $pdf->stream('S-PPD LS: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
        
    }
}
