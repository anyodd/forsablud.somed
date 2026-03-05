<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbunit extends Model
{
    use HasFactory;
    protected $table = 'tb_unit'; 
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at'];

    public function hasRelation()
    {
        // return $this->Sys_users()->exists()
        // || $this->Tbsubs()->exists()
        // || $this->Tbsub1s()->exists();

    }

    public function getEntityCodeAttribute()
    {
        return substr('0' . $this->Ko_Wil1, -1). '.' . substr('0' . $this->Ko_Wil2, -1) . '.' . substr('0' . $this->Ko_Urus, -1) . '.' . substr('0' . $this->Ko_Bid, -1) . '.' .  substr('0' . $this->Ko_unit, -1);
    }

    public function getEntityNameWithCodeAttribute()
    {
        return $this->entity_code . ' ' . $this->Ur_Unit;
    }

    public function pemda()
    {
        return $this->belongsTo(Tbpemda::class, 'id');
    }

    public function subs()
    {
        return $this->hasMany(Tbsub::class, 'id_unit');
    }

    public function scopeUnitAktif($query)
    {
        return $query->first();
    }

    public function scopeGetSelect2($query, $id_pemda = 0)
    {
        return $query->where('id_pemda', $id_pemda)->pluck('Ur_Unit', 'id')->prepend('Pilih Unit', '')->all();
    }
}
