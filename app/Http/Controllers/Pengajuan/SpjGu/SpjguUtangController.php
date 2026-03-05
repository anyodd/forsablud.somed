<?php

namespace App\Http\Controllers\Pengajuan\SpjGu;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SpjguUtangController extends Controller
{
    public function index()
    {
        $spjgu = Tb_spi::select('tb_spi.*',DB::raw('SUM(tb_spirc.spirc_Rp) As jml'))
        ->leftJoin('tb_spirc', function ($join) {
            $join->on('tb_spi.Ko_Period', '=', 'tb_spirc.Ko_Period');
            $join->on('tb_spi.Ko_unitstr', '=', 'tb_spirc.Ko_unitstr');
            $join->on('tb_spi.No_SPi', '=', 'tb_spirc.No_spi');
        })
        ->where(['tb_spi.Ko_Period' => Tahun(), 'tb_spi.Ko_unitstr' => kd_unit(), 'tb_spi.Ko_SPi' => 91])
        ->groupBy('tb_spi.id')
        ->orderBy('tb_spi.Dt_SPi','DESC')
        ->get();

        return view('pengajuan.spjguutang.index', compact('spjgu'));
    }

    public function create()
    {
        $spjgu = Tb_spi::all();
        $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
        $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

        return view('pengajuan.spjguutang.create', compact('spjgu','ko_bank','bank_rekan','pegawai'));
    }

    public function show($id)
    {
        $log = DB::select("SELECT * FROM tb_logv WHERE id_spi = '".$id."'");
        return view('pengajuan.spjguutang.popup.itemlog',compact('log'));
    }

    public function store(Request $request)
    {
        $bank_rekan = explode('||',$request->rekan_bank);
        $Ko_SPi = '91';
        $Tag = '0';
    
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
        return redirect()->route("spjguutang.index");
    }

    public function spjguedit($id)
    {
        $data = Tb_spi::find($id);
        $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
        $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

        return view('pengajuan.spjguutang.edit', compact('data','ko_bank','bank_rekan','pegawai'));
    }

    public function spjgu_update(Request $request, $id)
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
          ];
      
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
          $PP  = explode("|",$request->Nm_PP);
          $Ben = explode("|",$request->Nm_Ben);
          $Keu = explode("|",$request->Nm_Keu);

        Tb_spi::where('id',$id)->update([      
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
        return redirect()->route("spjguutang.index");
    }

    public function rincian($id)
    {
        $spjgu1 = Tb_spi::find($id);
        // $spjgu = DB::select(DB::raw("SELECT a.*, b.*, c.* 
        //     FROM tb_spi a
        //         JOIN tb_spirc b 
        //         ON a.No_SPi = b.No_spi
        //         LEFT JOIN tb_bp c
        //         ON b.No_bp = c.No_bp
        //         where a.id = '".$id."'
        //         GROUP BY b.id"));
        $no_spi = Tb_spi::where('id',$id)->value('No_SPi');
        $spjgu = Tb_spirc::where(['Ko_unitstr' => kd_unit(),'Ko_Period' => Tahun(), 'No_spi' => $no_spi])->get();
        
        return view('pengajuan.spjguutang.rincian', compact('spjgu','spjgu1'));
    }

    public function viewtambahrincian($id)
    {
        $Tag =0;

        if(
            $spjguutang = DB::select(DB::raw('select a.* 
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

            $spjguutangbukti= collect($data);

            $spjguutang = Tb_spi::find($id);

            $spjguutang1 = DB::select(DB::raw('SELECT a.*, b.* 
            FROM tb_spi a
            JOIN tb_spirc b 
            ON a.No_SPi = b.No_spi 
            WHERE a.id = '.$id));

            $spjguutang2 = array_column($spjguutang1, 'Ko_spirc');

            if(empty($spjguutang2)){
                $spjguutang2 = 0;
                $spjguutang3 = $spjguutang2;
            }else{
                $spjguutang2 = $spjguutang2;
                $spjguutang3 = max($spjguutang2);
                $spjguutang4 = $spjguutang3 + 1;  
            }
            $norincian = $spjguutang3 + 1;  
            
            return view('pengajuan.spjguutang.viewtambahrincian', compact('spjguutang','spjguutangbukti','norincian'));
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
        return redirect()->route('spjguutang.index')->with('sukses','Data rincian ls tagihan berhasil di tambah, silahkan cek pada menu list rincian');
    }

    public function hapusrincianspjgu($id)
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
            $spjgu = Tb_spirc::find($id);
            $spjgu->delete();
            return back();
        }
        
        //dd($satu);  
    }

    public function destroy($id)
    {
        $Tag = 0;

        if(
            $spjgu = DB::select(DB::raw('select a.* 
            from tb_spi a
            where a.Tag = '.$Tag.' and a.id = '.$id))
        ){
            $spjgu = Tb_spi::find($id);
            $spjgurc = Tb_spirc::where('No_spi',$spjgu)->delete();
            $spjgu->delete();
    
            return redirect()->route("spjguutang.index");
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
        return redirect()->route('spjguutang.index');
    }
}
