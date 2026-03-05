<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbpemda extends Model
{
    use HasFactory;
    protected $table = 'tb_pemda'; 
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function hasRelation()
    {
        // return $this->Sys_user()->exists() 
        //     || $this->units()->exists();
        $this->units()->exists();
    }

    public function wil2()
    {
        return $this->belongsTo(Pfwil2::class, 'id');
    }

    public function units()
    {
        return $this->hasMany(Tbunit::class, 'id_pemda');
    }

    public function scopepemdaAktif($query)
    {
        return $query->first();
    }

    public function scopeGetPemda($query, $pemda = 0)
    {
        return $query->where('id', $pemda);
    }

    public function scopeGetSelect2($query, $Ko_Wil1 = 0)
    {
        return $query->where('Ko_Wil1', $Ko_Wil1)->pluck('Ur_Pemda', 'id')->prepend('Pemerintah Daerah', '')->all();
    }

    public function jns_pemda()
    {
        return $this->Ko_Wil2 == 0 ? Pfurus::JNS_PEMDA_PROVINSI : Pfurus::JNS_PEMDA_KABUPATEN_KOTA;
    }

}
