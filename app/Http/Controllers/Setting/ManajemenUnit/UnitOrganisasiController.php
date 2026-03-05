<?php

namespace App\Http\Controllers\Setting\ManajemenUnit;

use App\Http\Controllers\Controller;
use App\Models\Tbpemda;
use App\Models\Pfurus;
use App\Models\Pfbid;
use App\Models\Tbunit;
use App\Models\Tbsub;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UnitOrganisasiController extends Controller
{
	private $modul = 'setting';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.manajemen-unit';
    }
	
    public function index(Request $request)
    {
		$pemda = id_pemda();
		$model = collect(DB::select(<<<SQL
                SELECT DISTINCT CASE WHEN Ko_Wil2=0 THEN 1 ELSE 2 END jnspemda		
                FROM tb_pemda
                WHERE id = :id
                SQL, [
        'id' => id_pemda()
        ]))->first();

        return view('setting.manajemen-unit.index', [
			'urusan' => Pfurus::jnspemda($model->jnspemda)->where('Ko_urus', '!=', 0)->get(),
            'bidang' => Pfbid::where('jns_pemda', '=', $model->jnspemda)->where('Ko_urus', '!=', 0)->get(),
            'tabList' => [
				'urusan',
                'bidang',
                'Unit',
                'Sub',
            ]
        ]);
    }

    public function datatable(Request $request)
    { 
        switch ($request->table) {			
            case 'Unit':
                $model = Tbunit::select(['id AS id_unit', 'Ko_Unit', 'Ur_Unit'])->where('id_pemda', id_pemda() ?? 0);
                $info['primaryKey'] = 'id_unit';
                $info['foreignKey'] = 'id_bidang';
                $info['labelName'] = 'Unit';
                $info['hasNext'] = true;
                $info['labelNext'] = 'Sub Unit';
                $info['hasDetail'] = false;
                $info['labelDetail'] = '';
                $info['targetDetail'] = '';
                break;

            case 'Sub':
				$model = Tbsub::select(['id AS id_sub', 'Ko_Sub', 'ur_subunit AS Ur_Sub']);
                $info['primaryKey'] = 'id_sub';
                $info['foreignKey'] = 'tb_sub.id_unit';
                $info['labelName'] = 'Sub Unit';
                $info['hasNext'] = false;
                $info['labelNext'] = '';
                $info['hasDetail'] = false;
                $info['labelDetail'] = '';
                $info['targetDetail'] = '';
                break;

            default:
                return response()->json(['message' => 'Tabel tidak ditemukan.'], 404);
                break;
        }

        if ($request->has('code')) {
            try {
                $id = Crypt::decryptString($request->code);
            } catch (DecryptException $e) {
                return response()->json(['message' => 'Tabel tidak ditemukan.'], 404);
            }

            $model = $model->where($info['foreignKey'], $id);
        }

        return DataTables::of($model)
            ->addColumn('action', function ($model) use ($request, $info) {
                $model->code = Crypt::encryptString($model->{$info['primaryKey']});

                return view($this->view.'.action', [
                    'model' => $model,
                    'table' => $request->table,
                    'info' => $info,
                ])->render();
            })
            ->addColumn('code', function ($model) use ($info) {
                return Crypt::encryptString($model->{$info['primaryKey']});
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->removeColumn($info['primaryKey'])
            ->with([
                'table' => $request->table,
                'code' => $request->code,
            ])
            ->make(true);
    }

    public function form(Request $request)
    {
        $id = 0;
        $foreignId = 0;
        $id_bidang = [];
        $parent = null;
        $pemda = id_pemda();
        $tahun = Tahun();

        if (!$pemda) {
            return response()->json(['message' => 'Data Pemda tidak ditemukan.'], 404);
        }

        if ($request->has('code')) {
            try {
                $id = Crypt::decryptString($request->code);
            } catch (DecryptException $e) {
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
            }
        }

        switch ($request->table) {
			case 'bidang':
                $modelClass = Pfbid::class;
                $foreignClass = Pfurus::class;
                $primaryKey = 'id_bidang';
                $foreignKey = 'id_urus';
                $labelName  = 'Bidang';
                break;
				
            case 'Unit':
                $modelClass = Tbunit::class;
                $foreignClass = Pfbid::class;
                $primaryKey = 'id';
                $foreignKey = 'id_bidang';
                $labelName  = 'Unit';
                break;

            case 'Sub':
                $modelClass = Tbsub::class;
                $foreignClass = Tbunit::class;
                $primaryKey = 'id';
                $foreignKey = 'id_unit';
                $labelName  = 'Sub Unit';
                break;

            default:
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
                break;
        }

        if (in_array($request->action, ['edit', 'delete', 'wizard'])) {
            $model = $modelClass::find($id);

            if (!$model) {
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
            }

            $model->code = Crypt::encryptString($model->{$primaryKey});
            $foreignId = $model->{$foreignKey};
        } else if ($request->action == 'create') {
            $model = new $modelClass();
            $foreignId = $id;
        } else {
            return response()->json(['message' => 'Aksi salah.'], 404);
        }

		if ($request->table == 'Unit') {
            $parent 	= $foreignClass::find($foreignId);
        } 

        $id_bidang 	= Pfbid::select(['id_bidang', DB::raw("CONCAT(pf_bid.Ko_Bid, ') ', Ur_Bid) as nmbidang")])
						->where('pf_bid.id_bidang', '!=', $foreignId);

        return response()->json(['form' => view($this->view.'.form', [
            'action' => $request->action,
            'table' => $request->table,
            'model' => $model,
            'modelClass' => $modelClass,
            'id_pemda' => id_pemda() ?? 0,
            'foreignKey' => $foreignKey,
            'foreignId' => $foreignId,
            'labelName' => $labelName,
            'id_bidang' => $id_bidang,
            'parent' => $parent,
            'tahun' => $tahun,
        ])->render()], 200);
    }

    public function store(Request $request)
    {

         switch ($request->table) {
            case 'Unit':
                $modelClass = Tbunit::class;
                $input = ['Ko_Period', 'id_pemda', 'id_bidang', 'Ko_Unit', 'Ur_Unit'];
                $request->validate([
                    'Ko_Period' => 'required',
                    'Ko_Unit' => [
                        'required',
                        'numeric',
                        Rule::unique('tb_unit')->where(function ($query) use ($request) {
                            return $query->where('id_pemda', $request->id_pemda)
                                ->where('id_bidang', $request->id_bidang)
                                ->where('Ko_Unit', $request->Ko_Unit);
                        }),
                    ],
                    'Ur_Unit' => 'required',
                ], [
                    'Ko_Unit.required' => 'Kode Unit harus diisi.',
                    'Ko_Unit.numeric' => 'Kode Unit hanya terdiri dari angka.',
                    'Ko_Unit.unique' => 'Kode Unit sudah digunakan.',
                    'Ur_Unit.required' => 'Nama Unit harus diisi.',
                    'Ko_Period.required' => 'Tahun Anggaran harus diisi.',
                ]);
                $Ko_Wil1 = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Wil1	
                    FROM tb_pemda
                    WHERE id = :id
                    SQL, [
                'id' => id_pemda()
                ]))->first();

                $Ko_Wil2 = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Wil2	
                    FROM tb_pemda
                    WHERE id = :id
                    SQL, [
                'id' => id_pemda()
                ]))->first();

                $Ko_Urus = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Urus	
                    FROM pf_bid
                    WHERE id_bidang = :id
                    SQL, [
                'id' => $request->id_bidang
                ]))->first();

                $Ko_Bid = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Bid	
                    FROM pf_bid
                    WHERE id_bidang = :id
                    SQL, [
                'id' => $request->id_bidang
                ]))->first();

                $Ko_Unit = collect(DB::select(<<<SQL
                    SELECT DISTINCT $request->Ko_Unit AS Ko_Unit	
                    SQL, [ ]))->first();

                break;

            case 'Sub':
                $modelClass = Tbsub::class;
                $input = ['Ko_Period', 'id_unit', 'Ko_Wil1', 'Ko_Wil2', 'Ko_Urus', 'Ko_Bid', 'Ko_Unit', 'Ko_Sub', 'ur_subunit'];
                $request->validate([
                    'Ko_Period' => 'required',
                    'Ko_Wil1' => 'required',
                    'Ko_Wil2' => 'required',
                    'Ko_Urus' => 'required',
                    'Ko_Bid' => 'required',
                    'Ko_Unit' => 'required',
                    'id_unit' => 'required|exists:tb_unit,id',
                    'Ko_Sub' => [
                        'required',
                        'numeric',
                        Rule::unique('tb_sub')->where(function ($query) use ($request) {
                            return $query->where('id_unit', $request->id_unit)
                                ->where('Ko_Sub', $request->Ko_Sub);
                        }),
                    ],
                    'ur_subunit' => 'required',
                ], [
                    'id_unit.required' => 'Unit harus dipilih.',
                    'id_unit.exists' => 'Unit tidak tersedia.',
                    'Ko_Sub.required' => 'Kode Sub Unit harus diisi.',
                    'Ko_Sub.numeric' => 'Kode Sub Unit hanya terdiri dari angka.',
                    'Ko_Sub.unique' => 'Kode Sub Unit sudah digunakan.',
                    'ur_subunit.required' => 'Nama Sub Unit harus diisi.',
                    'Ko_Period.required' => 'Tahun Anggaran harus diisi.',
                ]);
                $Ko_Wil1 = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Wil1	
                    FROM tb_unit
                    WHERE id = :id
                    SQL, [
                'id' => $request->id_unit
                ]))->first();

                $Ko_Wil2 = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Wil2	
                    FROM tb_unit
                    WHERE id = :id
                    SQL, [
                'id' => $request->id_unit
                ]))->first();

                $Ko_Urus = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Urus	
                    FROM tb_unit
                    WHERE id = :id
                    SQL, [
                'id' => $request->id_unit
                ]))->first();

                $Ko_Bid = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Bid	
                    FROM tb_unit
                    WHERE id = :id
                    SQL, [
                'id' => $request->id_unit
                ]))->first();

                $Ko_Unit = collect(DB::select(<<<SQL
                    SELECT DISTINCT Ko_Unit	
                    FROM tb_unit
                    WHERE id = :id
                    SQL, [
                'id' => $request->id_unit
                ]))->first();

                break;

            default:
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
                break;
        }
        
        $ko_unitstr0 = collect(DB::select(DB::raw("SELECT CONCAT(LPAD('".$Ko_Wil1->Ko_Wil1."',2,0),'.',LPAD('".$Ko_Wil2->Ko_Wil2."',2,0),'.',LPAD('".$Ko_Urus->Ko_Urus."',2,0),
        '.',LPAD('".$Ko_Bid->Ko_Bid."',2,0),'.',LPAD('".$Ko_Unit->Ko_Unit."',2,0),'.',LPAD('".$request->Ko_Sub."',3,0)) AS ko_unitstr")))->first();

        $create = $request->only($input);

		$model = $modelClass::create($create);  
       

        if( $modelClass == Tbsub::class ) { 
            $model->Ko_Period   	= $request->Ko_Period ?? Tahun();
            $model->Ko_Wil1     	= $Ko_Wil1->Ko_Wil1 ?? 0;
            $model->Ko_Wil2      	= $Ko_Wil2->Ko_Wil2 ?? 0;
            $model->Ko_Urus      	= $Ko_Urus->Ko_Urus ?? 0;
            $model->Ko_Bid       	= $Ko_Bid->Ko_Bid ?? 0;
            $model->Ko_Unit       	= $Ko_Unit->Ko_Unit ?? 0;
            $model->Ko_unitstr      = $ko_unitstr0->ko_unitstr;
            $model->save();
        } else {
            $model->Ko_Period   	= $request->Ko_Period ?? Tahun();
            $model->Ko_Wil1     	= $Ko_Wil1->Ko_Wil1 ?? 0;
            $model->Ko_Wil2      	= $Ko_Wil2->Ko_Wil2 ?? 0;
            $model->Ko_Urus      	= $Ko_Urus->Ko_Urus ?? 0;
            $model->Ko_Bid       	= $Ko_Bid->Ko_Bid ?? 0;
            $model->Ko_Unit       	= $Ko_Unit->Ko_Unit ?? 0;
            $model->save();
        }

        return response()->json(['message' => 'Data berhasil dibuat.'], 201);
    }


    public function update(Request $request, $code)
    {
        $tahun = $request->session()->get('tahun_anggaran');


        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        switch ($request->table) {
            case 'Unit':
                $model = Tbunit::find($id);

                if (!$model) {
                    return response()->json(['message' => 'Data tidak ditemukan.'], 404);
                }

                $request->validate([
                    'Ko_Unit' => [
                        'required',
                        'numeric',
                        Rule::unique('tb_unit')->ignore($id, 'id')->where(function ($query) use ($request, $model) {
                            return $query->where('id_pemda', $model->id_pemda)
                                ->where('id_bidang', $model->id_bidang)
								->where('Ko_Unit', $request->Ko_Unit);
                        }),
                    ],
                    'Ur_Unit' => 'required',
                ], [
                    'Ko_Unit.required' => 'Kode Unit harus diisi.',
                    'Ko_Unit.numeric' => 'Kode Unit hanya terdiri dari angka.',
                    'Ko_Unit.unique' => 'Bidang dan Kode Unit yang sama sudah digunakan.',
                    'Ur_Unit.required' => 'Nama Unit harus diisi.',
                ]);
                $model->Ko_Unit = $request->Ko_Unit;
                $model->Ur_Unit = $request->Ur_Unit;
                break;

            case 'Sub':
                $model = Tbsub::find($id);

                if (!$model) {
                    return response()->json(['message' => 'Data tidak ditemukan.'], 404);
                }

                $request->validate([
                    'Ko_Sub' => [
                        'required',
                        'numeric',
                        Rule::unique('tb_sub')->ignore($id, 'id')->where(function ($query) use ($request, $model) {
                            return $query->where('id_unit', $model->id_unit)
                                ->where('Ko_Sub', $request->Ko_Sub);
                        }),
                    ],
                    'ur_subunit' => 'required',
                ], [
                    'Ko_Sub.required' => 'Kode Sub Unit harus diisi.',
                    'Ko_Sub.numeric' => 'Kode Sub Unit hanya terdiri dari angka.',
                    'Ko_Sub.unique' => 'Unit dan Kode Sub Unit yang sama sudah digunakan.',
                    'ur_subunit.required' => 'Nama Sub Unit harus diisi.',
                ]);

                $model->Ko_Sub = $request->Ko_Sub;
                $model->ur_subunit = $request->ur_subunit;
                break;


            default:
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
                break;
        }

        $model->save();

        return response()->json(['message' => 'Data berhasil diubah.'], 200);
    }


    public function destroy(Request $request, $code)
    {

        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        switch ($request->table) {
            case 'Unit':
                $model = Tbunit::find($id);
                break;

            case 'Sub':
                $model = Tbsub::find($id);
                break;

            default:
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
                break;
        }

        if (!$model) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        if ($model->hasRelation()) {
            return response()->json(['message' => 'Data tidak dapat dihapus karena sudah digunakan.'], 403);
        }

        $model->delete();

        return response()->json(['message' => 'Data berhasil dihapus.'], 200);
    }

    public function wizard(Request $request, $code)
    {
        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $pemda = Tbpemda::first();

        $request->validate([
            'Ko_Unit' => [
                'required',
                'numeric',
                Rule::unique('tb_unit')->where(function ($query) use ($request, $pemda, $id) {
                    return $query->where('id_pemda', $pemda->id_pemda ?? 0)
                        ->where('id_bidang', $id)
                        ->where('Ko_Unit', $request->Ko_Unit);
                }),
            ],
            'Ur_Unit' => 'required',
            
            'unit.*.Ko_Unit' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    $tahun = collect($request->unit)->where('Ko_Unit', $value)->pluck('tahun')->toArray();

                    if (count($tahun) > count(array_unique($tahun))) {
                        $fail('Kode Unit yang sama sudah digunakan.');
                    }
                },
            ],
            'unit.*.Ur_Unit' => 'required',
        ], [

            'unit.*.Ko_Unit.required' => 'Kode Unit harus diisi.',
            'unit.*.Ko_Unit.numeric' => 'Kode Unit hanya terdiri dari angka.',
            'unit.*.Ur_Unit.required' => 'Nama Unit harus diisi.',
        ]);


        return response()->json(['message' => 'Data berhasil dibuat.'], 201);
    }


    public function selectUnit(Request $request, $id = null)
    {
        $unit = Tbunit::query();

        if (!is_null($id)) {
            $unit = $unit->where('id_bidang', $id);
        }

        return response()->json(['unit' => $unit->getSelect2()], 200);
    }

    public function datatableBidang(Request $request, $id = null)
    {
        $model = PfBid::query();

        return DataTables::of($model->select([
                'pf_bid.id',
                'pf_bid.Ko_Bid',
                'pf_bid.Ur_Bid',
            ]))
            ->addColumn('action', function ($model) {
                return '<button type="button" class="btn btn-success btn-xs select-bidang" data-id="'.$model->id.'" data-uraian="'.$model->Ur_Bid.'"><i class="fa fa-check"></i> Pilih</button>';
            })
            ->addColumn('Ko_Bid', function ($model) {
                return $model->Ko_Bid;
            })
            ->setRowClass('row-bidang curs-point')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->removeColumn(['id'])
            ->make(true);
    }
}
