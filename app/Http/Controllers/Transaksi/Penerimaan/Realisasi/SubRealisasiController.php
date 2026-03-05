<?php

namespace App\Http\Controllers\Transaksi\Penerimaan\Realisasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tbbyr; 
use RealRashid\SweetAlert\Facades\Alert;


class SubRealisasiController extends Controller
{
    public function index()
    {
        $realisasi = Tbbyr::orderBy('id_byr')->orderBy('Ko_Period')->get();
        return view('transaksi.penerimaan.subrealisasi.index', compact('realisasi'));
    }

    public function create()
    {
        $realisasi = Tbbyr::all();
        return view('transaksi.penerimaan.create', compact('realisasi'));
    }

    public function tambah()
    {
        $realisasi = Tbbyr::all();
        return view('transaksi.penerimaan.create', compact('realisasi'));
    }

    public function store(Request $request)
    {
        //
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
        $no_byr = DB::select(DB::raw('select a.No_byr, a.id_byr , b.No_byr, b.id_sts
                                        from tb_byr a
                                        right join tb_stsrc b
                                        On a.No_byr = b.No_byr
                                        where a.id_byr='.$id));  
        if(empty($no_byr)){
            $data = Tbbyr::where('id_byr',$id);
            $data->delete();

            Alert::success('Berhasil', "Detail Realisasi berhasil dihapus");
            return redirect('realisasi');
        }else{
            Alert::error('Terdapat Data STS', "Rincian Realisasi Tidak Dapat Dihapus");
            return back();

            }
    }
}
