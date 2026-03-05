<?php

namespace App\Http\Controllers\Setting\ManajemenRekening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pfbid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class MasterRekeningController extends Controller
{
    private $modul = 'setting';
    private $view;
    private $tabList;
    private $addRk;

    public function __construct()
    {
        $this->tabList = [
            'Rk1' => 'Akun',
            'Rk2' => 'Kelompok',
            'Rk3' => 'Jenis',
            'Rk4' => 'Objek',
            'Rk5' => 'Rincian Objek',
            'Rk6' => 'Sub Rincian Objek',
        ];
        $this->addRk = [
            '1' => [
                'parentRk' => '1',
                'lastRk' => 0,
                'edit' => false, // edit existing
                'delete' => false, // delete existing
            ],
            '2' => [
                'parentRk' => '2',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
			'3' => [
                'parentRk' => '3',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
			'4' => [
                'parentRk' => '4',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
			'5' => [
                'parentRk' => '5',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
			'6' => [
                'parentRk' => '6',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
			'7' => [
                'parentRk' => '7',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
			'8' => [
                'parentRk' => '8',
                'lastRk' => 0,
                'edit' => true, // edit existing
                'delete' => false, // delete existing
            ],
        ];
        $this->view = $this->modul . '.manajemen-rekening';
    }

    public function index()
    {
        return view('setting.manajemen-rekening.index', [
            'tabList' => $this->tabList,
        ]);
    }

    public function datatable(Request $request)
    {
        $tahun = Tahun();
        $id_bidang = $request->id_bidang;
        $info = [
            'nextLabel' => '',
            'parentRk' => '',
            'addRk' => $this->addRk,
            'level' => $request->level,
            'addRkKeys' => array_keys($this->addRk),
        ];
        $hasNext = false;
        $btnAdd = false;

        if ( $info['level'] < 6) {
        $model = DB::table('pf_rk' . $info['level'])
            ->select(['Ko_Period', 'Ko_Rk' . $info['level'], 'Ur_Rk' . $info['level'], 'id_bidang'])
            ->where('Ko_Period', $tahun);
        } else {
          $model = DB::table('pf_rk' . $info['level'])
            ->select(['Ko_Period', 'Ko_Rk' . $info['level'], 'Ur_Rk' . $info['level'], 'id_bidang'])
            //->where('id_bidang', $id_bidang)
            ->where('Ko_Period', $tahun);  
        }

        if ($request->has('kode')) {
            for ($i = 1; $i < $info['level']; $i++) {
                $key = 'Rk' . $i;
                $kode = $request->kode[$key];
                $model = $model->where('Ko_' . $key, $kode);

                if ($info['parentRk']) {
                    $info['parentRk'] .= '.' . $kode;
                } else {
                    $info['parentRk'] .= $kode;
                }

                if (in_array($info['parentRk'], $info['addRkKeys'])) {
                    $nextRk = 'Rk' . ($i + 1);

                    if (array_key_exists($nextRk, $request->kode)) {
                        $currentRk = $request->kode[$nextRk];

                        if ($currentRk > $info['addRk'][$info['parentRk']]['lastRk']) {
                            $btnAdd = true;
                        }
                    } else {
                        $btnAdd = true;
                    }
                }
            }
        }

        if ($btnAdd) {
            $route = route($this->view . '.form', ['Ko_Rk' => $info['parentRk']]);
            $btnAdd = <<<HTML
                <a href="$route" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" data-action="create" title="Tambah Rekening">
                    <i class="fas fa-plus"></i> Tambah Rekening
                </a>
            HTML;
        }

        foreach ($this->tabList as $key => $label) {
            if ($hasNext) {
                $info['nextLabel'] = $label;
                break;
            }

            if ($key == 'Rk' . $info['level']) {
                $hasNext = true;
            }
        }

        return DataTables::of($model)
            ->addColumn('action', function ($model) use ($info) {
                $Ko_Rk = $model->{'Ko_Rk' . $info['level']};
                $Rk = explode('.', $info['parentRk']);
                // $canEdit = false;
                // $canDelete = false;
                $info['parentRk'] = '';

                foreach ($Rk as $key => $kode) {
                    if ($info['parentRk']) {
                        $info['parentRk'] .= '.' . $kode;
                    } else {
                        $info['parentRk'] .= $kode;
                    }

                    if (in_array($info['parentRk'], $info['addRkKeys'])) {
                        if (array_key_exists($key + 1, $Rk)) {
                            $currentRk = $Rk[$key + 1];
                        } else {
                            $currentRk = $Ko_Rk;
                        }

                        // if ($currentRk <= $info['addRk'][$info['parentRk']]['lastRk']) {
                        //     $canEdit = $info['canEdit'] && $info['addRk'][$info['parentRk']]['edit'];
                        //     $canDelete = $info['canDelete'] && $info['addRk'][$info['parentRk']]['delete'];
                        // } else {
                        //     $canEdit = $info['canEdit'];
                        //     $canDelete = $info['canDelete'];
                        // }
                    }
                }

                // $info['canEdit'] = $canEdit;
                // $info['canDelete'] = $canDelete;

                return view($this->view . '.action', [
                    'model' => $model,
                    'Ko_Rk' => $Ko_Rk,
                    'info' => $info,
                ])->render();
            })
            ->addIndexColumn()
            ->with([
                'btnAdd' => $btnAdd,
            ])
            ->make(true);
    }

    public function form(Request $request, $Ko_Rk)
    {
        $idbidang = [];
        $arrRk = explode('.', $Ko_Rk);
        $lvlRk = count($arrRk);

        if ($request->action == 'create') {
            $lvlRk++;
            $model = DB::table('pf_rk' . $lvlRk)
                ->select([
                    DB::raw('Ko_Rk' . $lvlRk . '+ 1 as Ko_Rk'),
                    DB::raw('null as Ur_Rk'),
                ])
                ->orderBy('Ko_Rk', 'desc');
        } else {
            $model = DB::table('pf_rk' . $lvlRk)
                ->select([
                    DB::raw('Ko_Rk' . $lvlRk . ' as Ko_Rk'),
                    DB::raw('Ur_Rk' . $lvlRk . ' as Ur_Rk'),
                ]);
        }

        $model = $model->where('Ko_Period', Tahun());

        foreach ($arrRk as $key => $value) {
            $model = $model->where('Ko_Rk' . ($key + 1), $value);
        }

    $jnspemda = collect(DB::select(<<<SQL
            SELECT DISTINCT CASE WHEN Ko_Wil2=0 THEN 1 ELSE 2 END jnspemda		
            FROM tb_pemda
            WHERE id = :id
            SQL, [
    'id' => id_pemda()
    ]))->first();

    $idbidang = Pfbid::select(['id_bidang', DB::raw("CONCAT(Ko_Urus, '.', Ko_Bid, ') ', Ur_Bid) AS Ur_Bid")])
				->where('jns_pemda', $jnspemda->jnspemda)
				->getSelect2();


        return response()->json(['form' => view($this->view . '.form', [
            'Ko_Rk' => $Ko_Rk,
            'model' => $model->first(),
            'action' => $request->action,
            'idbidang' => $idbidang,
        ])->render()], 200);
    }

    private function validateUniqueRekening($newidbidang, $Ko_Rk, $newKo_Rk, $action)
    {
        $arrRk = explode('.', $Ko_Rk);
        $lvlRk = count($arrRk);
        $model = DB::table('pf_rk' . $lvlRk)->where('Ko_Period', Tahun());
 
        foreach ($arrRk as $key => $value) {
            $level = $key + 1;
            $columnKo_Rk = 'Ko_Rk' . $level;
			$idbidang_Rk = 'id_bidang';

            if ($level == count($arrRk) && $action != 'create') {
                $model = $model->where($idbidang_Rk, $newidbidang)
							   ->where($idbidang_Rk, '!=', $newidbidang)
							   ->where($columnKo_Rk, $newKo_Rk)
                               ->where($columnKo_Rk, '!=', $value);
            } else {
                $model = $model->where($idbidang_Rk, $newidbidang)
							   ->where($columnKo_Rk, $value);
            }
        }

        if ($model->exists()) {
            throw ValidationException::withMessages([
                'Ko_Rk' => ['Kode Rekening sudah digunakan.'],
            ]);
        }
    }

    public function store(Request $request, $Ko_Rk)
    {
        $request->validate([
            'Ko_Rk' => ['required'],
            'Ur_Rk' => ['required'],
			'id_bidang' => ['required'],
        ], [
            'Ko_Rk.required' => 'Kode Rekening harus diisi.',
            'Ur_Rk.required' => 'Nama Rekening harus diisi.',
			'id_bidang.required' => 'Kode Bidang harus dipilih.',
        ]);
        $this->validateUniqueRekening($request->id_bidang, $Ko_Rk . '.' . $request->Ko_Rk, $request->Ko_Rk, 'create');

        // for ($i = 2; $i <= $request->level; $i++) {
        //     if ($i == 2) {
        //         $kode_rekening = COLLECT(DB::SELECT("SELECT CONCAT(Ko_Rk1, '.', Ko_Rk2) AS Ko_rek FROM pf_rk2 WHERE "))->first();
        //     } else if ($i == 3) {
        //         $kode_rekening = COLLECT(DB::SELECT("SELECT CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2)) AS Ko_rek FROM pf_rk3 "))->first();
        //     } else if ($i == 4) {
        //         $kode_rekening = COLLECT(DB::SELECT("SELECT CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2)) AS Ko_rek FROM pf_rk3"))->first();
        //     } else if ($i == 5) {
        //         $kode_rekening = COLLECT(DB::SELECT("SELECT CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2), '.', RIGHT(CONCAT('0', Ko_Rk5), 2)) AS Ko_rek FROM pf_rk3"))->first();
        //     } else {
        //         $kode_rekening = COLLECT(DB::SELECT("SELECT CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2), '.', RIGHT(CONCAT('0', Ko_Rk5), 2), '.', RIGHT(CONCAT('000', Ko_Rk6), 4)) AS Ko_rek FROM pf_rk3"))->first();
        //     }
        // }

        $arrRk = explode('.', $Ko_Rk);
        $lvlRk = count($arrRk) + 1;
        $input = [
            'Ko_Period' => Tahun(),
            'Ko_Rk' . $lvlRk => $request->Ko_Rk,
            'Ur_Rk' . $lvlRk => $request->Ur_Rk,
            'created_at' => now(),
            'updated_at' => now(),
			'id_bidang' => $request->id_bidang,
        ];

        foreach ($arrRk as $key => $value) {
            $input['Ko_Rk' . ($key + 1)] = $value;
        }
        
        DB::table('pf_rk' . $lvlRk)->insert($input);
        return response()->json(['message' => 'Rekening berhasil dibuat.'], 201);
    }

    public function update(Request $request, $Ko_Rk)
    {
        $request->validate([
            'Ko_Rk' => ['required'],
            'Ur_Rk' => ['required'],
			'id_bidang' => ['required'],
        ], [
            'Ko_Rk.required' => 'Kode Rekening harus diisi.',
            'Ur_Rk.required' => 'Nama Rekening harus diisi.',
			'id_bidang.required' => 'Kode Bidang harus dipilih.',
        ]);
        $this->validateUniqueRekening($request->id_bidang, $Ko_Rk, $request->Ko_Rk, 'edit');

        $arrRk = explode('.', $Ko_Rk);
        $lvlRk = count($arrRk);
        
        $input = [
            'Ko_Rk' . $lvlRk => $request->Ko_Rk,
            'Ur_Rk' . $lvlRk => $request->Ur_Rk,
			'id_bidang' => $request->id_bidang,
        ];
        $model = DB::table('pf_rk' . $lvlRk)->where('Ko_Period', Tahun());

        foreach ($arrRk as $key => $value) {
            $model = $model->where('Ko_Rk' . ($key + 1), $value);
        }

        $model->update($input);

        return response()->json(['message' => 'Rekening berhasil diubah.'], 200);
    }

    public function destroy(Request $request, $Ko_Rk)
    {
        $arrRk = explode('.', $Ko_Rk);
        $lvlRk = count($arrRk);
        $model = DB::table('pf_rk' . $lvlRk)->where('Ko_Period', Tahun());
        
        foreach ($arrRk as $key => $value) {
            $model = $model->where('Ko_Rk' . ($key + 1), $value);
        }

        DB::beginTransaction();

        try {
            $model->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            info($th->getMessage());

            throw ValidationException::withMessages([
                'Ko_Rk' => ['Rekening tidak dapat dihapus karena sudah digunakan.'],
            ]);
        }

        return response()->json(['message' => 'Rekening berhasil dihapus.'], 200);
    }

    public function export(Request $request)
    {
        $tahun = Tahun();

        $model = DB::table('pf_rk1')
            ->select(DB::raw("
                Ko_Rk1 AS Ko_Rk,
                Ur_Rk1 AS Ur_Rk,
                null AS saldo_normal
            "))
            ->where('Ko_Period', $tahun);

        for ($i = 2; $i <= $request->level; $i++) {
            if ($i == 2) {
                $Ko_Rk = DB::table('pf_rk2')
                    ->select(DB::raw("
                        CONCAT(Ko_Rk1, '.', Ko_Rk2) AS Ko_Rk,
                        Ur_Rk2 AS Ur_Rk,
                        null AS saldo_normal
                    "))
                    ->where('Ko_Period', $tahun);
            } else if ($i == 3) {
                $Ko_Rk = DB::table('pf_rk3')
                    ->select(DB::raw("
                        CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2)) AS Ko_Rk,
                        Ur_Rk3 AS Ur_Rk,
                        SN_rk3 AS saldo_normal
                    "))
                    ->where('Ko_Period', $tahun);
            } else if ($i == 4) {
                $Ko_Rk = DB::table('pf_rk4')
                    ->select(DB::raw("
                        CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2)) AS Ko_Rk,
                        Ur_Rk4 AS Ur_Rk,
                        null AS saldo_normal
                    "))
                    ->where('Ko_Period', $tahun);
            } else if ($i == 5) {
                $Ko_Rk = DB::table('pf_rk5')
                    ->select(DB::raw("
                        CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2), '.', RIGHT(CONCAT('0', Ko_Rk5), 2)) AS Ko_Rk,
                        Ur_Rk5 AS Ur_Rk,
                        null AS saldo_normal
                    "))
                    ->where('Ko_Period', $tahun);
            } else {
                $Ko_Rk = DB::table('pf_rk6')
                    ->select(DB::raw("
                        CONCAT(Ko_Rk1, '.', Ko_Rk2, '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2), '.', RIGHT(CONCAT('0', Ko_Rk5), 2), '.', RIGHT(CONCAT('000', Ko_Rk6), 4)) AS Ko_Rk,
                        Ur_Rk6 AS Ur_Rk,
                        null AS saldo_normal
                    "))
                    ->where('Ko_Period', $tahun);
            }

            $model = $model->unionAll($Ko_Rk);
        }

        $model = $model->orderBy('Ko_Rk', 'asc')->get();

        $view = $this->view . '.export';
        $param = [
            'title' => 'KODE REKENING AKRUAL',
            'Rekening' => $model,
            'type' => $request->type,
        ];

        switch ($request->type) {
            // case 'excel':
            //     return Excel::download(new RekeningExport($view, $param), 'Rekening.xlsx');
            //     break;

            case 'pdf':
                $pdf = PDF::loadView($view, $param)->setPaper('A4', 'Potret');
                return $pdf->stream('Rekening.pdf',  array("Attachment" => false));
                break;

            default:
                return 'Invalid export type.';
                break;
        }
    }

    public function datatableRekening(Request $request)
    {
        $tahun = Tahun();

        if ($request->tahun) {
            $tahun = $request->tahun;
        }

        if ($request->level) {
            $table = 'pf_rk' . $request->level;
            $Ur_Rk = $table . '.' . 'Ur_Rk' . $request->level;
            $select = ['Ko_Period'];
            $concat = '';

            for ($i = 1; $i <= 6; $i++) {
                if ($i <= $request->level) {
                    $Ko_Rk = $table . '.' . 'Ko_Rk' . $i;
                    $select[] = $Ko_Rk;

                    if ($i > 1) {
                        $concat .= ", '.', ";
                    }

                    $concat .= $Ko_Rk;
                } else {
                    $select[] = DB::raw("null as " . "Ko_Rk" . $i);
                }
            }

            $select[] = DB::raw("CONCAT(" . $concat . ") AS Ko_Rk");
            $select[] = $Ur_Rk . ' as Ur_Rk';
            $Ko_Rk = DB::table($table)->select($select);
        } else {
            $table = 'pf_rk6';
            $Ko_Rk = DB::table('pf_rk6')
                ->select([
                    'pf_rk6.Ko_Period',
                    'pf_rk6.Ko_Rk1',
                    'pf_rk6.Ko_Rk2',
                    'pf_rk6.Ko_Rk3',
                    'pf_rk6.Ko_Rk4',
                    'pf_rk6.Ko_Rk5',
                    'pf_rk6.Ko_Rk6',
                    DB::raw("CONCAT(pf_rk6.Ko_Rk1, '.', pf_rk6.Ko_Rk2, '.', pf_rk6.Ko_Rk3, '.', pf_rk6.Ko_Rk4, '.', pf_rk6.Ko_Rk5, '.', pf_rk6.Ko_Rk6) AS Ko_Rk"),
                    'pf_rk6.Ur_Rk6 AS Ur_Rk',
                ]);

            if ($request->exclude_table) {
                $Ko_Rk = $Ko_Rk->leftJoin($request->exclude_table, function ($join) use ($request) {
                    $join->on('pf_rk6.Ko_Period', '=', $request->exclude_table . '.Ko_Period')
                        ->on('pf_rk6.Ko_Rk1', '=', $request->exclude_table . '.Ko_Rk1')
                        ->on('pf_rk6.Ko_Rk2', '=', $request->exclude_table . '.Ko_Rk2')
                        ->on('pf_rk6.Ko_Rk3', '=', $request->exclude_table . '.Ko_Rk3')
                        ->on('pf_rk6.Ko_Rk4', '=', $request->exclude_table . '.Ko_Rk4')
                        ->on('pf_rk6.Ko_Rk5', '=', $request->exclude_table . '.Ko_Rk5')
                        ->on('pf_rk6.Ko_Rk6', '=', $request->exclude_table . '.Ko_Rk6')
                        ->where($request->exclude_table . '.idssh_4', '=', $request->idssh_4);
                })
                    ->whereNull($request->exclude_table . '.Ko_Period')
                    ->whereNull($request->exclude_table . '.Ko_Rk1')
                    ->whereNull($request->exclude_table . '.Ko_Rk2')
                    ->whereNull($request->exclude_table . '.Ko_Rk3')
                    ->whereNull($request->exclude_table . '.Ko_Rk4')
                    ->whereNull($request->exclude_table . '.Ko_Rk5')
                    ->whereNull($request->exclude_table . '.Ko_Rk6');
            }
        }

        $Ko_Rk = $Ko_Rk->where($table . '.Ko_Period', $tahun);

        for ($i = 1; $i <= 6; $i++) {
            $Ko_Rk = 'Ko_Rk' . $i;

            if ($request->{$Ko_Rk}) {
                if (Str::contains($request->{$Ko_Rk}, ',')) {
                    $Ko_Rk = $Ko_Rk->whereIn($table . '.' . $Ko_Rk, explode(',', $request->{$Ko_Rk}));
                } else {
                    $Ko_Rk = $Ko_Rk->where($table . '.' . $Ko_Rk, $request->{$Ko_Rk});
                }
            }
        }

        if ($request->Ko_Rk) {
            $Ko_Rks = explode(',', $request->Ko_Rk);
            $Ko_Rk = $Ko_Rk->where(function ($query) use ($table, $Ko_Rks) {
                foreach ($Ko_Rks as $key => $Ko_Rk) {
                    if ($key == 0) {
                        $where = 'where';
                    } else {
                        $where = 'orWhere';
                    }

                    if (Str::contains($Ko_Rk, '.')) {
                        $Ko_RkArr = explode('.', $Ko_Rk);
                        $query = $query->{$where}(function ($q) use ($table, $Ko_RkArr) {
                            foreach ($Ko_RkArr as $k => $r) {
                                $q = $q->where($table . '.Ko_Rk' . ($k + 1), $r);
                            }
                        });
                    } else {
                        $query = $query->{$where}($table . '.Ko_Rk' . ($key + 1), $Ko_Rk);
                    }
                }
            });
        }

        return DataTables::of($Ko_Rk)
            ->addColumn('action', function ($model) {
                return '<button type="button" class="btn btn-success btn-xs select-Rekening" data-id="' . $model->Ko_Rk . '" data-uraian="' . $model->Ur_Rk . '"><i class="fa fa-check"></i> Pilih</button><br>';
            })
            ->addColumn('checkbox', function ($model) {
                return '<input type="checkbox" name="Ko_Rk[]" class="curs-point" value="' . $model->tahun . '.' . $model->Ko_Rk . '">';
            })
            ->addColumn('navigation', function ($model) use ($request) {
                $navigation = '';

                if ($request->level && $request->level > 3) {
                    $navigation .= '<button type="button" class="btn btn-danger btn-xs prev change-Rekening mr-1" data-id="' . $model->Ko_Rk . '" data-level="' . ($request->level - 1) . '" title="Rekening Sebelumnya"><i class="fas fa-bwd fa-backward"></i></button>';
                }

                if ($request->level && $request->level < 6) {
                    $navigation .= '<button type="button" class="btn btn-primary btn-xs next change-Rekening ml-1" data-id="' . $model->Ko_Rk . '" data-level="' . ($request->level + 1) . '" title="Rekening Selanjutnya"><i class="fas fa-fwd fa-forward"></i></button>';
                }

                return $navigation;
            })
            ->setRowClass('row-Rekening curs-point')
            ->addIndexColumn()
            ->rawColumns(['action', 'checkbox', 'navigation'])
            ->make(true);
    }

    public function copy(Request $request)
    {
        $tahun = Tahun();
        $tahunSebelum = $tahun - 1;
        $checkExists = DB::table('pf_rk1')->where('Ko_Period', $tahunSebelum)->exists();

        if (!$checkExists) {
            return response()->json(['message' => 'Data Rekening tahun sebelumnya tidak ditemukan.'], 404);
        }

        DB::beginTransaction();

        try {
            DB::delete(<<<SQL
                DELETE pf_rk6
                WHERE Ko_Period = :tahun6;
                DELETE pf_rk5
                WHERE Ko_Period = :tahun5;
                DELETE pf_rk4
                WHERE Ko_Period = :tahun4;
                DELETE pf_rk3
                WHERE Ko_Period = :tahun3;
                DELETE pf_rk2
                WHERE Ko_Period = :tahun2;
                DELETE pf_rk1
                WHERE Ko_Period = :tahun1;
            SQL, [
                ':tahun6' => $tahun,
                ':tahun5' => $tahun,
                ':tahun4' => $tahun,
                ':tahun3' => $tahun,
                ':tahun2' => $tahun,
                ':tahun1' => $tahun,
            ]);
            // Rekening 1
            DB::insert(<<<SQL
                INSERT INTO pf_rk1
                SELECT Ko_Rk1
                ,Ur_Rk1,getdate() AS created_at
                ,getdate() AS updated_at
                ,:tahun AS Ko_Period
                FROM pf_rk1
                WHERE tahun = :tahunSebelum
            SQL, [
                ':tahun' => $tahun,
                ':tahunSebelum' => $tahunSebelum,
            ]);

            // Rekening 2
            DB::insert(<<<SQL
                INSERT INTO pf_rk2
                SELECT :tahun AS tahun
                ,Ko_Rk1
                ,Ko_Rk2
                ,CONCAT(RIGHT(CONCAT('0', Ko_Rk2), 1), '.', RIGHT(CONCAT('0', Ko_Rk2), 2))
                ,Ur_Rk2
                ,getdate() AS created_at
                ,getdate() AS updated_at
                FROM pf_rk2
                WHERE tahun = :tahunSebelum
            SQL, [
                ':tahun' => $tahun,
                ':tahunSebelum' => $tahunSebelum,
            ]);

            // Rekening 3
            DB::insert(<<<SQL
                INSERT INTO pf_rk3
                SELECT :tahun AS tahun
                ,Ko_Rk1
                ,Ko_Rk2
                ,Ko_Rk3
                ,CONCAT(RIGHT(CONCAT('0', Ko_Rk2), 1), '.', RIGHT(CONCAT('0', Ko_Rk2), 2), '.', RIGHT(CONCAT('0', Ko_Rk3), 2))
                ,SN_rk3
                ,Ur_Rk3
                ,getdate() AS created_at
                ,getdate() AS updated_at
                FROM pf_rk3
                WHERE tahun = :tahunSebelum
            SQL, [
                ':tahun' => $tahun,
                ':tahunSebelum' => $tahunSebelum,
            ]);

            // Rekening 4
            DB::insert(<<<SQL
                INSERT INTO pf_rk4
                SELECT :tahun AS tahun
                    ,Ko_Rk1
                    ,Ko_Rk2
                    ,Ko_Rk3
                    ,Ko_Rk4
                    ,CONCAT(RIGHT(CONCAT('0', Ko_Rk2), 1), '.', RIGHT(CONCAT('0', Ko_Rk2), 2), '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2))
                    ,NULL
                    ,Ur_Rk4
                    ,getdate() AS created_at
                    ,getdate() AS updated_at
                FROM pf_rk4
                WHERE tahun = :tahunSebelum
            SQL, [
                ':tahun' => $tahun,
                ':tahunSebelum' => $tahunSebelum,
            ]);

            // Rekening 5
            DB::insert(<<<SQL
                INSERT INTO pf_rk5
                SELECT :tahun AS tahun
                    ,Ko_Rk1
                    ,Ko_Rk2
                    ,Ko_Rk3
                    ,Ko_Rk4
                    ,Ko_Rk5
                    ,CONCAT(RIGHT(CONCAT('0', Ko_Rk2), 1), '.', RIGHT(CONCAT('0', Ko_Rk2), 2), '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2), '.', RIGHT(CONCAT('00', Ko_Rk5), 3))
                    ,Ur_Rk5
                    ,getdate() AS created_at
                    ,getdate() AS updated_at
                FROM pf_rk5
                WHERE tahun = :tahunSebelum
            SQL, [
                ':tahun' => $tahun,
                ':tahunSebelum' => $tahunSebelum,
            ]);

            // Rekening 6
            DB::insert(<<<SQL
                INSERT INTO pf_rk6
                SELECT :tahun AS tahun
                    ,Ko_Rk1
                    ,Ko_Rk2
                    ,Ko_Rk3
                    ,Ko_Rk4
                    ,Ko_Rk5
                    ,Ko_Rk6
                    ,CONCAT(RIGHT(CONCAT('0', Ko_Rk2), 1), '.', RIGHT(CONCAT('0', Ko_Rk2), 2), '.', RIGHT(CONCAT('0', Ko_Rk3), 2), '.', RIGHT(CONCAT('0', Ko_Rk4), 2), '.', RIGHT(CONCAT('00', Ko_Rk5), 3), '.', RIGHT(CONCAT('000', Ko_Rk6), 4))
                    ,Ur_Rk6
                    ,getdate() AS created_at
                    ,getdate() AS updated_at
                FROM pf_rk6
                WHERE tahun = :tahunSebelum
            SQL, [
                ':tahun' => $tahun,
                ':tahunSebelum' => $tahunSebelum,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            info($th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyalin data Rekening.',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Rekening berhasil disalin.',
        ], 200);
    }
}
