<?php

namespace App\Http\Controllers\Pengajuan\Kasawal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use App\Models\Pfbank;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
Use PDF;

class KasawalController extends Controller
{
    public function index()
    { 
        $sesi = Tahun();
        $max = Tb_spi::where('Ko_SPi', 1)->where(['Ko_Period' => Tahun(),'Ko_unitstr' => kd_unit()])->max('Ko_Period');

        $kasawal = Tb_spi::select('tb_spi.*',DB::raw('SUM(tb_spirc.spirc_Rp) As jml'))
        ->leftJoin('tb_spirc', function ($join) {
            $join->on('tb_spi.Ko_Period', '=', 'tb_spirc.Ko_Period');
            $join->on('tb_spi.Ko_unitstr', '=', 'tb_spirc.Ko_unitstr');
            $join->on('tb_spi.No_SPi', '=', 'tb_spirc.No_spi');
        })
        ->where(['tb_spi.Ko_Period' => Tahun(), 'tb_spi.Ko_unitstr' => kd_unit(), 'tb_spi.Ko_SPi' => 1])
        ->groupBy('tb_spi.id')
        ->get();

        $no_spi  = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'Ko_SPi' => '1'])->value('No_SPi'); 
        $satu = DB::table('tb_spirc')
                ->where(['No_spi' => $no_spi,'Ko_unitstr' => kd_unit(), 'Ko_Period' => Tahun()])
                ->first();

        return view('pengajuan.kasawal.index', compact('kasawal','max','sesi','satu'));
    }

    public function create()
    {
        $kasawal = Tb_spi::all();
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
        return view('pengajuan.kasawal.create', compact('kasawal','pegawai'));
    }

    public function store(Request $request)
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $Ko_SPi = '1';
        $tb_ulog = 'admin';
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
            "Dt_SPi.required" => "Tanggal wajib diisi.",
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
            'Ko_Period' => $Ko_Period,
            'Ko_unitstr' => $Ko_unitstr,
            'Ko_SPi'  => $Ko_SPi,
            'No_SPi'  => $request->No_SPi,
            'Dt_SPi'  => $request->Dt_SPi,
            'Ur_SPi'  => $request->Ur_SPi,
            'Nm_PP'   => $PP[0],
            'NIP_PP'  => $PP[1],
            'Nm_Ben'  => $Ben[0],
            'NIP_Ben' => $Ben[1],
            'Nm_Keu'  => $Keu[0],
            'NIP_Keu' => $Keu[1],
            'tb_ulog' => $tb_ulog,
            'Tag'     => $Tag,
        ]);

        Alert::success('Berhasil', "Data berhasil ditembah");
        return redirect()->route("kasawal.index");
    }

    public function editkasawal($id)
    {
        $spi = Tb_spi::where(['id' => $id, 'Tag' => '0'])->first();
        if ($spi != NULL) {
            $data = Tb_spi::where('id',$id)->first();
            $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                        LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                        WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
        } else {
        Alert::warning('', 'Data telah diverifikasi, tidak dapat dilakukan perubahan data');
        return back();
        }

        return view('pengajuan.kasawal.editkasawal',compact('data','pegawai'));
    }

    public function updatekasawal(Request $request, $id)
    {
        // dd($request->all);
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

          Tb_spi::where('id', $id)->update([ 
            'No_SPi'  => $request->No_SPi,
            'Dt_SPi'  => $request->Dt_SPi,
            'Ur_SPi'  => $request->Ur_SPi,
            'Nm_PP'   => $PP[0],
            'NIP_PP'  => $PP[1],
            'Nm_Ben'  => $Ben[0],
            'NIP_Ben' => $Ben[1],
            'Nm_Keu'  => $Keu[0],
            'NIP_Keu' => $Keu[1],
            ]);

        Alert::success('Berhasil', "Data berhasil dirubah");
        return redirect('kasawal');
    }

    public function rincian($id)
    {
        $kasawal = DB::select(DB::raw("SELECT a.*, b.* 
            FROM tb_spi a
            JOIN tb_spirc b 
            on a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            where a.id = '".$id."' && a.Ko_unitstr = '".kd_unit()."' "));
        return view('pengajuan.kasawal.rincian', compact('kasawal'));
    }

    public function viewtambahrincian($id)
    {
        $kasawal = Tb_spi::find($id);
        $kasawalold = DB::select(DB::raw("SELECT a.*, b.spirc_Rp 
            FROM tb_spi a
            LEFT JOIN tb_spirc b 
            on a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            where a.id = '".$id."' && a.Ko_unitstr = '".kd_unit()."' "));
        return view('pengajuan.kasawal.viewtambahrincian', compact('kasawal','kasawalold'));
    }

    public function show($id)
    {
        $log = DB::select("SELECT * FROM tb_logv WHERE id_spi = '".$id."'");
        return view('pengajuan.kasawal.itemlog',compact('log'));
    }

    public function tambahrincian(Request $request)
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $Ko_spirc = '1';
        $No_bp = '001-Kas';
        $Ko_bprc = '1';
        $Ko_Rkk = '01.01.01.03.001.0001';
        $Ko_Pdp = '99';
        $ko_pmed = '99';
        $rftr_bprc = '001-Kas';
        $Ur_bprc = 'Kas di Bendahara Pengeluaran';
        $tb_ulog = 'user';

        $kasawalold = collect(DB::select(DB::raw("SELECT a.*, b.spirc_Rp 
            FROM tb_spi a
            LEFT JOIN tb_spirc b 
            on a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            where b.id_spi = '".$request->id_spi."' && a.Ko_unitstr = '".kd_unit()."' ")))->first();

        $rules = [
            "spirc_Rp" => "required",
          ];
      
          $messages = [
            "spirc_Rp.required" => "Nilai (Rp) wajib diisi.",
          ];
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

        if (!$kasawalold) {

            Tb_spirc::create([          
                'Ko_Period' => $Ko_Period,
                'Ko_unitstr' => $Ko_unitstr,
                'Ko_spirc' => $Ko_spirc,
                'id_spi'     => $request->id_spi,
                'No_spi' => $request->No_spi,        
                'No_bp' => $No_bp,
                'Ko_bprc' => $Ko_bprc,
                'Ko_Rkk' => $Ko_Rkk,
                'Ko_Pdp' => $Ko_Pdp,
                'ko_pmed' => $ko_pmed,
                'rftr_bprc' => $rftr_bprc,
                'dt_rftrbprc' => $request->dt_rftrbprc,
                'Ur_bprc' => $Ur_bprc,
                'spirc_Rp' => $request->spirc_Rp,
                'tb_ulog' => $tb_ulog,
            ]);

        } else {

            Tb_spirc::where('id_spi',$request->id_spi)->update([
                'id_spi'     => $request->id_spi,
                'spirc_Rp' => $request->spirc_Rp,
                'updated_at' => now(),
            ]);
            
        }
        return redirect()->route("kasawal.index");
    }
    
    public function hapusrinciankasawal($id)
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
            $kasawal = Tb_spirc::find($id);
            $kasawal->delete();
            return back();
        }
        
        //dd($satu);  
    }

    public function edit($id)
    {

        $Tag = 0;

        $satu = DB::select(DB::raw('select a.*, b.*
        from tb_spi a
        inner join tb_spirc b 
        on a.No_SPi = b.No_spi && a.Ko_unitstr = b.Ko_unitstr
        where a.Tag = '.$Tag.' and b.id = '.$id));

        if(
            empty($satu)
        ){
            return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
        }else{
            $kasawal = Tb_spirc::find($id);
            return view('pengajuan.kasawal.edit', compact('kasawal'));
        }
       
    }

    public function update(Request $request, $id)
    {
        $kasawal = Tb_spirc::find($id);

        $rules = [
            "spirc_Rp" => "required",
          ];
      
          $messages = [
            "spirc_Rp.required" => "Nilai (Rp) wajib diisi.",
          ];
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
          
        $kasawal->spirc_Rp = $request->spirc_Rp;
        $kasawal->updated_at = now();
        $kasawal->save();
        
        Alert::success('Berhasil', "Data berhasil dirubah");
        return redirect()->route("kasawal.index");
    }

    public function destroy($id)
    {
        // $Tag = 0;

        // if(
        //     $kasawal = DB::select(DB::raw('select a.* 
        //     from tb_spi a
        //     where a.Tag = '.$Tag.' and a.id = '.$id))
        // ){
        //     $kasawal = Tb_spi::find($id);
        //     $kasawalrc = Tb_spirc::where('No_spi',$kasawal)->delete();
        //     $kasawal->delete();
    
        //     return redirect()->route("kasawal.index");
        // }else{
        //     //Alert::success('Yeay!', 'berhasil dihapus');
        //     return back()->with('alert','Data telah diverifikasi, tidak dapat dilakukan perubahan data.');
        //     //return back();
        // }

        $spi = Tb_spi::where(['id' => $id, 'Tag' => '0'])->first();
        if ($spi != NULL) {
            $kasawal = Tb_spi::find($id);
            $kasawalrc = Tb_spirc::where('No_spi',$kasawal)->delete();
            $kasawal->delete();

            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route("kasawal.index");
        }else{
            Alert::warning('', 'Data telah diverifikasi, tidak dapat dilakukan perubahan data');
            return back();
        }

    }

    public function verifikasi(Request $request, $id)
    {
        Tb_spi::where('id',$id)->update([
            'Tag_v' => $request->Tag_v,
        ]);

        Alert::success('Berhasil', 'Data berhasil diajukan verifikasi');
        return redirect()->route('kasawal.index');
    }

    public function sppdup_pdf($id)
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
        $pdf = PDF::loadView('pengajuan.kasawal.sppd_up_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','title'))->setPaper('A4', 'portrait');
        return $pdf->stream('S-PPD UP: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
        
    }
}