<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Tbpemda;
use App\Models\Tbunit;
use App\Models\Tbsub;
use App\Models\Tbsub1;


class Sys_user extends Model
{
    use HasFactory;
    
    protected $table= "users";
	
	protected $primaryKey = 'user_id';

    protected $fillable = ['username', 'password', 'user_level', 'email','ko_unitstr', 'ko_unit1', 'status'];
	
	protected $hidden  	= ['pwd'];
	
	const ACTIVE = 1;
    const IN_ACTIVE = 0;
	
	//public function hasRelation()
    //{
    //    return $this->user_id == auth()->Sys_user()->user_id
    //        || $this->status == Sys_user::ACTIVE;
    //}
	
	public function pemdas()
    {
        return $this->belongsToMany(Tbpemda::class, 'users', 'user_id', 'ko_unitstr');
    }

	public function units()
    {
        return $this->belongsToMany(Tbunit::class, 'users', 'user_id', 'ko_unitstr');
    }

	public function subs()
    {
        return $this->belongsToMany(Tbsub::class, 'users', 'user_id', 'ko_unitstr');
    }

    public function sub1s()
    {
        return $this->belongsToMany(Tbsub1::class, 'users', 'user_id', 'ko_unit1');
    }

	public function pemdaAktif()
    {
        $pemda = null;
        $query = collect(DB::select(<<<SQL
						SELECT DISTINCT tu.user_id,
						pemda.ko_period,
						pemda.Ko_Wil1,
						pemda.Ko_Wil2,
						pemda.id_kabkota AS id_kabkota,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN pemda.id ELSE NULL END AS id_pemda,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN pemda.Ur_Pemda ELSE NULL END AS Ur_Pemda						
						FROM tb_pemda AS pemda
						JOIN users AS tu ON CONCAT(LPAD(pemda.ko_wil1,2,0),'.' ,LPAD(pemda.ko_wil2,2,0)) = LEFT(tu.Ko_unitstr,5) AND 
						CASE 
							WHEN tu.Ko_unitstr IS NOT NULL AND CONCAT(LPAD(pemda.ko_wil1,2,0),'.' ,LPAD(pemda.ko_wil2,2,0)) = LEFT(tu.Ko_unitstr,5) THEN 1
							WHEN tu.Ko_unitstr IS NULL THEN 1 ELSE 0 END = 1
						WHERE tu.user_id = :user_id
						SQL, [
            'user_id' => $this->user_id
        ]))->first();

        if ($query) {
            $pemda = new Tbpemda();
            $pemda->ko_period 	= $query->ko_period;
			$pemda->Ko_Wil1 	= $query->Ko_Wil1;
			$pemda->Ko_Wil2 	= $query->Ko_Wil2;
			$pemda->id_kabkota 	= $query->id_kabkota;
			$pemda->id_pemda 	= $query->id_pemda;
        }
        return $pemda;
    }

	public function unitAktif()
    {
        $unit = null;
        $query = collect(DB::select(<<<SQL
						SELECT DISTINCT tu.user_id,
						unit.ko_period,
						unit.Ko_Wil1,
						unit.Ko_Wil2,
						unit.Ko_Urus,
						unit.Ko_Bid,
						pemda.id_kabkota AS id_kabkota,
						unit.id_pemda AS id_pemda,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN unit.id ELSE NULL END AS id_unit,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN unit.Ko_Unit ELSE NULL END AS Ko_Unit,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN unit.Ur_unit ELSE NULL END AS Ur_unit						
						FROM tb_unit AS unit
						JOIN tb_pemda AS pemda ON unit.id_pemda=pemda.id
						JOIN users AS tu ON CONCAT(LPAD(unit.ko_wil1,2,0),'.' ,LPAD(unit.ko_wil2,2,0),'.', LPAD(unit.ko_urus,2,0),'.',LPAD(unit.ko_bid,2,0),'.',LPAD(unit.ko_unit,2,0)) = LEFT(tu.Ko_unitstr,14) AND 
						CASE 
							WHEN tu.Ko_unitstr IS NOT NULL AND CONCAT(LPAD(unit.ko_wil1,2,0),'.' ,LPAD(unit.ko_wil2,2,0),'.', LPAD(unit.ko_urus,2,0),'.',LPAD(unit.ko_bid,2,0),'.',LPAD(unit.ko_unit,2,0)) = LEFT(tu.Ko_unitstr,14) THEN 1
							WHEN tu.Ko_unitstr IS NULL THEN 1 ELSE 0 END = 1
						WHERE tu.user_id = :user_id
						SQL, [
            'user_id' => $this->user_id
        ]))->first();

        if ($query) {
            $unit = new Tbunit();
            $unit->ko_period 	= $query->ko_period;
			$unit->Ko_Wil1 		= $query->Ko_Wil1;
			$unit->Ko_Wil2 		= $query->Ko_Wil2;
			$unit->Ko_Urus 		= $query->Ko_Urus;
			$unit->Ko_Bid 		= $query->Ko_Bid;
			$unit->id_kabkota 	= $query->id_kabkota;
			$unit->id_pemda 	= $query->id_pemda;
			$unit->id_unit 		= $query->id_unit;
            $unit->Ko_Unit 		= $query->Ko_Unit;
            $unit->Ur_unit 		= $query->Ur_unit;
        }
        return $unit;
    }

