<?php

namespace App\Http\Controllers\Setting\ManajemenPemda;

use App\Http\Controllers\Controller;
use App\Models\Pfwil2;
use App\Models\Tbpemda;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;



class MasterPemdaController extends Controller
{
   
    public function index(Request $request)
    {
        return view('setting.manajemen-pemda.index');
    }

    public function datatable(Request $request)
    { 
                
        $pemda = DB::SELECT("SELECT (@id:=@id+1) AS kdurut, a.* FROM(
                    SELECT c.id AS id_pemda, concat(a.Ko_Wil1,'.',right(concat('0',a.Ko_Wil2),2)) AS kode_pemda, a.Ur_Wil2 AS nama_kab, c.ibukota, 
                    b.Ko_Wil1 AS id_prov, b.Ur_Wil1 AS nama_prov, concat(b.Ko_Wil1,' - ', 'PROVINSI ',b.Ur_Wil1) AS nama_prov_display
                    FROM pf_wil2 a 
                    INNER JOIN pf_wil1 b on a.Ko_Wil1 = b.Ko_Wil1 
                    INNER JOIN tb_pemda c on a.id = c.id_kabkota
                    ORDER BY a.Ko_Wil1, a.Ko_Wil2 ) a, (SELECT @id:=0) b  ");

        return Datatables::of($pemda)
        ->addColumn('action', function ($pemda) {
            $pemda->code = Crypt::encryptString($pemda->id_pemda);

            return view('setting.manajemen-pemda.action', compact('pemda'));
        })
        ->rawColumns(['action'])
        ->removeColumn('id_pemda')
        ->addIndexColumn()
        ->make(true);
    }

    public function form(Request $request, $code = null)
    {
        $id = 0;
		$tahun = Tahun();

        if ($code) {
            try {
                $id = Crypt::decryptString($code);
            } catch (DecryptException $e) {
                return response()->json(['message' => 'Pemda tidak ditemukan.'], 404);
            }
        }

        if (in_array($request->action, ['edit', 'delete'])) {
            $pemda = Tbpemda::find($id);

            $pemda->code = Crypt::encryptString($pemda->id);
        } else if ($request->action == 'create') {
            $pemda = new Tbpemda();
        } else {
            return response()->json(['message' => 'Aksi salah.'], 404);
        }

        return response()->json(['form' => view('setting.manajemen-pemda.form', [
            'action' => $request->action,
            'pemda' => $pemda,
			'kabkotanew' => Pfwil2::PemdaAktif(),
            'kabkotaold' => Pfwil2::getSelect2(),
            'tahun' => $tahun,
        ])->render()], 200);
    }

    public function store(Request $request)
    {
        $input = ['id_kabkota', 'Ibukota', 'Ur_Kpl', 'Ur_Sekda', 'Ur_PPKD'];
        $request->validate([
            'id_kabkota' => 'required',
            'Ibukota' => 'required',
            'Ur_Kpl' => 'required',
            'Ur_Sekda' => 'required',
            'Ur_PPKD' => 'required',
        ], [
            'id_kabkota.required' => 'Kode Pemda harus dipilih.',
            'Ibukota.required' => 'Nama Ibukota harus diisi.',
            'Ur_Kpl.required' => 'Nama Kepala Daerah harus diisi.',
            'Ur_Sekda.required' => 'Nama Sekretaris Daerah harus diisi.',
            'Ur_PPKD.required' => 'Nama PPKD harus diisi.',
        ]);

        $Ko_Wil1 = collect(DB::select(<<<SQL
            SELECT DISTINCT Ko_Wil1	
            FROM pf_wil2
            WHERE id = :id
            SQL, [
        'id' => $request->id_kabkota
        ]))->first();

        $Ko_Wil2 = collect(DB::select(<<<SQL
            SELECT DISTINCT Ko_Wil2	
            FROM pf_wil2
            WHERE id = :id
            SQL, [
        'id' => $request->id_kabkota
        ]))->first();

        $Ur_pemda = collect(DB::select(<<<SQL
            SELECT DISTINCT Ur_Wil2	
            FROM pf_wil2
            WHERE id = :id
            SQL, [
        'id' => $request->id_kabkota
        ]))->first();

        $create = $request->only($input);

		$model = Tbpemda::create($create);      

        $model->Ko_Period   	= Tahun();
        $model->Ko_Wil1     	= $Ko_Wil1->Ko_Wil1 ?? 0;
		$model->Ko_Wil2      	= $Ko_Wil2->Ko_Wil2 ?? 0;
        $model->Ur_pemda      	= $Ur_pemda->Ur_Wil2 ?? 0;
        $model->save();

        return response()->json(['message' => 'Pemerintah Daerah berhasil dibuat.'], 201);
    }

    public function update(Request $request, $code)
    {

        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Data Pemda tidak ditemukan.'], 404);
        }

        $request->validate([
            'Ibukota' => 'required',
            'Ur_Kpl' => 'required',
            'Ur_Sekda' => 'required',
            'Ur_BUD' => 'required',
        ], [
            'Ibukota.required' => 'Nama Ibukota Kabupaten/Kota wajib diisi.',
            'Ur_Kpl.required' => 'Nama Kepala Daerah wajib diisi.',
            'Ur_Sekda.required' => 'Nama Sekretaris Daerah wajib diisi.',
            'Ur_BUD.required' => '"Nama BUD wajib diisi.',
        ]);

        $pemda = Tbpemda::find($id);

        if (!$pemda) {
            return response()->json(['message' => 'Data Pemda tidak ditemukan.'], 404);
        }

        $pemda->Ibukota     = $request->Ibukota;
        $pemda->Ur_Kpl      = $request->Ur_Kpl;
        $pemda->Ur_Sekda    = $request->Ur_Sekda;
        $pemda->Ur_PPKD     = $request->Ur_BUD;
        $pemda->Ur_BUD      = $request->Ur_BUD;
        $pemda->save();

        return response()->json(['message' => 'Data Pemda berhasil disimpan.'], 200);
    }

    public function destroy($code)
    {
  
        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $pemda = Tbpemda::find($id);

        if (!$pemda) {
            return response()->json(['message' => 'Data Pemda tidak ditemukan.'], 404);
        }

        $pemda->delete();

        return response()->json(['message' => 'Data Pemda berhasil dihapus.'], 200);
    }

    public function pemda(Request $request)
    {
        return response()->json(['pemda' => Tbpemda::getSelect2($request->Ko_Wil1)], 200);
    }

}
