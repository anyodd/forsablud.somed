<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jrsesuai extends Model
{
    use HasFactory;
    protected $table = 'jr_sesuai';
    protected $primaryKey = 'id_jr';
    protected $fillable = ['id_tbses','Ko_Period','Ko_unitstr', 'Sesuai_No','dt_sesuai','No_bp','Ko_bprc','Ko_sKeg1','Ko_sKeg2','Ko_Rkk','Rp_D','Rp_K','Ko_DK','Tag','tb_ulog'];
    protected $guarded = [];

    public function Tbsesuai()
    {
        return $this->belongsTo(Tbsesuai::class,'id_tbses','id_tbses');
    }
}