	public function subunitAktif()
    {
        $subunit = null;
        $query = collect(DB::select(<<<SQL
						SELECT DISTINCT tu.user_id,
						sub.ko_period,
						sub.Ko_Wil1,
						sub.Ko_Wil2,
						sub.Ko_Urus,
						sub.Ko_Bid,
						pemda.id_kabkota AS id_kabkota,
						unit.id_pemda AS id_pemda,
						unit.id AS id_unit,
						unit.Ko_Unit,
						unit.Ur_unit,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN sub.id ELSE NULL END AS id_sub,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN sub.Ko_Sub ELSE NULL END AS Ko_Sub,
						CASE WHEN tu.Ko_unitstr IS NOT NULL THEN sub.ur_subunit ELSE NULL END AS ur_subunit						
						FROM tb_sub AS sub
						JOIN tb_unit AS unit ON sub.id_unit=unit.id
						JOIN tb_pemda AS pemda ON unit.id_pemda=pemda.id
						JOIN users AS tu ON sub.Ko_unitstr = tu.Ko_unitstr AND 
						CASE 
							WHEN tu.Ko_unitstr IS NOT NULL AND sub.Ko_unitstr = tu.Ko_unitstr THEN 1
							WHEN tu.Ko_unitstr IS NULL THEN 1 ELSE 0 END = 1
						WHERE tu.user_id = :user_id
						SQL, [
            'user_id' => $this->user_id
        ]))->first();

        if ($query) {
            $subunit = new Tbsub();
            $subunit->ko_period 	= $query->ko_period;
			$subunit->Ko_Wil1 		= $query->Ko_Wil1;
			$subunit->Ko_Wil2 		= $query->Ko_Wil2;
			$subunit->Ko_Urus 		= $query->Ko_Urus;
			$subunit->Ko_Bid 		= $query->Ko_Bid;
			$subunit->id_kabkota 	= $query->id_kabkota;
			$subunit->id_pemda 		= $query->id_pemda;
			$subunit->id_unit 		= $query->id_unit;
            $subunit->Ko_Unit 		= $query->Ko_Unit;
            $subunit->Ur_unit 		= $query->Ur_unit;
			$subunit->id_sub 		= $query->id_sub;
            $subunit->Ko_Sub 		= $query->Ko_Sub;
            $subunit->ur_subunit 	= $query->ur_subunit;
        }
        return $subunit;
    }

	public function subunit1Aktif()
    {
        $subunit1 = null;
        $query = collect(DB::select(<<<SQL
						SELECT DISTINCT tu.user_id,
						sub.ko_period,
						sub.Ko_Wil1,
						sub.Ko_Wil2,
						sub.Ko_Urus,
						sub.Ko_Bid,
						pemda.id_kabkota AS id_kabkota,
						unit.id_pemda AS id_pemda,
						unit.id AS id_unit,
						unit.Ko_Unit,
						unit.Ur_unit,
						sub.id AS id_sub,
						sub.Ko_Sub,
						sub.ur_subunit,
						CASE WHEN tu.Ko_unit1 IS NOT NULL THEN sub1.id ELSE NULL END AS id_sub1,
						CASE WHEN tu.Ko_unit1 IS NOT NULL THEN sub1.Ko_Sub1 ELSE NULL END AS Ko_Sub1,
						CASE WHEN tu.Ko_unit1 IS NOT NULL THEN sub1.ur_subunit1 ELSE NULL END AS ur_subunit1						
						FROM tb_sub AS sub
						JOIN tb_unit AS unit ON sub.id_unit=unit.id
						JOIN tb_sub1 AS sub1 ON sub.id=sub1.id_sub
						JOIN tb_pemda AS pemda ON unit.id_pemda=pemda.id
						JOIN users AS tu ON sub.Ko_unitstr = tu.Ko_unitstr AND 
						CASE 
							WHEN tu.Ko_unit1 IS NOT NULL AND sub1.Ko_unit1 = tu.Ko_unit1 THEN 1
							WHEN tu.Ko_unit1 IS NULL THEN 1 ELSE 0 END = 1
						WHERE tu.user_id = :user_id
						SQL, [
            'user_id' => $this->user_id
        ]))->first();

        if ($query) {
            $subunit1 = new Tbsub1();
            $subunit1->ko_period 	= $query->ko_period;
			$subunit1->Ko_Wil1 		= $query->Ko_Wil1;
			$subunit1->Ko_Wil2 		= $query->Ko_Wil2;
			$subunit1->Ko_Urus 		= $query->Ko_Urus;
			$subunit1->Ko_Bid 		= $query->Ko_Bid;
			$subunit1->id_kabkota 	= $query->id_kabkota;
			$subunit1->id_pemda 	= $query->id_pemda;
			$subunit1->id_unit 		= $query->id_unit;
            $subunit1->Ko_Unit 		= $query->Ko_Unit;
            $subunit1->Ur_unit 		= $query->Ur_unit;
			$subunit1->id_sub 		= $query->id_sub;
            $subunit1->Ko_Sub 		= $query->Ko_Sub;
            $subunit1->ur_subunit 	= $query->ur_subunit;
			$subunit1->id_sub1		= $query->id_sub1;
            $subunit1->Ko_Sub1 		= $query->Ko_Sub1;
            $subunit1->ur_subunit1 	= $query->ur_subunit1;
        }
        return $subunit1;
    }

}

