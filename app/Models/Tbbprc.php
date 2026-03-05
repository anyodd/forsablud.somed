<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbbprc extends Model
{
    use HasFactory;
    protected $table = 'tb_bprc';
    protected $fillable = ['id_bp','Ko_Period','Ko_unit1','No_bp','Ko_bprc','Ur_bprc','rftr_bprc','dt_rftrbprc','No_PD','Ko_sKeg1','Ko_sKeg2','Ko_Rkk','Ko_Pdp','ko_pmed','To_Rp','ko_kas','tb_ulog','created_at','updated_at'];
    protected $primaryKey = 'id_bprc';
}
