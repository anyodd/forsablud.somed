<?php

namespace App\Http\Controllers\Transaksi\Belanja\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbyr;
use App\Models\Tbbprc;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class PembayaranController extends Controller
{
    public function index()
    {
        $data  = DB::select("SELECT a.nm_BUcontr,a.id_bp,c.*,SUM(b.To_Rp) total FROM tb_bp a
                JOIN tb_bprc b ON a.id_bp = b.id_bp
                LEFT JOIN tb_byr c ON b.id_bprc = c.id_bprc
                WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."' && a.Ko_bp = 4 && c.id_byr IS NOT NULL
                GROUP BY a.id_bp ORDER BY a.dt_bp DESC");

        $rincian = Tbbyr::all();

        return view('transaksi.belanja.pembayaran.index', compact('data','rincian'));
    }

    public function v_bulan(Request $request,$id)
    {
        $bulan = $id;
        $request->session()->put('bulan', $bulan);

        $data  = DB::select("SELECT a.nm_BUcontr,a.id_bp,c.*,SUM(b.To_Rp) total FROM tb_bp a
                JOIN tb_bprc b ON a.id_bp = b.id_bp
                LEFT JOIN tb_byr c ON b.id_bprc = c.id_bprc
                WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."' && a.Ko_bp = 4 && c.id_byr IS NOT NULL
                GROUP BY a.id_bp ORDER BY a.dt_bp DESC");

        return view('transaksi.belanja.pembayaran.index', compact('data','bulan'));
    }

    public function create()
    {
        $data  = DB::select("SELECT a.*,SUM(b.To_Rp) total FROM tb_bp a
                        JOIN tb_bprc b ON a.id_bp = b.id_bp
                        LEFT JOIN tb_byr c ON b.id_bprc = c.id_bprc
                        LEFT JOIN tb_spirc d ON a.No_bp = d.No_bp && a.Ko_Period = d.Ko_Period && LEFT(a.Ko_unit1,18) = d.Ko_unitstr
                        WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."' && a.Ko_bp = 4 && c.id_byr IS NULL && d.id IS NULL
                        GROUP BY a.id_bp");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
                    
        return view('transaksi.belanja.pembayaran.create',compact('data','pegawai'));
    }

    public function tambah($id)
    {
        $data = Tbbprc::where('id_bprc',$id)->first();
        $cekbyr = Tbbyr::where('id_bprc',$id)->first();

        if(empty($cekbyr)){
            return view('transaksi.belanja.pembayaran.create', compact('data'));
        }else{
            Alert::error('Tidak Dapat Melakukan Penambahan Data', "Data Sudah Tersedia");
            return back();   
        }
    }


    public function store(Request $request)
    {
        $rules = [
          'id_bp' => 'required',
        ];
      
        $messages = [
          'id_bp.required' => 'Data tagihan belum dipilih !!',
        ];
      
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $up = DB::select("SELECT a.id FROM tb_spirc a 
          WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.No_bp = '001-Kas' && a.Ko_Rkk = '01.01.01.03.001.0001'");
        if (empty($up)) {
            Alert::warning('Gagal', "Data Uang Persediaan (UP) belum ada !!");
            return redirect()->route("pembayaran.index");
        } else {
            $bprc = Tbbprc::where('id_bp',$request->id_bp)->get();
            foreach ($bprc as $key => $value) {
                Tbbyr::create([
                    'id_bprc'    => $value->id_bprc,
                    'Ko_Period'  => Tahun(),
                    'Ko_unitstr' => kd_unit(),
                    'No_byr'     => $request->No_byr,
                    'dt_byr'     => $request->dt_byr,
                    'Ur_byr'     => $request->Ur_byr,
                    'No_bp'      => $value->No_bp,
                    'Ko_bprc'    => $value->Ko_bprc,
                    'real_rp'    => inrupiah($value->To_Rp),
                    'ko_kas'     => $request->ko_kas,
                    'Ko_Bank'    => '1',
                    'Nm_Byr'     => $request->Nm_Byr,
                    'Tag'        => '0',
                    'tb_ulog'    => getUser('username'),
                ]);
            }

            $bulan = Carbon::parse($request->dt_byr)->format('m');
            
            Alert::success('Berhasil', "Data Berhasil Ditambah");
            return redirect()->route('pembayaran.bulan',$bulan);
        }
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
        $rows = DB::select("SELECT c.id_byr FROM tb_bp a
                JOIN tb_bprc b ON a.id_bp = b.id_bp
                LEFT JOIN tb_byr c ON b.id_bprc = c.id_bprc
                WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."' && a.id_bp= '".$id."'");
        $id_byr = collect($rows)->pluck('id_byr');
        Tbbyr::destroy($id_byr->toArray());

        Alert::success('Berhasil', "Data Berhasil Dihapus");
        return redirect()->route('pembayaran.bulan',$bulan);
    }

    public function rincian($id)
    {
        $realisasi = Tbbyr::where('id_bprc',$id)->get();

        return view('transaksi.belanja.pembayaran.rincian', compact( 'realisasi'));
    }

}
