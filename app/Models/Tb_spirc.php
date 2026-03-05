<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_spirc extends Model
{
    use HasFactory;
    protected $table = 'tb_spirc';
    protected $guarded = ['id'];
    //protected $fillable = ['id','Ko_Period','Ko_unitstr','No_SPi','Ko_spirc','No_bp','Ko_bprc','Ur_bprc','rftr_bprc','dt_rftrbprc','No_PD','Ko_sKeg1','Ko_sKeg2','Ko_Rkk','Ko_Pdp','ko_pmed','spirc_Rp','tb_ulog']; 
}