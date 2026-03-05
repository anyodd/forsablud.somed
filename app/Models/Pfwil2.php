<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pfwil2 extends Model
{
    use HasFactory;
    protected $table = 'pf_wil2'; 

    public function hasRelation()
    {
        return $this->pemdas()->exists();
    }
	
	public function wil1()
    {
        return $this->belongsTo(Pfwil1::class, 'Ko_Wil1');
    }

    public function pemdas()
    {
        return $this->hasMany(Tbpemda::class, 'id_kabkota');
    }

    public function scopePemdaAktif($query)
    {
        
        $pemda = self::query()
            ->SELECT([
                DB::raw("CONCAT(pf_wil2.Ko_Wil1,'.',right(concat('0',pf_wil2.Ko_Wil2),2),' - ',pf_wil2.Ur_wil2) AS name"),
                'pf_wil2.id AS id',
            ])
            ->LEFTJOIN('tb_pemda', 'pf_wil2.id', '=', 'tb_pemda.id_kabkota')
            ->WHERE('tb_pemda.id_kabkota', NULL);

        return $pemda->pluck('name', 'id')->all();
    }

    public function scopeGetSelect2($query)
    {
        return $query->pluck('Ur_wil2', 'id')->prepend('Pilih Pemerintah Daerah', '-1')->all();
    }

}
