<?php

namespace App\Http\Controllers\Setting\ManajemenUser;

use App\Http\Controllers\Controller;
use App\Models\Sys_user;
use App\Models\User;
use App\Models\Pfwil1;
use App\Models\Tbpemda;
use App\Models\Tbunit;
use App\Models\Tbsub;
use App\Models\Tbsub1;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class MasterUserController extends Controller
{
    private $jmlAktif = 0;
    private $jmlTidakAktif = 0;
    private $jmlAdmin = 0;
    private $jmlOperator = 0;

    public function index()
    {
        Sys_user::select(['user_id', 'user_level', 'status'])->get()->map(function ($item) {
            try {
                $level = $item->user_level;
            } catch (DecryptException $e) {
                $level = '';
            }

            if ($item->status == 1) {
                $this->jmlAktif++;
            } else if ($item->status == 0) {
                $this->jmlTidakAktif++;
            }

            if ($level == 1 || $level == 99 || $level == 98) {
                $this->jmlAdmin++;
            } else if ($level != 1 || $level != 99 || $level != 98) {
                $this->jmlOperator++;
            }
        });

        return view('setting.manajemen-user.user.index', [
            'jmlAktif' => $this->jmlAktif,
            'jmlTidakAktif' => $this->jmlTidakAktif,
            'jmlAdmin' => $this->jmlAdmin,
            'jmlOperator' => $this->jmlOperator,
        ]);
    }

    public function datatable(Request $request)
    {
        $wil1 = substr(getUser('ko_unit1'), 0, 2);
        $level = getUser('user_level');

        if ( $level == 99 ) {
            $param= " ";
        } else{
            $param= " WHERE ua.Ko_Wil1 = " . $wil1 . " AND u.user_level<>99 ";
        }      

        Sys_user::select(['user_id', 'user_level', 'status'])->get()->map(function ($item) {
            try {
                $level = $item->user_level;
            } catch (DecryptException $e) {
                $level = '';
            }

            if ($item->status == 1) {
                $this->jmlAktif++;
            } else if ($item->status == 0) {
                $this->jmlTidakAktif++;
            }

            if ($level == 1 || $level == 99 || $level == 98 ) {
                $this->jmlAdmin++;
            } else if ($level != 1 || $level != 99 || $level != 98) {
                $this->jmlOperator++;
            }
        });

        return DataTables::of(
				DB::select("WITH unit_aktif AS (
					SELECT DISTINCT tu.user_id,
						sub.ko_period,
						sub.Ko_Sub,
						sub.ur_subunit,
						CASE WHEN tu.Ko_unit1 IS NOT NULL THEN sub1.Ko_Sub1 ELSE NULL END AS Ko_Sub1,
						CASE WHEN tu.Ko_unit1 IS NOT NULL THEN sub1.ur_subunit1 ELSE NULL END AS ur_subunit1,
						unit.Ko_Unit,
						unit.Ur_unit,
                        unit.Ko_Wil1
						FROM tb_sub AS sub
						JOIN tb_unit AS unit ON sub.ko_period = unit.ko_period AND sub.Ko_Wil1 = unit.Ko_Wil1 AND sub.Ko_Wil2 = unit.Ko_Wil2 
								AND sub.Ko_Urus = unit.Ko_Urus AND sub.Ko_Bid = unit.Ko_Bid AND sub.Ko_Unit = unit.Ko_Unit 
						JOIN tb_sub1 AS sub1 ON sub.ko_period = sub1.ko_period AND sub.Ko_Wil1 = sub1.Ko_Wil1 AND sub.Ko_Wil2 = sub1.Ko_Wil2 
								AND sub.Ko_Urus = sub1.Ko_Urus AND sub.Ko_Bid = sub1.Ko_Bid AND sub.Ko_Unit = sub1.Ko_Unit AND sub.Ko_Sub = sub1.Ko_Sub
						JOIN users AS tu ON sub.Ko_unitstr = tu.Ko_unitstr AND 
						CASE WHEN tu.Ko_unit1 IS NOT NULL AND sub1.Ko_unit1 = tu.Ko_unit1 THEN 1
								WHEN tu.Ko_unit1 IS NULL THEN 1 ELSE 0 END = 1
					)
					SELECT u.user_id, u.username, CASE WHEN u.user_level=99 THEN 'Super Admin' WHEN u.user_level=98 THEN 'Admin Perwakilan' WHEN u.user_level=1 THEN 'Admin'ELSE 'Operator' END AS level, 
					u.status, ua.ur_subunit AS nmblud, ua.ur_subunit1 AS nmbidang
					FROM users u
					LEFT JOIN unit_aktif ua ON u.user_id = ua.user_id ".$param."")
            )
            ->addColumn('action', function ($user) {
                $user->code = Crypt::encryptString($user->user_id);

                return view('setting.manajemen-user.user.action', compact('user'));
            })
            ->editColumn('level', function ($user) {
                try {
                    $level = $user->level;
                } catch (DecryptException $e) {
                    $level = 'Level user salah';
                }

                return Str::title($level);
            })
            ->editColumn('status', function ($user) {
                return $user->status ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
            })
            ->rawColumns(['action', 'status'])
            ->removeColumn('user_id')
            ->addIndexColumn()
            ->with([
                'jmlAktif' => $this->jmlAktif,
                'jmlTidakAktif' => $this->jmlTidakAktif,
                'jmlAdmin' => $this->jmlAdmin,
                'jmlOperator' => $this->jmlOperator,
            ])
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
                return response()->json(['message' => 'User tidak ditemukan.'], 404);
            }
        }

        if (in_array($request->action, ['edit', 'password', 'delete'])) {
            $user = Sys_user::find($id);

            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan.'], 404);
            }

            try {
                $level = $user->user_level;
            } catch (DecryptException $e) {
                $level = '';
            }

            $user->user_level = $level;
            $user->code = Crypt::encryptString($user->user_id);
        } else if ($request->action == 'create') {
            $user = new Sys_user();
        } else {
            return response()->json(['message' => 'Aksi salah.'], 404);
        }

        return response()->json(['form' => view('setting.manajemen-user.user.form', [
            'action' => $request->action,
            'user' => $user,
			'provinsi' => Pfwil1::getSelect2(),
			'pemda' => Tbpemda::getSelect2($user->unitAktif()->Ko_Wil1 ?? 0),
			'unit' =>  Tbunit::getSelect2($user->unitAktif()->id_pemda ?? 0),
			'subunit' => Tbsub::getSelect2($user->subunitAktif()->id_unit ?? 0),
            'subunit1' => Tbsub1::getSelect2($user->subunit1Aktif()->id_sub ?? 0),
            //'group' => Group::getSelect2(),
            'tahun' => $tahun,
        ])->render()], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'password' => 'required',
            'user_level' => 'required',
            'status' => 'required|boolean',
        ], [
            'username.required' => 'Nama user harus diisi.',
            'username.unique' => 'Nama user sudah terpakai.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password kurang dari :min karakter.',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password.',
            'password.required' => 'Konfirmasi password harus diisi.',
            'user_level.required' => 'Level user harus dipilih.',
            'status.required' => 'Status user harus diisi.',
            'status.boolean' => 'Status user harus diisi.',
        ]);

        $input = $request->only([
            'username',
            'password',
			'id_pemda',
            'id_unit',
            'id_sub',
            'id_sub1',
            'user_level',
            'status',
        ]);
        $input['password'] = Hash::make($input['password']);

        $user = Sys_user::create($input);

        $ko_unitstr = collect(DB::select(<<<SQL
                SELECT DISTINCT sub.Ko_unitstr					
                FROM tb_sub AS sub
                WHERE sub.id = :id
                SQL, [
        'id' => $request->id_sub
        ]))->first();

        $ko_unit1 = collect(DB::select(<<<SQL
                SELECT DISTINCT sub1.ko_unit1					
                FROM tb_sub1 AS sub1
                WHERE sub1.id = :id
                SQL, [
        'id' => $request->id_sub1
        ]))->first();

        $user->Ko_unitstr   	= $ko_unitstr->Ko_unitstr ?? NULL;
        $user->ko_unit1     	= $ko_unit1->ko_unit1 ?? NULL;
		$user->id_pemda      	= $request->id_pemda ?? NULL;
        $user->id_unit      	= $request->id_unit ?? 0;
        $user->id_sub       	= $request->id_sub ?? 0;
        $user->id_sub1      	= $request->id_sub1 ?? 0;
        $user->save();

        //if ($request->idunit) {
        //    $user->units()->syncWithPivotValues([$request->idunit], [
        //        'idsubunit' => $request->idsubunit,
        //        'created_id' => auth()->user()->iduser,
        //    ]);
        //} else {
        //    $user->units()->detach();
        //}

        // $user->groups()->detach();

        //foreach ($request->idgroup as $key => $idgroup) {
        //    $user->groups()->attach($idgroup, [
        //        'tahun' => $request->tahun[$key],
        //        'created_id' => auth()->user()->iduser,
        //    ]);
        //}

        return response()->json(['message' => 'User berhasil dibuat.'], 201);
    }


    public function update(Request $request, $code)
    {
        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $request->validate([
            'username' => 'required|unique:users,username,'.$id.',user_id',
            'user_level' => 'required',
            'status' => 'required|boolean',
        ], [
            'username.required' => 'Nama user harus diisi.',
            'username.unique' => 'Nama user sudah terpakai.',
            'user_level.required' => 'Level user harus dipilih.',
            'status.required' => 'Status user harus diisi.',
            'status.boolean' => 'Status user harus diisi.',
        ]);

        $user = Sys_user::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $ko_unitstr = collect(DB::select(<<<SQL
                SELECT DISTINCT sub.Ko_unitstr					
                FROM tb_sub AS sub
                WHERE sub.id = :id
                SQL, [
        'id' => $request->id_sub
        ]))->first();

        $ko_unit1 = collect(DB::select(<<<SQL
                SELECT DISTINCT sub1.ko_unit1					
                FROM tb_sub1 AS sub1
                WHERE sub1.id = :id
                SQL, [
        'id' => $request->id_sub1
        ]))->first();

        $Ko_Wil1 = collect(DB::select(<<<SQL
            SELECT DISTINCT Ko_Wil1	
            FROM tb_pemda
            WHERE id = :id
            SQL, [
        'id' => $request->id_pemda
        ]))->first();

        $Ko_Wil2 = collect(DB::select(<<<SQL
            SELECT DISTINCT Ko_Wil2	
            FROM tb_pemda
            WHERE id = :id
            SQL, [
        'id' => $request->id_pemda
        ]))->first();

        $ko_unitstr0 = collect(DB::select(DB::raw("SELECT CONCAT(LPAD('".$Ko_Wil1->Ko_Wil1."',2,0),'.',LPAD('".$Ko_Wil2->Ko_Wil2."',2,0),'.00.00.000') AS ko_unitstr")))->first();
        $ko_unit10 = collect(DB::select(DB::raw("SELECT CONCAT(LPAD('".$Ko_Wil1->Ko_Wil1."',2,0),'.',LPAD('".$Ko_Wil2->Ko_Wil2."',2,0),'.00.00.000.000') AS ko_unit1")))->first();
	
        $user->username     = $request->username;
		$user->id_pemda     = $request->id_pemda ?? NULL;
        $user->id_unit      = $request->id_unit ?? 0;
        $user->Ko_unitstr   = $ko_unitstr->Ko_unitstr ?? $ko_unitstr0->ko_unitstr;
        $user->id_sub       = $request->id_sub ?? 0;
        $user->ko_unit1     = $ko_unit1->ko_unit1 ?? $ko_unit10->ko_unit1;
        $user->id_sub1      = $request->id_sub1 ?? 0;
        $user->email        = $request->email;
        $user->user_level   = $request->user_level;
        $user->status       = $request->status;
        $user->save();
		
		//Session::put('users.username', $user->username);
		//Session::put('users.Ko_unitstr', $user->Ko_unitstr);
		//Session::put('users.ko_unit1', $user->ko_unit1);
		
        return response()->json(['message' => 'User berhasil diubah.'], 200);
    }

    public function destroy($code)
    {
        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }
		
        $user = Sys_user::where('user_id',$id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        //if ($user->hasRelation()) {
        //    return response()->json(['message' => 'User tidak dapat dihapus karena status user aktif atau sedang digunakan.'], 403);
        //}

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.'], 200);
    }

    public function password(Request $request, $code)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password kurang dari :min karakter.',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.',
        ]);

        try {
            $id = Crypt::decryptString($code);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $user = Sys_user::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password user berhasil diubah.'], 200);
    }

    public function pemda(Request $request)
    {
        return response()->json(['pemda' => Tbpemda::getSelect2($request->Ko_Wil1)], 200);
    }

    public function unit(Request $request)
    {
        return response()->json(['unit' => Tbunit::getSelect2($request->id_pemda)], 200);
    }

    public function subunit(Request $request)
    {
        return response()->json(['subunit' => Tbsub::getSelect2($request->id_unit)], 200);
    }

    public function subunit1(Request $request)
    {
        return response()->json(['subunit1' => Tbsub1::getSelect2($request->id_sub)], 200);
    }
}
