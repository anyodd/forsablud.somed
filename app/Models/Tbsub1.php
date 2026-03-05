<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tbsub1 extends Model
{
    use HasFactory;
    protected $table = 'tb_sub1'; 
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at'];

    // public function hasRelation()
    // {
    //     return $this->Sys_users()->exists();
    // }

    public function getEntityCodeAttribute()
    {
        return $this->Tbsub->entity_code . '.' . substr('000' . $this->Ko_sub1, -3);
    }

    public function getEntityNameWithCodeAttribute()
    {
        return $this->entity_code . ' ' . $this->ur_subunit1;
    }

    public function subs()
    {
        return $this->belongsTo(Tbsub::class, 'id');
    }

    public function getSubs()
    {
        return $this->belongsTo(Tbsub::class, 'id');
    }

    // public function users()
    // {
    //     return $this->belongsToMany(Sys_user::class, 'users', 'ko_unit1', 'user_id');
    // }

    public function scopeSubUnit1Aktif($query)
    {
        return $query->first();
    }

    public function scopeGetSelect2($query, $id_sub = 0)
    {
        return $query->where('id_sub', $id_sub)->pluck('ur_subunit1', 'id')->prepend('Pilih Bidang', '')->all();
    }

    public function scopeGetSubunit1FromUnitArrayList($query, $id_sub, $pluck = 'id')
    {
        return $query->where(['id_sub' => $id_sub])->pluck($pluck)->all();
    }

    public static function getSubunit1ArrayList($id_sub = '%', $id = [])
    {
        $subunit1 = self::query()
            ->select([
                DB::raw("CONCAT(tb_sub1.ur_subunit1,' (',tb_sub.ur_subunit,')') AS name"),
                'tb_sub1.id AS id',
            ])
            ->leftJoin('tb_sub', 'tb_sub1.id_sub', '=', 'tb_sub.id')
            ->where('tb_sub1.id_sub', 'like', $id_sub);

        if (count($id)) {
            $subunit1 = $subunit1->whereIn('tb_sub1.id', $id);
        }

        return $subunit1->pluck('name', 'id')->all();
    }
}
